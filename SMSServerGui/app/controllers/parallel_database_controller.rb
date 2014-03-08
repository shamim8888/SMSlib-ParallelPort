class ParallelDatabaseController < ApplicationController
  # GET /users
  # GET /users.xml
  def index
    @users = ParallelDatabase.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @users }
    end
  end

  # GET /users/1
  # GET /users/1.xml
  def show
    @user = ParallelDatabase.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @user }
    end
  end

  # GET /users/new
  # GET /users/new.xml
  def new
    @user = ParallelDatabase.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @user }
    end
  end

  # GET /users/1/edit
  def edit
    @user = ParallelDatabase.find(params[:id])
  end

  # POST /users
  # POST /users.xml
  def create
    @user = ParallelDatabase.new(params[:user])

    respond_to do |format|
      if @user.save
        flash[:notice] = 'User was successfully created.'
        format.html { redirect_to(@user) }
        format.xml  { render :xml => @user, :status => :created, :location => @user }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @user.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /users/1
  # PUT /users/1.xml
  def update
    @user = ParallelDatabase.find(params[:id])

    respond_to do |format|
      if @user.update_attributes(params[:user])
        flash[:notice] = 'User was successfully updated.'
        format.html { redirect_to(@user) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @user.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /users/1
  # DELETE /users/1.xml
  def destroy
    @user = ParallelDatabase.find(params[:id])
    @user.destroy

    respond_to do |format|
      format.html { redirect_to(users_url) }
      format.xml  { head :ok }
    end
  end
  
  def outgoing_sms
    if request.get?
      @form_name =  "Outgoing SMS logs"
     render :action => "_form"
    else
        begin
        sdate = params[ :sdate ].to_datetime  
        edate = params[ :edate ].to_datetime  
       rescue 
        session[ :error ] =  "Invalid Start date or/and End date...Please check"
        render :action => "_form"
        return 1
       end
       sdate_in_string  =  sdate.strftime( "%Y-%m-%d %H:%M:%S" )
       edate_in_string  =  edate.strftime( "%Y-%m-%d %H:%M:%S" )

         session[ :info ]  =  "Your criteria was From Date:<font color=\"green\">#{params[ :sdate ]}</font> To Date:<font color=\"green\">#{params[ :edate ]}</font>" 
       
       @total_sms = SmsserverOutMessage.count( 1, :conditions => [ "create_date  >= ?  and create_date <= ?",sdate_in_string,edate_in_string ]  )
       @success_sms = SmsserverOutMessage.count( 1, :conditions => [ "status=? and create_date  >= ?  and create_date <= ?",'S',sdate_in_string,edate_in_string ]  ) 
       @queued_sms = SmsserverOutMessage.count( 1, :conditions => [ "status=? or status=? and create_date  >= ?  and create_date <= ?",'Q','U',sdate_in_string,edate_in_string ]  ) 

       @failed_sms = @total_sms - @success_sms - @queued_sms 

    end
  end

  def incoming_sms

       @form_name =  "Incoming SMS logs"
    if  params[ :sdate ] and params[ :edate ] 
        begin
        sdate = params[ :sdate ].to_datetime  
        edate = params[ :edate ].to_datetime  
        rescue 
        session[ :error ] =  "Invalid Start date or/and End date...Please check"
        render :action => "_form"
        return 1
        end
       sdate_in_string  =  sdate.strftime( "%Y-%m-%d %H:%M:%S" )
       edate_in_string  =  edate.strftime( "%Y-%m-%d %H:%M:%S" )
       
       @received_sms = SmsserverInMessage.paginate( :all, :conditions => [ "process=? and receive_date  >= ?  and receive_date <= ?",1,sdate_in_string,edate_in_string ] ,:page => params[ :page ] , :per_page => 10 , :order => "receive_date Desc"   )

         session[ :info ]  =  "Your criteria was From Date:<font color=\"green\">#{params[ :sdate ]}</font> To Date:<font color=\"green\">#{params[ :edate ]}</font><br\>Total No of received sms for this criteria is <font color=\"green\">#{@received_sms.total_entries}</font>" 

       if @received_sms.length < 1
         render :action => "_form"
       end
    else 
        render :action => "_form"
    end 

  end

  def missed_call
    @form_name =  "Missed Call logs"
    if  params[ :sdate ] and params[ :edate ] 
        begin
        sdate = params[ :sdate ].to_datetime  
        edate = params[ :edate ].to_datetime  
       rescue 
        session[ :error ] =  "Invalid Start date or/and End date...Please check"
        render :action => "_form"
        return 1
       end

       sdate_in_string  =  sdate.strftime( "%Y-%m-%d %H:%M:%S" )
       edate_in_string  =  edate.strftime( "%Y-%m-%d %H:%M:%S" )
       
       @missed_calls = SmsserverCall.paginate( :all, :conditions => [ "isread=? and call_date  >= ?  and call_date <= ?",1,sdate_in_string,edate_in_string ] ,:page => params[ :page ] , :per_page => 10 , :order => "call_date Desc"   )


         session[ :info ]  =  "Your criteria was From Date:<font color=\"green\">#{params[ :sdate ]}</font> To Date:<font color=\"green\">#{params[ :edate ]}</font><br\>Total No of received sms for this criteria is <font color=\"green\">#{@missed_calls.total_entries}</font>" 

       if @missed_calls.length < 1
         render :action => "_form"
       end
    else
        render :action => "_form"
    end  

  end

  def get_record_by_id
      @received_sms = SmsserverInMessage.find_by_id( params[ :incoming ][ :id ] )
  end

  
  
  
  
end
