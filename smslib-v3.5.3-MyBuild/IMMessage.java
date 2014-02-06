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
import java.util.List;
import java.util.Properties;
import java.io.InputStreamReader;
import java.util.Iterator;
import org.jivesoftware.smack.Chat;
import org.jivesoftware.smack.ConnectionConfiguration;
import org.jivesoftware.smack.MessageListener;
import org.jivesoftware.smack.Roster;
import org.jivesoftware.smack.RosterEntry;
import org.jivesoftware.smack.XMPPConnection;
import org.jivesoftware.smack.XMPPException;
import org.jivesoftware.smack.packet.Message;



import org.smslib.InboundMessage;
import org.smslib.OutboundMessage;
import org.smslib.Message.MessageEncodings;
import org.smslib.Message.MessageTypes;
import org.smslib.helper.ExtStringBuilder;
import org.smslib.helper.Logger;
import org.smslib.smsserver.SMSServer;

/**
 * Interface for Email communication with SMSServer. <br />
 * Inbound messages are send via SMTP. Outbound messages are received via POP3.
 * 
 * @author Sebastian Just
 */
public class IMMessage extends Interface<Integer>
{
	ConnectionConfiguration connConfig = null;
        XMPPConnection xMPPConnection = null;
        BufferedReader readFromKeyboard = null;
        String toAddresss = null;
        String[] buddies = null;
        int buddySize = 0;

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
			Message msg = new MimeMessage(this.mailSession);
			msg.setFrom();
			msg.addRecipient(RecipientType.TO, new InternetAddress(getProperty("to")));
			msg.setSubject(updateTemplateString(this.messageSubject, im));
			if (this.messageBody != null)
			{
				msg.setText(updateTemplateString(this.messageBody, im));
			}
			else
			{
				msg.setText(im.toString());
			}
			msg.setSentDate(im.getDate());
			Transport.send(msg);
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
		Store s = this.mailSession.getStore();
		s.connect();
		Folder inbox = s.getFolder(getProperty("mailbox_name", "INBOX"));
		inbox.open(Folder.READ_WRITE);
		for (Message m : inbox.getMessages())
		{
			OutboundMessage om = new OutboundMessage(m.getSubject(), m.getContent().toString());
			om.setFrom(m.getFrom().toString());
			om.setDate(m.getReceivedDate());
			retValue.add(om);
			// Delete message from inbox
			m.setFlag(Flags.Flag.DELETED, true);
		}
		inbox.close(true);
		s.close();
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
		/**
                * Set the 'ConnectionConfiguration' with
                * -host name
                * -port number
                * -service name
                */
                connConfig = new ConnectionConfiguration("talk.google.com", 5222, "gmail.com");
                /**
                * Create an instance of 'XMPPConnection' with the already created
                * instance of 'ConnectionConfiguration'
                */
                xMPPConnection = new XMPPConnection(connConfig);
                try {
                        /**
                        * Connecting to the service
                        */
                        xMPPConnection.connect();
                        /**
                        * Login to the GMail account from which you want to chat
                        * Provide
                        * -email id
                        * -password
                        */
                        xMPPConnection.login("user-name@gmail.com", "password");
                    } catch (XMPPException ex) {
                        System.out.println("Error: " + ex.getMessage());
                    }
            
                
		if ("pop3".equals(getProperty("mailbox_protocol")))
		{
			mailProps.setProperty("mail.pop3.host", getProperty("mailbox_host"));
			mailProps.setProperty("mail.pop3.port", getProperty("mailbox_port"));
			mailProps.setProperty("mail.pop3.user", getProperty("mailbox_user"));
			mailProps.setProperty("mail.pop3.password", getProperty("mailbox_password"));
		}
		else if ("pop3s".equals(getProperty("mailbox_protocol")))
		{
			mailProps.setProperty("mail.pop3s.host", getProperty("mailbox_host"));
			mailProps.setProperty("mail.pop3s.port", getProperty("mailbox_port"));
			mailProps.setProperty("mail.pop3s.user", getProperty("mailbox_user"));
			mailProps.setProperty("mail.pop3s.password", getProperty("mailbox_password"));
		}
		else if ("imap".equals(getProperty("mailbox_protocol")))
		{
			mailProps.setProperty("mail.imap.host", getProperty("mailbox_host"));
			mailProps.setProperty("mail.imap.port", getProperty("mailbox_port"));
			mailProps.setProperty("mail.imap.user", getProperty("mailbox_user"));
			mailProps.setProperty("mail.imap.password", getProperty("mailbox_password"));
		}
		else if ("imaps".equals(getProperty("mailbox_protocol")))
		{
			mailProps.setProperty("mail.imaps.host", getProperty("mailbox_host"));
			mailProps.setProperty("mail.imaps.port", getProperty("mailbox_port"));
			mailProps.setProperty("mail.imaps.user", getProperty("mailbox_user"));
			mailProps.setProperty("mail.imaps.password", getProperty("mailbox_password"));
		}
		else
		{
			throw new IllegalArgumentException("mailbox_protocol have to be pop3(s) or imap(s)!");
		}
		mailProps.setProperty("mail.transport.protocol", "smtp");
		mailProps.setProperty("mail.from", getProperty("from"));
		mailProps.setProperty("mail.smtp.host", getProperty("smtp_host"));
		mailProps.setProperty("mail.smtp.port", getProperty("smtp_port"));
		mailProps.setProperty("mail.smtp.user", getProperty("smtp_user"));
		mailProps.setProperty("mail.smtp.password", getProperty("smtp_password"));
		mailProps.setProperty("mail.smtp.auth", "true");
		this.mailSession = Session.getInstance(mailProps, new javax.mail.Authenticator()
		{
			@Override
			protected PasswordAuthentication getPasswordAuthentication()
			{
				return new PasswordAuthentication(getProperty("mailbox_user"), getProperty("mailbox_password"));
			}
		});
		if (isOutbound())
		{
			prepareEmailTemplate();
		}
		super.start();
	}

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

	private void prepareEmailTemplate()
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
        
       /**
 *
 * @author dhanoopbhaskar
 */
public class GtalkClient implements Runnable, MessageListener {
   
    ConnectionConfiguration connConfig = null;
    XMPPConnection xMPPConnection = null;
    BufferedReader readFromKeyboard = null;
    String toAddresss = null;
    String[] buddies = null;
    int buddySize = 0;


    public GtalkClient() {
        /**
         * Set the 'ConnectionConfiguration' with
         * -host name
         * -port number
         * -service name
         */
        connConfig = new ConnectionConfiguration("talk.google.com", 5222, "gmail.com");
        /**
         * Create an instance of 'XMPPConnection' with the already created
         * instance of 'ConnectionConfiguration'
         */
        xMPPConnection = new XMPPConnection(connConfig);      
        try {
            /**
             * Connecting to the service
             */
            xMPPConnection.connect();
            /**
             * Login to the GMail account from which you want to chat
             * Provide
             * -email id
             * -password
             */
            xMPPConnection.login("user-name@gmail.com", "password");
        } catch (XMPPException ex) {
            System.out.println("Error: " + ex.getMessage());
        }
        /**
         * BufferedReader to read from the keyboard
         */
        readFromKeyboard = new BufferedReader(new InputStreamReader(System.in));
       
        displayBuddyList();
       
        System.out.println("\n\nEnter the recipient's Email Id! or "
                + "buddy id in the list");
        try {
            String temp = readFromKeyboard.readLine();
            try {
                int j = Integer.parseInt(temp);
                toAddresss = getBuddy(j);
                System.out.println("Buddy <" + toAddresss + "> selected!");
            } catch(NumberFormatException exp) {
                toAddresss = temp;
            }
        } catch (IOException ex) {
            System.out.println("Error: " + ex.getMessage());
        }
       
       
        System.out.println("Enter your chat messages one by one!");
        System.out.println("[Enter \"quit\" to end the chat!]");
       
        String msg = "";
        while(true) {
            try {
                msg = readFromKeyboard.readLine();
            } catch (IOException ex) {
                System.out.println("Error: " + ex.getMessage());
            }
           
            if(msg.equalsIgnoreCase("quit")) {
                System.out.println("--Chat Ended--");
                break;
            } else {
                sendMessage(toAddresss, msg);
            }
        }
    }


    /**
     *
     * @param recipient
     * @param message
     */
    private void sendMessage(String recipient, String message) {
        /**
         * Create an instance of 'Chat' providing the recipient's email-id
         * and an instance of MessageListener interface(The predefined
         * reference 'this' will do, since the class
         * implements the MessageListener interface.        
         */
        Chat chat = xMPPConnection.getChatManager().createChat(recipient, this);
        try {
            /**
             * Sending the chat message
             */
            chat.sendMessage(message);
        } catch (XMPPException ex) {
            System.out.println("Error: " + ex.getMessage());
        }
    }
    

      /**
       * This method belongs to MessageListener interface.
       * It listens for the incoming chat messages.
       */
    @Override

    public void processMessage(Chat chat, Message msg) {       
        String msgStr = msg.getBody();
        System.out.println("<" + chat.getParticipant() + ">  says " + msgStr);
    }
   
    public static void main(String[] args) {
        GtalkClient gtalkClient = new GtalkClient();      
    }


    @Override
    public void run() {      
    }
   
    private void displayBuddyList() {
        Roster roster = xMPPConnection.getRoster();
        Collection entries = roster.getEntries();


        System.out.println("\n\n------------Your Buddies!!------------");
        System.out.println(entries.size() + " buddy(ies):\n");
        Iterator iter = entries.iterator();
        buddySize = entries.size();  
        buddies = new String[buddySize];
        int i = 0;
        while (iter.hasNext()) {
            RosterEntry rosterEntry = (RosterEntry) iter.next();
            buddies[i] = rosterEntry.getUser();
            i++;
            System.out.println(i + ". " + rosterEntry.getUser());          
        }
        System.out.println("--------------------------------------");
    }
   
    private String getBuddy(int i) {
        String buddy = "";
        if(i > 0 && i <= buddySize) {
            buddy = buddies[i-1];
        } else {
            System.out.println("Invalid Buddy Id!! Selected default one!!");
            buddy = buddies[0];
        }
        return buddy;
    }
}


        
}
