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

import java.io.IOException;
import java.util.Collection;
import javax.mail.Session;

import org.smslib.AGateway;
import org.smslib.GatewayException;
import org.smslib.InboundMessage;
import org.smslib.TimeoutException;
import org.smslib.InboundMessage.MessageClasses;

/**
 * Email Gateway's base class.
 * @author Shamim Ahmed Chowdhury
 *
 */
public abstract class AbstractEmailGateway extends AGateway {

	
        private String messageSubject;
	private String messageBody;
        private Session mailSession;
    
        protected String pop_protocol;
        protected String pop_host;
	protected String pop_port;
	protected String pop_user;
	protected String pop_password;
	protected String smtp_host;
        protected String smtp_port;
        protected String smtp_user;
        protected String smtp_password;
        protected String to;
        protected String from;
        protected String message_subject;
        protected String message_body;
	
	/**
	 * 
	 * @param id gateway ID
	 * @param host Email host
	 * @param port Email port
	 * @param bindAttributes Email bind attributes
	 */
	public AbstractEmailGateway(String id,String pop_protocol,String pop_host,String pop_port, String pop_user,String pop_password,String smtp_host,String smtp_port,String smtp_user,String smtp_password,String to,String from, String message_subject, String message_body ) {
		super(id);               
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
		return pop_host;
	}

	public String getPort() {
		return pop_port;
	}

	

	@Override
	public void readMessages(Collection<InboundMessage> msgList,
			MessageClasses msgClass) throws TimeoutException, GatewayException,
			IOException, InterruptedException {
		// A dummy implementation
		// A temporarily fix for issue 354  
	}
	
	

}
