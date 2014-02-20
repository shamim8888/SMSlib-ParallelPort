// SMSLib for Java v3
// A Java API library for sending and receiving SMS via a GSM modem
// or other supported gateways.
// Web Site: http://www.smslib.org
//
// Copyright (C) 2002-2012, Thanasis Delenikas, Athens/GREECE.
// SMSLib is distributed under the terms of the Apache License version 2.0
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
// http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

package org.smslib.smsserver.interfaces;

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
import org.smslib.InboundMessage;
import org.smslib.OutboundBinaryMessage;
import org.smslib.OutboundMessage;
import org.smslib.OutboundWapSIMessage;
import org.smslib.StatusReportMessage;
import org.smslib.Message.MessageEncodings;
import org.smslib.Message.MessageTypes;
import org.smslib.OutboundMessage.FailureCauses;
import org.smslib.OutboundMessage.MessageStatuses;
import org.smslib.OutboundWapSIMessage.WapSISignals;
import org.smslib.helper.Logger;
import org.smslib.smsserver.SMSServer;

// this is my import shamim
import java.lang.Integer;
import java.lang.String;
import java.io.*;
import static java.rmi.server.LogStream.log;
import java.util.StringTokenizer;

// end of my import shamim

/**
 * Interface for database communication with SMSServer. <br />
 * Inbound messages and calls are logged in special tables, outbound messages
 * are retrieved from another table.
 */
public class ParallelDatabase extends Interface<Integer>
{
	static final int SQL_DELAY = 1000;

	int sqlDelayMultiplier = 1;

	private Connection dbCon = null;
        
        // This is my writing shamim
        private String ParallelMessage = null;
        static short datum;
        static short Addr;
	static pPort lpt;
        
        // end of my writing shamim

	public ParallelDatabase(String myInterfaceId, Properties myProps, SMSServer myServer, InterfaceTypes myType)
	{
		super(myInterfaceId, myProps, myServer, myType);
		setDescription("Default Parallel database interface.");
	}

	@Override
	public void start() throws Exception
	{
		Connection con = null;
		Statement cmd;
		Class.forName(getProperty("driver"));
		while (true)
		{
			try
			{
				con = getDbConnection();
				cmd = con.createStatement(ResultSet.TYPE_FORWARD_ONLY, ResultSet.CONCUR_READ_ONLY);
				cmd.executeUpdate("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'U' where status = 'Q'");
				con.commit();
				cmd.close();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				if (getServer().getShutdown()) break;
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
		super.start();
	}

	@Override
	public void stop() throws Exception
	{
		Connection con = null;
		while (true)
		{
			try
			{
				Statement cmd;
				con = getDbConnection();
				cmd = con.createStatement(ResultSet.TYPE_FORWARD_ONLY, ResultSet.CONCUR_READ_ONLY);
				cmd.executeUpdate("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'U' where status = 'Q'");
				con.commit();
				cmd.close();
				closeDbConnection();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				if (getServer().getShutdown()) break;
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
		super.stop();
	}

	@Override
	public void callReceived(String gtwId, String callerId) throws Exception
	{
		Connection con = null;
		while (true)
		{
			try
			{
				PreparedStatement cmd;
				con = getDbConnection();
				cmd = con.prepareStatement("insert into " + getProperty("tables.calls", "smsserver_calls") + " (call_date, gateway_id, caller_id) values (?,?,?) ");
				cmd.setTimestamp(1, new Timestamp(new java.util.Date().getTime()));
				cmd.setString(2, gtwId);
				cmd.setString(3, callerId);
				cmd.executeUpdate();
				con.commit();
				cmd.close();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
	}

	@Override
	public void messagesReceived(Collection<InboundMessage> msgList) throws Exception
	{
		Connection con = null;
		while (true)
		{
			try
			{
				PreparedStatement pst;
				con = getDbConnection();
				pst = con.prepareStatement(" insert into " + getProperty("tables.sms_in", "smsserver_parallel_in") + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id) " + " values(?,?,?,?,?,?,?,?,?,?)");
				for (InboundMessage msg : msgList)
				{
					if ((msg.getType() == MessageTypes.INBOUND) || (msg.getType() == MessageTypes.STATUSREPORT))
					{
						pst.setInt(1, 0);
						switch (msg.getEncoding())
						{
							case ENC7BIT:
								pst.setString(4, "7");
								break;
							case ENC8BIT:
								pst.setString(4, "8");
								break;
							case ENCUCS2:
								pst.setString(4, "U");
								break;
							case ENCCUSTOM:
								pst.setString(4, "C");
								break;
						}
						switch (msg.getType())
						{
							case INBOUND:
								pst.setString(3, "I");
								pst.setString(2, msg.getOriginator());
								if (msg.getDate() != null) pst.setTimestamp(5, new Timestamp(msg.getDate().getTime()));
								pst.setString(8, null);
								pst.setTimestamp(9, null);
								break;
							case STATUSREPORT:
								pst.setString(3, "S");
								pst.setString(2, ((StatusReportMessage) msg).getRecipient());
								if (((StatusReportMessage) msg).getSent() != null) pst.setTimestamp(5, new Timestamp(((StatusReportMessage) msg).getSent().getTime()));
								pst.setString(8, ((StatusReportMessage) msg).getRefNo());
								if (((StatusReportMessage) msg).getReceived() != null) pst.setTimestamp(9, new Timestamp(((StatusReportMessage) msg).getReceived().getTime()));
								if (getProperty("update_outbound_on_statusreport", "no").equalsIgnoreCase("yes"))
								{
									PreparedStatement cmd2;
									cmd2 = con.prepareStatement(" update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = ? " + " where (recipient = ? or recipient = ?) and ref_no = ? and gateway_id = ?");
									switch (((StatusReportMessage) msg).getStatus())
									{
										case DELIVERED:
											cmd2.setString(1, "D");
											break;
										case KEEPTRYING:
											cmd2.setString(1, "P");
											break;
										case ABORTED:
											cmd2.setString(1, "A");
											break;
										case UNKNOWN:
											break;
									}
									cmd2.setString(2, ((StatusReportMessage) msg).getRecipient());
									if (((StatusReportMessage) msg).getRecipient().startsWith("+")) cmd2.setString(3, ((StatusReportMessage) msg).getRecipient().substring(1));
									else cmd2.setString(3, "+" + ((StatusReportMessage) msg).getRecipient());
									cmd2.setString(4, ((StatusReportMessage) msg).getRefNo());
									cmd2.setString(5, ((StatusReportMessage) msg).getGatewayId());
									cmd2.executeUpdate();
									cmd2.close();
								}
								break;
							default:
								break;
						}
						pst.setTimestamp(6, new Timestamp(new java.util.Date().getTime()));
						if (msg.getEncoding() == MessageEncodings.ENC8BIT) pst.setString(7, msg.getPduUserData());
						else pst.setString(7, (msg.getText().length() == 0 ? "" : msg.getText()));
                                                
                                                //this is my writing shamim
                                                // Shamim Ahmed Chowdhury
                                                
                                                if (msg.getEncoding() == MessageEncodings.ENC8BIT) ParallelMessage =  msg.getPduUserData();
						else ParallelMessage = (msg.getText().length() == 0 ? "" : msg.getText());
                                                //end of my writing shamim
                                                
                                                // All code copied from iotest.java shamim
                   
                                                String[][] AreaName = new String[2][10];              
                try 
                    {
                        String driver = "com.mysql.jdbc.Driver";
                        Class.forName(driver).newInstance();
                        Connection Parallelconn = null;
                        Parallelconn = DriverManager.getConnection("jdbc:mysql://localhost:3306/smslib?autoReconnect=true","root","");
                        Statement s = Parallelconn.createStatement();
                        ResultSet rs = s.executeQuery("SELECT *  FROM smsserver_parallel_device_configuration");         
                        int i = 0;
                        while(rs.next()) 
                            {
                                System.out.println("LPT_Device_original_name   : "+ rs.getString(2));
                                AreaName[i][0] = rs.getString(2);
                                System.out.println("LPT_Device_Mobile_name   : "+ rs.getString(3));
                                AreaName[i][1] = rs.getString(3);
                                for(int k=2;k<10;k++)
                                    {                                           
                                        System.out.println("Device Name : "+ rs.getString(k+2));
                                        AreaName[i][k] = rs.getString(k+2);
                                    }                               
                                System.out.println();
                                i++;
                            }
                        rs.close();
                        s.close();
                        Parallelconn.close();
                    } 
                catch(Exception e) 
                    {
                        System.out.println("Exception: "+ e);
                        e.printStackTrace();
                    }
                //Start Check and tokenize the Message And Read and Write Lpt
                                                
                                                
                                                
                                                
                                                StringTokenizer Entertokens = new StringTokenizer(ParallelMessage, "\r",true);
                   if(Entertokens.countTokens() == 1)
                    {
                        System.out.println("Enter Token is "+Entertokens.countTokens());
                        StringTokenizer commatokens = new StringTokenizer(ParallelMessage, ",", true);
                        if(commatokens.countTokens() == 1)
                            {
                                System.out.println("Comma Token is "+commatokens.countTokens());
                                StringTokenizer spacetokens = new StringTokenizer(ParallelMessage, " ");
                                if(spacetokens.countTokens() == 1)
                                    {
                                        System.out.println("Space Token is "+spacetokens.countTokens());
                                        //String commandname = "Status";
                                        if("STATUS".equals(ParallelMessage.trim().toUpperCase()))
                                            {
                                                // pst.setString(11, "STATUS");
                                                //SendStatusMessage();
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
                                                                        System.out.println("Concatenated string "+stat);
                                                                    }
                                                            }
                                                        char[] chars = stat.toCharArray();
                                                        String SmsOut = "";                               
                                                        for(int i = 7; i >=0; i--)
                                                            {
                                                                if("1".equals(String.valueOf(chars[i])))
                                                                    {
                                                                        System.out.println(AreaName[j][9-i]+" is "+"ON");
                                                                        if(i==7)
                                                                            {
                                                                                SmsOut = SmsOut.concat(AreaName[j][9-i]+" is "+"ON");
                                                                            }
                                                                        else
                                                                            {
                                                                                SmsOut = SmsOut.concat("\n"+AreaName[j][9-i]+" is "+"ON");
                                                                            }
                                                                        System.out.println("SMS STring Is: " + SmsOut);
                                                                    }
                                                                else
                                                                    {
                                                                        System.out.println(AreaName[j][9-i]+" is "+"OFF");
                                                                        if(i==7)
                                                                            {
                                                                                SmsOut = SmsOut.concat(AreaName[j][9-i]+" is "+"OFF");
                                                                            }
                                                                        else
                                                                            {
                                                                                SmsOut = SmsOut.concat("\n"+AreaName[j][9-i]+" is "+"OFF");
                                                                            }
                               
                                                                        System.out.println("SMS STring Is: " + SmsOut);
                                                                    }      
                                                                        
                                                            }
                                        
                                                    }
                                                                
                                                for(int i = 12; i <52; i++)
                                                    {
                                                        //pst.setString(i,null)
                                                        System.out.println("Field Number is "+i);
                                                    }
                                                System.out.println("Command is "+spacetokens.nextToken());
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
                                                System.out.println("Command Is More Than "+spacetokens.countTokens());
                                                //  SendErrorMessage();
                                            }
                                        else
                                            {
                                                // pst.setString(11, null);
                                                int fieldnumber = 12;
                                                int PinNumber = 0;
                                                String PinCommand = "";
                                                int aPinNumberInt = 0;
                                                while(spacetokens.hasMoreTokens())
                                                    {
                                                        if (fieldnumber==12)
                                                            {
                                                                //   pst.setString(fieldnumber, (subtokens.nextToken().length() == 0 ? "" : subtokens.nextToken()));
                                                                //System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+spacetokens.nextToken());
                             
                                                                String TokenAreaName = spacetokens.nextToken();
                                                                for(int i=0;i<2;i++)
                                                                    {
                                                                        if (AreaName[i][1].toUpperCase().equals(TokenAreaName.trim().toUpperCase()))
                                                                            {
                                                                                //PinNumber = AreaName[i][2];
                                                                                System.out.println(TokenAreaName+" Device Mobile Name is found in database ");
                                                                                String TokenPinName = spacetokens.nextToken();
                                                                                for(int j=2;j<10;j++)
                                                                                    {
                                                                                        if (AreaName[i][j].toUpperCase().equals(TokenPinName.trim().toUpperCase()))
                                                                                            {
                                                                                                System.out.println(TokenPinName+" Pin Number is found in database ");
                                                                                                PinNumber = j-1;
                                                                                                System.out.println(PinNumber+" is Pin Number of "+TokenPinName+" found in database ");
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
                                                                                else if ("ALL".equals(TokenPinName.trim().toUpperCase()))
                                                                                    {
                                                                                        System.out.println(" Device Pin Number is ALL found in database And ");
                                                                                        aPinNumberInt = 10;
                                                                                    }
                                                                                else
                                                                                    {
                                                                                        System.out.println(" Device Pin Number not found in database ");
                                                                                        //  SendErrorMessage();
                                                                                    }
                                     
                                                                            }
                                                                        if ("".equals(TokenAreaName.trim()))
                                                                            {
                                                                                System.out.println(TokenAreaName+" LPT_Device_Mobile_Name Not found in database");
                                                                                //  SendErrorMessage();
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
                                                                        PinCommand = "1";
                                                                        System.out.println("Command is "+TokenCommandName+" And PinCommand is "+PinCommand);
                                                                    }
                                                                else
                                                                    {
                                                                        System.out.println("Command is "+TokenCommandName+" And Command Is Not Supported");
                                                                    }
                                                            }
                                                        fieldnumber++;                                                                                
                                                    }
                                                if(aPinNumberInt!=0)
                                                        {
                                                            Addr=0x378;
                                                            lpt = new pPort();
                                                            do_read_register(Addr);
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
                                                                    char firstLetter = PinCommand.charAt(0);
                                                                    if (aPinNumberInt<=8)
                                                                        {                                                                         
                                                                            stat = replaceCharAt(stat, aPinNumberInt, firstLetter); 
                                                                            System.out.println("Binary String After replacement: "+stat);
                                                                        }
                                                                    else
                                                                        {
                                                                            if ("0".equals(PinCommand.trim().toUpperCase()))
                                                                                {
                                                                                    stat = "00000000";
                                                                                    System.out.println("Binary String After replacement: "+stat);
                                                                                }
                                                                            else
                                                                                {
                                                                                    stat = "11111111";
                                                                                    System.out.println("Binary String After replacement: "+stat);
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
                                                                                
                                                String linecut = commatokens.nextToken().trim();
                                                StringTokenizer spacetokens = new StringTokenizer(linecut, " ");
                                                int highestToken = spacetokens.countTokens();
                                                System.out.println("Highest Space Token in a Comma Token is: "+highestToken);
                                                String FirstSpaceToken = spacetokens.nextToken();                                        
                                                                            
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
                                                        System.out.println("FieldNumber is :"+fieldnumber);   
                                                    }
                                                else
                                                    {
                                                        if(highestToken==4)
                                                            {
                                                                String DB_CONN_STRING = "jdbc:mysql://localhost:3306/smslib";
                                                                String DRIVER_CLASS_NAME = "com.mysql.jdbc.Driver";
                                                                String USER_NAME = "root";
                                                                String PASSWORD = "";
                                                                                    
                                                                Connection result = null;
                                                                try 
                                                                    {
                                                                        Class.forName(DRIVER_CLASS_NAME).newInstance();
                                                                    }
                                                                catch (Exception ex)
                                                                    {
                                                                        log("Check classpath. Cannot load db driver: " + DRIVER_CLASS_NAME);
                                                                    }
                                                                                    
                                                                try 
                                                                    {
                                                                        result = DriverManager.getConnection(DB_CONN_STRING, USER_NAME, PASSWORD);
                                                                    }
                                                                catch (SQLException e)
                                                                    {
                                                                        log( "Driver loaded, but cannot connect to db: " + DB_CONN_STRING);
                                                                    }
                                                                                    // return result;
                                                                                    
                                                                String query = "";
                                                                try 
                                                                    {
                                                                        Connection Parallelcon = DriverManager.getConnection("jdbc:mysql://localhost:3306/smslib", "root", "");
                                                                                    
                                                                        //Connection con = DriverManager.getConnection("jdbc:com.mysql.jdbc.Driver:smslib", "smslib","smslib");
                                                                                    
                                                                        Statement stmt = Parallelcon.createStatement();
                                                                        ResultSet rs = stmt.executeQuery("SELECT *  FROM smsserver_parallel_device_configuration");
                                                                        while (rs.next()) 
                                                                            {
                                                                                //int x = rs.getInt("a");
                                                                                String s = rs.getString("name");
                                                                                System.out.println("Device_name_"+firstset+" : "+s);
                                                                                //float f = rs.getFloat("c");
                                                                            }
                                                                                    
                                                                    }
                                                                catch (SQLException ex) 
                                                                    {
                                                                        ex.printStackTrace();
                                                                        System.out.println(query);
                                                                    }
                                                                                    
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
                                                        else
                                                            {
                                                                ISItFirstComma = false;
                                                                System.out.println("Device_name_"+firstset+" : "+FirstSpaceToken);
                                                                fieldnumber++;
                                                                System.out.println("FieldNumber is :"+fieldnumber);
                                                                System.out.println("Command_name_"+firstset+" : "+spacetokens.nextToken());
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
                                                
                                                
                                                // end of all code copied from java shamim
                                                
                                                
						pst.setString(10, msg.getGatewayId());
						pst.executeUpdate();
					}
				}
				pst.close();
				con.commit();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
	}

	@Override
	public Collection<OutboundMessage> getMessagesToSend() throws Exception
	{
		Connection con = null;
		Collection<OutboundMessage> msgList = new ArrayList<OutboundMessage>();
		while (true)
		{
			try
			{
				OutboundMessage msg;
				Statement cmd;
				PreparedStatement pst;
				ResultSet rs;
				int msgCount;
				msgCount = 1;
				con = getDbConnection();
				cmd = con.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_UPDATABLE);
				pst = con.prepareStatement("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'Q' where id = ? ");
				rs = cmd.executeQuery("select id, type, recipient, text, wap_url, wap_expiry_date, wap_signal, create_date, originator, encoding, status_report, flash_sms, src_port, dst_port, sent_date, ref_no, priority, status, errors, gateway_id from " + getProperty("tables.sms_out", "smsserver_parallel_out") + " where status = 'U' order by priority desc, id");
				while (rs.next())
				{
					if (msgCount > Integer.parseInt(getProperty("batch_size"))) break;
					if (getServer().checkPriorityTimeFrame(rs.getInt("priority")))
					{
						switch (rs.getString("type").charAt(0))
						{
							case 'O':
								switch (rs.getString("encoding").charAt(0))
								{
									case '7':
										msg = new OutboundMessage(rs.getString("recipient").trim(), rs.getString("text").trim());
										msg.setEncoding(MessageEncodings.ENC7BIT);
										break;
									case '8':
									{
										String text = rs.getString("text").trim();
										byte bytes[] = new byte[text.length() / 2];
										for (int i = 0; i < text.length(); i += 2)
										{
											int value = (Integer.parseInt("" + text.charAt(i), 16) * 16) + (Integer.parseInt("" + text.charAt(i + 1), 16));
											bytes[i / 2] = (byte) value;
										}
										msg = new OutboundBinaryMessage(rs.getString("recipient").trim(), bytes);
									}
										break;
									case 'U':
										msg = new OutboundMessage(rs.getString("recipient").trim(), rs.getString("text").trim());
										msg.setEncoding(MessageEncodings.ENCUCS2);
										break;
									default:
										msg = new OutboundMessage(rs.getString("recipient").trim(), rs.getString("text").trim());
										msg.setEncoding(MessageEncodings.ENC7BIT);
										break;
								}
								if (rs.getInt("flash_sms") == 1) msg.setFlashSms(true);
								if (rs.getInt("src_port") != -1)
								{
									msg.setSrcPort(rs.getInt("src_port"));
									msg.setDstPort(rs.getInt("dst_port"));
								}
								break;
							case 'W':
								Date wapExpiryDate;
								WapSISignals wapSignal;
								if (rs.getTime("wap_expiry_date") == null)
								{
									Calendar cal = Calendar.getInstance();
									cal.setTime(new Date());
									cal.add(Calendar.DAY_OF_YEAR, 7);
									wapExpiryDate = cal.getTime();
								}
								else wapExpiryDate = rs.getTimestamp("wap_expiry_date");
								if (rs.getString("wap_signal") == null) wapSignal = WapSISignals.NONE;
								else
								{
									switch (rs.getString("wap_signal").charAt(0))
									{
										case 'N':
											wapSignal = WapSISignals.NONE;
											break;
										case 'L':
											wapSignal = WapSISignals.LOW;
											break;
										case 'M':
											wapSignal = WapSISignals.MEDIUM;
											break;
										case 'H':
											wapSignal = WapSISignals.HIGH;
											break;
										case 'D':
											wapSignal = WapSISignals.DELETE;
											break;
										default:
											wapSignal = WapSISignals.NONE;
									}
								}
								msg = new OutboundWapSIMessage(rs.getString("recipient").trim(), new URL(rs.getString("wap_url").trim()), rs.getString("text").trim(), wapExpiryDate, wapSignal);
								break;
							default:
								throw new Exception("Message type '" + rs.getString("type") + "' is unknown!");
						}
						msg.setPriority(rs.getInt("priority"));
						if (rs.getInt("status_report") == 1) msg.setStatusReport(true);
						if ((rs.getString("originator") != null) && (rs.getString("originator").length() > 0)) msg.setFrom(rs.getString("originator").trim());
						msg.setGatewayId(rs.getString("gateway_id").trim());
						msgList.add(msg);
						getMessageCache().put(msg.getMessageId(), rs.getInt("id"));
						pst.setInt(1, rs.getInt("id"));
						pst.executeUpdate();
						con.commit();
						msgCount++;
					}
				}
				con.commit();
				rs.close();
				cmd.close();
				pst.close();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
		return msgList;
	}

	@Override
	public int getPendingMessagesToSend() throws Exception
	{
		Connection con = null;
		int count = -1;
		while (true)
		{
			try
			{
				Statement cmd;
				ResultSet rs;
				con = getDbConnection();
				cmd = con.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_READ_ONLY);
				rs = cmd.executeQuery("select count(*) as cnt from " + getProperty("tables.sms_out", "smsserver_parallel_out") + " where status in ('U', 'Q')");
				if (rs.next()) count = rs.getInt("cnt");
				rs.close();
				cmd.close();
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
		return count;
	}

	@Override
	public void markMessage(OutboundMessage msg) throws Exception
	{
		Connection con = null;
		if (getMessageCache().get(msg.getMessageId()) == null) return;
		while (true)
		{
			try
			{
				PreparedStatement selectStatement, updateStatement;
				ResultSet rs;
				int errors;
				con = getDbConnection();
				selectStatement = con.prepareStatement("select errors from " + getProperty("tables.sms_out", "smsserver_parallel_out") + " where id = ?");
				selectStatement.setInt(1, getMessageCache().get(msg.getMessageId()));
				rs = selectStatement.executeQuery();
				rs.next();
				errors = rs.getInt("errors");
				rs.close();
				selectStatement.close();
				if (msg.getMessageStatus() == MessageStatuses.SENT)
				{
					updateStatement = con.prepareStatement("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = ?, sent_date = ?, gateway_id = ?, ref_no = ? where id = ?");
					updateStatement.setString(1, "S");
					updateStatement.setTimestamp(2, new Timestamp(msg.getDispatchDate().getTime()));
					updateStatement.setString(3, msg.getGatewayId());
					updateStatement.setString(4, msg.getRefNo());
					updateStatement.setInt(5, getMessageCache().get(msg.getMessageId()));
					updateStatement.executeUpdate();
					con.commit();
					updateStatement.close();
				}
				else if ((msg.getMessageStatus() == MessageStatuses.UNSENT) || ((msg.getMessageStatus() == MessageStatuses.FAILED) && (msg.getFailureCause() == FailureCauses.NO_ROUTE)))
				{
					updateStatement = con.prepareStatement("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = ? where id = ?");
					updateStatement.setString(1, "U");
					updateStatement.setInt(2, getMessageCache().get(msg.getMessageId()));
					updateStatement.executeUpdate();
					con.commit();
					updateStatement.close();
				}
				else
				{
					updateStatement = con.prepareStatement("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = ?, errors = ? where id = ?");
					errors++;
					if (errors > Integer.parseInt(getProperty("retries", "2"))) updateStatement.setString(1, "F");
					else updateStatement.setString(1, "U");
					updateStatement.setInt(2, errors);
					updateStatement.setInt(3, getMessageCache().get(msg.getMessageId()));
					updateStatement.executeUpdate();
					con.commit();
					updateStatement.close();
				}
				break;
			}
			catch (SQLException e)
			{
				try
				{
					if (con != null) con.close();
					closeDbConnection();
				}
				catch (Exception innerE)
				{
				}
				Logger.getInstance().logError(String.format("SQL failure, will retry in %d seconds...", (sqlDelayMultiplier * (SQL_DELAY / 1000))), e, null);
				Thread.sleep(sqlDelayMultiplier * SQL_DELAY);
				sqlDelayMultiplier *= 2;
			}
		}
		getMessageCache().remove(msg.getMessageId());
	}

	private Connection getDbConnection() throws SQLException
	{
		if (dbCon == null)
		{
			dbCon = DriverManager.getConnection(getProperty("url"), getProperty("username", ""), getProperty("password", ""));
			dbCon.setAutoCommit(false);
			sqlDelayMultiplier = 1;
		}
		return dbCon;
	}

	private void closeDbConnection()
	{
		try
		{
			if (dbCon != null) dbCon.close();
		}
		catch (Exception e)
		{
		}
		finally
		{
			dbCon = null;
		}
	}
        
        // this is my copy from iotest.java shamim
        
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
        
        // end of my copy from iotest.java shamim
}
