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

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.Reader;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import java.util.Properties;
import org.jivesoftware.smack.Chat;
import org.jivesoftware.smack.ChatManager;
import org.jivesoftware.smack.ConnectionConfiguration;
import org.jivesoftware.smack.MessageListener;
import org.jivesoftware.smack.Roster;
import org.jivesoftware.smack.RosterEntry;
import org.jivesoftware.smack.SmackConfiguration;
import org.jivesoftware.smack.XMPPConnection;
import org.jivesoftware.smack.XMPPException;
import org.jivesoftware.smack.ConnectionConfiguration.SecurityMode;
import org.jivesoftware.smack.PacketCollector;
import org.jivesoftware.smack.packet.Message;
import org.jivesoftware.smack.packet.Presence;
import org.jivesoftware.smack.PacketListener;
import org.jivesoftware.smack.filter.AndFilter;
import org.jivesoftware.smack.filter.FromContainsFilter;
import org.jivesoftware.smack.filter.PacketFilter;
import org.jivesoftware.smack.filter.PacketTypeFilter;
import org.jivesoftware.smack.packet.Packet;
import org.jivesoftware.smack.packet.Presence.Type;



import org.smslib.InboundMessage;
import org.smslib.OutboundMessage;
import org.smslib.Message.MessageEncodings;
import org.smslib.helper.ExtStringBuilder;
import org.smslib.helper.Logger;
import org.smslib.smsserver.SMSServer;

/**
 * Interface for IM Message communication with SMSServer. <br />
 * @author Shamim Ahmed Chowdhury
 * @author E-mail: shamim8888@gmail.com
 * 
 */
public class IMMessage extends Interface<Integer>
{
	private static final int packetReplyTimeout = 500; // millis
	//private String server;
	//private int port;
	private ConnectionConfiguration config;
	private XMPPConnection connection;
	private ChatManager chatManager;
	private MessageListener messageListener;
        private String messageSubject;
	private String messageBody;
        private String msgBody;
        private String msgFrom ;

	public IMMessage(String myInterfaceId, Properties myProps, SMSServer myServer, InterfaceTypes myType)
	{
		super(myInterfaceId, myProps, myServer, myType);
		setDescription("Default Message Interface for communication.");
	}

	@Override
	public void messagesReceived(Collection<InboundMessage> msgList) throws Exception
	{
		for (InboundMessage im : msgList)
		{
			Message sndMsg = new Message();
			//msg.setFrom();
			//msg.addRecipient(RecipientType.TO, new InternetAddress(getProperty("to")));
			sndMsg.setSubject(updateTemplateString(this.messageSubject, im));
			if (this.messageBody != null)
			{
				sndMsg.setBody(updateTemplateString(this.messageBody, im));
			}
			else
			{
				sndMsg.setBody(im.toString());
			}
			//msg.setDate(im.getDate());
                        //sendMessage("From Received Message", "shamim@ns1");
                        //String fromReceivedMessage = sndMsg.getBody();
                        //System.out.println(fromReceivedMessage);
                        String fromReceivedMessageBuddy = getProperty("buddyJID")+"@"+getProperty("host");
                        System.out.println(fromReceivedMessageBuddy);
			sendMessage(sndMsg.getBody(), fromReceivedMessageBuddy);
		}
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see org.smslib.smsserver.AInterface#getMessagesToSend()
	 */
	@Override
	public Collection<OutboundMessage> getMessagesToSend() throws Exception
	{
		List<OutboundMessage> retValue = new ArrayList<OutboundMessage>();
                
               // Message msg = new Message();
               // MyMessageListener s = new MyMessageListener();
               // s.processMessage(null, msg);
		//s.connect();
		//Folder inbox = s.getFolder(getProperty("mailbox_name", "INBOX"));
		//inbox.open(Folder.READ_WRITE);
                //Message msg = new Message();
                Date presenttime = new Date();
                PacketCollector collector = connection.createPacketCollector(filter);
		Message msg =  (Message) collector.pollResult();
		
                //connection.addPacketListener(myListener, filter);
                        if (this.msgBody != null)
                            {
                                OutboundMessage om = new OutboundMessage(getProperty("userPhone"), msgBody);
                       
                                om.setFrom(getProperty("buddyJID").toString());
                                om.setDate(presenttime);
                                retValue.add(om);
                                collector.cancel();
                                msgBody = null;
                            }
                            // Delete message from inbox
                            
		//}
		//inbox.close(true);
		//s.close();
		return retValue;
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see org.smslib.smsserver.AInterface#start()
	 */
	@Override
	public void start() throws Exception
	{
		Properties messageProps = new Properties();
		
                messageProps.setProperty("message.host", getProperty("host"));
		messageProps.setProperty("message.port", getProperty("port"));
		messageProps.setProperty("message.username", getProperty("username"));
		messageProps.setProperty("message.password", getProperty("password"));
                messageProps.setProperty("message.userPhone", getProperty("userPhone"));
                messageProps.setProperty("message.buddyJID", getProperty("buddyJID"));
                messageProps.setProperty("message.buddyName", getProperty("buddyName"));
                //System.out.println(String.format("Initializing connection to server %1$s port %2$d", getProperty("host").toString(), getProperty("port").toString()));
                
		SmackConfiguration.setPacketReplyTimeout(packetReplyTimeout);
			                            
                config = new ConnectionConfiguration(getProperty("host"), Integer.parseInt(getProperty("port")));
		config.setSASLAuthenticationEnabled(true);
		config.setSecurityMode(SecurityMode.enabled);
		
		connection = new XMPPConnection(config);
		connection.connect();
		
		System.out.println("Connected: " + connection.isConnected());
		
		chatManager = connection.getChatManager();
		//messageListener = new MyMessageListener();
               
               	
		performLogin(getProperty("username"),getProperty("password"));
		setStatus(true, "Hello everyone");
				
		createEntry(getProperty("buddyJID"), getProperty("buddyName"));
		
		//sendMessage("Hello from smslib", "shamim@ns1");
		
		printRoster();
		connection.addPacketListener(myListener, filter);
				
		if (isOutbound())
		{
			prepareMessageTemplate();
		}
		super.start();
	}
        
        public void performLogin(String username, String password) throws XMPPException {
		if (connection!=null && connection.isConnected()) {
			connection.login(username, password);
		}
	}
        
        public void setStatus(boolean available, String status) {
		
		Presence.Type type = available? Type.available: Type.unavailable;
		Presence presence = new Presence(type);
		
		presence.setStatus(status);
		connection.sendPacket(presence);
		
	}
        
        public void destroy() {
		if (connection!=null && connection.isConnected()) {
			connection.disconnect();
		}
	}
	
	public void printRoster() throws Exception {
		Roster roster = connection.getRoster();
		Collection<RosterEntry> entries = roster.getEntries();		
		for (RosterEntry entry : entries) {
		    System.out.println(String.format("Buddy:%1$s - Status:%2$s", 
		    		entry.getName(), entry.getStatus()));
		}
	}
        
        public void sendMessage(String message, String buddyJID) throws XMPPException {
		System.out.println(String.format("Sending message '%1$s' to user %2$s", message, buddyJID));
		Chat chat = chatManager.createChat(buddyJID, messageListener);
		chat.sendMessage(message);
	}
	
	public void createEntry(String user, String name) throws Exception {
		System.out.println(String.format("Creating entry for buddy '%1$s' with name %2$s", user, name));
		Roster roster = connection.getRoster();
		roster.createEntry(user, name, null);
	}
        
        class MyMessageListener implements MessageListener {
                //private String from = "smslib";
                //private String body = "Test From smslib";
		@Override
		public void processMessage(Chat chat, Message message) {
			 String from = message.getFrom();
			 String body = message.getBody();
			System.out.println(String.format("Received message '%1$s' from %2$s", body, from));
		}
		
	}
        
        PacketFilter  filter = new AndFilter(new PacketTypeFilter(Message.class), new FromContainsFilter("shamim@ns1") );
                PacketListener myListener = new PacketListener(){
                  public void processPacket(Packet packet)
                        {
                            if (packet instanceof Message )
                                {
                                    Message msg = (Message) packet;
                                    //Process Message
                                    msgFrom = msg.getFrom();
                                    msgBody = msg.getBody();
                                    System.out.println("Message Received, Loud And Clear:"+msg.getBody());
                                }
                        }
                };
                
       // PacketCollector collector = connection.createPacketCollector(filter);
        

	private String updateTemplateString(String template, InboundMessage msg)
	{
		ExtStringBuilder sb = new ExtStringBuilder(template);
		sb.replaceAll("%gatewayId%", msg.getGatewayId());
		sb.replaceAll("%encoding%", (msg.getEncoding() == MessageEncodings.ENC7BIT ? "7-bit" : (msg.getEncoding() == MessageEncodings.ENC8BIT ? "8-bit" : "UCS2 (Unicode)")));
		sb.replaceAll("%date%", msg.getDate().toString());
		sb.replaceAll("%text%", msg.getText());
		sb.replaceAll("%pduUserData%", msg.getPduUserData());
		sb.replaceAll("%originator%", msg.getOriginator());
		sb.replaceAll("%memIndex%", msg.getMemIndex());
		sb.replaceAll("%mpMemIndex%", msg.getMpMemIndex());
		return sb.toString();
	}

	private void prepareMessageTemplate()
	{
		this.messageSubject = getProperty("message_subject");
		if (this.messageSubject == null ||this. messageSubject.length() == 0)
		{
			Logger.getInstance().logWarn("No message_subject found - Using default", null, null);
			this.messageSubject = "SMS from %ORIGINATOR%";
		}
		File f = new File(getProperty("message_body"));
		if (f.canRead())
		{
			try
			{
				Reader r = new FileReader(f);
				BufferedReader br = new BufferedReader(r);
				String line = null;
				StringBuilder sb = new StringBuilder();
				while ((line = br.readLine()) != null)
				{
					sb.append(line);
				}
				this.messageBody = sb.toString();
			}
			catch (IOException e)
			{
				Logger.getInstance().logError("I/O-Exception while reading message body template: " + e.getMessage(), null, null);
			}
		}
		if (this.messageBody == null || this.messageBody.length() == 0)
		{
			Logger.getInstance().logWarn("message_body can't be read or is empty - Using default", null, null);
			this.messageBody = null;
		}
	}
}
