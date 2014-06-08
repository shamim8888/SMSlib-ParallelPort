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

// end of my import Shamim Ahmed Chowdhury

/**
 * Interface for Parallel database communication with SMSServer. <br />
 * Inbound messages and calls are logged in special tables, outbound messages
 * are retrieved from another table.
 * @author Shamim Ahmed Chowdhury
 */
public class ParallelDatabase extends Interface<Integer>
{
	static final int SQL_DELAY = 1000;

	int sqlDelayMultiplier = 1;

	private Connection dbCon = null;
        
        // This is my writing Shamim Ahmed Chowdhury
        private String ParallelMessage = null;
        private String AllMessageString = null;
        private String Host = getServer().getHostAddress();
        static short datum;
        static short Addr;
	static pPort lpt;
        private int rowCount = 0;
        private String[] MessageString = new String[500];
        private String[][] AreaName = new String[rowCount][15];
        private String[][] HostMessageString = new String[128][15];       
        private ArrayList SMSMessageString = new ArrayList<String>();
        private String[] DelimeterArray = new String[8];                              
        private int fieldCount = 0;
        
        private int HostCount = 0;
        private String CompareMessage = null;
        
        // end of my writing Shamim Ahmed Chowdhury

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
				Statement cmd;
				PreparedStatement pst;
				ResultSet rs;
                                ResultSet rowcount;
                                ResultSet fieldcount;
				int msgCount;
                                
				msgCount = 1;
				con = getDbConnection();
				cmd = con.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_UPDATABLE);
				//pst = con.prepareStatement("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'Q' where id = ? ");
				fieldcount = cmd.executeQuery("SELECT COUNT(*) AS CNT FROM information_schema.columns WHERE table_schema = 'smslib' AND table_name = 'parallel_comm_port_view' ");
                                if (fieldcount.next()) fieldCount = fieldcount.getInt("CNT");
                                rowcount = cmd.executeQuery("SELECT COUNT(*) AS CNT FROM parallel_comm_port_view");
                                if (rowcount.next()) rowCount = rowcount.getInt("CNT");
                                
                                rs = cmd.executeQuery("SELECT * FROM parallel_comm_port_view ");
                                //PreparedStatement pst;
				//con = getDbConnection();
				pst = con.prepareStatement(" insert into " + getProperty("tables.sms_in", "smsserver_parallel_in") + " (process, originator, type, encoding, message_date, receive_date, text," + " original_ref_no, original_receive_date, gateway_id, gateway_address, host_address) " + " values(?,?,?,?,?,?,?,?,?,?,?,?)");
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
                                                
                                                //this is my writing Shamim Ahmed Chowdhury                                                
                                                
                                                if (msg.getEncoding() == MessageEncodings.ENC8BIT) ParallelMessage =  msg.getPduUserData();
						else ParallelMessage = (msg.getText().length() == 0 ? "" : msg.getText());
                                                //end of my writing Shamim Ahmed Chowdhury
                                                
                                                // All code copied from iotest.java Shamim Ahmed Chowdhury
                                                
                                                AreaName = new String[rowCount][15]; 
                                                
                                                DelimeterArray[0] = ",";
                                                DelimeterArray[1] = ".";
                                                DelimeterArray[2] = ";";
                                                DelimeterArray[3] = ":";
                                                DelimeterArray[4] = "'";
                                                DelimeterArray[5] = "\"";
                                                DelimeterArray[6] = "/";
                                                DelimeterArray[7] = "\\";
                                                try 
                                                {
                        
                                                    int i = 0;
                                                    while(rs.next()) 
                                                    {
                                                        int d = 0;
                                                        //int e = 1;
                                
                                                        System.out.println("Building_Name   : "+ rs.getString("building_name"));
                                                        AreaName[i][0] = rs.getString(3);
                                                        System.out.println("Floor_Name   : "+ rs.getString("floor_name"));
                                                        AreaName[i][1] = rs.getString(5);
                                                        System.out.println("Flat_Name   : "+ rs.getString("flat_name"));
                                                        AreaName[i][2] = rs.getString(7);
                                                        System.out.println("Room_Name   : "+ rs.getString("room_name"));
                                                        AreaName[i][3] = rs.getString(9);
                                                        System.out.println("Host_Address   : "+ rs.getString("host_address"));
                                                        AreaName[i][4] = rs.getString(11);
                                                        System.out.println("Device_Name   : "+ rs.getString("device_name"));
                                                        AreaName[i][5] = rs.getString(14);
                                                        System.out.println("Device_Address   : "+ rs.getString("device_address"));
                                                        AreaName[i][6] = rs.getString(15);
                                                        for(int k=7;k<15;k++)
                                                        {                                                                                                                  
                                                            //System.out.println("Equipment_ID : "+ rs.getString(k+9+d));
                                                            //AreaName[i][k+d] = rs.getString(k+9+d);
                                                            System.out.println("Equipment_Name : "+ rs.getString(k+10+d));
                                                            AreaName[i][k] = rs.getString(k+10+d);
                                                            d++;
                                                           // e++;
                                                        }                               
                                                        System.out.println();
                                                        i++;                                                                                                                                                           
                                                    }
                                                    //This loop is to get Host address to check whether this SMS is for this host or not
                                                    int w=0;
                                                    for(int x=0;x<rowCount;x++)
                                                        {                                                                                            
                                                            for(int j=0;j<15;j++)
                                                                {
                                                                    if (AreaName[i][j].toUpperCase().equals(Host.trim().toUpperCase()))
                                                                        {                                                                                                                                                                                                                                                                                                                                   
                                                                            for(int k=0;k<15;k++)
                                                                                {
                                                                                    HostMessageString[w][k] = AreaName[i][k];
                                                                                }                                                                                                            
                                                                        }
                                                                }
                                                            w++;
                                                        }                                                                                                                         
                                                } 
                                                catch(Exception e) 
                                                {
                                                    System.out.println("Exception: "+ e);
                                                    e.printStackTrace();
                                                }
                                                //Start Check and tokenize the Message And Read and Write Lpt   
                
                                                int F = 0;
                                                while(ParallelMessage.length()>0)
                                                {
                                                    String FirstMessage = ParallelMessage;   
                                                    StringTokenizer Entertokens = new StringTokenizer(ParallelMessage, "\r",true);
                                                    if (Entertokens.countTokens() == 1)
                                                    {
                                                        for (int i=0;i<DelimeterArray.length;i++)  
                                                        {
                                                            StringTokenizer Whichtokens = new StringTokenizer(ParallelMessage, DelimeterArray[i],true);
                                                            if(Whichtokens.countTokens() > 1)
                                                            {                  
                                                                CompareMessage = Whichtokens.nextToken();
                                                                System.out.println("Message Token Is "+CompareMessage);
                                                                if (CompareMessage.length()<FirstMessage.length())
                                                                {
                                                                    FirstMessage = CompareMessage;
                                                                    System.out.println("First Message Token Is "+FirstMessage);
                                                                }
                                                            }
                                                        }
                                                        MessageString[F] = FirstMessage;
                                                        System.out.println("MessageString"+F+" "+MessageString[F]);
                                                        if (ParallelMessage.length()>FirstMessage.length())
                                                        {
                                                            ParallelMessage = ParallelMessage.substring(FirstMessage.length()+1);
                                                            System.out.println(" Message Substr Is "+ParallelMessage);
                                                        }
                                                        else if (ParallelMessage.length()==FirstMessage.length())
                                                        {
                                                            ParallelMessage = ParallelMessage.substring(FirstMessage.length());
                                                            //System.out.println(" Message Substr Is "+Message);
                                                        }                      
                                                        F++;
                                                    }               
                                                }
                
                                                for(int G=0;G<MessageString.length;G++)
                                                {
                                                    if (MessageString[G]==null)
                                                        {
                                                        
                                                        }
                                                    else
                                                        {
                                                            StringTokenizer Spacetokens = new StringTokenizer(MessageString[G], " ", true);
                                                            if(Spacetokens.countTokens() == 1)
                                                                {
                                                                    System.out.println("Space Token is "+Spacetokens.countTokens());                                                                                                     
                                                                    //String commandname = "Status";
                                                                    if("STATUS".equals(Spacetokens.nextToken().trim().toUpperCase()))
                                                                        {
                                                                            // pst.setString(11, "STATUS");
                                                                            for(int i =0;i<4;i++)
                                                                                {
                                                                                    AllMessageString = AllMessageString.concat(" "+HostMessageString[0][i]);
                                                                                }
                                                                            StatusCommand(AllMessageString,"",HostMessageString);                                                                                                                                                              
                                                                        }
                                                                    else
                                                                        {
                                                                            System.out.println("Command is not Status, Command is "+Spacetokens.nextToken());
                                                                            //SendErrorMessage("Command is not Status, Command is "+Spacetokens.nextToken());
                                                                        }                            
                                                                }
                                                            else
                                                                {
                                                                    if(Spacetokens.countTokens() >6)
                                                                        {
                                                                            System.out.println("Command Is More Than "+Spacetokens.countTokens());
                                                                            //  SendErrorMessage();
                                                                        }
                                                                    else
                                                                        {
                                                                            // pst.setString(11, null);
                                                                            int fieldnumber = 12;                                                                        
                                                                            while(Spacetokens.hasMoreTokens())
                                                                                {
                                                                                    if (fieldnumber==12)
                                                                                        {
                                                                                            //   pst.setString(fieldnumber, (subtokens.nextToken().length() == 0 ? "" : subtokens.nextToken()));
                                                                                            //System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+spacetokens.nextToken());
                                                                
                                                                                            String FirstSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                            System.out.println("FieldNumber is "+fieldnumber+" and FirstSpaceTokenSMSCommandName Is  "+FirstSpaceTokenSMSCommandName);                                                                                                                             
                                                                
                                                                                            if ("STATUS".equals(FirstSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                {
                                                                                                    System.out.println(FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                                                    rs = cmd.executeQuery("SELECT COUNT(*) AS CNT FROM parallel_comm_port_view ");
                                                                                                    String[] TempHostString = new String[rowCount];
                                                                                                    String[] ExistTempHostString = new String[rowCount];
                                                                                                    boolean exist = false;
                                                                                                    for (int a=0;a<rowCount;a++)
                                                                                                        {
                                                                                                            TempHostString[a] = AreaName[a][11];
                                                                                                            exist = false;
                                                                                                            for (int b=0;b<rowCount;b++)
                                                                                                            {
                                                                                                                if(TempHostString[a].equalsIgnoreCase(ExistTempHostString[b]))
                                                                                                                        {
                                                                                                                            exist = true;
                                                                                                                        }
                                                                                                            }
                                                                                                            if(exist)
                                                                                                                {
                                                                                                                
                                                                                                                }
                                                                                                            else
                                                                                                                {
                                                                                                                    ExistTempHostString[a] = TempHostString[a];
                                                                                                                }   
                                                                                                        }
                                                                                                    for (int c=0; c<rowCount;c++)
                                                                                                        {
                                                                                                            if (ExistTempHostString[c] == null)
                                                                                                                {
                                                                                                                    
                                                                                                                }
                                                                                                            else
                                                                                                                {
                                                                                                                    HostCount++;
                                                                                                                }
                                                                                                            
                                                                                                        }
                                                                                                    String SecondSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                    StatusCommand(FirstSpaceTokenSMSCommandName,SecondSpaceTokenSMSCommandName,HostMessageString);                                                                
                                                                                                }
                                                                                            //This elseif is for FirstSpaceTokenSMSCommend is not STATUS And It is ALL
                                                                                            else if ("ALL".equals(FirstSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                {
                                                                                                    System.out.println(" Device Pin Number is ALL found in database And ");                                                                                                   
                                                                                                    System.out.println(FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                                                    String SecondSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                    WriteDeviceAllCommand(FirstSpaceTokenSMSCommandName, HostMessageString, SecondSpaceTokenSMSCommandName);                                                                                                                                                                                                                                                             
                                                                                                }
                                                                                            //This else is for FirstSpaceTokenSMSCommend is not STATUS or ALL
                                                                                            else
                                                                                                {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                                                                                                    // This Loop is to check whether FirstSpaceTokenSMSCommand is related with this host or not? this host                                                                                                                            
                                                                                                    if (MessageInHost(HostMessageString,FirstSpaceTokenSMSCommandName))
                                                                                                        {
                                                                                                            AllMessageString = FirstSpaceTokenSMSCommandName;
                                                                                                            System.out.println("FieldNumber is "+fieldnumber+" and FirstSpaceTokenSMSCommandName Is  "+FirstSpaceTokenSMSCommandName.trim().toUpperCase()+" FirstSpaceTokenSMSCommandName is found in database ");
                                                                                                            String SecondSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                            if ("STATUS".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                {
                                                                                                                    System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                                    String ThirdSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                    StatusCommand(AllMessageString, ThirdSpaceTokenSMSCommandName, HostMessageString);
                                                                                                                }
                                                                                                            else if("ALL".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                {
                                                                                                                    System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                                    String ThirdSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                    WriteDeviceAllCommand(FirstSpaceTokenSMSCommandName, HostMessageString, ThirdSpaceTokenSMSCommandName);
                                                                                                                }
                                                                                                            else if(EquipmentCommand(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                {
                                                                                                                    WriteEquipment(HostMessageString, FirstSpaceTokenSMSCommandName, SecondSpaceTokenSMSCommandName.trim().toUpperCase());
                                                                                                                }
                                                                                                            else
                                                                                                                {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
                                                                                                                    // This Loop is to check whether SecondSpaceTokenSMSCommand is related with this host or not? this host                                                                                                                                                                                    
                                                                                                                    if (MessageInHost(HostMessageString,SecondSpaceTokenSMSCommandName))
                                                                                                                        {                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                            AllMessageString = AllMessageString.concat(" "+SecondSpaceTokenSMSCommandName);
                                                                                                                            System.out.println(SecondSpaceTokenSMSCommandName.trim().toUpperCase()+" SecondSpaceTokenSMSCommandName is found in database ");
                                                                                                                            String ThirdSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                            if ("STATUS".equals(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                {
                                                                                                                                    System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                    String FourthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                    StatusCommand(AllMessageString,FourthSpaceTokenSMSCommandName,HostMessageString);
                                                                                                                                }
                                                                                                                            else if("ALL".equals(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                {
                                                                                                                                    System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                    String FourthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                    WriteDeviceAllCommand(FirstSpaceTokenSMSCommandName, HostMessageString, FourthSpaceTokenSMSCommandName);
                                                                                                                                }
                                                                                                                            else if(EquipmentCommand(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                {
                                                                                                                                    WriteEquipment(HostMessageString, SecondSpaceTokenSMSCommandName.trim().toUpperCase(), ThirdSpaceTokenSMSCommandName.trim().toUpperCase());
                                                                                                                                }
                                                                                                                            else
                                                                                                                                {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
                                                                                                                                    // This Loop is to check whether SecondSpaceTokenSMSCommand is related with this host or not? this host                                                                                                                                                                                                            
                                                                                                                                    if (MessageInHost(HostMessageString,ThirdSpaceTokenSMSCommandName))
                                                                                                                                        {
                                                                                                                                            AllMessageString = AllMessageString.concat(" "+ThirdSpaceTokenSMSCommandName);
                                                                                                                                            System.out.println(ThirdSpaceTokenSMSCommandName.trim().toUpperCase()+" ThirdSpaceTokenSMSCommandName is found in database ");
                                                                                                                                            String FourthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                            if ("STATUS".equals(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                {
                                                                                                                                                    System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                    String FifthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                    StatusCommand(AllMessageString,FifthSpaceTokenSMSCommandName,HostMessageString);
                                                                                                                                                }
                                                                                                                                            else if("ALL".equals(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                {
                                                                                                                                                    System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                    String FifthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                    WriteDeviceAllCommand(FirstSpaceTokenSMSCommandName, HostMessageString, FifthSpaceTokenSMSCommandName);
                                                                                                                                                }
                                                                                                                                            else if(EquipmentCommand(FourthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                {
                                                                                                                                                    WriteEquipment(HostMessageString, ThirdSpaceTokenSMSCommandName.trim().toUpperCase(), FourthSpaceTokenSMSCommandName.trim().toUpperCase());
                                                                                                                                                }
                                                                                                                                            else
                                                                                                                                                {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
                                                                                                                                                    if (MessageInHost(HostMessageString,FourthSpaceTokenSMSCommandName))
                                                                                                                                                        {
                                                                                                                                                            AllMessageString = AllMessageString.concat(" "+FourthSpaceTokenSMSCommandName);
                                                                                                                                                            System.out.println(FourthSpaceTokenSMSCommandName.trim().toUpperCase()+" FourthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                            String FifthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                            if ("STATUS".equals(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                {
                                                                                                                                                                    System.out.println(FifthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                    String SixthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                                    StatusCommand(AllMessageString, SixthSpaceTokenSMSCommandName, HostMessageString);
                                                                                                                                                                }
                                                                                                                                                            else if("ALL".equals(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                {
                                                                                                                                                                    System.out.println(FifthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                    String SixthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                                    WriteDeviceAllCommand(FirstSpaceTokenSMSCommandName, HostMessageString, SixthSpaceTokenSMSCommandName);
                                                                                                                                                                }
                                                                                                                                                            else if(EquipmentCommand(FifthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                {
                                                                                                                                                                    WriteEquipment(HostMessageString, FourthSpaceTokenSMSCommandName.trim().toUpperCase(), FifthSpaceTokenSMSCommandName.trim().toUpperCase());
                                                                                                                                                                }
                                                                                                                                                            else
                                                                                                                                                                {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
                                                                                                                                                                    AllMessageString = AllMessageString.concat(" "+FifthSpaceTokenSMSCommandName);
                                                                                                                                                                    System.out.println(FifthSpaceTokenSMSCommandName.trim().toUpperCase()+" FifthSpaceTokenSMSCommandName is found in database ");
                                                                                                                                                                    String SixthSpaceTokenSMSCommandName = Spacetokens.nextToken();
                                                                                                                                                                    if ("STATUS".equals(SixthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                        {
                                                                                                                                                                            System.out.println(SixthSpaceTokenSMSCommandName.trim().toUpperCase()+" SixthSpaceTokenSMSCommandName is found in database ");                                                                                                                                                                            
                                                                                                                                                                            StatusCommand(AllMessageString, "", HostMessageString);
                                                                                                                                                                        }                                                                                                                                                                    
                                                                                                                                                                    else if(EquipmentCommand(SixthSpaceTokenSMSCommandName.trim().toUpperCase()))
                                                                                                                                                                        {
                                                                                                                                                                            WriteEquipment(HostMessageString, FifthSpaceTokenSMSCommandName.trim().toUpperCase(), SixthSpaceTokenSMSCommandName.trim().toUpperCase());
                                                                                                                                                                        }
                                                                                                                                                                    else
                                                                                                                                                                        {
                                                                                                                                                                            System.out.println(SixthSpaceTokenSMSCommandName.trim().toUpperCase()+" SixthSpaceTokenSMSCommandName is not found in database ");
                                                                                                                                                                            //SendErrorMessage(SixthSpaceTokenSMSCommandName.trim().toUpperCase()+" is not found in database ");
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
                                                    // end of all code copied from java Shamim Ahmed Chowdhury                                                                                                
                                                    pst.setString(10, msg.getGatewayId());
                                                    pst.setString(11, msg.getGatewayAddress());
                                                    pst.setString(12,getServer().getHostAddress());
                                                    pst.executeUpdate();
                                                }
                                        }
				}
                                                                  
                                rs.close();
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
        
        // this is my copy from iotest.java Shamim Ahmed Chowdhury
        
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
        
        public  void StatusCommand(String FirstSpaceTokenSMSCommandName, String SecondSpaceTokenSMSCommandName, String AreaName[][] ) throws InterruptedException
            {                                                                                                                    
                if ("ON".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                       
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(ParallelMessage, AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else if("OFF".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(ParallelMessage, AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS STring");
                    }
                else if("TG".equals(SecondSpaceTokenSMSCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand is "+SecondSpaceTokenSMSCommandName);
                        System.out.println("SMS String is : "+SendStatusMessage(ParallelMessage, AreaName,SecondSpaceTokenSMSCommandName)+" End Of SMS String");
                    }
                else
                    {
                        System.out.println("SecondSpaceTokenSMSCommandName is "+SecondSpaceTokenSMSCommandName+" And StatusCommand Is : "+SecondSpaceTokenSMSCommandName +" And StatusCommand Is Not Supported");
                        //  SendErrorMessage();                                                                                
                    }                                         
            } 
                        
        public  String SendStatusMessage(String AllMessageString, String AreaName[][], String StatusCommand ) throws InterruptedException
                {
                    String SmsOut = AllMessageString;               
                    for (int j=0;j<2;j++)
                        {
                            Addr=Short.parseShort(HostMessageString[0][6], 16);
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
                    Connection con = null;
                    try
			{
                            String textCheck = null;
                            int Host_Address_Count = 0;
                            con = getDbConnection();
                            Statement cmd;
                            PreparedStatement pst;
                            cmd = con.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_UPDATABLE);
                            ResultSet rs;
                            rs = cmd.executeQuery("select id, type, recipient, text, create_date, originator, encoding, status_report, flash_sms, src_port, dst_port, sent_date, ref_no, priority, status, errors, gateway_id, gateway_address, host_address, host_address_counter from " + getProperty("tables.sms_out", "smsserver_parallel_out") + " where type = 'N' AND status = 'U' order by priority desc, id");
                            while (rs.next())
				{
                                    textCheck = rs.getString("text");
                                    for(int t=0;t<4;t++)
                                        {
                                            if (!textCheck.contains(HostMessageString[0][t])) 
                                            {
                                                textCheck = HostMessageString[0][t].concat(" "+textCheck);   
                                            } 
                                            else 
                                            {
                                            }
                                        }
                                }
                            
                            if((Host_Address_Count+1) == HostCount)
                                {
                                    Host_Address_Count++;
                                    cmd.executeUpdate("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'U' where status = 'Q' AND set type = 'O' where type = 'N'");
                                }
                            else
                                {
                                    Host_Address_Count++;
                                    cmd.executeUpdate("update " + getProperty("tables.sms_out", "smsserver_parallel_out") + " set status = 'U' where status = 'Q'");
                                }
                            
                            con.commit();
                            rs.close();
                            cmd.close();
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
                    return SmsOut;
                }
        
         public  void WriteDeviceAllCommand(String LPTDeviceName, String AreaName[][], String DeviceCommand )
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
                            Addr=Short.parseShort(HostMessageString[0][6], 16) ;
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
                
        public  void AllStatusCommand(String AllMessageString, String StatusCommand, String AreaName[][] ) throws InterruptedException
            {                                                                                                                    
                if ("ON".equals(StatusCommand.trim().toUpperCase()))
                    {                       
                        System.out.println("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand is "+StatusCommand);
                        System.out.println("SMS String is : "+SendStatusMessage(AllMessageString, AreaName, StatusCommand)+" End Of SMS String");
                    }
                else if("OFF".equals(StatusCommand.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand is "+StatusCommand);
                        System.out.println("SMS String is : "+SendStatusMessage(AllMessageString, AreaName, StatusCommand)+" End Of SMS STring");
                    }
                else if("TG".equals(StatusCommand.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand is "+StatusCommand);
                        System.out.println("SMS String is : "+SendStatusMessage(AllMessageString, AreaName, StatusCommand)+" End Of SMS String");
                    }
                else if("".equals(StatusCommand.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand is "+StatusCommand);
                        System.out.println("SMS String is : "+SendStatusMessage(AllMessageString, AreaName, StatusCommand)+" End Of SMS String");
                    }
                else
                    {
                        System.out.println("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand Is : "+StatusCommand +" And StatusCommand Is Not Supported");
                        //  SendErrorMessage("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand Is : "+StatusCommand +" And StatusCommand Is Not Supported");                                                                                
                    }                                         
            }
        
        public  boolean MessageInHost(String[][] HostMessageString, String SpaceTokenSMSCommandName )
            {
                boolean InHost;
                InHost = false;
                for(int s=0;s<128;s++)
                    {
                        for(int t=0;t<15;t++)
                            {
                                if (HostMessageString[s][t].toUpperCase().trim().equals(SpaceTokenSMSCommandName.trim().toUpperCase()))
                                    {
                                        InHost = true;
                                    }
                            }
                    }
                return InHost;   
            }
        
        public  boolean MessageInDataBase(String[][] DataBaseMessageString, String SpaceTokenSMSCommandName )
            {
                boolean InHost;
                InHost = false;
                for(int s=0;s<rowCount;s++)
                    {
                        for(int t=0;t<15;t++)
                            {
                                if (DataBaseMessageString[s][t].toUpperCase().trim().equals(SpaceTokenSMSCommandName.trim().toUpperCase()))
                                    {
                                        InHost = true;
                                    }
                            }
                    }
                return InHost;   
            }
                
        public int ReturnHostCount(String FirstSpaceCommandName, String SecondSpaceCommandName, String ThirdSpaceCommandName, String FourthSpaceCommandName, String FifthSpaceCommandName )
            {                
                String[] TempHostString = new String[rowCount];
                String[] ExistTempHostString = new String[rowCount];
                boolean exist, First, Second, Third, Fourth, Fifth =  false;                                                                              
                HostCount = 0;
                for (int a=0;a<rowCount;a++)
                    {
                        for (int b=0;b<15;b++)
                            {
                                if(FirstSpaceCommandName.equalsIgnoreCase(AreaName[a][b]))
                                    {
                                        First = true;
                                        TempHostString[b] = AreaName[a][11];
                                    }
                                else if(SecondSpaceCommandName.equalsIgnoreCase(AreaName[a][b]))
                                    {
                                        Second = true;
                                        TempHostString[b] = AreaName[a][11];
                                    }
                                else if(ThirdSpaceCommandName.equalsIgnoreCase(AreaName[a][b]))
                                    {
                                        Third = true;
                                        TempHostString[b] = AreaName[a][11];
                                    }
                                else if(FourthSpaceCommandName.equalsIgnoreCase(AreaName[a][b]))
                                    {
                                        Fourth = true;                                        
                                        TempHostString[b] = AreaName[a][11];
                                    }
                                else if(FifthSpaceCommandName.equalsIgnoreCase(AreaName[a][b]))
                                    {
                                        Fifth = true;
                                        TempHostString[b] = AreaName[a][11];
                                    }                                                                                                                                                                                                                        
                            }
                        TempHostString[a] = AreaName[a][11];
                        exist = false;
                        for (int b=0;b<rowCount;b++)
                            {
                                if(TempHostString[a].equalsIgnoreCase(ExistTempHostString[b]))
                                    {
                                        exist = true;
                                    }                                        
                            }
                        if(exist)
                            {
                                                           
                            }
                        else
                            {
                                ExistTempHostString[a] = TempHostString[a];
                            }   
                    }
                for (int c=0; c<rowCount;c++)
                    {
                        if (ExistTempHostString[c] == null)
                            {
                                                                                
                            }
                        else
                            {
                                HostCount++;
                            }
                                                                                                            
                    }
                
                return HostCount;
            }
                
        public  boolean EquipmentCommand(String EquipmentCommandName) throws InterruptedException
            {                                                                                                                    
                boolean EquipmentCommand = false;
                if ("ON".equals(EquipmentCommandName.trim().toUpperCase()))
                    {                       
                        System.out.println("SpaceTokenSMSCommandName is "+EquipmentCommandName+" And StatusCommand is "+EquipmentCommandName);
                        EquipmentCommand = true;
                    }
                else if("OFF".equals(EquipmentCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+EquipmentCommandName+" And StatusCommand is "+EquipmentCommandName);
                        EquipmentCommand = true;
                    }
                else if("TG".equals(EquipmentCommandName.trim().toUpperCase()))
                    {                        
                        System.out.println("SecondSpaceTokenSMSCommandName is "+EquipmentCommandName+" And StatusCommand is "+EquipmentCommandName);
                        EquipmentCommand = true;
                    }                
                else
                    {
                        System.out.println("SecondSpaceTokenSMSCommandName is "+EquipmentCommandName+" And StatusCommand Is : "+EquipmentCommandName +" And StatusCommand Is Not Supported");
                        //  SendErrorMessage("SecondSpaceTokenSMSCommandName is "+StatusCommand+" And StatusCommand Is : "+StatusCommand +" And StatusCommand Is Not Supported");                                                                                
                    }
                return EquipmentCommand; 
            }

    /**
     *
     * @param DataBaseString
     * @param EquipmentName
     * @param EquipmentCommand
     */
    public  void WriteEquipment(String[][] DataBaseString, String EquipmentName, String EquipmentCommand )
                {                   
                    char firstLetter = '0';
                    char CharPosForToggle = '0';                    
                    String stat = "";                    
                    int aPinNumberInt = 0;
                    int PinNumber = 0;
                    String PinCommand = "";
                    for(int i=0;i<rowCount;i++)
                        {
                            for(int j=7;j<15;j++)
                                {
                                    if (DataBaseString[i][j].toUpperCase().equals(EquipmentName.trim().toUpperCase()))
                                        {
                                            System.out.println(EquipmentName.trim().toUpperCase()+" Equipment is found in database ");
                                            PinNumber = j-6;
                                            System.out.println(PinNumber+" is Pin Number of "+EquipmentName+" found in database ");
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
                                                            
                     if ("ON".equals(EquipmentCommand.trim().toUpperCase()))
                        {
                            PinCommand = "1";
                            firstLetter = PinCommand.charAt(0);
                            System.out.println("Command is "+EquipmentCommand+" And PinCommand is "+PinCommand);                           
                        }
                     else if("OFF".equals(EquipmentCommand.trim().toUpperCase()))
                        {
                            PinCommand = "0";
                            firstLetter = PinCommand.charAt(0);
                            System.out.println("Command is "+EquipmentCommand+" And PinCommand is "+PinCommand);  
                        }
                     else if("TG".equals(EquipmentCommand.trim().toUpperCase()))
                        {
                            PinCommand = "2";                           
                            System.out.println("Command is "+EquipmentCommand+" And PinCommand is "+PinCommand);
                        }
                                          
                     stat = do_read_register(Addr);
                     System.out.println("Binary Number is "+stat+" And Stat Length is "+stat.length());
                     if(stat.length()<8)
                        {
                            for (int i=0;i<(8-stat.length());i++)
                                {
                                    stat = "0".concat(stat);
                                    System.out.println("Concatenated string "+stat);
                                }
                        }                                                            
                     char[] chars = stat.toCharArray();
                     System.out.println("Binary String Before replacement: "+stat);                                                                                    
                     
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
                                                                                  
                    Addr=0x378;
                    String writedatum = Integer.toHexString(Integer.parseInt(stat,2));
                    System.out.println("Check To See hexstring : "+writedatum);                    
                    datum = Short.parseShort(writedatum, 16) ;                    
                    do_write(Addr,datum);
                    stat = do_read_register(Addr);
                    System.out.println("Check To See if we write properly: "+stat);                                                                                                                                                                                     
                }                         
        // end of my copy from iotest.java shamim
        
        
        //Scratch Writing of PutSratusInSMS Function --- Data 08-06-2014 --- author shamim Ahmed Chowdhury
	// Status All SMS for a Country/DivisionDistrict/UpaZillaUnion/Area Or Ward/Building/Floor/Flat/Room/Computer Or Host(Doskless)
	public  void PutSratusInSMS(String SMSOut, Sreing[][] AreaName, String HostAreaName, String[] SpaceToken, String Status)
		{
	       		if (SMSOut.Contains(SpaceToken)
	       			{

					SpaceToken.Remove[0]; //First
					PutStatusInSMS(SMSOut, AreaName, HostAreaName, SpaceToken, Status);
	       			}
	       		else
	       			{
	       				for(int i = 0; i < BuildingArray.Length; i++)
	       					{
	       						if (SMSOut.Contains(Spacetoken)
	       							{
	       								SpaceToken.Remove[0];  //Forst
										       							
	       							}
	       						else
	       							{
	       								for(int j=2; i < Buildong - 10; i++)
	       									{
	       										if (SMSOut.Contains(BuildingArray[j])
	       											{
	       												Boolean BeforePosition = True;
	       											}
	       									}
	       								for(for v()
	       					}
	       			}
	       			
	       			
		}


