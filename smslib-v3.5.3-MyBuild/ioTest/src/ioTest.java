import java.io.*;
import java.util.StringTokenizer;
import java.util.Date;
import java.util.Calendar;
import java.text.SimpleDateFormat;
import java.text.DateFormat;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.PreparedStatement;

import java.util.Properties;

public class ioTest
{
          static short datum;
          static short Addr;
	    static pPort lpt;

    static String do_read()
    {
          // Read from the port
          datum = (short) lpt.input(Addr);

          // Notify the console
          System.out.println("Read Port: " + Integer.toHexString(Addr) +
                              " = " +  Integer.toHexString(datum)+" And Binary String is " +  Integer.toBinaryString(datum));
          return Integer.toBinaryString(datum);
    }

     static void do_write()
     {
          // Notify the console
          System.out.println("Write to Port: " + Integer.toHexString(Addr) +
                              " with data = " +  Integer.toHexString(datum));
          //Write to the port
          lpt.output(Addr,datum);
     }


     static void do_read_range()
     {
          // Try to read 0x378..0x37F, LPT1:
          for (Addr=0x378; (Addr<0x380); Addr++) {

               //Read from the port
               datum = (short) lpt.input(Addr);

               // Notify the console
               System.out.println("Port: " + Integer.toHexString(Addr) +
                                   " = " +  Integer.toHexString(datum));
          }
     }
     
      public static String replaceCharAt(String s, int pos, char c) {
    return s.substring(0, pos) + c + s.substring(pos + 1);
  }
     
        
     public static void main( String args[] )
     {
	    lpt = new pPort();
 
          // Try to read 0x378..0x37F, LPT1:

           do_read_range();

     //  Write the data register

    // Addr=0x378;
    // datum=0x88;
    // do_write();

     // And read back to verify
    // do_read();

     //  One more time, different value
    // datum=0x92;
    // do_write();

     // And read back to verify
     //do_read();

     // etc.... one more time now control port
     //Addr=0x378;
     //datum=0xcc;
     //do_write();
     
     //Addr++;
     //do_read();     

     //Addr++;
     //do_read();

     //Addr--;
     //do_read();
     //Addr--;
     //do_read();
     
     //do_read_range();

     System.out.print("Enter Your Message: ");
     
     //  open up standard input
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));        
        
        String msg = null;

      //  read the Commandname from the command-line; need to use try/catch with the
      //  readLine() method
      try {
         msg = br.readLine();
      } catch (IOException ioe) {
         System.out.println("IO error trying to read your name!");
         System.exit(1);
      }

      System.out.println("Thanks for the message: " + msg);           
      
      String[][] AreaName = new String[8][3];
      try {
         String driver = "com.mysql.jdbc.Driver";

         Class.forName(driver).newInstance();
         Connection conn = null;
         //Connection con = null;
         conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/smslib?autoReconnect=true","smslib","smslib");
         Statement s = conn.createStatement();
         ResultSet rs = s.executeQuery("SELECT name,device_name,pin_number  FROM device_name");
         
         // Our database Input Starts here...........
         PreparedStatement pst;
	 //con = getDbConnection();
	 //	pst = con.prepareStatement(" insert into " + getProperty("tables.sms_in", "parallel_smsserver_in") + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id, single_command, device_name_1, command_name_1, from_toggle_1, to_toggle_1, separator_1, device_name_2, command_name_2, from_toggle_2, to_toggle_2,separator_2, device_name_3, command_name_3, from_toggle_3, to_toggle_3, separator_3, device_name_4, command_name_4, from_toggle_4, to_toggle_4, separator_4, device_name_5, command_name_5, from_toggle_5, to_toggle_5,separator_5, device_name_6, command_name_6, from_toggle_6, to_toggle_6, separator_6, device_name_7, command_name_7, from_toggle_7, to_toggle_7, separator_7, device_name_8, command_name_8, from_toggle_8, to_toggle_8, status) " + " values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	 pst = conn.prepareStatement(" insert into  parallel_smsserver_in" + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id, single_command, device_name_1) " + " values(?,?,?,?,?,?,?,?,?,?,?,?)");
         
         
         int i = 0;
         while(rs.next()) {
            //System.out.println("name   : "+ rs.getString(1));
            AreaName[i][0] = rs.getString(1);
            //System.out.println("Device Name : "+ rs.getString(2));
            AreaName[i][1] = rs.getString(2);
            //System.out.println("Pin Number: "+ rs.getString(3));
            AreaName[i][2] = rs.getString(3);
            //System.out.println();
            i++;
         }

         rs.close();
         s.close();
         conn.close();
      } catch(Exception e) {
         System.out.println("Exception: "+ e);
         e.printStackTrace();
      }
      
      
      
      String PinNumber = "";
      String PinCommand[] = new String[8];
      for (int i=0;i<8;i++)
      {
          PinCommand[i] = "";
      }
      
      int[] aPinNumberInt = new int[8];
      int j = 0;
      String stat = "";
      String TokenAreaName = "";
      boolean WriteToParallelNumber = false;
      boolean WriteToParallelCommand = false;
      boolean WriteToParallelPermission = true;
      String FirstSpaceToken;
      String SecondSpaceToken;
      String ThirdSpaceToken = "";
      String FourthSpaceToken;
      StringTokenizer Entertokens = new StringTokenizer(msg, "\r",true);      
            
      if(Entertokens.countTokens() == 1)
      {
         System.out.println("Enter Token is "+Entertokens.countTokens());
         StringTokenizer commatokens = new StringTokenizer(msg, ",", true);
         if(commatokens.countTokens() == 1)
         {
             System.out.println("Comma Token is "+commatokens.countTokens());
             StringTokenizer spacetokens = new StringTokenizer(msg, " ");
             if(spacetokens.countTokens() == 1)
             {
                 System.out.println("Space Token is "+spacetokens.countTokens());
                 //String commandname = "Status";
                 if("STATUS".equals(msg.trim().toUpperCase()))
                 {
                      // pst.setString(11, "STATUS");
                      //SendStatusMessage();
                      Addr=0x378;
                      //do_read();
                      stat = do_read();
                      int statlength = stat.length();
                      System.out.println("Binary Number is "+stat+" And Stat Length is "+statlength);
                      if(statlength<8)
                      {
                           for (int i=0;i<(8-statlength);i++)
                           {
                               stat = "0".concat(stat);
                               System.out.println("Concatenated Binary string is "+stat);
                           }
                      }
                      char[] chars = stat.toCharArray();
                      String SmsOut = "";                               
                      for(int i = 7; i >=0; i--)
                      {
                          
                          if("1".equals(String.valueOf(chars[i])))
                          {
                               //System.out.println(AreaName[7-i][0]+" is "+"ON");
                               if(i==7)
                               {
                                    SmsOut = SmsOut.concat(AreaName[7-i][0]+" is "+"ON");
                               }
                               else
                               {
                                    SmsOut = SmsOut.concat("\n"+AreaName[7-i][0]+" is "+"ON");
                               }
                               //System.out.println(SmsOut);
                          }
                          else
                          {
                               //System.out.println(AreaName[7-i][0]+" is "+"OFF");
                               if(i==7)
                               {
                                    SmsOut = SmsOut.concat(AreaName[7-i][0]+" is "+"OFF");
                               }
                               else
                               {
                                    SmsOut = SmsOut.concat("\n"+AreaName[7-i][0]+" is "+"OFF");
                               }
                               
                               //System.out.println(SmsOut);
                          }      
                                                                        
                      }
                      System.out.println(SmsOut);                                          
                      for(int i = 12; i <52; i++)
                      {
                           //pst.setString(i,null)
                           System.out.println("Field Number is "+i);
                      }
                      System.out.println("Command is "+spacetokens.nextToken());
                      
                      Calendar currentDate = Calendar.getInstance();
                      SimpleDateFormat formatter= new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
                      String dateNow = formatter.format(currentDate.getTime());
                      
                      try {
                            String driver = "com.mysql.jdbc.Driver";

                            Class.forName(driver).newInstance();
                            Connection conn = null;
                            //Connection con = null;
                            conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/smslib?autoReconnect=true","smslib","smslib");
                            //Statement s = conn.createStatement();
                            //ResultSet rs = s.executeQuery("SELECT name,device_name,pin_number  FROM device_name");
         
                            // Our database Input Starts here...........
                            PreparedStatement pst;
                            //con = getDbConnection();
                            //	pst = con.prepareStatement(" insert into " + getProperty("tables.sms_in", "parallel_smsserver_in") + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id, single_command, device_name_1, command_name_1, from_toggle_1, to_toggle_1, separator_1, device_name_2, command_name_2, from_toggle_2, to_toggle_2,separator_2, device_name_3, command_name_3, from_toggle_3, to_toggle_3, separator_3, device_name_4, command_name_4, from_toggle_4, to_toggle_4, separator_4, device_name_5, command_name_5, from_toggle_5, to_toggle_5,separator_5, device_name_6, command_name_6, from_toggle_6, to_toggle_6, separator_6, device_name_7, command_name_7, from_toggle_7, to_toggle_7, separator_7, device_name_8, command_name_8, from_toggle_8, to_toggle_8, status) " + " values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            //pst = conn.prepareStatement(" insert into  parallel_smsserver_in" + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id, single_command, device_name_1) " + " values(?,?,?,?,?,?,?,?,?,?,?,?)");
                            pst = conn.prepareStatement(" insert into  parallel_smsserver_out" + " (recipient, text, create_date, originator," + " ref_no, sent_date, gateway_id) " + " values(?,?,?,?,?,?,?)");
                            pst.setString(1, "01681880261");          
                            pst.setString(2, SmsOut);
                            pst.setString(3, dateNow);
                            pst.setString(4, "01681880261");
                            pst.setString(5, "01681880261");
                            pst.setString(6, "2012-05-20 12:53:14");
                            pst.setString(7, "01681880261");
                            pst.executeUpdate();
                            pst.close();
                            //s.close();
                            //conn.commit();
                            
                            conn.close();
                        } catch(Exception e) {
                            System.out.println("Exception: "+ e);
                            e.printStackTrace();
                        }
                      
                      
                 }
                 else
                 {
                      System.out.println("Command is not Status, Command is "+spacetokens.nextToken());
                      //SendErrorMessage();
                 }
             }
             else
             {
                 if(spacetokens.countTokens() >4)
                 {
                     System.out.println("Command Is More Than "+spacetokens.countTokens()+" Space");
                     //  SendErrorMessage();
                 }
                 else
                 {
                     // pst.setString(11, null);
                     int fieldnumber = 12;
                     
                     while(spacetokens.hasMoreTokens())
                     {
                          if (fieldnumber==12)
                          {
                             //   pst.setString(fieldnumber, (subtokens.nextToken().length() == 0 ? "" : subtokens.nextToken()));
                             //System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+spacetokens.nextToken());
                             
                             TokenAreaName = spacetokens.nextToken();
                             FirstSpaceToken = TokenAreaName;
                             if ("ALL".equals(TokenAreaName.trim().toUpperCase()))
                             {
                                 PinNumber = "WriteToParallelNumber";
                                 System.out.println(TokenAreaName+" Area Name is ALL And Pin Number is "+PinNumber);
                                 WriteToParallelNumber = true;
                             }
                             else
                             {
                                 
                                for(int i=0;i<8;i++)
                                {
                                    if (AreaName[i][0].toUpperCase().equals(TokenAreaName.trim().toUpperCase()))
                                    {
                                        PinNumber = AreaName[i][2];
                                        System.out.println(TokenAreaName+" Area Name is found in database And Pin Number is "+PinNumber);
                                        WriteToParallelNumber = true;
                                        aPinNumberInt[j] = Integer.parseInt(PinNumber);
                                     
                                        switch (aPinNumberInt[j])
                                        {
						case 1:
                                                    aPinNumberInt[j] =7;
                                                    break;
						case 2:
                                                    aPinNumberInt[j] =6;
                                                    break;
						case 3:
                                                    aPinNumberInt[j] =5;
                                                    break;
						case 4:
                                                    aPinNumberInt[j] =4;
                                                    break;
                                                case 5:
                                                    aPinNumberInt[j] =3;
                                                    break;
                                                case 6:
                                                    aPinNumberInt[j] =2;
                                                    break;
                                                case 7:
                                                    aPinNumberInt[j] =1;
                                                    break;
                                                case 8:
                                                    aPinNumberInt[j] =0;
                                                    break;
					}
                                     
                                    }
                                }
                             }
                             if ("".equals(PinNumber.trim()))
                             {
                                   System.out.println(TokenAreaName+" Area Name Not found in database");
                                   //  SendErrorMessage();
                                   WriteToParallelNumber = false;
                                   WriteToParallelPermission = false;
                             }
                                                                                
                          }
                          else
                          {
                                String TokenCommandName =  spacetokens.nextToken();
                                SecondSpaceToken = TokenCommandName;
                                System.out.println("fieldNumber is "+fieldnumber+" and next Spacetoken Is  "+TokenCommandName);  
                                
                                if ("ON".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                     if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                     {
                                         PinCommand[j] = "11111111";
                                         System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                         WriteToParallelCommand = true;
                                     }
                                     else
                                     {
                                        PinCommand[j] = "1";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        //  SendErrorMessage();
                                        //WriteToParallel = true;
                                     }
                                }
                                else if("OFF".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                     if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                     {
                                         PinCommand[j] = "00000000";
                                         System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                         WriteToParallelCommand = true;
                                     }
                                     else
                                     {
                                        PinCommand[j] = "0";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);  
                                        WriteToParallelCommand = true;
                                     }
                                }
                                else if("TG".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                     if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                     {
                                         PinCommand[j] = "11111111";
                                         System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                         WriteToParallelCommand = true;
                                     }
                                     else
                                     {
                                        PinCommand[j] = "1";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        WriteToParallelCommand = true;
                                     }   
                                }
                                else
                                {
                                    //SendErrorMessage();
                                    ThirdSpaceToken = TokenCommandName;
                                    DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd");
                                    //get current date time with Date()
                                    Date date = new Date();
                                    System.out.println("Current Date is :"+dateFormat.format(date)+" Time :"+ThirdSpaceToken);
                                    DateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                                    String CurrentDate = dateFormat.format(date)+" "+ThirdSpaceToken;
                                    System.out.println(CurrentDate);
                                    
                                    try{
                                        Date d = df.parse(CurrentDate);
                                        //String ElapsedTime = dateFormat.format(date) - d;
                                    }
                                    catch(Exception e) {
                                        System.out.println("Exception: "+ e);
                                        e.printStackTrace();
                                    } 
                                    String str_date1 = "26/02/2011";
                                    String str_time1 = "11:00 AM";

                                    String str_date2 = "27/02/2011";
                                    String str_time2 = "12:15 AM" ;

                                    DateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm a");
                                    Date date1 = formatter.parse(str_date1 + " " + str_time1);
                                    Date date2 = formatter.parse(str_date2 + " " + str_time2);

                                    // Get msec from each, and subtract.
                                    long diff = date2.getTime() - date1.getTime();

                                    System.out.println("Difference In Days: " + (diff / (1000 * 60 * 60 * 24)));

                                    //DateTimeFormatter formatter = DateTimeFormat.forPattern("yyyy-MM-dd HH:mm:ss");
                                    //DateTime dateTime = formatter.parseDateTime(dateString);
                                    System.out.println("Command is "+TokenCommandName+" And It is unknown and PinCommand is "+PinCommand[j]);
                                    WriteToParallelCommand = false;
                                    WriteToParallelPermission = false;
                                }
                                                          
                          }
                          fieldnumber++;
                                                                                
                     }
                     if(fieldnumber==14)
                        {
                            for(int i = 14; i <52; i++)
                            {
                                //pst.setString(i,null)
                                System.out.println("Field Number is "+i);
                            }
                        }
                        else
                        {
                            if(fieldnumber==15)
                            {
                                System.out.println("Unfinished command. Need another token to make it Toggle Mode");
                                WriteToParallelNumber = false;
                                for(int i = 15; i <52; i++)
                                {
                                    //pst.setString(i,null)
                                    System.out.println("Field Number is "+i);
                                }
                            }
                            else
                            {                                                                     
                                for(int i = 16; i <52; i++)
                                {
                                    //pst.setString(i,null)
                                    System.out.println("Field Number is "+i);
                                }
                            }
                            System.out.println("We are in tg mode. Field Number is ");
                            
                            
                            System.out.println("Hi");
                            
                            for (int i = 0; i < 10; i++)
                            {
                                System.out.println("Number of itartion = " + i);
                                System.out.println("Wait:");
                                try
                                {
                                    Thread.sleep(4000);  
 
                                }catch (InterruptedException ie)
                                {
                                    System.out.println(ie.getMessage());
                                }
                            }
                            
                            
                            try
                            {
                                
                                Thread.sleep(1000); // do nothing for 1000 miliseconds (1 second)
                            }
                            catch(InterruptedException e)
                            {
                                e.printStackTrace();
                            } 
                        }
                     
                     
                     
                     if (WriteToParallelNumber & WriteToParallelCommand & WriteToParallelPermission)
                     {
                        Addr=0x378;
                        //do_read();
                        stat = do_read();
                        int statlength = stat.length();
                        System.out.println("Binary Number is "+stat+" And Stat Length is "+statlength);
                        if(statlength<8)
                        {
                            for (int i=0;i<(8-statlength);i++)
                            {
                                stat = "0".concat(stat);
                                System.out.println("Concatenated string "+stat);
                            }
                        }
                        char[] chars = stat.toCharArray();
                        System.out.println("Binary String Before replacement: "+stat);
                        //int aPinNumberInt = Integer.parseInt(PinNumber);
                        if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                        {
                            stat = PinCommand[j];
                        }
                        else
                        {    
                            char firstLetter = PinCommand[j].charAt(0);
                      
                            stat = replaceCharAt(stat, aPinNumberInt[j], firstLetter);
                        }
                        System.out.println("Binary String After replacement: "+stat);
                        Addr=0x378;
                        String writedatum = Integer.toHexString(Integer.parseInt(stat,2));
                        System.out.println("Check To See hexstring : "+writedatum);
                        //datum = writedatum;
                        datum = Short.parseShort(writedatum, 16) ;
                        //Short sObj2 = Short.valueOf(str);
                        do_write();
                        stat = do_read();
                        System.out.println("Check To See if we write properly: "+stat);
                     }
                        
                    }
                }
            }
         else
         {
             if(commatokens.countTokens() > 15)
             {
                // SendErrorMessage();
                System.out.println("Comma Token is "+commatokens.countTokens());
                System.out.println("You put more than Eight commands...Comma Token is "+commatokens.countTokens());
             
             }
             else
             {
                System.out.println("Comma Token is "+commatokens.countTokens());
                int fieldnumber = 12;
                int firstset = 1;
                int separatorset = 1;
                boolean ISItFirstComma = true;
                while(commatokens.hasMoreTokens())
                {
                     // System.out.println(commatokens.nextToken());                                                    
                     //  pst.setString(fieldnumber, (tokens.nextToken().length() == 0 ? "" : "Enter"));
                                                                                
                     String linecut = commatokens.nextToken().trim();
                     StringTokenizer spacetokens = new StringTokenizer(linecut, " ");
                     int highestToken = spacetokens.countTokens();
                     PinNumber = "";
                     System.out.println("Highest Space Token in a Comma Token is: "+highestToken);
                     FirstSpaceToken = spacetokens.nextToken();                                                                            
                                                                            
                     if(",".equals(FirstSpaceToken.trim()) & ISItFirstComma & fieldnumber==12)
                     {
                        ISItFirstComma = true;
                        //SendErrorMessage("You Put Comma First"); 
                        System.out.println("You Put a Comma before anything....Separator_"+separatorset+" : "+FirstSpaceToken);
                        separatorset++;
                        fieldnumber++;
                        System.out.println("FieldNumber is :"+fieldnumber);
                     }
                                                                            
                     else if(",".equals(FirstSpaceToken.trim()) & ISItFirstComma)
                     {
                        ISItFirstComma = true;
                        //SendErrorMessage("You Put Comma First"); 
                        System.out.println("You Put a Comma after a comma....Separator_"+separatorset+" : "+FirstSpaceToken);
                        separatorset++;
                        fieldnumber++;
                        System.out.println("FieldNumber is :"+fieldnumber);
                     }
                     else if(",".equals(FirstSpaceToken.trim()))
                     {
                        ISItFirstComma = true;   
                        System.out.println("Separator_"+separatorset+" : "+FirstSpaceToken);
                        separatorset++;
                        fieldnumber++;
                        //pst.setString(fieldnumber,null)
                        System.out.println("FieldNumber is :"+fieldnumber);   
                     }
                     else
                     {
                        if(highestToken==4)
                        {                                                                                
                            System.out.println("Device_name_"+firstset+" : "+FirstSpaceToken);
                            System.out.println("Device_name_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                            fieldnumber++;
                            System.out.println("FieldNumber is :"+fieldnumber);
                            System.out.println("Command_name_"+firstset+" : "+spacetokens.nextToken());
                            fieldnumber++;
                            System.out.println("FieldNumber is :"+fieldnumber);
                            System.out.println("from_toggle_"+firstset+" : "+spacetokens.nextToken());
                            fieldnumber++;
                            System.out.println("FieldNumber is :"+fieldnumber);
                            System.out.println("to_toggle_"+firstset+" : "+spacetokens.nextToken());
                            fieldnumber++;
                            System.out.println("FieldNumber is :"+fieldnumber);
                            switch (highestToken)
                            {
                                case 1:                                                                           
                                        System.out.println("Only One Word.."+spacetokens.nextToken()+" use Two words");
                                        //SendErrorMessage("Only one word"); 
                                        //fieldnumber= fieldnumber+3;
                                        break;
                                case 2:                                                                                        
                                        fieldnumber= fieldnumber+2;
                                        break;
                                case 3:
                                        fieldnumber= fieldnumber+1;
                                        break;
                                                                                    
                            }
                                                                                    
                        }
                        else if(highestToken==3)
                        {
                            System.out.println("Only Three Words...use Four words");
                            WriteToParallelNumber = false;
                            
                        }        
                        else
                        {
                            ISItFirstComma = false;
                            
                            
                            if ("ALL".equals(FirstSpaceToken.trim().toUpperCase()))
                             {
                                 //PinNumber = ""
                                 System.out.println(FirstSpaceToken+" Area Name is ALL And Pin Number is "+PinNumber);
                             }
                             else
                             {
                                 
                                for(int i=0;i<8;i++)
                                {
                                    if (AreaName[i][0].toUpperCase().equals(FirstSpaceToken.trim().toUpperCase()))
                                    {
                                        PinNumber = AreaName[i][2];
                                        System.out.println(FirstSpaceToken+" Area Name is found in database And Pin Number is "+PinNumber);
                                        WriteToParallelNumber = true;
                                        aPinNumberInt[j]= Integer.parseInt(PinNumber);
                                     
                                        switch (aPinNumberInt[j])
                                        {
						case 1:
                                                    aPinNumberInt[j] =7;
                                                    break;
						case 2:
                                                    aPinNumberInt[j] =6;
                                                    break;
						case 3:
                                                    aPinNumberInt[j] =5;
                                                    break;
						case 4:
                                                    aPinNumberInt[j] =4;
                                                    break;
                                                case 5:
                                                    aPinNumberInt[j] =3;
                                                    break;
                                                case 6:
                                                    aPinNumberInt[j] =2;
                                                    break;
                                                case 7:
                                                    aPinNumberInt[j] =1;
                                                    break;
                                                case 8:
                                                    aPinNumberInt[j] =0;
                                                    break;
					}
                                     
                                    }
                                }
                             }
                             if ("".equals(PinNumber.trim()))
                             {
                                   System.out.println(FirstSpaceToken+" Area Name Not found in database");
                                   //  SendErrorMessage();
                                   WriteToParallelNumber = false;
                                   WriteToParallelPermission = false;
                             }
                                                                                                                                           
                            
                            
                            System.out.println("Device_name_"+firstset+" : "+FirstSpaceToken);
                            fieldnumber++;
                            System.out.println("FieldNumber is :"+fieldnumber);
                            
                            if(highestToken==2)
                            {
                                String TokenCommandName =  spacetokens.nextToken();
                                SecondSpaceToken = TokenCommandName;
                                System.out.println("fieldNumber is "+fieldnumber+" and next Spacetoken Is  "+TokenCommandName);  
                                
                                if ("ON".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                    if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                    {
                                        PinCommand[j] = "11111111";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        WriteToParallelCommand = true;
                                    }
                                    else
                                    {
                                        PinCommand[j] = "1";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        //  SendErrorMessage();
                                        WriteToParallelCommand = true;
                                    }
                                }
                                else if("OFF".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                    if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                    {
                                        PinCommand[j] = "00000000";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        WriteToParallelCommand = true;
                                    }
                                    else
                                    {
                                        PinCommand[j] = "0";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);  
                                        WriteToParallelCommand = true;
                                    }
                                }
                                else if("TG".equals(TokenCommandName.trim().toUpperCase()))
                                {
                                    if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                                    {
                                        PinCommand[j] = "11111111";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        WriteToParallelCommand = true;
                                    }
                                    else
                                    {
                                        PinCommand[j] = "1";
                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand[j]);
                                        WriteToParallelCommand = true;
                                    }   
                                }
                                else
                                {
                                    //SendErrorMessage();
                                    if("TG".equals(SecondSpaceToken.trim()))
                                    {
                                        ThirdSpaceToken = TokenCommandName;
                                    }
                                    else
                                    {
                                       ThirdSpaceToken = ""; 
                                    }
                                    DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
                                    //get current date time with Date()
                                    Date date = new Date();
                                    System.out.println(dateFormat.format(date));
                                    System.out.println("Command is "+ThirdSpaceToken+" And It is unknown and PinCommand is "+PinCommand[j]);
                                    WriteToParallelCommand = false;
                                    WriteToParallelPermission = false;
                                }
                            
                                System.out.println("Command_name_"+firstset+" : "+TokenCommandName);
                                fieldnumber++;
                                System.out.println("FieldNumber is :"+fieldnumber);
                                //pst.setString(i,null)
                                System.out.println("from_toggle_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                                fieldnumber++;
                                System.out.println("FieldNumber is :"+fieldnumber);
                                System.out.println("to_toggle_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                                fieldnumber++;
                                System.out.println("FieldNumber is :"+fieldnumber);
                                firstset++;
                            j++;
                        }
                    }
                }
           }
                if (WriteToParallelNumber & WriteToParallelCommand & WriteToParallelPermission)
                {
                    Addr=0x378;
                    //do_read();
                    stat = do_read();
                    int statlength = stat.length();
                    System.out.println("Binary Number is "+stat+" And Stat Length is "+statlength);
               
                    if(statlength<8)
                    {
                         for (int i=0;i<(8-statlength);i++)
                         {
                             stat = "0".concat(stat);
                             System.out.println("Concatenated string "+stat);
                         }
                    }
                
                    char[] chars = stat.toCharArray();
                    System.out.println("Binary String Before replacement: "+stat);
                    //int aPinNumberInt = Integer.parseInt(PinNumber);
                    if("ALL".equals(TokenAreaName.trim().toUpperCase()))
                    {
                        stat = "11111111";
                    }
                    else
                    {    
                        for (int i=0;i<8;i++)
                        {                       
                            if ("".equals(PinCommand[i].trim()))
                            {
                            }
                            else
                            {
                                char firstLetter = PinCommand[i].charAt(0);
                                stat = replaceCharAt(stat, aPinNumberInt[i] , firstLetter);
                                System.out.println("Binary String while replacment: "+stat);
                            }
                        }
                    }
                    System.out.println("Binary String After replacement: "+stat);
                    Addr=0x378;
                    String writedatum = Integer.toHexString(Integer.parseInt(stat,2));
                    System.out.println("Check To See hexstring : "+writedatum);
                    //datum = writedatum;
                    datum = Short.parseShort(writedatum, 16) ;
                    //Short sObj2 = Short.valueOf(str);
                    do_write();
                    stat = do_read();
                    System.out.println("Check To See if we write properly: "+stat);
                }                                                      
             }
         }
      }
   }
}
