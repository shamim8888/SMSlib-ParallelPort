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

package org.smslib.email;

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
import javax.mail.Flags;
import javax.mail.Folder;
import javax.mail.Message;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Store;
import javax.mail.Transport;
import javax.mail.Message.RecipientType;
import javax.mail.MessagingException;
import javax.mail.NoSuchProviderException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import org.smslib.helper.ExtStringBuilder;
import org.smslib.helper.Logger;
import org.smslib.smsserver.SMSServer;
import org.smslib.AGateway;
import org.smslib.GatewayException;
import org.smslib.InboundMessage;
import org.smslib.InboundMessage.MessageClasses;
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
 * A gateway that supports Email through mail (https://github.com/shamim8888/SMSlib-ParallelPort).
 * 
 * @author Shamim Ahmed Chowdhury
 */
public class EMAILGateway extends AbstractEmailGateway {

	
    
        private String username;
        private String password;
        //private String message_subject;
	//private String message_body;
        private Session mailSession;
        private Properties mailProps;

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
    public EMAILGateway(String id, String pop_protocol, String pop_host, String pop_port, String pop_user, String pop_password, String smtp_host, String smtp_port, String smtp_user, String smtp_password, String to, String from, String message_subject, String message_body) {
		super(id, pop_protocol,pop_host, pop_port,pop_user,pop_password,smtp_host,smtp_port,smtp_user,smtp_password,to,from,message_subject,message_body);
                this.pop_protocol=pop_protocol;
                this.pop_host=pop_host;
		this.pop_port=pop_port;		
		this.pop_user=pop_user;
                this.pop_password=pop_password;
                this.smtp_host=smtp_host;
                this.smtp_port=smtp_port;	
		this.smtp_user=smtp_user;
                this.smtp_password=smtp_password;
                this.to=to;
                this.from=from;
                this.message_subject = message_subject;
                this.message_body = message_body;
                
		setAttributes(AGateway.GatewayAttributes.SEND | AGateway.GatewayAttributes.CUSTOMFROM | AGateway.GatewayAttributes.BIGMESSAGES | AGateway.GatewayAttributes.FLASHSMS | AGateway.GatewayAttributes.RECEIVE);
		
		
	}
        
        
        

	
	@Override
	public void startGateway() throws TimeoutException, GatewayException,
			IOException, InterruptedException {
		
                        Properties mailProps = new Properties();
                        mailProps.setProperty("mail.store.protocol", pop_protocol);
                        if ("pop3".equals(pop_protocol))
		{
			mailProps.setProperty("mail.pop3.host", pop_host);
			mailProps.setProperty("mail.pop3.port", pop_port);
			mailProps.setProperty("mail.pop3.user", pop_user);
			mailProps.setProperty("mail.pop3.password", pop_password);
		}
		else if ("pop3s".equals(pop_protocol))
		{
			mailProps.setProperty("mail.pop3s.host", pop_host);
			mailProps.setProperty("mail.pop3s.port", pop_port);
			mailProps.setProperty("mail.pop3s.user", pop_user);
			mailProps.setProperty("mail.pop3s.password", pop_password);
		}
		else if ("imap".equals(pop_protocol))
		{
			mailProps.setProperty("mail.imap.host", pop_host);
			mailProps.setProperty("mail.imap.port", pop_port);
			mailProps.setProperty("mail.imap.user", pop_user);
			mailProps.setProperty("mail.imap.password", pop_password);
		}
		else if ("imaps".equals(pop_protocol))
		{
			mailProps.setProperty("mail.imaps.host", pop_host);
			mailProps.setProperty("mail.imaps.port", pop_port);
			mailProps.setProperty("mail.imaps.user", pop_user);
			mailProps.setProperty("mail.imaps.password", pop_password);
		}
		else
		{
			throw new IllegalArgumentException("mailbox_protocol have to be pop3(s) or imap(s)!");
		}
		mailProps.setProperty("mail.transport.protocol", "smtp");
		mailProps.setProperty("mail.from", from);
		mailProps.setProperty("mail.smtp.host", smtp_host);
		mailProps.setProperty("mail.smtp.port", smtp_port);
		mailProps.setProperty("mail.smtp.user", smtp_user);
		mailProps.setProperty("mail.smtp.password", smtp_password);
		mailProps.setProperty("mail.smtp.auth", "true");
                
		this.mailSession = Session.getInstance(mailProps, new javax.mail.Authenticator()
		{
			@Override
			protected PasswordAuthentication getPasswordAuthentication()
			{
				return new PasswordAuthentication(pop_user, pop_password);
			}
		});
		if (isOutbound())
		{
			prepareEmailTemplate();
		}
		Logger.getInstance().logInfo("Starting gateway.", null, getGatewayId());
		super.startGateway();
                Logger.getInstance().logInfo("Gateway started.", null, getGatewayId());
		
	}

	@Override
	public void stopGateway() throws TimeoutException, GatewayException,
			IOException, InterruptedException {
		Logger.getInstance().logInfo("Stopping gateway...", null, getGatewayId());
		super.stopGateway();
                Logger.getInstance().logInfo("Gateway stopped.", null, getGatewayId());
	}


        public void readMessages(Collection<InboundMessage> msgList,
			MessageClasses msgClass) throws TimeoutException, GatewayException,
			IOException, InterruptedException {
            try {            
                List<InboundMessage> retValue = new ArrayList<InboundMessage>();
                Store s = this.mailSession.getStore();
                s.connect();
                Folder inbox = s.getFolder("INBOX"); 
                inbox.open(Folder.READ_WRITE);
                for (Message m : inbox.getMessages())
                {
                    InboundMessage om = new InboundMessage(m.getReceivedDate(), m.getSubject(), m.getContent().toString(),pop_host);
                    om.setFrom(m.getFrom().toString());
                    om.setDate(m.getReceivedDate());
                    retValue.add(om);
                    // Delete message from inbox
                    m.setFlag(Flags.Flag.DELETED, true);
                }
                inbox.close(true);
                s.close();
                
                
                
                //return true;
            } catch (NoSuchProviderException ex) {
                java.util.logging.Logger.getLogger(EMAILGateway.class.getName()).log(Level.SEVERE, null, ex);
            } catch (MessagingException ex) {
                java.util.logging.Logger.getLogger(EMAILGateway.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
 

	

	@Override
	public boolean sendMessage(OutboundMessage msg) throws TimeoutException, GatewayException, IOException, InterruptedException
	{
            try {
                Message mesg = new MimeMessage(this.mailSession);
                mesg.setFrom();
                mesg.addRecipient(RecipientType.TO, new InternetAddress(to));
                mesg.setSubject(updateTemplateString(this.message_subject, msg));
                if (this.message_body != null)
                {
                    mesg.setText(updateTemplateString(this.message_body, msg));
                    //mesg.setText(msg.toString());
                }
                else
                {
                    mesg.setText(msg.toString());
                }
                mesg.setSentDate(msg.getDate());
                Transport.send(mesg);
                msg.setDispatchDate(new Date());
                msg.setMessageStatus(MessageStatuses.SENT);
                
                
            } catch (MessagingException ex) {
                java.util.logging.Logger.getLogger(EMAILGateway.class.getName()).log(Level.SEVERE, null, ex);
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
		//sb.replaceAll("%pduUserData%", msg.getPduUserData());
		//sb.replaceAll("%originator%", msg.getOriginator());
		//sb.replaceAll("%memIndex%", msg.getMemIndex());
		//sb.replaceAll("%mpMemIndex%", msg.getMpMemIndex());
		return sb.toString();
	}
        
        private void prepareEmailTemplate()
	{
		//this.message_subject = "message_subject";
		if (this.message_subject == null ||this.message_subject.length() == 0)
		{
			Logger.getInstance().logWarn("No message_subject found - Using default", null, null);
			this.message_subject = "SMS from %ORIGINATOR%";
		}
		File f = new File(this.message_body);
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
				this.message_body = sb.toString();
			}
			catch (IOException e)
			{
				Logger.getInstance().logError("I/O-Exception while reading message body template: " + e.getMessage(), null, null);
			}
		}
		if (this.message_body == null || this.message_body.length() == 0)
		{
			Logger.getInstance().logWarn("message_body can't be read or is empty - Using default", null, null);
			this.message_body = null;
		}
	}
}


