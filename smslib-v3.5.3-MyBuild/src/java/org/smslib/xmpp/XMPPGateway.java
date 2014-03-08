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

package org.smslib.xmpp;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.Reader;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import java.util.Properties;
import java.util.logging.Level;
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
import org.smslib.helper.ExtStringBuilder;
import org.smslib.helper.Logger;
import org.smslib.smsserver.SMSServer;
import org.smslib.AGateway;
import org.smslib.GatewayException;
import org.smslib.InboundMessage;
import org.smslib.OutboundMessage;
import org.smslib.Service;
import org.smslib.StatusReportMessage;
import org.smslib.TimeoutException;
import org.smslib.Message.MessageEncodings;
import org.smslib.Message.MessageTypes;
import org.smslib.OutboundMessage.FailureCauses;
import org.smslib.OutboundMessage.MessageStatuses;
import org.smslib.StatusReportMessage.DeliveryStatuses;
import org.smslib.helper.Logger;
import org.smslib.notify.InboundMessageNotification;



/**
 * A gateway that supports Xmpp through XMPP (https://github.com/shamim8888/SMSlib-ParallelPort).
 * 
 * @author Shamim Ahmed Chowdhury
 */
public class XMPPGateway extends AbstractXmppGateway {

	
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
        private String username;
        private String password;
        //private String message_subject;
	//private String message_body;
       // private Session mailSession;
       // private Properties mailProps;

	/**
	 * @param id
	 * @param host
	 * @param port
	 * @param bindAttributes
	 */

    /**
     *
     * @param id
     * @param pop_protocol
     * @param host
     * @param port
     */
    public XMPPGateway(String id,  String host, String port, String username, String password, String userPhone, String buddyJID, String buddyName, String message_subject, String message_body) {
		super(id, host, port, username, password, userPhone, buddyJID, buddyName, message_subject, message_body);
                
                this.host=host;
		this.port=port;		
		this.username=username;
                this.password=password;
                this.userPhone=userPhone;
                this.buddyJID=buddyJID;	
		this.buddyName=buddyName;
                //this.smtp_password=smtp_password;
                //this.to=to;
                //this.from=from;
                this.messageSubject = message_subject;
                this.messageBody = message_body;
                
		setAttributes(AGateway.GatewayAttributes.SEND | AGateway.GatewayAttributes.CUSTOMFROM | AGateway.GatewayAttributes.BIGMESSAGES | AGateway.GatewayAttributes.FLASHSMS | AGateway.GatewayAttributes.RECEIVE);
		
		
	}
        
        
        

	
	@Override
	public void startGateway() throws TimeoutException, GatewayException,
			IOException, InterruptedException {
            try {
                Properties messageProps = new Properties();
                
                messageProps.setProperty("message.host", host);
                messageProps.setProperty("message.port", port);
                messageProps.setProperty("message.username", username);
                messageProps.setProperty("message.password", password);
                messageProps.setProperty("message.userPhone", userPhone);
                messageProps.setProperty("message.buddyJID", buddyJID);
                messageProps.setProperty("message.buddyName", buddyName);
                
                SmackConfiguration.setPacketReplyTimeout(packetReplyTimeout);
			                            
                config = new ConnectionConfiguration(host, Integer.parseInt(port));
                config.setSASLAuthenticationEnabled(true);
                config.setSecurityMode(SecurityMode.enabled);
                
                connection = new XMPPConnection(config);
                connection.connect();
                
                System.out.println("Connected: " + connection.isConnected());
                
                chatManager = connection.getChatManager();
                //messageListener = new MyMessageListener();
                
                
                performLogin(username,password);
                setStatus(true, "Hello everyone");
                try {
                    createEntry(buddyJID, buddyName);
                } catch (Exception ex) {
                    java.util.logging.Logger.getLogger(XMPPGateway.class.getName()).log(Level.SEVERE, null, ex);
                }
                try {
                    //sendMessage("Hello from smslib", "shamim@ns1");
                    
                    printRoster();
                } catch (Exception ex) {
                    java.util.logging.Logger.getLogger(XMPPGateway.class.getName()).log(Level.SEVERE, null, ex);
                }
                connection.addPacketListener(myListener, filter);
                
                
                
                if (isOutbound())
                {
                    prepareMessageTemplate();
                }
                Logger.getInstance().logInfo("Starting gateway.", null, getGatewayId());
                super.startGateway();
                Logger.getInstance().logInfo("Gateway started.", null, getGatewayId());
            } catch (XMPPException ex) {
                java.util.logging.Logger.getLogger(XMPPGateway.class.getName()).log(Level.SEVERE, null, ex);
            }
		
	}

	@Override
	public void stopGateway() throws TimeoutException, GatewayException,
			IOException, InterruptedException {
		Logger.getInstance().logInfo("Stopping gateway...", null, getGatewayId());
		super.stopGateway();
                Logger.getInstance().logInfo("Gateway stopped.", null, getGatewayId());
	}


        	public boolean readMessage(InboundMessage msg) throws TimeoutException, GatewayException, IOException, InterruptedException
	{
            
                List<InboundMessage> retValue = new ArrayList<InboundMessage>();
                Date presenttime = new Date();
                PacketCollector collector = connection.createPacketCollector(filter);
		Message IMmsg =  (Message) collector.pollResult();
		
                //connection.addPacketListener(myListener, filter);
                        if (this.msgBody != null)
                            {
                                InboundMessage om = new InboundMessage(presenttime,this.msgFrom, this.msgBody, this.host);
                       
                                om.setFrom(this.buddyJID.toString());
                                om.setDate(presenttime);
                                retValue.add(om);
                                collector.cancel();
                                this.msgBody = null;
                            }
                            // Delete message from inbox
                            
		//}
		//inbox.close(true);
		//s.close();
		
		
                
            
            return true;
        }
 

	

	@Override
	public boolean sendMessage(OutboundMessage msg) throws TimeoutException, GatewayException, IOException, InterruptedException
	{
            try {            
                Message sndMsg = new Message();
                //msg.setFrom();
                //msg.addRecipient(RecipientType.TO, new InternetAddress(getProperty("to")));
                sndMsg.setSubject(updateTemplateString(this.messageSubject, msg));
                if (this.messageBody != null)
                {
                    sndMsg.setBody(updateTemplateString(this.messageBody, msg));
                }
                else
                {
                    sndMsg.setBody(msg.toString());
                }
                //msg.setDate(im.getDate());
                //sendMessage("From Received Message", "shamim@ns1");
                //String fromReceivedMessage = sndMsg.getBody();
                //System.out.println(fromReceivedMessage);
                String fromReceivedMessageBuddy = buddyJID+"@"+host;
                System.out.println(fromReceivedMessageBuddy);
                sendMessage(sndMsg.getBody(), fromReceivedMessageBuddy);
                msg.setDispatchDate(new Date());
                msg.setMessageStatus(MessageStatuses.SENT);
                                                                                
                
            } catch (XMPPException ex) {
                java.util.logging.Logger.getLogger(XMPPGateway.class.getName()).log(Level.SEVERE, null, ex);
            }
            return true;
	}
                       
          
		

        
        private String updateTemplateString(String template, OutboundMessage msg)
	{
		ExtStringBuilder sb = new ExtStringBuilder(template);
		sb.replaceAll("%gatewayId%", msg.getGatewayId());
		sb.replaceAll("%encoding%", (msg.getEncoding() == MessageEncodings.ENC7BIT ? "7-bit" : (msg.getEncoding() == MessageEncodings.ENC8BIT ? "8-bit" : "UCS2 (Unicode)")));
		sb.replaceAll("%date%", msg.getDate().toString());
		sb.replaceAll("%text%", msg.getText());
		sb.replaceAll("%pduUserData%", msg.getPduUserData());
		//sb.replaceAll("%originator%", msg.getOriginator());
		//sb.replaceAll("%memIndex%", msg.getMemIndex());
		//sb.replaceAll("%mpMemIndex%", msg.getMpMemIndex());
		return sb.toString();
	}
        
        private void prepareMessageTemplate()
	{
		//this.messageSubject = "message_subject" ;
		if (this.messageSubject == null ||this.messageSubject.length() == 0)
		{
			Logger.getInstance().logWarn("No message_subject found - Using default", null, null);
			this.messageSubject = "SMS from %ORIGINATOR%";
		}
		File f = new File(this.messageBody);
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
        
        
        
}


