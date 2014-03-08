<?php
// required variables
require("config.php");

?>


<html>
<head>

<script language = javascript>


function setattribute()
        {

                <?php

                        if ($reportchoose=="custom" )
                                {
                                        print("

                                                document.test.purchase[0].disabled=true;
                                                document.test.purchase[1].disabled=true;
                                                document.test.purchase[2].disabled=true;



                                                ");

                               }

                        else
                                {
                                                print("document.test.clientname.disabled=true; ");
											
                                
								}


                ?>

                document.test.fromdate.disabled=true;
                document.test.todate.disabled=true;
                document.test.fixorcus[0].select();
                document.test.fixorcus[0].focus();

                //document.test.monthname.value = document.test.month.options[Number("<?php echo date("m") ?>")].text;
                //alert(document.test.monthname.value);
                document.test.year.disabled=true;
                document.test.month.disabled=true;

        }




function normal (whatever)
        {
                if (whatever=="first")
                        {
                                document.test.reportchoose.value = "fixed" ;
                                document.test.radiotest.value = "first" ;
                                document.test.todate.disabled=true;
                                document.test.fromdate.disabled=false;
                                document.test.month.disabled=true;
                                document.test.year.disabled=true;
                                document.test.fromdate.select();
                                document.test.fromdate.focus();


                        }

                if (whatever=="second")
                        {
                                document.test.reportchoose.value = "fixed" ;
                                document.test.radiotest.value = "second" ;
                                document.test.todate.disabled=true;
                                document.test.fromdate.disabled=true;
                                document.test.month.disabled=false;
                                document.test.year.disabled=false;
                                document.test.month.select();
                                document.test.month.focus();

                        }

                if (whatever=="third")
                        {
                                document.test.reportchoose.value = "fixed" ;
                                document.test.radiotest.value = "third" ;
                                document.test.todate.disabled=true;
                                document.test.fromdate.disabled=true;
                                document.test.month.disabled=false;
                                document.test.year.disabled=false;
                                document.test.todategif.disabled = true;
                                document.test.month.select();
                                document.test.month.focus();



                        }


                if (whatever=="fourth")
                        {
                                document.test.reportchoose.value = "fixed" ;
                                document.test.radiotest.value = "fourth" ;
                        }

                if (whatever=="fifth")
                        {
                                document.test.reportchoose.value = "fixed" ;
                                document.test.radiotest.value = "fifth" ;
                        }




        }




function fixnormal (whatever)
        {
                if (whatever=="fixed")
                        {
                                document.test.radiotest.value = "fixed" ;
                                document.test.reportchoose.value = "fixed" ;
                                document.test.purchase[0].disabled=false;
                                document.test.purchase[1].disabled=false;
                                document.test.purchase[2].disabled=false;




                                document.test.todate.disabled=true;
                                document.test.acctype[0].disabled=true;
                                document.test.acctype[1].disabled=true;
                                document.test.acctype[2].disabled=true;
                                document.test.acctype[3].disabled=true;
                                document.test.clientname.disabled=true;
								document.test.shipname.disabled=true; 
								document.test.allship_check.disabled=true; 
								document.test.carryorsale.disabled=true; 

                                if ( document.test.acctype[1].checked==true)
                                        {

                                                document.test.shipname.disabled=true;
                                        }

                                document.test.fromdate.disabled=false;
                                document.test.month.disabled=true;
                                document.test.year.disabled=true;
                                document.test.fromdate.focus();


                        }


                if (whatever=="custom")
                        {
                                document.test.radiotest.value = "custom" ;
                                document.test.reportchoose.value = "custom" ;
                                document.test.acctype[0].disabled=false;
                                document.test.acctype[1].disabled=false;
                                document.test.acctype[2].disabled=false;
                                document.test.acctype[3].disabled=false;
                                //document.test.clientname.disabled=false;
                                // document.test.shipname.disabled=false;
                                document.test.purchase[0].disabled=true;
                                document.test.purchase[1].disabled=true;
                                document.test.purchase[2].disabled=true;

                                document.test.todate.disabled=true;
                                document.test.fromdate.disabled=true;
                                document.test.month.disabled=false;
                                document.test.year.disabled=false;
                                document.test.todategif.disabled = true;
                                // document.test.month.focus();

                        }


        } //end of fixnormal


function shipsel()
        {


              document.test.shipselect.value = "true";
  	    //  document.test.setat.value = "true";
  	    	document.test.clientselect.value = "true";
            //    document.test.savecancel.value = "false";
  		document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
  		document.test.submit();


        }        // shipsel function ends



 function shipdisabled()
        {
             if (document.test.carryorsale.options[document.test.carryorsale.selectedIndex].text == "Purchase")
                {
                        document.test.shipname.disabled = "true";
                }

             if (document.test.carryorsale.options[document.test.carryorsale.selectedIndex].text == "Carrying")


                {
                      //   alert("shamim");
                         document.test.shipname.disabled = "false";
                         document.test.shipname.focus();

                }

        }





 function acctypechange(whatever)

         {   if (whatever=="Client")
                {
                        document.test.reportchoose.value = "custom" ;
                        document.test.clientchoose.value = "Client" ;
                        document.test.purchase[0].disabled=false;
                        document.test.purchase[1].disabled=false;
                        document.test.purchase[2].disabled=false;


 	                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
 	//document.test.submit();
                }


                if (whatever=="ShipOwner")
                     {
                             document.test.reportchoose.value = "custom"
                             document.test.clientchoose.value = "ShipOwner" ;
                             document.test.purchase[0].disabled=false;
                             document.test.purchase[1].disabled=false;
                             document.test.purchase[2].disabled=false;

                             document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
         	//document.test.submit();
                      }


                         if (whatever=="Official")
                             {
                                     document.test.reportchoose.value = "custom"
                                     document.test.clientchoose.value = "Official" ;
                                     document.test.purchase[0].disabled=false;
                                     document.test.purchase[1].disabled=false;
                                     document.test.purchase[2].disabled=false;

                                     document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;

                               }



                         if (whatever=="Account Ledger")
                             {
                                     document.test.reportchoose.value = "custom"
                                     document.test.clientchoose.value = "Account Ledger" ;
                                     document.test.purchase[0].disabled=false;
                                     document.test.purchase[1].disabled=false;
                                     document.test.purchase[2].disabled=false;

                                     document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;

                               }





                document.test.submit();





      }        // acctypechane function ends


















function report_window()
{

    document.test.monthname.value = document.test.month.options[document.test.month.selectedIndex].text;
    // alert(document.test.monthname.value);

    if ( document.test.radiotest.value == "")
        {

                alert("Please Select A Report");

        }








 if (document.test.reportchoose.value == "fixed")
        {

                if (document.test.radiotest.value == "first")
                        {


                                if (document.test.fromdate.value=="")
                                        {
                                                document.test.fromdate.focus();
                                                alert("Please Enter A Date For The Cashbook");

                                        }

                                else
                                        {

                                                var abc = "cashbook.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value+"&datevalue="+document.test.fromdate.value;
                                            //    alert(abc);
                                                window.open(abc,"Preview","toolbar=no,scrollbars=yes");

                                        }

                        }


                else if (document.test.radiotest.value == "second")
                        {
                           //     alert(document.test.radiotest.value);
                                var abc = "billwindow.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value;

                                window.open(abc,"Preview","toolbar=no,scrollbars=yes");
                        }

                else if (document.test.radiotest.value == "third")
                        {
                                alert(document.test.radiotest.value);
                                var abc = "income_expenditure_report.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value;
                           //     alert(abc);

                                window.open(abc,"Preview","toolbar=no,scrollbars=yes");
                        }

                else if (document.test.radiotest.value == "fourth")
                        {
                           //     alert(document.test.radiotest.value);
                                var abc = "income_expenditure_report.php?year="+document.test.year.value+"&month="+document.test.month.value;

                                window.open(abc,"Preview","toolbar=no,scrollbars=yes");
                        }

                 else
                        {

                              alert("Please Select A Report");

                         }




        }

  else if(document.test.reportchoose.value == "custom")

        {

                 if ( document.test.clientchoose.value == "")
                     {

                             alert("Please Select Client Or ShipOwner Or Official");

                     }


                if (document.test.clientchoose.value == "Client")
                       {
                           //     alert(document.test.radiotest.value);
                                if(document.test.allship_check.checked==true)
                                        {
                                         document.test.allship_value.value= "true";


                                        }


                                if(document.test.allship_check.checked==false)
                                        {
                                         document.test.allship_value.value= "false";
                                        }



                                var abc = "client_custom_report.php?year="+document.test.year.value+"&clientname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&clientchoose="+document.test.clientchoose.value+"&clientid="+document.test.clientname.value+"&carryorsale="+document.test.carryorsale.options[document.test.carryorsale.selectedIndex].text+"&shipname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&shipid="+document.test.shipname.value+"&allship="+document.test.allship_value.value;
                           //     alert(abc);

                                window.open(abc,"Preview","toolbar=no,scrollbars=yes,resizable=yes");
                       }
                else if (document.test.clientchoose.value == "ShipOwner")
                        {

                                if ( capfirst(document.test.shipname.options[document.test.shipname.selectedIndex].text) == "" )
                                        {
                                               alert("Please Select A shipname first");
                                               document.test.shipname.focus();
                                               return(false);
                                        }


                                document.test.shipid.value = document.test.shipname.value;

                                var abc = "custom_report.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value+"&clientname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&shipid="+document.test.shipid.value+"&clientchoose="+document.test.clientchoose.value+"&shipname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientid="+document.test.clientname.value;


                                window.open(abc,"Preview","toolbar=no,scrollbars=yes,resizable=yes");

                         }

                else if (document.test.clientchoose.value == "Official")
                        {

                                 var abc = "custom_report.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value+"&clientname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&clientchoose="+document.test.clientchoose.value+"&clientid="+document.test.clientname.value;


                                 window.open(abc,"Preview","toolbar=no,scrollbars=yes,resizable=yes");

                         }



                else if (document.test.clientchoose.value == "Account Ledger")
                        {

                                 var abc = "client2_custom_report.php?year="+document.test.year.value+"&month="+document.test.month.value+"&monthname="+document.test.monthname.value+"&clientname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&clientchoose="+document.test.clientchoose.value+"&clientid="+document.test.clientname.value;


                                 window.open(abc,"Preview","toolbar=no,scrollbars=yes,resizable=yes");

                         }






        }



 }



</script>

 <script language = javascript src="date_picker.js"> </script>

 <script language = javascript src="all_jscript_function.js"></script>

</head>

<body bgcolor="#4D4650" onload="setattribute()">

<form name = "test" action = "report.php" method = "post">


<div align="center"><b><font size="+3"><font color="yellow">Report Session </b></div></font> </font>








<div align="center"> <table border = 2><TR><th BGCOLOR=\"#aabf5c\">

<?php

  if ($reportchoose=="fixed")
        {

                print(" <input type =\"radio\" name =\"fixorcus\" value =\"fixed\" checked  onclick=\"fixnormal('fixed')\">&nbsp; FIXED REPORT</th><th BGCOLOR=\"#aabf5c\">
                <input type =\"radio\" name =\"fixorcus\" value =\"custom\"   onclick=\"fixnormal('custom')\">&nbsp;CUSTOMIZED REPORT</th> ");




        }


  elseif ($reportchoose=="custom")
        {

                print(" <input type =\"radio\" name =\"fixorcus\" value =\"fixed\"   onclick=\"fixnormal('fixed')\">&nbsp; FIXED REPORT</th><th BGCOLOR=\"#aabf5c\">
                <input type =\"radio\" name =\"fixorcus\" value =\"custom\" checked  onclick=\"fixnormal('custom')\">&nbsp;CUSTOMIZED REPORT</th> ");


        }

  else  {

                print(" <input type =\"radio\" name =\"fixorcus\" value =\"fixed\" checked  onclick=\"fixnormal('fixed')\">&nbsp; FIXED REPORT</th><th BGCOLOR=\"#aabf5c\">
                <input type =\"radio\" name =\"fixorcus\" value =\"custom\"   onclick=\"fixnormal('custom')\">&nbsp;CUSTOMIZED REPORT</th> ");

        }



        ?>



                     <tr><td align =justify valign =top width=50%>

                    <input type ="radio" name ="purchase" value ="first"   onclick="normal('first')"><font color="white"><b>&nbsp; Cashbook</b>
                    <br>
                    <input type ="radio" name ="purchase" value ="second"   onclick="normal('second')">&nbsp; <B>Bill.</B>
                    <br>
                    <input type ="radio" name ="purchase" value ="third"   onclick="normal('third')">&nbsp; <B>Monthly  Income & Expenditure Statement</B></font>


                    </td>

                    <td width=50% bordercolor=#FFFFFF>
                     <font color="white"><b>Account's Type :&nbsp;&nbsp; </b></font>
                     <BR>

                      <?php

                        if ($clientchoose=="Client")  {

                      print (" <font color=\"white\"><input type = \"radio\" name = \"acctype\" value = \"Client\" checked onclick= \"acctypechange('Client');document.test.submit()\">&nbsp;&nbsp; Client.

                      <input type = \"radio\" name = \"acctype\" value = \"ShipOwner\"  onclick= \"acctypechange('ShipOwner');document.test.submit()\">&nbsp;&nbsp; ShipOwner.
                      <input type = \"radio\" name = \"acctype\" value = \"Official\"   onclick= \"acctypechange('Official');document.test.submit()\">&nbsp;&nbsp; Official.
                      <input type = \"radio\" name = \"acctype\" value = \"Account Ledger\"  onclick= \"acctypechange('Account Ledger');document.test.submit()\">&nbsp;&nbsp; Account Ledger.</font>");
                        }

                        elseif ($clientchoose=="ShipOwner")  {

                       print (" <input type = \"radio\" name = \"acctype\" value = \"Client\"  onclick= \"acctypechange('Client');document.test.submit()\">&nbsp;&nbsp; Client.

                       <input type = \"radio\" name = \"acctype\" value = \"ShipOwner\"  checked onclick= \"acctypechange('ShipOwner');document.test.submit()\">&nbsp;&nbsp; ShipOwner.
                       <input type = \"radio\" name = \"acctype\" value = \"Official\"  onclick= \"acctypechange('Official');document.test.submit()\">&nbsp;&nbsp; Official.
                       <input type = \"radio\" name = \"acctype\" value = \"Account Ledger\"    onclick= \"acctypechange('Account Ledger');document.test.submit()\">&nbsp;&nbsp; Account Ledger.");
                        }

                           elseif ($clientchoose=="Official")  {

                          print (" <font color=\"white\"><input type = \"radio\" name = \"acctype\" value = \"Client\"  onclick= \"acctypechange('Client');document.test.submit()\">&nbsp;&nbsp; Client.

                          <input type = \"radio\" name = \"acctype\" value = \"ShipOwner\"   onclick= \"acctypechange('ShipOwner');document.test.submit()\">&nbsp;&nbsp; ShipOwner.
                          <input type = \"radio\" name = \"acctype\" value = \"Official\"  checked  onclick= \"acctypechange('Official');document.test.submit()\">&nbsp;&nbsp; Official.
                          <input type = \"radio\" name = \"acctype\" value = \"Account Ledger\"   onclick= \"acctypechange('Account Ledger');document.test.submit()\">&nbsp;&nbsp; Account Ledger.</font>");
                           }


                           elseif ($clientchoose=="Account Ledger")  {

                          print (" <input type = \"radio\" name = \"acctype\" value = \"Client\"  onclick= \"acctypechange('Client');document.test.submit()\">&nbsp;&nbsp; Client.

                          <input type = \"radio\" name = \"acctype\" value = \"ShipOwner\"   onclick= \"acctypechange('ShipOwner');document.test.submit()\">&nbsp;&nbsp; ShipOwner.
                          <input type = \"radio\" name = \"acctype\" value = \"Official\"    onclick= \"acctypechange('Official');document.test.submit()\">&nbsp;&nbsp; Official.
                          <input type = \"radio\" name = \"acctype\" value = \"Account Ledger\"  checked  onclick= \"acctypechange('Account Ledger');document.test.submit()\">&nbsp;&nbsp; Account Ledger.");
                           }







                            else
                              {

                                print (" <font color=\"white\"><input type = \"radio\" name = \"acctype\" value = \"Client\" disabled onclick= \"acctypechange('Client');document.test.submit()\">&nbsp;&nbsp; Client.

                                <input type = \"radio\" name = \"acctype\" value = \"ShipOwner\" disabled onclick= \"acctypechange('ShipOwner');document.test.submit()\">&nbsp;&nbsp; ShipOwner.
                                <input type = \"radio\" name = \"acctype\" value = \"Official\" disabled onclick= \"acctypechange('Official');document.test.submit()\">&nbsp;&nbsp; Official.
                                <input type = \"radio\" name = \"acctype\" value = \"Account Ledger\" disabled  onclick= \"acctypechange('Account Ledger');document.test.submit()\">&nbsp;&nbsp; Account Ledger.</font>");
                              }







                      ?>





                      <BR>
                    <font color="white"><b>Account's Name:&nbsp;&nbsp; </b></font>

                    <select  name="clientname"  id="clname" onchange="shipsel()  ">

                       <?php if ($clientselect =="true"){

                    print ("<option value = \"$clientname\" selected>$ownername");  $clientselect="false"; }   ////??????????why clientname   on 12th october ownername has been changed to accountname
                    ?></option>



                    <?php

                    if ($clientchoose=="Client")
                        {
                                $result = pg_exec("select account_id,account_name from accounts where account_type='Client' order by account_name");
                        }

                    elseif ($clientchoose=="ShipOwner")
                        {
                                $result = pg_exec("select account_id,account_name from accounts where account_type='Shipowner' order by account_name");
                        }

                    elseif ($clientchoose=="Official")
                        {
                                $result = pg_exec("select account_id,account_name from accounts where account_type='Official' order by account_name");
                        }


                    elseif ($clientchoose=="Account Ledger")
                        {
                                $result = pg_exec("select distinct on(account_name) account_id,account_name from accounts order by account_name");
                        }







                    else
                        {


                                // grabs all product information
                                $result = pg_exec("select account_id,account_name from accounts order by account_name");
                        }

                    $accountrows=pg_numrows($result);

                     for($i=0;$i<$accountrows;$i++)
                        {
                    	        $accountrow = pg_fetch_row($result,$i);

                    	        print("<option value = \"$accountrow[0]\" >$accountrow[1]</option>\n");
                    	}

                    ?>
                    </select>

                    <?php

             if ($clientchoose=="ShipOwner")

               {


                                print("<br><font color=\"white\"><b> Ship Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></font>");



                                // grabs all product information if ($radiotest=="normal")   { //starting normal option
                                print("<select size=\"1\" name=\"shipname\" ");

                                //print( "<option value= \" $row[5]\" selected> $row[6]  </option>  ");

                                if ($shipselect=="false")
                                        {
                                                $result = pg_exec("select ship_id,ship_name,account_id from ship where account_id=$clientname order by ship_name");
                                                echo "alert( Entered)";

                                                $shipselect = "false";
                                        }

                                else
                                        {
                                                echo "print( Entered)";
                                                $result = pg_exec("select ship_id,ship_name from ship where account_id=$clientname order by ship_name");
                    	                        print( "<option value= \"$shipname\" selected> $nameofship </option>  ");
                                        }

                        $num_ship = pg_numrows($result);

                        for($i=0;$i<$num_ship;$i++)
                                {
                    	                $row_ship = pg_fetch_row($result,$i);

                    	                print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
                    	        }

                        print(" </select>");


                }



                 if ($clientchoose=="Client")

                   {
                                  ///////  Next lines are to choose the records for purchase or carrying


                                         print("<br><font color=\"white\"><b> View For:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></font>");


                                         print("<select size=\"1\" name=\"carryorsale\" onchange=\"shipdisabled()\">

                                        <option selected>Carrying</option>
                                        <option>Purchase</option> ");

                                        print(" </select>");


                                    print("<br><font color=\"white\"><b> Ship Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></font>");



                                    // grabs all product information if ($radiotest=="normal")   { //starting normal option
                                    print("<select size=\"1\" name=\"shipname\" >");

                                    //print( "<option value= \" $row[5]\" selected> $row[6]  </option>  ");

                                    if ($shipselect=="false")
                                            {
                                                    $result = pg_exec("select ship_id,ship_name,account_id from ship order by ship_name ");
                                                    echo "alert( Entered)";

                                                    $shipselect = "false";
                                            }

                                    else
                                            {
                                                    echo "print( Entered)";
                                                    $result = pg_exec("select ship_id,ship_name from ship order by ship_name");
                        	                        print( "<option value= \"$shipname\" selected> $nameofship </option>  ");
                                            }

                                                    $num_ship = pg_numrows($result);

                                                    for($i=0;$i<$num_ship;$i++)

                                                        {
                        	                                $row_ship = pg_fetch_row($result,$i);

                        	                                print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
                        	                        }

                                        print(" </select>");

                              print("<input type=\"checkbox\" name=\"allship_check\" value=\"yes\">");
                                print("<font color=\"white\">Select all </font>");


                    }


                        ?>






                    </select>
                    <br> <br> <br> <br> <br> <br><br> <br>
                    </td></tr></table>
                    </div>



<p>

<div align="center"><font color="white">Enter Year :&nbsp;&nbsp;&nbsp;&nbsp;</font><input type ="text" size=5 name=year value="<?php print date ("Y")?>"><font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Month :&nbsp;&nbsp;</font>
                     <select name="month" onselect="report()">
                     <option value="<?php echo date("m") ?>" selected ><?php echo date("F") ?></option>
                     <option value="01" >January</option>
                     <option value="02" >February</option>
                     <option value="03" >March</option>
                     <option value="04" >April</option>
                     <option value="05" >May</option>
                     <option value="06" >June</option>
                     <option value="07" >July</option>
                     <option value="08" >August</option>
                     <option value="09" >September</option>
                     <option value="10" >October</option>
                     <option value="11" >November</option>
                     <option value="12" >December</option>
                    </select>

                    <br><br>
                    <font color="white">&nbsp;From Date : </font><input type=text name="fromdate" value="<?php echo date("Y-m-d") ?>" size=15><a href="javascript:show_calendar('test.fromdate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>

                    <font color="white">&nbsp;To Date : </font><input type=text name="todate" value="<?php echo date("Y-m-d") ?>" size=15><a href="javascript:show_calendar('test.todate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif" name="todategif" width=24 height=22 border=0></a>
                    </div>


<p><p></p></p>
<br><br>

<?php






//Print Body of the Table

//if($month=="January"){
$month_size = 01;
//$last_day = 31;
$tot_row=0;

//}
















?>

<INPUT TYPE="hidden" name="radiotest" value="<?php echo $radiotest  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>">
<INPUT TYPE="hidden" name="shipselect" value="<?php echo $shipselect  ?>" >
<INPUT TYPE="hidden" name="shipid" value="<?php echo $shipid  ?>" >
<INPUT TYPE="hidden" name="ownername" value="<?php echo $ownername ?>" >
<INPUT TYPE="hidden" name="clientselect" value="<?php echo $clientselect  ?>" >
<INPUT TYPE="hidden" name="clientchoose" value="<?php echo $clientchoose  ?>" >
<INPUT TYPE="hidden" name="reportchoose" value="<?php echo $reportchoose  ?>" >
<INPUT TYPE="hidden" name="allship_value" value="<?php echo $allship_value  ?>" >





<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Ok" name="okbutton" style=" width: 84; height: 25" onclick="report_window()">

</td>
    </tr>

    <tr>
    <td width="16%" height="32" valign="baseline" align="center"> <input type="reset" value="Cancel" name="exitbutton" style=" width: 84; height: 25" onclick= "">

    </td>
        </tr>

  </table>
</form>


<!--numrows("<?php echo $numrows ?>");
    accountid("<?php echo $accountid ?>");
    gotocheck("<?php echo $gotocheck ?>");
    filling("<?php echo $filling ?> ");
    button_check("<?php echo $button_check ?> ");
    radiotest("<?php echo $radiotest ?> ");
    monthname("<?php echo $monthname ?> ");
    -->

</body>
</html>

