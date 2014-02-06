/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author kamruzzaman
 */

import java.net.Inet4Address;
import java.net.NetworkInterface;
import java.net.InetAddress;
import java.util.Enumeration;

public class ipaddress {
    
    public static void main(String[] args) throws Exception
{
    //System.out.println("Your Host addr: " + InetAddress.getLocalHost().getHostAddress());  // often returns "127.0.0.1"
   //System.out.println("Your Host addr: " + Inet4Address.getLocalHost().getHostAddress());
    //Enumeration<NetworkInterface> n = NetworkInterface.getNetworkInterfaces();
    //for (; n.hasMoreElements();)
    //{
    //    NetworkInterface e = n.nextElement();

     //   Enumeration<InetAddress> a = e.getInetAddresses();
     //   for (; a.hasMoreElements();)
     //   {
     //       InetAddress addr = a.nextElement();
            //System.out.println("  " + addr.getHostAddress());
     //   }
    //}
    for (Enumeration<NetworkInterface> ifaces = 
               NetworkInterface.getNetworkInterfaces();
             ifaces.hasMoreElements(); )
        {
            NetworkInterface iface = ifaces.nextElement();
            //System.out.println(iface.getName() + ":");
            if (iface.getName().startsWith("eth"))
            {
                
            
                for (Enumeration<InetAddress> addresses =
                   iface.getInetAddresses();
                 addresses.hasMoreElements(); )
                {
                    InetAddress address = addresses.nextElement();
                    if (address.equals(""))
                    {
                        
                    }
                    else
                    {
                        System.out.println(iface.getName() + ":");
                        System.out.println("  " + address);
                    }
                    
                }
            }
        }
    //Enumeration e=NetworkInterface.getNetworkInterfaces();
    //        while(e.hasMoreElements())
    //        {
    //            NetworkInterface n=(NetworkInterface) e.nextElement();
    //            Enumeration ee = n.getInetAddresses();
    //            while(ee.hasMoreElements())
    //            {
    //                InetAddress i= (InetAddress) ee.nextElement();
    //                System.out.println(i.getHostAddress());
    //            }
    //        }
} 
    
}
