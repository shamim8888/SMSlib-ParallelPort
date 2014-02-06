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

package org.smslib.modem;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.StringTokenizer;
import org.smslib.GatewayException;
import org.smslib.Service;
import org.smslib.helper.ParallelPortIdentifier;
import org.smslib.helper.Logger;
import org.smslib.helper.ParallelPort;
import org.smslib.helper.ParallelPortEvent;
import org.smslib.helper.ParallelPortEventListener;
import org.smslib.threading.AServiceThread;

class ParallelModemDriver extends AModemDriver implements ParallelPortEventListener
{
	private String comPort;

	private int mode;

	private ParallelPortIdentifier portId;

	private ParallelPort parallelPort;

	private InputStream in;

	private OutputStream out;

	private PortReader portReader;

	protected ParallelModemDriver(ModemGateway myGateway, String deviceParms)
	{
		super(myGateway, deviceParms);
		StringTokenizer tokens = new StringTokenizer(deviceParms, ":");
		setComPort(tokens.nextToken());
		setBaudRate(Integer.parseInt(tokens.nextToken()));
		setParallelPort(null);
	}

	@Override
	protected void connectPort() throws GatewayException, IOException, InterruptedException
	{
		if (Service.getInstance().getSettings().PARALLEL_NOFLUSH) Logger.getInstance().logInfo("Parallel port flushing is disabled.", null, getGateway().getGatewayId());
		if (Service.getInstance().getSettings().PARALLEL_POLLING) Logger.getInstance().logInfo("Using polled parallel port mode.", null, getGateway().getGatewayId());
		try
		{
			Logger.getInstance().logInfo("Opening: " + getComPort() + " @" + getmode(), null, getGateway().getGatewayId());
			ParallelPortIdentifier.getPortIdentifiers();
			setPortId(ParallelPortIdentifier.getPortIdentifier(getComPort()));
			setParallelPort(getPortId().open("org.smslib", 1971));
			setIn(getParallelPort().getInputStream());
			setOut(getParallelPort().getOutputStream());
			if (!Service.getInstance().getSettings().PARALLEL_POLLING)
			{
				getParallelPort().notifyOnDataAvailable(true);
				getParallelPort().notifyOnOutputEmpty(true);
			}
			if (!Service.getInstance().getSettings().PARALLEL_NOEVENTS)
			{
				getParallelPort().notifyOnBreakInterrupt(true);
				getParallelPort().notifyOnFramingError(true);
				getParallelPort().notifyOnOverrunError(true);
				getParallelPort().notifyOnParityError(true);
			}
			else Logger.getInstance().logInfo("Skipping registration of parallel port events!", null, null);
			//if (Service.getInstance().getSettings().PARALLEL_RTSCTS_OUT) getParallelPort().setFlowControlMode(ParallelPort.FLOWCONTROL_RTSCTS_IN | ParallelPort.FLOWCONTROL_RTSCTS_OUT);
			//else getParallelPort().setFlowControlMode(ParallelPort.FLOWCONTROL_RTSCTS_IN);
			getParallelPort().addEventListener(this);
			//getParallelPort().setParallelPortParams(getBaudRate(), ParallelPort.DATABITS_8, ParallelPort.STOPBITS_1, ParallelPort.PARITY_NONE);
			getParallelPort().setInputBufferSize(Service.getInstance().getSettings().PARALLEL_BUFFER_SIZE);
			getParallelPort().setOutputBufferSize(Service.getInstance().getSettings().PARALLEL_BUFFER_SIZE);
			getParallelPort().enableReceiveThreshold(1);
			getParallelPort().enableReceiveTimeout(Service.getInstance().getSettings().PARALLEL_TIMEOUT);
			if (Service.getInstance().getSettings().PARALLEL_POLLING)
			{
				setPortReader(new PortReader("PortReader() [" + getComPort() + "]", Service.getInstance().getSettings().PARALLEL_POLLING_INTERVAL));
			}
		}
		catch (Exception e)
		{
			throw new GatewayException("Comm library exception: " + e.getMessage());
		}
	}

	@Override
	protected void disconnectPort() throws IOException, InterruptedException
	{
		synchronized (getSYNCReader())
		{
			if (Service.getInstance().getSettings().PARALLEL_POLLING)
			{
				if (getPortReader() != null)
				{
					getPortReader().cancel();
					setPortReader(null);
				}
			}
			if (getParallelPort() != null) getParallelPort().close();
			Logger.getInstance().logInfo("Closing: " + getComPort() + " @" + getmode(), null, getGateway().getGatewayId());
		}
	}

	@Override
	protected void clear() throws IOException
	{
		while (portHasData())
			read();
	}

	@Override
	protected boolean portHasData() throws IOException
	{
		return (getIn().available() > 0);
	}

	public void parallelEvent(ParallelPortEvent event)
	{
		int eventType = event.getEventType();
		if (eventType == ParallelPortEvent.OE) Logger.getInstance().logError("Overrun Error!", null, getGateway().getGatewayId());
		else if (eventType == ParallelPortEvent.FE) Logger.getInstance().logError("Framing Error!", null, getGateway().getGatewayId());
		else if (eventType == ParallelPortEvent.PE) Logger.getInstance().logError("Parity Error!", null, getGateway().getGatewayId());
		else if (eventType == ParallelPortEvent.DATA_AVAILABLE)
		{
			if (!Service.getInstance().getSettings().PARALLEL_POLLING)
			{
				synchronized (getSYNCReader())
				{
					setDataReceived(true);
					getSYNCReader().notifyAll();
				}
			}
		}
	}

	@Override
	public void write(char c) throws IOException
	{
		getOut().write(c);
		if (!Service.getInstance().getSettings().PARALLEL_NOFLUSH) getOut().flush();
	}

	@Override
	public void write(byte[] s) throws IOException
	{
		if (Service.getInstance().getSettings().PARALLEL_BUFFER_CHUNK == 0) getOut().write(s);
		else
		{
			int offset = 0;
			int left = s.length;
			while (left > 0)
			{
				int i = left > Service.getInstance().getSettings().PARALLEL_BUFFER_CHUNK ? Service.getInstance().getSettings().PARALLEL_BUFFER_CHUNK : left;
				getOut().write(s, offset, i);
				offset += i;
				left -= i;
				try
				{
					Thread.sleep(Service.getInstance().getSettings().PARALLEL_BUFFER_CHUNK_DELAY);
				}
				catch (InterruptedException e)
				{
				}
			}
		}
		if (!Service.getInstance().getSettings().PARALLEL_NOFLUSH) getOut().flush();
	}

	@Override
	protected int read() throws IOException
	{
		return getIn().read();
	}

	PortReader getPortReader()
	{
		return this.portReader;
	}

	void setPortReader(PortReader myPortReader)
	{
		this.portReader = myPortReader;
	}

	private class PortReader extends AServiceThread
	{
		public PortReader(String name, int delay)
		{
			super(name, delay, 0, true);
		}

		@Override
		public void process() throws Exception
		{
			if (portHasData())
			{
				synchronized (getSYNCReader())
				{
					setDataReceived(true);
					getSYNCReader().notifyAll();
				}
			}
		}
	}

	String getComPort()
	{
		return this.comPort;
	}

	void setComPort(String myComPort)
	{
		this.comPort = myComPort;
	}

	int getmode()
	{
		return this.mode;
	}

	void setBaudRate(int myBaudRate)
	{
		this.mode = myBaudRate;
	}

	ParallelPortIdentifier getPortId()
	{
		return this.portId;
	}

	void setPortId(ParallelPortIdentifier myPortId)
	{
		this.portId = myPortId;
	}

	ParallelPort getParallelPort()
	{
		return this.parallelPort;
	}

	void setParallelPort(ParallelPort myParallelPort)
	{
		this.parallelPort = myParallelPort;
	}

	InputStream getIn()
	{
		return this.in;
	}

	void setIn(InputStream myIn)
	{
		this.in = myIn;
	}

	OutputStream getOut()
	{
		return this.out;
	}

	void setOut(OutputStream myOut)
	{
		this.out = myOut;
	}
}
