/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Shamim Ahmed Chowdhury
 */


import java.util.StringTokenizer;
public class TokenizerTest {
    
     public static void main( String args[] )
            {
            String[] MessageString = new String[500];
            String[] DelimeterArray = new String[8];
            
            String CompareMessage = null;
            DelimeterArray[0]= ",";
            DelimeterArray[1]= ".";
            DelimeterArray[2]= ";";
            DelimeterArray[3]= ":";
            DelimeterArray[4]= "'";
            DelimeterArray[5]= "\"";
            DelimeterArray[6]= "/";
            DelimeterArray[7]= "\\";


                                  
            String Message = "Computer ON. AC TG, Light Off. Fan Off; Oven ON: TV ON' Refrigerator Tg.Energy ON";
            
            int j = 0;
            while(Message.length()>0)
            {
             String FirstMessage = Message;   
            StringTokenizer Entertokens = new StringTokenizer(Message, "\r",true);
                if (Entertokens.countTokens() == 1)
                    {
                      for (int i=0;i<DelimeterArray.length;i++)  
                      {
                          StringTokenizer Whichtokens = new StringTokenizer(Message, DelimeterArray[i],true);
                          if(Whichtokens.countTokens() > 1)
                            {                  
                                    CompareMessage = Whichtokens.nextToken();
                                    System.out.println("Message Token Is "+CompareMessage);
                                    if (CompareMessage.length()<FirstMessage.length())
                                    {
                                        FirstMessage = CompareMessage;
                                        System.out.println("First Message Token Is "+FirstMessage);
                                    }
                            }
                      }
                      MessageString[j] = FirstMessage;
                      System.out.println("MessageString"+j+" "+MessageString[j]);
                      if (Message.length()>FirstMessage.length())
                        {
                            Message = Message.substring(FirstMessage.length()+1);
                            System.out.println(" Message Substr Is "+Message);
                        }
                      else if (Message.length()==FirstMessage.length())
                      {
                            Message = Message.substring(FirstMessage.length());
                            //System.out.println(" Message Substr Is "+Message);
                      }
                      
                      j++;
                 }
                
          }
     }
}
