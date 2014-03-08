import java.lang.Integer;
import java.lang.String;
import java.io.*;
import java.lang.System;
import java.util.StringTokenizer;
import java.util.logging.Logger;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collection;
import java.util.Date;
import java.util.Properties;
import org.smslib.smsserver.SMSServer;

public class ioTest
    {
        static short datum;
        static short Addr;
	static pPort lpt;
        static final int SQL_DELAY = 1000;
	int sqlDelayMultiplier = 1;
	private Connection dbCon = null;

        static String do_read(short address)
            {
                short addnumber = 2;
                short ContAddr=(short)(address+addnumber);
                short Contdatanumber=0x50;
                do_write(ContAddr,Contdatanumber);          
                // Read from the port
                datum = (short) lpt.input(address);
                // Notify the console
                System.out.println("Read Port: " + Integer.toHexString(address) +
                              " = " +  Integer.toHexString(datum)+" And Binary String is " +  Integer.toBinaryString(datum));
                return Integer.toBinaryString(datum);
            }
    
        static String do_read_register(short address)
            {
                // Read from the port
                datum = (short) lpt.input(address);
                // Notify the console
                System.out.println("Read Port: " + Integer.toHexString(address) +
                              " = " +  Integer.toHexString(datum)+" And Binary String is " +  Integer.toBinaryString(datum));
                return Integer.toBinaryString(datum);
            }
 
        static void do_write(short Address,short datanumber)
            {
                // Notify the console
                System.out.println("Write to Port: " + Integer.toHexString(Address) +
                              " with data = " +  Integer.toHexString(datanumber));
                //Write to the port
                lpt.output(Address,datanumber);
            }

        static void do_read_range()
            {
                // Try to read 0x378..0x37F, LPT1:
                for (Addr=0x378; (Addr<0x380); Addr++) 
                    {
                        //Read from the port
                        datum = (short) lpt.input(Addr);
                        // Notify the console
                        System.out.println("Port: " + Integer.toHexString(Addr) +
                                   " = " +  Integer.toHexString(datum));
                    }
            }
     
        public static String replaceCharAt(String s, int pos, char c) 
            {
                return s.substring(0, pos) + c + s.substring(pos + 1);
            }
        
        public static String SendStatusMessage(String AreaName[][],String StatusCommand )
                {
                    String SmsOut = "";               
                    for (int j=0;j<2;j++)
                        {
                            Addr=0x378;
                            do_read(Addr);
                            String stat = do_read(Addr);
                            int statlength = stat.length();
                            System.out.println("Binary Number is "+stat+" And Stat Length is "+statlength);
                            if(statlength<8)
                                {
                                    for (int i=0;i<(8-statlength);i++)
                                        {
                                            stat = "0".concat(stat);
                                            
                                        }
                                }
                            System.out.println("Concatenated string "+stat);
                            char[] chars = stat.toCharArray();                              
                            for(int i = 7; i >=0; i--)
                                {
                                    if("1".equals(String.valueOf(chars[i])))
                                        {
                                            // System.out.println(AreaName[j][9-i]+" is "+"ON");
                                            if(i==7)
                                                {
                                                    if ("OFF".equals(StatusCommand.trim().toUpperCase()))
                                                        {
                                                        } 
                                                    else    
                                                        {
                                                            SmsOut = SmsOut.concat(AreaName[j][9-i]+" is "+"ON");
                                                        }
                                                }
                                            else
                                               {
                                                    if ("OFF".equals(StatusCommand.trim().toUpperCase()))
                                                        {
                                                        } 
                                                    else    
                                                        {
                                                            SmsOut = SmsOut.concat("\n"+AreaName[j][9-i]+" is "+"ON");
                                                        }
                                               }
                                        }                                        
                                    else
                                        {
                                            // System.out.println(AreaName[j][9-i]+" is "+"OFF");
                                            if(i==7)
                                                {
                                                    if ("ON".equals(StatusCommand.trim().toUpperCase()))
                                                        {                                        
                                                        } 
                                                    else    
                                                        {
                                                            SmsOut = SmsOut.concat(AreaName[j][9-i]+" is "+"OFF");
                                                        }                                                                                                              
                                                }
                                            else
                                                {
                                                    if ("ON".equals(StatusCommand.trim().toUpperCase()))
                                                        {                                       
                                                        } 
                                                    else    
                                                        {
                                                            SmsOut = SmsOut.concat("\n"+AreaName[j][9-i]+" is "+"OFF");
                                                        }    
                                                        
                                                }
                               
                                          //  System.out.println("SMS String Is: " + SmsOut);
                                        }                                                                              
                                }
                        }                
                    return SmsOut;
                }
        
        public static void WriteDeviceAllCommand(String LPTDeviceName,String AreaName[][],String DeviceCommand )
                {                   
                    char firstLetter;
                    String DeviceAllPinCommand;
                    DeviceAllPinCommand = "";
                    
                    if ("ON".equals(DeviceCommand.trim().toUpperCase()))
                        {                                        
                            System.out.println("AllCommandName is "+DeviceCommand);
                            DeviceAllPinCommand = "11111111";
                            System.out.println("Binary String Before replacement: "+DeviceAllPinCommand);                           
                        }
                    else if("OFF".equals(DeviceCommand.trim().toUpperCase()))
                        {                           
                            System.out.println("ThirdSpaceTokenSMSCommandName is "+DeviceCommand+" And StatusCommand is "+DeviceCommand);
                            DeviceAllPinCommand = "00000000";
                            System.out.println("Binary String Before replacement: "+DeviceAllPinCommand);                            
                        }
                    else if("TG".equals(DeviceCommand.trim().toUpperCase()))
                        {                                                        
                            Addr=0x378;
                            DeviceAllPinCommand = do_read_register(Addr);
                            int PinStatuslength = DeviceAllPinCommand.length();
                            System.out.println("Binary Number is "+DeviceAllPinCommand+" And DeviceAllPinStatus Length is "+PinStatuslength);
                            if(PinStatuslength<8)
                                {
                                    for (int c=0;c<(8-PinStatuslength);c++)
                                        {
                                            DeviceAllPinCommand = "0".concat(DeviceAllPinCommand);
                                            System.out.println("Concatenated string "+DeviceAllPinCommand);
                                        }
                                }
                            for(int k=0;k<8;k++)
                                {
                                    char CharPosForToggle = DeviceAllPinCommand.charAt(k);
                                    if(CharPosForToggle=='0')
                                        {
                                            firstLetter = '1';
                                        }
                                    else
                                        {
                                            firstLetter = '0';
                                        }
                                    DeviceAllPinCommand = replaceCharAt(DeviceAllPinCommand, k, firstLetter);                                                         
                                }                            
                        }
                    String writedatum = Integer.toHexString(Integer.parseInt(DeviceAllPinCommand,2));
                    System.out.println("Check To See hexstring : "+writedatum);                  
                    datum = Short.parseShort(writedatum, 16) ;                    
                    do_write(Addr,datum);
                    DeviceAllPinCommand = do_read_register(Addr);
                    System.out.println("Check To See if we write properly: "+DeviceAllPinCommand);                                         
                }                
        
       public static void StatusCommand(String FirstSpaceTokenSMSCommandName,String SecondSpaceTokenSMSCommandName, String AreaName[][] )
            {                                                                                                                    
                if ("ON".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                       
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else if("OFF".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS STring");
                    }
                else if("TG".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else
                    {
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand Is : "+SecondSpaceTokenSMSCommandName +" And StatusCommand Is Not Supported");
                        //  SendErrorMessage();                                                                                
                    }                                         
            } 
               
        
       public static void AllCommand(String FirstSpaceTokenSMSCommandName,String SecondSpaceTokenSMSCommandName, String AreaName[][] )
            {                                                                                                                    
                if ("ON".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                       
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else if("OFF".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS STring");
                    }
                else if("TG".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else
                    {
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand Is : "+SecondSpaceTokenSMSCommandName +" And StatusCommand Is Not Supported");
                        //  SendErrorMessage();                                                                                
                    }                                         
            } 
        
       
       public static void main( String args[] )
            {
                lpt = new pPort();                
                System.out.print("Enter Your Message: ");
                //  open up standard input
                BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
                String msg = null;
                int PinNumber = 0;
                int DataBaseNotFound = 0;
                int aPinNumberInt = 0;
                String LPTDeviceName;
                LPTDeviceName = "";
                String PinCommand = "";
                String StatusCommand;               
                StatusCommand = "";
                String DeviceCommand;
                int NumberOfSpaceToken=0;
                String PinStatus = "";
                char firstLetter;
                int PinStatuslength;
                Connection con = null;
		Statement cmd;
		
                //  read the username from the command-line; need to use try/catch with the readLine() method 
                try 
                    {
                        msg = br.readLine();
                    }
                catch (IOException ioe) 
                    {
                        System.out.println("IO error trying to read your Message!");
                        System.exit(1);
                    }
                System.out.println("Thanks for the message: " + msg);
      
                String[][] AreaName = new String[32][22];              
                try 
                    {
                        String driver = "com.mysql.jdbc.Driver";
                        Class.forName(driver).newInstance();
                        Connection conn = null;
                        conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/parallelport?autoReconnect=true","root","");
                        Statement s = conn.createStatement();
                        
                        ResultSet rs = s.executeQuery("SELECT *  FROM parallel_comm_port_view");         
                        int i = 0;
                        while(rs.next()) 
                            {                               
                                int d = 0;
                                int e = 1;
                                System.out.println("Building_Name   : "+ rs.getString(3));
                                AreaName[i][0] = rs.getString(3);
                                System.out.println("Floor_Name   : "+ rs.getString(5));
                                AreaName[i][1] = rs.getString(5);
                                System.out.println("Flat_Name   : "+ rs.getString(7));
                                AreaName[i][2] = rs.getString(7);
                                System.out.println("Room_Name   : "+ rs.getString(9));
                                AreaName[i][3] = rs.getString(9);
                                System.out.println("Host_Address   : "+ rs.getString(10));
                                AreaName[i][4] = rs.getString(10);
                                System.out.println("Device_Name   : "+ rs.getString(12));
                                AreaName[i][5] = rs.getString(12);
                                for(int k=6;k<14;k++)
                                    {                                                                                                                  
                                        System.out.println("Equipment_ID : "+ rs.getString(k+7+d));
                                        AreaName[i][k+d] = rs.getString(k+7+d);
                                        System.out.println("Equipment_Name : "+ rs.getString(k+7+e));
                                        AreaName[i][k+e] = rs.getString(k+7+e);
                                        d++;
                                        e++;
                                    }                               
                                System.out.println();
                                i++;
                            }
                        rs.close();
                        s.close();
                        conn.close();
                    } 
                catch(Exception e) 
                    {
                        System.out.println("Exception: "+ e);
                        e.printStackTrace();
                    }

                //Start Check and tokenize the Message And Read and Write Lpt 
                StringTokenizer Entertokens = new StringTokenizer(msg, "\r",true);
                if(Entertokens.countTokens() == 1)
                    {
                        System.out.println("Enter Token is "+Entertokens.countTokens());
                        StringTokenizer commatokens = new StringTokenizer(msg, ",", true);
                        if(commatokens.countTokens() == 1)
                            {
                                System.out.println("Comma Token in Enter Token is "+commatokens.countTokens()+" And It's a Single SMS Command");
                                StringTokenizer spacetokens = new StringTokenizer(msg, " ");
                                if(spacetokens.countTokens() == 1)
                                    {
                                        System.out.println("Space Token in Comma Token is "+spacetokens.countTokens());                                        
                                        if("STATUS".equals(msg.trim().toUpperCase()))
                                            {
                                                System.out.println("SMS Command is "+spacetokens.nextToken());
                                                // pst.setString(11, "STATUS");
                                                System.out.println("SMS String is : "+SendStatusMessage(AreaName,StatusCommand)+" End Of SMS String");                                                                                                              
                                                for(int i = 12; i <52; i++)
                                                    {
                                                        //pst.setString(i,null);
                                                        System.out.println("Field Number is "+i);
                                                    }                                              
                                            }
                                            //This else is for command not status 
                                        else
                                            {
                                                System.out.println("Command is not Status, Command is "+spacetokens.nextToken()+"Command is not supported");
                                                //SendErrorMessage();
                                            }                           
                                    }
                                    //This else is for Space token not equal 1
                                else
                                    {
                                        //System.out.println("Comma Token in Enter Token is "+spacetokens.countTokens()+" And It's a Single SMS Command");
                                        System.out.println("Space Token in Comma Token is "+spacetokens.countTokens()+" And It's a Single SMS Command And Total Words Are "+spacetokens.countTokens());
                                        NumberOfSpaceToken = spacetokens.countTokens();
                                        if(spacetokens.countTokens() >6)
                                            {
                                                System.out.println("SMS Command Is More Than "+spacetokens.countTokens());
                                                //  SendErrorMessage("You Have Write More Than Six Words");
                                            }
                                            // This else is for space token not greater than 6
                                        else
                                            {
                                                // pst.setString(11, null);
                                                int fieldnumber = 12;                                                                                             
                                                char CharPosForToggle = '0';                                               
                                                while(spacetokens.hasMoreTokens())
                                                    {
                                                        if (fieldnumber==12)
                                                            {                                                               
                                                                //   pst.setString(fieldnumber, (subtokens.nextToken().length() == 0 ? "" : subtokens.nextToken()));                                                                                            
                                                                String FirstSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                System.out.println("FieldNumber is "+fieldnumber+" and FirstSpaceTokenSMSCommandName Is  "+FirstSpaceTokenSMSCommandName);                                                                                                                             
                                                                
                                                                if ("STATUS".equals(FirstSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                    {
                                                                        System.out.println(FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                        String SecondSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                        StatusCommand(FirstSpaceTokenSMSCommandName,SecondSpaceTokenSMSCommandName,AreaName);                                                                
                                                                    }
                                                                    //This elseif is for FirstSpaceTokenSMSCommend is not STATUS
                                                                else if ("ALL".equals(FirstSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                    {
                                                                        System.out.println(" Device Pin Number is ALL found in database And ");
                                                                        aPinNumberInt = 10;
                                                                        DataBaseNotFound = 1;
                                                                        System.out.println(FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                        String SecondSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                        AllCommand(FirstSpaceTokenSMSCommandName,SecondSpaceTokenSMSCommandName,AreaName);                                                                                                                                                                                                                                                             
                                                                    }
                                                                    //This else is for FirstSpaceTokenSMSCommend is not STATUS or ALL
                                                                else
                                                                    {                                                                                                                                
                                                                        for(int i=0;i<32;i++)
                                                                            {
                                                                                for(int j=0;j<22;j++)
                                                                                    {
                                                                                        if (AreaName[i][j].toUpperCase().equals(FirstSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                            {
                                                                                                String FirstSpaceTokenSMSCommand = AreaName[i][j];
                                                                                                System.out.println("FieldNumber is "+fieldnumber+" and FirstSpaceTokenSMSCommandName Is  "+FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                                                String SecondSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                if ("STATUS".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                    {
                                                                                                        System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                        String ThirdSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                        StatusCommand(FirstSpaceTokenSMSCommand,ThirdSpaceTokenSMSCommandName,AreaName);
                                                                                                    }
                                                                                                else if("ALL".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                    {
                                                                                                        System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                        String ThirdSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                        AllCommand(FirstSpaceTokenSMSCommand,ThirdSpaceTokenSMSCommandName,AreaName);
                                                                                                    }
                                                                                                else
                                                                                                    {
                                                                                                        for(int k=0;k<32;k++)
                                                                                                            {
                                                                                                                for(int l=0;l<22;l++)
                                                                                                                    {
                                                                                                                        if (AreaName[k][l].toUpperCase().equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                            {
                                                                                                                                String SecondSpaceTokenSMSCommand = AreaName[k][l];
                                                                                                                                System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                                                String ThirdSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                if ("STATUS".equals(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                    {
                                                                                                                                        System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                        String FourthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                        StatusCommand(FirstSpaceTokenSMSCommand,FourthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                    }
                                                                                                                                else if("ALL".equals(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                    {
                                                                                                                                        System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                        String FourthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                        AllCommand(FirstSpaceTokenSMSCommand,FourthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                    }
                                                                                                                                else
                                                                                                                                    {
                                                                                                                                        for(int m=0;m<32;m++)
                                                                                                                                            {
                                                                                                                                                for(int n=0;n<22;n++)
                                                                                                                                                    {
                                                                                                                                                        if (AreaName[m][n].toUpperCase().equals(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                            {
                                                                                                                                                                String ThirdSpaceTokenSMSCommand = AreaName[m][n];
                                                                                                                                                                System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                String FourthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                if ("STATUS".equals(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                    {
                                                                                                                                                                        System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                        String FifthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                        StatusCommand(FirstSpaceTokenSMSCommand,FifthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                    }
                                                                                                                                                                else if("ALL".equals(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                    {
                                                                                                                                                                        System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                        String FifthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                        AllCommand(FirstSpaceTokenSMSCommand,FifthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                    }
                                                                                                                                                                else
                                                                                                                                                                    {
                                                                                                                                                                        for(int o=0;o<32;o++)
                                                                                                                                                                            {
                                                                                                                                                                                for(int p=0;p<22;p++)
                                                                                                                                                                                    {
                                                                                                                                                                                        if (AreaName[o][p].toUpperCase().equals(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                            {
                                                                                                                                                                                                String FourthSpaceTokenSMSCommand = AreaName[o][p];
                                                                                                                                                                                                System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                String FifthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                if ("STATUS".equals(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                                    {
                                                                                                                                                                                                        System.out.println(FifthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                        String SixthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                        StatusCommand(FirstSpaceTokenSMSCommand,SixthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                                                    }
                                                                                                                                                                                                else if("ALL".equals(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                                    {
                                                                                                                                                                                                        System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                        String SixthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                        AllCommand(FirstSpaceTokenSMSCommand,SixthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                                                    }
                                                                                                                                                                                                else
                                                                                                                                                                                                    {
                                                                                                                                                                                                        for(int q=0;q<32;q++)
                                                                                                                                                                                                            {
                                                                                                                                                                                                                for(int r=0;r<22;r++)
                                                                                                                                                                                                                    {
                                                                                                                                                                                                                        if (AreaName[q][r].toUpperCase().equals(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                String FifthSpaceTokenSMSCommand = AreaName[o][p];
                                                                                                                                                                                                                                System.out.println(FifthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                                                String SixthSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                                                if ("STATUS".equals(SixthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                                                                    {
                                                                                                                                                                                                                                        System.out.println(SixthSpaceTokenSMSCommandName.trim().toUpperCase()+" SixthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                                                        String SeventhSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                                                        StatusCommand(FirstSpaceTokenSMSCommand,SixthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                else if("ALL".equals(SixthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                                                                                    {
                                                                                                                                                                                                                                        System.out.println(SixthSpaceTokenSMSCommandName.trim().toUpperCase()+" SixthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                                                                                        String SeventhSpaceTokenSMSCommandName = spacetokens.nextToken();
                                                                                                                                                                                                                                        AllCommand(FirstSpaceTokenSMSCommand,SixthSpaceTokenSMSCommandName,AreaName);
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                else
                                                                                                                                                                                                                                    {
                                                                                                                                        
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                    }
                                                                                                                                                                                                            }
                                                                                                                                                                                                    }
                                                                                                                                                                                            }
                                                                                                                                                                                    }
                                                                                                                                                                            }
                                                                                                                                                                    }
                                                                                                                                                            }
                                                                                                                                                    }
                                                                                                                                            }
                                                                                                                                    }
                                                                                                                            }
                                                                                                                    }
                                                                                                            }
                                                                                                    }
                                                                                            }
                                                                                    }
                                                                            }
                                                                    }
                                                            }
                                                    }
                                            }
                                    }
                            }
                            //This Else is for Comma Token is More Than 1                                                                                                                                       
                        else
                            {
                                System.out.println("Comma Token in Enter Token is "+commatokens.countTokens()+" And It's a Multiple SMS Command");                                                                
                                if(commatokens.countTokens() >16)
                                    {
                                        System.out.println("SMS Command Is More Than "+commatokens.countTokens());
                                        //  SendErrorMessage("You Have Write More Than Six Words");
                                    }
                                      // This else is for Comma token not greater than 16
                                else
                                    {
                                        // pst.setString(11, null);
                                        int fieldnumber = 12;                                                                                             
                                        char CharPosForToggle = '0';                                               
                                        while(commatokens.hasMoreTokens())
                                            {
                                            }
                                    }
                            }
                                                                            
                                                                                        // aPinNumberInt = Integer.parseInt(PinNumber);
                                                                                        aPinNumberInt = PinNumber;
                                                                                        if (aPinNumberInt!=0)
                                                                                            {
                                                                                                switch (aPinNumberInt)
                                                                                                    {
                                                                                                        case 1:
                                                                                                            aPinNumberInt =7;
                                                                                                            break;
                                                                                                        case 2:
                                                                                                            aPinNumberInt =6;
                                                                                                            break;
                                                                                                        case 3:
                                                                                                            aPinNumberInt =5;
                                                                                                            break;
                                                                                                        case 4:
                                                                                                            aPinNumberInt =4;
                                                                                                            break;
                                                                                                        case 5:
                                                                                                            aPinNumberInt =3;
                                                                                                            break;
                                                                                                        case 6:
                                                                                                            aPinNumberInt =2;
                                                                                                            break;
                                                                                                        case 7:
                                                                                                            aPinNumberInt =1;
                                                                                                            break;
                                                                                                        case 8:
                                                                                                            aPinNumberInt =0;
                                                                                                            break;
                                                                                                    }
                                                                                            }
                                                                                        else if ("ALL".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                            {
                                                                                                System.out.println(" Device Pin Number is ALL found in database And ");
                                                                                                aPinNumberInt = 10;
                                                                                                DataBaseNotFound = 1;
                                                                                            }
                                                                                        else
                                                                                            {
                                                                                                System.out.println(" Device Pin Number not found in database ");
                                                                                                //  SendErrorMessage();
                                                                                            }
                                     
                                                                                    }
                                                                                if ("".equals(SecondSpaceTokenSMSCommandName.trim()))
                                                                                    {
                                                                                        System.out.println(SecondSpaceTokenSMSCommandName+" LPT_Device_Mobile_Name Not found in database");
                                                                                        //  SendErrorMessage();
                                                                                    }
                                                                            }
                                                                    }                                                                                     
                                                            }
                                                        else
                                                            {
                                                                String TokenCommandName =  spacetokens.nextToken();
                                                                System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+TokenCommandName);  
                                
                                                                if ("ON".equals(TokenCommandName.trim().toUpperCase()))
                                                                    {
                                                                        PinCommand = "1";
                                                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand);
                                                                        //  SendErrorMessage();
                                                                    }
                                                                else if("OFF".equals(TokenCommandName.trim().toUpperCase()))
                                                                    {
                                                                        PinCommand = "0";
                                                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand);  
                                                                    }
                                                                else if("TG".equals(TokenCommandName.trim().toUpperCase()))
                                                                    {
                                                                        PinCommand = "2";
                                                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand);
                                                                    }
                                                                else
                                                                    {
                                                                        System.out.println("Command is "+TokenCommandName+" And Command Is Not Supported");
                                                                    }
                                                            }
                                                        fieldnumber++;                                                                                
                                                    }
                                                if(DataBaseNotFound!=0)
                                                        {
                                                            Addr=0x378;
                                                       //     do_read(Addr);
                                                            String stat = do_read_register(Addr);
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
                                                                    char firstLetterOfPinCommand = PinCommand.charAt(0);
                                                                    if (aPinNumberInt<=7)
                                                                        {                                                                         
                                                                            if ("2".equals(PinCommand.trim().toUpperCase()))
                                                                                {
                                                                                    CharPosForToggle = stat.charAt(aPinNumberInt-1);
                                                                                    if(CharPosForToggle=='0')
                                                                                        {
                                                                                            firstLetter = '1';
                                                                                        }
                                                                                    else
                                                                                        {
                                                                                            firstLetter = '0';
                                                                                        }
                                                                                    stat = replaceCharAt(stat, aPinNumberInt, firstLetter);
                                                                                    System.out.println("Binary String After replacement: "+stat);
                                                                                }
                                                                            else
                                                                                {
                                                                                    stat = replaceCharAt(stat, aPinNumberInt, firstLetter); 
                                                                                    System.out.println("Binary String After replacement: "+stat);
                                                                                }
                                                                        }
                                                                    else
                                                                        {
                                                                            if ("0".equals(PinCommand.trim().toUpperCase()))
                                                                                {
                                                                                    stat = "00000000";
                                                                                    System.out.println("Binary String After replacement: "+stat);
                                                                                }
                                                                            else if ("1".equals(PinCommand.trim().toUpperCase()))
                                                                                {
                                                                                    stat = "11111111";
                                                                                    System.out.println("Binary String After replacement: "+stat);
                                                                                }
                                                                            else
                                                                            {
                                                                                for(int k=0;k<8;k++)
                                                                                    {
                                                                                        CharPosForToggle = stat.charAt(k);
                                                                                        if(CharPosForToggle=='0')
                                                                                            {
                                                                                                firstLetter = '1';
                                                                                            }
                                                                                        else
                                                                                            {
                                                                                                firstLetter = '0';
                                                                                            }
                                                                                        stat = replaceCharAt(stat, k, firstLetter);
                                                                                        
                                                                                        
                                                                                    }
                                                                            }
                                                                        }
                                                            Addr=0x378;
                                                            String writedatum = Integer.toHexString(Integer.parseInt(stat,2));
                                                            System.out.println("Check To See hexstring : "+writedatum);
                                                            //datum = writedatum;
                                                            datum = Short.parseShort(writedatum, 16) ;
                                                            //Short sObj2 = Short.valueOf(str);
                                                            do_write(Addr,datum);
                                                            stat = do_read_register(Addr);
                                                            System.out.println("Check To See if we write properly: "+stat);
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
                                                                System.out.println("Unfinished command. Need another token");
                                                                //  SendErrorMessage();                                                                
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
                                                    }
                                            }
                                    }
                            }
                        else
                            {
                                if(commatokens.countTokens() > 7)
                                    {
                                        // SendErrorMessage();
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
                                                                                
                                                String FirstBlockLineCut = commatokens.nextToken().trim();
                                                StringTokenizer FirstBlockSpacetokens = new StringTokenizer(FirstBlockLineCut, " ");
                                                int FirstBlockHighestToken = FirstBlockSpacetokens.countTokens();
                                                System.out.println("Highest First Block Space Token in a Comma Token is: "+FirstBlockHighestToken);
                                                String FirstBlockFirstToken = FirstBlockSpacetokens.nextToken();                                        
                                                                            
                                                if(",".equals(FirstBlockFirstToken.trim()) & ISItFirstComma & fieldnumber==12)
                                                    {
                                                        ISItFirstComma = true;
                                                        //SendErrorMessage("You Put Comma First"); 
                                                        System.out.println("You Put a Comma before anything....Separator_"+separatorset+" : "+FirstBlockFirstToken);
                                                        separatorset++;
                                                        fieldnumber++;
                                                        System.out.println("FieldNumber is :"+fieldnumber);
                                                    }
                                                                           
                                                else if(",".equals(FirstBlockFirstToken.trim()) & ISItFirstComma)
                                                    {
                                                        ISItFirstComma = true;
                                                        //SendErrorMessage("You Put Comma First"); 
                                                        System.out.println("You Put a Comma after a comma....Separator_"+separatorset+" : "+FirstBlockFirstToken);
                                                        separatorset++;
                                                        fieldnumber++;
                                                        System.out.println("FieldNumber is :"+fieldnumber);
                                                    }
                                                else if(",".equals(FirstBlockFirstToken.trim()))
                                                    {
                                                        ISItFirstComma = true;   
                                                        System.out.println("Separator_"+separatorset+" : "+FirstBlockFirstToken);
                                                        separatorset++;
                                                        fieldnumber++;
                                                        System.out.println("FieldNumber is :"+fieldnumber);   
                                                    }
                                                else
                                                    {
                                                        if(FirstBlockHighestToken==4)
                                                            {
                                                               
                                                                                    
                                                            }
                                                        else
                                                            {
                                                                ISItFirstComma = false;
                                                                while(FirstBlockSpacetokens.hasMoreTokens())
                                                                    {
                                                                        String FirstBlockMobileDeviceToken = FirstBlockSpacetokens.nextToken();
                                                                    
                                                                        for (int m=0;m<2;m++)
                                                                            {
                                                                                if(AreaName[m][1].trim().toUpperCase().equals(FirstBlockMobileDeviceToken.trim().toUpperCase()))
                                                                                    {
                                                                                        System.out.println(FirstBlockMobileDeviceToken+" Device Mobile Name is found in database ");
                                                                                        System.out.println("LPT_Device_Mobile_name   : " + FirstBlockMobileDeviceToken);
                                                                                        String FirstBlockTokenPinName = FirstBlockSpacetokens.nextToken();
                                                                                        for (int n=0;n<10;n++)
                                                                                            {
                                                                                                if(AreaName[m][n].trim().toUpperCase().equals(FirstBlockTokenPinName.trim().toUpperCase()))
                                                                                                    {
                                                                                                        System.out.println(FirstBlockTokenPinName+" First Block Device Name is found in database ");
                                                                                                        PinNumber = n-1;
                                                                                                        DataBaseNotFound = 1;
                                                                                                        System.out.println(PinNumber+" is Pin Number of "+FirstBlockTokenPinName+" found in database ");
                                                                                                        // aPinNumberInt = Integer.parseInt(PinNumber);
                                                                                                        aPinNumberInt = PinNumber;
                                                                                                        if (aPinNumberInt!=0)
                                                                                                            {
                                                                                                                switch (aPinNumberInt)
                                                                                                                    {
                                                                                                                        case 1:
                                                                                                                            aPinNumberInt =7;
                                                                                                                            break;
                                                                                                                        case 2:
                                                                                                                            aPinNumberInt =6;
                                                                                                                            break;
                                                                                                                        case 3:
                                                                                                                            aPinNumberInt =5;
                                                                                                                            break;
                                                                                                                        case 4:
                                                                                                                            aPinNumberInt =4;
                                                                                                                            break;
                                                                                                                        case 5:
                                                                                                                            aPinNumberInt =3;
                                                                                                                            break;
                                                                                                                        case 6:
                                                                                                                            aPinNumberInt =2;
                                                                                                                            break;
                                                                                                                        case 7:
                                                                                                                            aPinNumberInt =1;
                                                                                                                            break;
                                                                                                                        case 8:
                                                                                                                            aPinNumberInt =0;
                                                                                                                            break;
                                                                                                                    }
                                                                                                            }
                                                                                                        String FirstBlockTokenCommandName =  FirstBlockSpacetokens.nextToken();
                                                                                                        System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+FirstBlockTokenCommandName);  
                                
                                                                                                        if ("ON".equals(FirstBlockTokenCommandName.trim().toUpperCase()))
                                                                                                            {
                                                                                                                PinCommand = "1";
                                                                                                                System.out.println("Command is "+FirstBlockTokenCommandName+" And PinCommand is "+PinCommand);
                                                                                                                //  SendErrorMessage();
                                                                                                            }
                                                                                                        else if("OFF".equals(FirstBlockTokenCommandName.trim().toUpperCase()))
                                                                                                            {
                                                                                                                PinCommand = "0";
                                                                                                                System.out.println("Command is "+FirstBlockTokenCommandName+" And PinCommand is "+PinCommand);  
                                                                                                            }
                                                                                                        else if("TG".equals(FirstBlockTokenCommandName.trim().toUpperCase()))
                                                                                                            {
                                                                                                                PinCommand = "2";
                                                                                                                System.out.println("Command is "+FirstBlockTokenCommandName+" And PinCommand is "+PinCommand);
                                                                                                            }
                                                                                                        else
                                                                                                            {
                                                                                                                System.out.println("Command is "+FirstBlockTokenCommandName+" And Command Is Not Supported");
                                                                                                            }
                                                                                                
                                                                                    
                                                                                                    }
                                                                                        else if ("ALL".equals(FirstBlockTokenPinName.trim().toUpperCase()))
                                                                                            {
                                                                                                System.out.println(" Device Pin Number is ALL found in database And ");
                                                                                                aPinNumberInt = 10;
                                                                                                DataBaseNotFound = 1;
                                                                                            }
                                                                                        else
                                                                                            {
                                                                                                System.out.println(" Device Pin Number not found in database ");
                                                                                               //  SendErrorMessage();
                                                                                            }
                                                                                    }
                                                                    }
                                                                }
                                                                System.out.println("Device_name_"+firstset+" : "+FirstBlockMobileDeviceToken);
                                                                fieldnumber++;
                                                                System.out.println("FieldNumber is :"+fieldnumber);
                                                                System.out.println("Command_name_"+firstset+" : "+FirstBlockMobileDeviceToken);
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
                                                            }    
                                                    }
                                            }
      
                                    }
     
                            }
                    }
            }
}         
         
         
