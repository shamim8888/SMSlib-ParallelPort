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

package org.smslib.smsserver.gateways;

import java.lang.reflect.Constructor;
import java.util.Properties;

import org.smslib.xmpp.AbstractXmppGateway;
import org.smslib.email.Address;
import org.smslib.email.BindAttributes;
import org.smslib.email.Address.NumberingPlanIndicator;
import org.smslib.email.Address.TypeOfNumber;
import org.smslib.email.BindAttributes.BindType;

/**
 * <b>SMSServer Application Gateway.</b>
 * 
 * @author Bassam Al-Sarori
 */
public class XmppGateway extends AGateway
{
	public XmppGateway(String myGatewayId, Properties myProps, org.smslib.smsserver.SMSServer myServer)
	{
		super(myGatewayId, myProps, myServer);
		setDescription(myGatewayId+" Xmpp Gateway.");
	}

	@SuppressWarnings("unchecked")
	@Override
	public void create() throws Exception
	{
		
		
		String propName;
		propName = getGatewayId() + ".";
		//setGateway(new org.smslib.email.email.EMAILGateway(getGatewayId(), getProperties().getProperty(propName + "mailbox_host"), getProperties().getProperty(propName + "mailbox_port")));
		//if (getProperties().getProperty(propName + "secure").equalsIgnoreCase("yes")) ((org.smslib.http.ClickatellHTTPGateway) getGateway()).setSecure((true));
		
                
			setGateway(new org.smslib.xmpp.XMPPGateway(getGatewayId(),  getProperties().getProperty(propName + "host"), getProperties().getProperty(propName + "port"),getProperties().getProperty(propName + "username"),getProperties().getProperty(propName + "password"),getProperties().getProperty(propName + "userPhone"),getProperties().getProperty(propName + "buddyJID"),getProperties().getProperty(propName + "buddyName"),getProperties().getProperty(propName + "message_subject"), getProperties().getProperty(propName + "message_body")));
                
                
                
                if (getProperties().getProperty(propName + "inbound").equalsIgnoreCase("yes")) getGateway().setInbound(true);
		else if (getProperties().getProperty(propName + "inbound").equalsIgnoreCase("no")) getGateway().setInbound(false);
		else throw new Exception("Incorrect parameter: " + propName + "inbound");
                if (getProperties().getProperty(propName + "outbound").equalsIgnoreCase("yes")) getGateway().setOutbound(true);
		else if (getProperties().getProperty(propName + "outbound").equalsIgnoreCase("no")) getGateway().setOutbound(false);
		else throw new Exception("Incorrect parameter: " + propName + "outbound");
		
		
		
		
		
	
	}
	
	
	
	private String getProperty(String name){
		String propertyValue=getProperties().getProperty(getGatewayId() + "." +name);
		if(propertyValue!=null)
			return propertyValue.trim();
		else
		return propertyValue;
	}
	
}
