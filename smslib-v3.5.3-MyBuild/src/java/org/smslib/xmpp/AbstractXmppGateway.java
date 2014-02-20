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

import java.io.IOException;
import java.util.Collection;
import javax.mail.Session;

import org.smslib.AGateway;
import org.smslib.GatewayException;
import org.smslib.InboundMessage;
import org.smslib.TimeoutException;
import org.smslib.InboundMessage.MessageClasses;

/**
 * Xmpp Gateway's base class.
 * @author Shamim Ahmed Chowdhury
 *
 */
public abstract class AbstractXmppGateway extends AGateway {

	
        private String messageSubject;
	private String messageBody;
       // private Session mailSession;
    
        //protected String pop_protocol;
        protected String host;
	protected String port;
	protected String username;
	protected String password;
	protected String userPhone;
        protected String buddyJID;
        protected String buddyName;
        //protected String smtp_password;
        //protected String to;
        //protected String from;
        protected String message_subject;
        protected String message_body;
	
	/**
	 * 
	 * @param id gateway ID
	 * @param host Email host
	 * @param port Email port
	 * @param bindAttributes Email bind attributes
	 */
	public AbstractXmppGateway(String id,String host,String port, String username,String password,String userPhone,String buddyJID,String buddyName, String message_subject, String message_body ) {
		super(id);               
		//this.pop_protocol=pop_protocol;
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
                this.message_subject=message_subject;
                this.message_body = message_body;
                        
		
	}

	/* (non-Javadoc)
	 * @see org.smslib.AGateway#getQueueSchedulingInterval()
	 */
	@Override
	public int getQueueSchedulingInterval() {
		
		return 500;
	}

	public String getHost() {
		return host;
	}

	public String getPort() {
		return port;
	}

	

	@Override
	public void readMessages(Collection<InboundMessage> msgList,
			MessageClasses msgClass) throws TimeoutException, GatewayException,
			IOException, InterruptedException {
		// A dummy implementation
		// A temporarily fix for issue 354  
	}
	
	

}
