class WelcomeController < ApplicationController

  def send_sms
      get_content_group 
      get_number_group 

    if request.post?
      @sms_out_obj = SmsserverOutMessage.new #just for detecting errors
      #@mail = Mail.new
      #@user = User.find( params[:id] )
      #@sms_outqueue = SmsserverOutMessage.find( params[:id] )
      #mail_address_from = @user.email_address
      
      
      
      error_flag = nil
      rows = [ ]

      numbers = params[ :send_sms ][ :recipient ].split( /\D+/ )
      mail_address_to = params[ :send_sms ][ :mailaddress ]
      mailsubject = params[ :send_sms ][ :mailsubject ]
      im = params[ :send_sms ][ :imaddress ]
      text = params[ :send_sms ][ :text ]


      if numbers.empty?
             @sms_out_obj.errors.add( :Recipient," : Recipient field has Invalid Numbers. Please check..."  )
             error_flag = 1
      end
      #Add By Shamim Ahmed Chowdhury to Check E-Mail Subject
      unless mail_address_to.empty?
          if mailsubject.empty?
             @sms_out_obj.errors.add( :Mailsubject," : Subject field is Empty. Please check..."  )
             error_flag = 1
          end
      end
      if text.empty? 
             @sms_out_obj.errors.add( :Content, " : Message content should not be empty. Please check..."      )
             error_flag = 1
      end

     if text.length > 156  
       @sms_out_obj.errors.add( :Content , " : Sorry, you have been restricted to send more than 156 message characters. your content length is #{text.length}" ) 
       error_flag = 1
     end

      unless error_flag
           numbers.shift if numbers[ 0 ] == ""   
            numbers.each{ |number|
             if number.length > 9 and number.length < 16 
              sms_out_tmp = SmsserverOutMessage.new
              sms_out_tmp.message_type = 'O'
              sms_out_tmp.recipient = number
              sms_out_tmp.email_address = mail_address_to
              sms_out_tmp.email_subject = mailsubject
              sms_out_tmp.message_address = im
              sms_out_tmp.text =  text
              sms_out_tmp.priority = params[ :scheduled_on ]
              sms_out_tmp.flash_sms = params[ :sms_type ]
              rows.push( sms_out_tmp )
              #pass sms parameters here 
             else
               error_flag = 1
               @sms_out_obj.errors.add( :Recipient, " : #{number} seem to be a invalid number.  Please check"  )
               break
             end
           }
           unless error_flag
           rows.each{ |row| row.save! }
           
          # Mail Section Start Shamim Ahmed Chowdhury
           smsmail = Mail.new do
              from  "shamim@localhost"
              to     mail_address_to
              subject   mailsubject
              body      text
             # add_file :filename => 'somefile.png', :content => File.read('/somefile.png') 
            end
            #End Of Mail Section Shamim Ahmed Chowdhury
           smsmail.deliver!
           # Start Messaging Shamim Ahmed Chowdhury
            sender_jid = Jabber::JID.new('smslib@ns1')
            client = Jabber::Client.new(sender_jid)
            client.connect('ns1')
            client.auth('smslib')

            client.send(Jabber::Presence.new.set_show(:chat))

            receiver_jid = Jabber::JID.new(im)
            immessage = Jabber::Message::new(receiver_jid, text).set_type(:normal).set_id('1')
            client.send(immessage)
          #end of IM Messaging Shamim Ahmed Chowdhury
          
           session[:notice] = 'Message has been scheduled successfully..'
           end

      end

    end
  end

  def clear_sms_queue
      SmsserverOutMessage.delete_all
      begin 
      SmsserverOutMessage.find_by_sql( "alter table smsserver_out_messages  auto_increment=0;" )
      rescue NoMethodError
      end
      session[ :notice ] = "sms queue has been cleared successfully"
      redirect_to :action => :send_sms_queue 
  end

  def send_sms_queue
   @queued_sms =  SmsserverOutMessage.paginate( :all,:conditions => [ "status = ? or status = ?" , 'U','Q' ] , :order => "create_date",:page => params[ :page ] ,:per_page => 10 )
    session[ :notice ] = "Total No of SMS Queued is #{@queued_sms.total_entries}"
  end


  def send_sms_queue_destroy
   SmsserverOutMessage.find( params[ :id ] ).destroy
   session[ :info ] = "Queued Message has been successfully deleted" 
   redirect_to :action => :send_sms_queue 
  end

  def received_sms
      @received_sms = SmsserverInMessage.paginate( :all , :conditions => [ "process=?" , '0' ], :page => params[ :page ] , :order => 'receive_date desc' , :per_page => 10 ) 
      session[ :notice ] = "You have #{@received_sms.total_entries} new sms"
      @received_sms.each{ |message| message.process='1' ; message.save }
  end

  def missed_calls

     @calls =  SmsserverCall.paginate( :all , :conditions =>  [ "isread=?" , '0' ]  ,:page => params[ :page ] , :order => 'call_date desc' , :per_page => 10 )
     session[ :notice ] = "You have #{@calls.total_entries} missed calls" 
     @calls.each{ |call| call.isread='1' ;  call.save }

  end

  def get_message_group_value    
     row =  OutgoingSmsContentGroup.find_by_id( params[ "content_group_id" ] )
     render :inline =>   row  ?  row.sms_content  : ''
  end

  def get_number_group_value    
     row =  OutgoingSmsNumberGroup.find_by_id( params[ "number_group_id" ] )
    render :inline =>   row  ?  row.phone_numbers  : ''
  end

 private
  def get_records_per_id

    @sms_outqueue = SmsserverOutMessage.find( params[:id] )

  end
  def get_content_group
     
      @contents = OutgoingSmsContentGroup.find( :all ).map{ |row| [row.group_name,row.id] }
      @contents = ( @contents.empty? ) ?  nil : @contents.unshift( [ "--Select Message Template Here---","-1" ] )  

  end
  def get_number_group

    @numbers   = OutgoingSmsNumberGroup.find( :all ).map{|row| [row.group_name,row.id] }
    @numbers = ( @numbers.empty? ) ? nil : @numbers.unshift( [ "--Select Number Template Here--","-1" ] )  

  end
  
  #connection for xmpp server Shamim Ahmed Chowdhury 
  def connect
    @client.connect
    @client.auth(@password)
    @client.send(Presence.new.set_type(:available))
 
    #the "roster" is our bot contact list
    @roster = Roster::Helper.new(@client)
 
    #...to accept new subscriptions
    start_subscription_callback
 
    #...to do something with the messages we receive
    start_message_callback
 
    #When the backend application has done its job, it tells the listener
    #via the "listener" message queue.
    process_queue
  end

end
