/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package tokenizertest;

import java.util.StringTokenizer;
import java.io.*;
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
/**
 *
 * @author User
 */
public class TokenizerTest {

    /**
     * @param args the command line arguments
     */
    static short datum;
    static short Addr;
    static pPort lpt;
    
    
    public int do_read( short Addr)
    {
          // Read from the port
          datum = (short) lpt.input(Addr);

          // Notify the console
          System.out.println("Read Port: " + Integer.toHexString(Addr) +
                              " = " +  Integer.toHexString(datum));
          return datum;
     }
    
    
     //static void do_read()
    //{
          // Read from the port
      //    datum = (short) lpt.input(Addr);

          // Notify the console
     //     System.out.println("Read Port: " + Integer.toHexString(Addr) +
     //                         " = " +  Integer.toHexString(datum));
     //}
     
     static void do_read_range()
     {
          // Try to read 0x378..0x37F, LPT1:
          for (Addr=0x378; (Addr<0x380); Addr++) {

               //Read from the port
               datum = (short) lpt.input(Addr);

               // Notify the console
               System.out.println("Port: " + Integer.toHexString(Addr) +
                                   " = " +  Integer.toHexString(datum));
          }
     }
    
     private static void log(Object aObject){
            System.out.println(aObject);
        }
    
    
    
    
    
    
    
    
    
    
    public static void main(String[] args) {
        // TODO code application logic here
        lpt = new pPort();
        //Addr=0x378;
        
        
        
        
        System.out.print("Enter Your Message: ");

      //  open up standard input
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
        
        
        String msg = null;

      //  read the username from the command-line; need to use try/catch with the
      //  readLine() method
      try {
         msg = br.readLine();
      } catch (IOException ioe) {
         System.out.println("IO error trying to read your name!");
         System.exit(1);
      }

      System.out.println("Thanks for the message: " + msg);
        

        StringTokenizer Entertokens = new StringTokenizer(msg, "\r",true);
                                               // setDescription("Tokenizing starts here.");  
                                               // Logger.getInstance().logInfo("Tokenizing starts here." , null, null);
                                                if(Entertokens.countTokens() == 1)
                                                {
                                                    System.out.println("Enter Token is "+Entertokens.countTokens());
                                                    StringTokenizer commatokens = new StringTokenizer(msg, ",", true);
                                                    if(commatokens.countTokens() == 1)
                                                    {
                                                        System.out.println("Comma Token is "+commatokens.countTokens());
                                                        StringTokenizer spacetokens = new StringTokenizer(msg, " ");
                                                        if(spacetokens.countTokens() == 1)
                                                        {
                                                            System.out.println("Space Token is "+spacetokens.countTokens());
                                                            //String commandname = "Status";
                                                            if("STATUS".equals(msg.trim().toUpperCase()))
                                                            {
                                                               // pst.setString(11, "STATUS");
                                                                //SendStatusMessage();
                                                                do_read(0x378,);
                                                                for(int i = 12; i <52; i++)
                                                                {
                                                                    //pst.setString(i,null)
                                                                    System.out.println("Field Number is "+i);
                                                                }
                                                                System.out.println("Command is "+spacetokens.nextToken());
                                                            }
                                                            else
                                                            {
                                                                System.out.println("Command is not Status, Command is "+spacetokens.nextToken());
                                                                //SendErrorMessage();
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if(spacetokens.countTokens() >4)
                                                            {
                                                               System.out.println("Command Is More Than "+spacetokens.countTokens());
                                                                //  SendErrorMessage();
                                                            }
                                                            else
                                                            {
                                                                 // pst.setString(11, null);
                                                                 int fieldnumber = 12;
                                                                 while(spacetokens.hasMoreTokens())
                                                                 {
                                                                                                                
                                                                             //   pst.setString(fieldnumber, (subtokens.nextToken().length() == 0 ? "" : subtokens.nextToken()));
                                                                                System.out.println("fieldNumber is "+fieldnumber+" and Spacetoken Is  "+spacetokens.nextToken());
                                                                                fieldnumber++;
                                                                                
                                                                 }
                                                                 if(fieldnumber==14)
                                                                 {
                                                                    for(int i = 14; i <52; i++)
                                                                    {
                                                                        //pst.setString(i,null)
                                                                        System.out.println("Field Number is "+i);
                                                                    }
                                                                 }
                                                                 else
                                                                 {
                                                                    if(fieldnumber==15)
                                                                    {
                                                                        System.out.println("Unfinished command. Need another token");
                                                                        for(int i = 15; i <52; i++)
                                                                        {
                                                                            //pst.setString(i,null)
                                                                            System.out.println("Field Number is "+i);
                                                                        }
                                                                    }
                                                                    else
                                                                    {                                                                     
                                                                       for(int i = 16; i <52; i++)
                                                                       {
                                                                            //pst.setString(i,null)
                                                                            System.out.println("Field Number is "+i);
                                                                        }
                                                                    }
                                                                     System.out.println("We are in tg mode. Field Number is ");
                                                                 }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if(commatokens.countTokens() > 7)
                                                        {
                                                            // SendErrorMessage();
                                                        }
                                                        else
                                                        {
                                                                System.out.println("Comma Token is "+commatokens.countTokens());
                                                                int fieldnumber = 12;
                                                                int firstset = 1;
                                                                int separatorset = 1;
                                                                boolean ISItFirstComma = true;
                                                                while(commatokens.hasMoreTokens())
                                                                {
                                                                           // System.out.println(commatokens.nextToken());
                                                                
                                                                          //  pst.setString(fieldnumber, (tokens.nextToken().length() == 0 ? "" : "Enter"));
                                                                                
                                                                            String linecut = commatokens.nextToken().trim();
                                                                            StringTokenizer spacetokens = new StringTokenizer(linecut, " ");
                                                                            int highestToken = spacetokens.countTokens();
                                                                            System.out.println("Highest Space Token in a Comma Token is: "+highestToken);
                                                                            String FirstSpaceToken = spacetokens.nextToken();
                                                                            
                                                                            
                                                                            if(",".equals(FirstSpaceToken.trim()) & ISItFirstComma & fieldnumber==12)
                                                                            {
                                                                                ISItFirstComma = true;
                                                                                //SendErrorMessage("You Put Comma First"); 
                                                                                System.out.println("You Put a Comma before anything....Separator_"+separatorset+" : "+FirstSpaceToken);
                                                                                separatorset++;
                                                                                fieldnumber++;
                                                                                System.out.println("FieldNumber is :"+fieldnumber);
                                                                            }
                                                                            
                                                                            else if(",".equals(FirstSpaceToken.trim()) & ISItFirstComma)
                                                                            {
                                                                                ISItFirstComma = true;
                                                                                //SendErrorMessage("You Put Comma First"); 
                                                                                System.out.println("You Put a Comma after a comma....Separator_"+separatorset+" : "+FirstSpaceToken);
                                                                                separatorset++;
                                                                                fieldnumber++;
                                                                                System.out.println("FieldNumber is :"+fieldnumber);
                                                                            }
                                                                            else if(",".equals(FirstSpaceToken.trim()))
                                                                                    {
                                                                                     ISItFirstComma = true;   
                                                                                     System.out.println("Separator_"+separatorset+" : "+FirstSpaceToken);
                                                                                     separatorset++;
                                                                                     fieldnumber++;
                                                                                     System.out.println("FieldNumber is :"+fieldnumber);   
                                                                                    }
                                                                            else
                                                                            {
                                                                                if(highestToken==4)
                                                                                {
                                                                                    String DB_CONN_STRING = "jdbc:mysql://localhost:3306/smslib";
                                                                                    String DRIVER_CLASS_NAME = "com.mysql.jdbc.Driver";
                                                                                    String USER_NAME = "smslib";
                                                                                    String PASSWORD = "smslib";
                                                                                    
                                                                                    Connection result = null;
                                                                                    try {
                                                                                            Class.forName(DRIVER_CLASS_NAME).newInstance();
                                                                                        }
                                                                                    catch (Exception ex){
                                                                                            log("Check classpath. Cannot load db driver: " + DRIVER_CLASS_NAME);
                                                                                        }
                                                                                    
                                                                                    try {
                                                                                        result = DriverManager.getConnection(DB_CONN_STRING, USER_NAME, PASSWORD);
                                                                                        }
                                                                                    catch (SQLException e){
                                                                                    log( "Driver loaded, but cannot connect to db: " + DB_CONN_STRING);
                                                                                        }
                                                                                    // return result;
                                                                                    
                                                                                    String query = "";
                                                                                    try {
                                                                                    Connection con = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/smslib", "smslib", "smslib");
                                                                                    
                                                                                    //Connection con = DriverManager.getConnection("jdbc:com.mysql.jdbc.Driver:smslib", "smslib","smslib");
                                                                                    
                                                                                    
                                                                                    Statement stmt = con.createStatement();
                                                                                    ResultSet rs = stmt.executeQuery("SELECT device_name FROM DEVICE_NAME");
                                                                                    while (rs.next()) {
                                                                                        //int x = rs.getInt("a");
                                                                                        String s = rs.getString("name");
                                                                                        System.out.println("Device_name_"+firstset+" : "+s);
                                                                                        //float f = rs.getFloat("c");
                                                                                        }
                                                                                    
                                                                                    }
                                                                                    catch (SQLException ex) {
                                                                                        ex.printStackTrace();
                                                                                        System.out.println(query);
                                                                                    }
                                                                                    
                                                                                    System.out.println("Device_name_"+firstset+" : "+FirstSpaceToken);
                                                                                    System.out.println("Device_name_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    System.out.println("Command_name_"+firstset+" : "+spacetokens.nextToken());
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    System.out.println("from_toggle_"+firstset+" : "+spacetokens.nextToken());
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    System.out.println("to_toggle_"+firstset+" : "+spacetokens.nextToken());
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    switch (highestToken)
                                                                                    {
                                                                                        case 1:
                                                                                        
                                                                                            System.out.println("Only One Word.."+spacetokens.nextToken()+" use Two words");
                                                                                            //SendErrorMessage("Only one word"); 
                                                                                            //fieldnumber= fieldnumber+3;
                                                                                            break;
                                                                                        case 2:
                                                                                        
                                                                                            fieldnumber= fieldnumber+2;
                                                                                            break;
                                                                                        case 3:
                                                                                            fieldnumber= fieldnumber+1;
                                                                                            break;
                                                                                    
                                                                                    }
                                                                                    
                                                                                }
                                                                                else
                                                                                {
                                                                                    ISItFirstComma = false;
                                                                                    System.out.println("Device_name_"+firstset+" : "+FirstSpaceToken);
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    System.out.println("Command_name_"+firstset+" : "+spacetokens.nextToken());
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    //pst.setString(i,null)
                                                                                    System.out.println("from_toggle_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    System.out.println("to_toggle_"+firstset+" : "+"//pst.setString("+fieldnumber+",null)");
                                                                                    fieldnumber++;
                                                                                    System.out.println("FieldNumber is :"+fieldnumber);
                                                                                    firstset++;
                                                                                }    
                                                                            }
                                                                  }
                                                                           
                                                                            while(spacetokens.hasMoreTokens())
                                                                            {
                                                                                 System.out.println("Remaining Tokens : " + spacetokens.countTokens());
                                                                                 System.out.println(spacetokens.nextToken());
                                                                                 System.out.println("FieldNumber Is :"+fieldnumber);
                                                                    
                                                                              //  pst.setString(fieldnumber, (spacetokens.nextToken().length() == 0 ? "" : spacetokens.nextToken()));
                                                                                
                                                                                switch (spacetokens.countTokens())
                                                                                {
                                                                                    case 1:
											fieldnumber= fieldnumber+3;
											break;
                                                                                    case 2:
											fieldnumber= fieldnumber+2;
											break;
                                                                                    case 3:
											fieldnumber= fieldnumber+1;
											break;
                                                                                    
                                                                                }                                                                                                                                                                                                                                                                                                                           
                                                                            }
                                                                        }
                                                                    }                                                                                                                 
                                                                }
                                                            }
                                                            else
                                                            {
                                                                System.out.println("Enter Token is "+Entertokens.countTokens());
                                                                while(Entertokens.hasMoreTokens()){
                                                                    if(Entertokens.nextToken()== "\r"){
                                                                      System.out.println("Enter");
                                                                      break;
                                                                    }

                                                                    System.out.println(Entertokens.nextToken());
                                                                }
                                                            }
    }
}
