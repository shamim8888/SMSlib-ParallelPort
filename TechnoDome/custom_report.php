<?php

        require("config.php");
        //;$handcash = 0;
        //$current_month = date("F","$datevalue");

?>


<html>
<head>

<script language = javascript>


function set_main()
        {

                <?php
	                print("opener.location=\"http://ns.riverine.org/report.php?year=$year&month=$month&monthname=$monthname\"; ");
                ?>

                window.close();

        }


function printstat()
{
 //eval("document.view_record."+buttonname+".value")= newvalue
        document.test.okbutton.style.background = "#FFFFFF";
        document.test.okbutton.style.border = 0;
        document.test.okbutton.value = "";
	document.test.exitbutton.style.background = "#FFFFFF";
        document.test.exitbutton.style.border = 0;
        document.test.exitbutton.value = "";
       // documentestt.view_record.exitbutton.style.width = "0";
        document.test.exitbutton.style.hidden = true;
	document.test.filling.value = "viewcheck";
	//document.test.gotocheck.value = Number(document.test.button_check.value)+1;
}






</script>

</head>

<body>
<form name = "test" action = "custom_report.php" method = "post">
<b><div align="center"><font size="+3">RIVERINE SHIPPERS & TRADERS</font></b></div>

<p><p></p></p>
<div align="center"><b><font size="+3">Report For <?php echo $clientname ?> </font></b></div>
<p><p></p></p>




<!--<div align="center"><b><font size="+2">For The Month Of : <?php print ("$monthname"); ?></font></b>&nbsp;&nbsp;&nbsp;<b><font size="+2">, <?php echo $year ?></font></b></div>
    -->








<BR>

<!--<div align="left"><b><font size="+2">Ship Name : <?php print ("$shipname"); ?></font></b></div>
    -->
<?php

   /*      if($clientchoose!="Official")
                 {

                      print ("<div align=\"left\"><b><font size=\"+2\">Ship Name :&nbsp;&nbsp; $shipname </font></b></div>");

                 }

    */



        $field_name_shipowner = array('&nbsp;Date&nbsp;&nbsp;','&nbsp;&nbsp;Voucher No.&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','&nbsp;Debit&nbsp;','&nbsp;Credit&nbsp;','&nbsp;Balance&nbsp;');
        $field_name_client = array('&nbsp;Date&nbsp;&nbsp;','&nbsp;&nbsp;Voucher No.&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','&nbsp;Debit&nbsp;','&nbsp;Credit&nbsp;','&nbsp;Balance&nbsp;');
        $field_name_official = array('&nbsp;Date&nbsp;&nbsp;','&nbsp;&nbsp;Voucher No.&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', '&nbsp;Debit&nbsp;','&nbsp;Credit&nbsp;','&nbsp;Balance&nbsp;');






        if($clientchoose=="ShipOwner")
                {

						print ("<div align=\"center\"><b><font size=\"+2\">Ship Name :&nbsp;&nbsp; $shipname </font></b></div><BR><BR>");
						
                        $trip_result =  pg_exec("select max(trip_id) from view_payment_carrying where ship_id=$shipid ");

                        $cargotripid  =pg_fetch_row($trip_result,0);
                        $maxtripid =  $cargotripid[0];


                        for ($trip_counter=1;$trip_counter<=$maxtripid;$trip_counter++)

                                {

                                        $payresult=pg_exec("select * from view_payment_carrying where ship_id= $shipid and account_id = $clientid and trip_id = $trip_counter");

                                        $numrows = pg_numrows($payresult);


                                        if ( $numrows !=0)
                                                {
                                                        print("<div align=\"center\">");

                                                        print ("<TABLE  border=1 align=justify valign =top>");  // Starting of the parent table

                                                        print ("<TR align = justify><U> <B>Trip No. : </B> $trip_counter</U>"); // Parent tables's row starts
                                                        print ("</TR>");
                                                        print ("<TR>");



                                                        if ($clientchoose=="ShipOwner")
                                                                {
                                                                        for ($column_num =0; $column_num<6;$column_num++)
                                                                                {

                                                                                        print ("<TH BGCOLOR=\"#aabf5c\"> $field_name_shipowner[$column_num]</TH>");

                                                                                }
                                                                }



                                                        print ("</TR>");


                                                        for($tablerow=0;$tablerow<$numrows;$tablerow++)
                                                                {
                                                                        $paytrip = pg_fetch_row($payresult,$tablerow);

                                                                        $voucherid = $paytrip[0];
                                                                        $voucherno = $paytrip[2];
                                                                        $voucherdate = $paytrip[1];
                                                                        $accountname = $paytrip[4];
                                                                        $shipname = $paytrip[6];
                                                                        $fromloc = $paytrip[8];
                                                                        $toloc = $paytrip[10];
                                                                        $matonename = $paytrip[12];
                                                                        $mattwoname = $paytrip[14];
                                                                        $amount = $paytrip [15];
                                                                        $comment = $paytrip[21];
                                                                        $partoradvance = $paytrip[24];
                                                                        $purticulars =  "From ";
                                                                        $purticulars.="$fromloc";
                                                                        $purticulars.="  To  ";
                                                                        $purticulars.=" $toloc";
                                                                        $purticulars.=" Carrying ";
                                                                        $purticulars.=" $matonename ";

                                                                        if (ltrim(rtrim($mattwoname))=="********")
                                                                                {
                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                }

                                                                        else
                                                                                {

                                                                                        $purticulars.=" And $mattwoname";
                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                 }




                                                                // print($voucherdate);



                                                                        echo ("<TR align = justify  valign = top BGCOLOR=\"#6fff0\">");

                                                                        print("<TD>$voucherdate</TD>");
                                                                        print("<TD>$voucherno</TD>");
                                                                        print("<TD>$purticulars</TD>");
                                                                        print("<TD align =right>$amount</TD>");


                                                                        print ("</TR>");

                                                                }   // inner for loop ends





                                                        ///// Calculate total debit amount///////

                                                        $drpayresult=pg_exec("select sum(amount) from payment_voucher where ship_id= $shipid and account_id = $clientid and trip_id = $trip_counter and car_pur_off='Carrying' " );

                                                        $drnumrows = pg_numrows($drpayresult);

                                                        if ($drnumrows==0)
                                                                {
                                                                        $drtotal=0;

                                                                }

                                                        else
                                                                {
                                                                        $drrow = pg_fetch_row($drpayresult,0);
                                                                        $drtotal = $drrow[0];

                                                                }


                                                        ////// Debit amount calculation ends///////////

                                                        $creditquery =  pg_exec("select total_tk, fair_rate,quantity_one,quantity_two from cargo_schedule where ship_id=$shipid and trip_id=$trip_counter");

                                                        $creditnumrows = pg_numrows($creditquery);


                                                        if ( $creditnumrows !=0)
                                                                {
                                                                        $creditcount = pg_fetch_row($creditquery,0);

                                                                        $creditamount = $creditcount[0];
                                                                        $cargofairrate = $creditcount[1];
                                                                        $quantityone = $creditcount[2];
                                                                        $quantitytwo = $creditcount[3];

                                                                        $cargoparticulars = "        ( $quantityone + $quantitytwo ) X          " ;
                                                                        $cargoparticulars.= "         $cargofairrate       ";

                                                                        $balanceamount = $creditamount - $drtotal;

                                                                        $balanceamount = floor($balanceamount);


                                                                        print("<TR><TD></TD><TD></TD><TD align =center bgcolor = #C07368><B>Total</B></TD><TD align =right bgcolor = #B7B7E8>$drtotal</TD></TR>");

                                                                        print("<TD></TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align=center bgcolor = #E6DBB5>         $cargoparticulars         </TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align=right right bgcolor = #DBE47C>$creditamount</TD>");


                                                                        print("<TR><TD></TD><TD></TD><TD align=center align=center bgcolor=#668181><B><font color =#E5E8B1 >Balance</font></B><TD></TD><TD></TD><TD align=right bgcolor = #FBEEAB><B>$balanceamount</B></TD>");

                                                                }


                                                        print("<br><br>");

                                                }   /// if numrows condition ends

                                        print ("</Table></div>");    // Table ends here

                                        print("<br><br><br>");

                                } /// outer for loop ends .... prints ship particulars according to tripid





                }  // If clientchoose is shipowner... ends



                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

                /////////////////////////////////   If clientchoose is Client... Condition Starts//////////////////////////////

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////


if($clientchoose=="Client")
        {

               if($allship=="false")

                     {
                       print ("<div align=\"left\"><b><font size=\"+2\">Ship Name :&nbsp;&nbsp; $shipname </font></b></div>");

                        $money_trip_result =  pg_exec("select max(trip_id) from money_carrying_view where ship_id=$shipid ");

                      //  $money_trip_result =  pg_exec("select max(trip_id) from money_carrying_view where ship_id=$shipid ");

                        $cargotripid  =pg_fetch_row($money_trip_result,0);

                        $maxtripid =  $cargotripid[0];

                        $tripnumber = 0;

                        for ($trip_counter=1;$trip_counter<=$maxtripid;$trip_counter++)

                                {

                                        $moneyresult=pg_exec("select * from money_carrying_view where ship_id= $shipid and account_id = $clientid and trip_id = $trip_counter");

                                        $numrows = pg_numrows($moneyresult);


                                        $departure_date_query = pg_exec("select departure_date from cargo_schedule where ship_id = $shipid and received_from = $clientid");


                                        $departure_date_result  =pg_fetch_row($departure_date_query,0);

                                        $ship_departure_date =  $departure_date_result[0];





                                        if ( $numrows !=0)
                                                {

                                                        $tripnumber ++;

                                                        print("<div align=\"center\">");

                                                        print ("<TABLE  border=1 align=justify valign =top>");  // Starting of the parent table

                                                        print ("<TR align = justify><U> <B>Trip No. : </B> $tripnumber</U>"); // Parent tables's row starts
                                                        print ("</TR>");

                                                        print ("<TR align = left><U> <B>Departure Date. : </B> $ship_departure_date</U>"); // Parent tables's row starts
                                                        print ("</TR>");


                                                        print ("<TR>");



                                                        if ($clientchoose=="Client")
                                                                {
                                                                        for ($column_num =0; $column_num<6;$column_num++)
                                                                                {

                                                                                        print ("<TH BGCOLOR=\"#aabf5c\"> $field_name_client[$column_num]</TH>");

                                                                                }
                                                                }



                                                        print ("</TR>");


                                                        for($tablerow=0;$tablerow<$numrows;$tablerow++)
                                                                {
                                                                        $moneytrip = pg_fetch_row($moneyresult,$tablerow);

                                                                        $voucherid = $moneytrip[0];
                                                                        $voucherno = $moneytrip[2];
                                                                        $voucherdate = $moneytrip[1];
                                                                        $accountname = $moneytrip[21];
                                                                        $shipname = $moneytrip[22];
                                                                        $fromloc = $moneytrip[23];
                                                                        $toloc = $moneytrip[24];
                                                                        $matonename = $moneytrip[25];
                                                                        $mattwoname = $moneytrip[26];
                                                                        $amount = $moneytrip [10];
                                                                        $comment = $moneytrip[27];
                                                                        $partoradvance = $moneytrip[11];
                                                                        $purticulars =  "From ";
                                                                        $purticulars.="$fromloc";
                                                                        $purticulars.="  To  ";
                                                                        $purticulars.=" $toloc";
                                                                        $purticulars.=" Carrying ";
                                                                        $purticulars.=" $matonename ";

                                                                        if (ltrim(rtrim($mattwoname))=="********")
                                                                                {

                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                }

                                                                        else
                                                                                {

                                                                                        $purticulars.=" And $mattwoname";
                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                }





                                                                        // print($voucherdate);



                                                                        echo ("<TR align = justify  valign = top BGCOLOR=\"#6fff0\">");

                                                                        print("<TD>$voucherdate</TD>");
                                                                        print("<TD>$voucherno</TD>");
                                                                        print("<TD>$purticulars</TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align =right>$amount</TD>");


                                                                        print ("</TR>");

                                                                }   // inner for loop ends





                                                        ///// Calculate total debit amount///////

                                                        $drpayresult=pg_exec("select sum(amount) from money_receipt where (ship_id= $shipid and account_id = $clientid and trip_id = $trip_counter and carry_sale_flag='Carrying') " );

                                                        $drnumrows = pg_numrows($drpayresult);

                                                        if ($drnumrows==0)
                                                                {
                                                                        $drtotal=0;

                                                                }

                                                        else
                                                                {
                                                                        $drrow = pg_fetch_row($drpayresult,0);
                                                                        $drtotal = $drrow[0];

                                                                }


                                                        ////// Debit amount calculation ends///////////

                                                        $creditquery =  pg_exec("select receive_total, money_fair_rate,quantity_one,quantity_two,money_fair_rate_two,receive_balance from cargo_schedule where ship_id=$shipid and trip_id=$trip_counter and received_from=$clientid");

                                                        $creditnumrows = pg_numrows($creditquery);




                                                        if ( $creditnumrows !=0)
                                                                {
                                                                        $creditcount = pg_fetch_row($creditquery,0);

                                                                        $creditamount = $creditcount[0];
                                                                        $cargofairrate = $creditcount[1];
                                                                        $quantityone = $creditcount[2];
                                                                        $quantitytwo = $creditcount[3];
                                                                        $cargofairratetwo = $creditcount[4];
                                                                        $balanceamount    = $creditcount[5];

                                                                        $cargoparticulars = "        ( $quantityone X          $cargofairrate       )+ ($quantitytwo  X          $cargofairratetwo                )" ;
                                                                        // $cargoparticulars.= "";

                                                                        $balanceamount = $creditamount - $drtotal;


                                                                        print("<TR><TD></TD><TD></TD><TD align =center bgcolor = #C07368><B>Total</B></TD><TD></TD><TD align =right  bgcolor = #B7B7E8>$drtotal</TD></TR>");

                                                                        print("<TD></TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align=center bgcolor = #E6DBB5>         $cargoparticulars         </TD>");

                                                                        print("<TD align=right bgcolor = #DBE47C>$creditamount</TD>");

                                                                        print("<TR><TD></TD><TD></TD><TD align=center bgcolor=#668181><B><font color =#E5E8B1 >Balance</font></B><TD></TD><TD></TD><TD align=right bgcolor = #FBEEAB><B>$balanceamount</B></TD>");

                                                                }


                                                        print("<br><br>");

                                                }   /// if numrows condition ends

                                        print ("</Table></div>");    // Table ends here

                                        print("<br><br><br>");

                                } /// outer for loop ends .... prints ship particulars according to tripid


                     }  ////// If $allship is false... ends



        ///////////////////////////////////////////////////////////
       ///  From here till  next bracket has been added by Miraj
       ///     To view all ship's information
        //////////////////////////////////////////////////////////



          if($allship=="true")

                     {   ////////  if $allship is true....starts


                       $ships_list_result = pg_exec("select distinct ship_id from money_carrying_view where account_id=$clientid");    ///// selects the number of ships associated with the client



                       $ships_list_numrows = pg_numrows($ships_list_result);



                       for($ship_count=0;$ship_count<$ships_list_numrows;$ship_count++)    /////////  Executes the loop for each ship

                       {   /////////  Executes the loop for each ship

                        $ships_list  =pg_fetch_row($ships_list_result,$ship_count);   /////////  Finds out the ship_ids column wise and increment column number


                        $money_trip_result =  pg_exec("select max(trip_id) from money_carrying_view where ship_id=$ships_list[0] ");   //// finds the trip id for for a particular ship

                        $cargotripid  =pg_fetch_row($money_trip_result,0);


                        $maxtripid =  $cargotripid[0];


                        $ship_name_result = pg_exec("select ship_name from ship where ship_id = $ships_list[0]");   ///////  Finds the particular ship name


                        $ship_name_row = pg_fetch_row($ship_name_result,0);



                        $SHIPNAME = $ship_name_row[0];    ////// Put the shipname into the variable $SHIPNAME



                        print ("<div align=\"left\"><b><font size=\"+2\">Ship Name :&nbsp;&nbsp; $SHIPNAME </font></b></div>");



                        $tripnumber = 0;           //////// initialize the variable $tripnumber for the particular ship


                        for ($trip_counter=1;$trip_counter<=$maxtripid;$trip_counter++)    /////////  execute the loop for a particular ship upto its max trip number

                                {

                                        $tripnumber ++;   //// increments the variable for a particular ship's trip id


                                        $moneyresult=pg_exec("select * from money_carrying_view where ship_id= $ships_list[0] and account_id = $clientid and trip_id = $tripnumber");


                                        $numrows = pg_numrows($moneyresult);

                                  /*



                                      */


                                        if ( $numrows !=0)
                                                {
                                                     //
                                                    



                                                        $departure_date_query = pg_exec("select departure_date from cargo_schedule where ship_id = $ships_list[0] and trip_id=$trip_counter and received_from = $clientid");


                                                        $departure_date_result  =pg_fetch_row($departure_date_query,0);


                                                        $ship_departure_date =  $departure_date_result[0];


                                                        $departure_numrows = pg_numrows($departure_date_query);





                                                        print("<div align=\"center\">");

                                                        print ("<TABLE  border=1 align=justify valign =top>");  // Starting of the parent table

                                                        print ("<TR align = justify><U> <B>Trip No. : </B> $tripnumber</U>"); // Parent tables's row starts
                                                        print ("</TR>");

                                                        print ("<TR align = left><U> <B>Departure Date. : </B> $ship_departure_date</U>"); // Parent tables's row starts
                                                        print ("</TR>");



                                                        print ("<TR>");



                                                        if ($clientchoose=="Client")
                                                                {
                                                                        for ($column_num =0; $column_num<6;$column_num++)
                                                                                {

                                                                                        print ("<TH BGCOLOR=\"#aabf5c\"> $field_name_client[$column_num]</TH>");

                                                                                }
                                                                }



                                                        print ("</TR>");


                                                        for($tablerow=0;$tablerow<$numrows;$tablerow++)
                                                                {
                                                                        $moneytrip = pg_fetch_row($moneyresult,$tablerow);

                                                                        $voucherid = $moneytrip[0];
                                                                        $voucherno = $moneytrip[2];
                                                                        $voucherdate = $moneytrip[1];
                                                                        $accountname = $moneytrip[21];
                                                                        $shipname = $moneytrip[22];
                                                                        $fromloc = $moneytrip[23];
                                                                        $toloc = $moneytrip[24];
                                                                        $matonename = $moneytrip[25];
                                                                        $mattwoname = $moneytrip[26];
                                                                        $amount = $moneytrip [10];
                                                                        $comment = $moneytrip[27];
                                                                        $partoradvance = $moneytrip[11];
                                                                        $purticulars =  "From ";
                                                                        $purticulars.="$fromloc";
                                                                        $purticulars.="  To  ";
                                                                        $purticulars.=" $toloc";
                                                                        $purticulars.=" Carrying ";
                                                                        $purticulars.=" $matonename ";

                                                                        if (ltrim(rtrim($mattwoname))=="********")
                                                                                {

                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                }

                                                                        else
                                                                                {

                                                                                        $purticulars.=" And $mattwoname";
                                                                                        $purticulars.=" $partoradvance";
                                                                                        $purticulars.=" $comment";

                                                                                }





                                                                        // print($voucherdate);



                                                                        echo ("<TR align = justify  valign = top BGCOLOR=\"#6fff0\">");

                                                                        print("<TD>$voucherdate</TD>");
                                                                        print("<TD>$voucherno</TD>");
                                                                        print("<TD>$purticulars</TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align =right>$amount</TD>");


                                                                        print ("</TR>");

                                                                }   // inner for loop ends





                                                        ///// Calculate total debit amount///////

                                                        $drpayresult=pg_exec("select sum(amount) from money_receipt where (ship_id= $ships_list[0] and account_id = $clientid and trip_id = $trip_counter and carry_sale_flag='Carrying') " );

                                                        $drnumrows = pg_numrows($drpayresult);

                                                        if ($drnumrows==0)
                                                                {
                                                                        $drtotal=0;

                                                                }

                                                        else
                                                                {
                                                                        $drrow = pg_fetch_row($drpayresult,0);
                                                                        $drtotal = $drrow[0];

                                                                }


                                                        ////// Debit amount calculation ends///////////

                                                        $creditquery =  pg_exec("select receive_total, money_fair_rate,quantity_one,quantity_two,money_fair_rate_two,receive_balance from cargo_schedule where ship_id=$ships_list[0] and trip_id=$trip_counter and received_from=$clientid");

                                                        $creditnumrows = pg_numrows($creditquery);




                                                        if ( $creditnumrows !=0)
                                                                {
                                                                        $creditcount = pg_fetch_row($creditquery,0);

                                                                        $creditamount = $creditcount[0];
                                                                        $cargofairrate = $creditcount[1];
                                                                        $quantityone = $creditcount[2];
                                                                        $quantitytwo = $creditcount[3];
                                                                        $cargofairratetwo = $creditcount[4];
                                                                        $balanceamount    = $creditcount[5];

                                                                        $cargoparticulars = "        ( $quantityone X          $cargofairrate       )+ ($quantitytwo  X          $cargofairratetwo                )" ;
                                                                        // $cargoparticulars.= "";

                                                                        $balanceamount = $creditamount - $drtotal;


                                                                        print("<TR><TD></TD><TD></TD><TD align =center bgcolor = #C07368><B>Total</B></TD><TD></TD><TD align =right  bgcolor = #B7B7E8>$drtotal</TD></TR>");

                                                                        print("<TD></TD>");
                                                                        print("<TD></TD>");
                                                                        print("<TD align=center bgcolor = #E6DBB5>         $cargoparticulars         </TD>");

                                                                        print("<TD align=right bgcolor = #DBE47C>$creditamount</TD>");

                                                                        print("<TR><TD></TD><TD></TD><TD align=center bgcolor=#668181><B><font color =#E5E8B1 >Balance</font></B><TD></TD><TD></TD><TD align=right bgcolor = #FBEEAB><B>$balanceamount</B></TD>");

                                                                }


                                                        print("<br><br>");

                                                }   /// if numrows condition ends



                                        print ("</Table></div>");    // Table ends here

                                        print("<br><br><br>");

                                } /// outer for loop ends .... prints ship particulars according to tripid


                        } //////  executing for loop for each ship..Ends

                     }  ////// If $allship is true... ends



             //////////////////////////////////////////////////////
            /// up to this... Added by miraj
            /////////////////////////////////////////////////////




        }  // If clientchoose is Client... ends




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////   If clientchoose is Official... Condition Starts//////////////////////////////

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////




        if($clientchoose=="Official")
                {


                        print("<div align=\"left\"><b><font size=\"+2\">Dr.</font>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <font size=\"+2\">Cr.</font></b>");



                print ("<div align = justify>");

                print ("<TABLE  border=\"1\" valign=\"top\" align=\"top>\" ");  // Starting of the parent table

                  print ("<TR>"); // Parent tables's row starts

                  print ("<TD valign=top align=justify>"); // Parent table's left data

                  print ("<TABLE  border=0>");   // Starting left table

                    print ("<TR>");


                  $field_name= array('&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;Voucher&nbsp;No.&nbsp;&nbsp;&nbsp;&nbsp;        ','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','&nbsp;Amount&nbsp;','&nbsp;Total&nbsp;');




                  for ($column_num =0; $column_num<6;$column_num++)
                    {

                print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
                     }
                  print ("</TR>");


                //Calculate the number of days of the selected month
                $last_day = date("t",mktime(0,0,0,$month,2,$year));

                $tot_row=0;



                 $crrecresult=pg_exec("select sum(amount) from money_official_view where account_id=$clientid " );
                 $crnumrows = pg_numrows($crrecresult);


                 if ($crnumrows==0)
                         {
                                 $crrectotal=0;

                         }
                 else
                         {
                                 $crrow = pg_fetch_row($crrecresult,0);
                                 $crrectotal = $crrow[0];
                                 //     print(098+$rectotal);
                         }


                  $crrectotal .=".00";



                  $crpayresult=pg_exec("select sum(amount) from view_payment_official where account_id=$clientid" );

                  $crnumrows = pg_numrows($crpayresult);

                 if ($crnumrows==0)
                          {
                                 $crpayuptodatetotal=0;

                          }
                 else
                          {
                                  $crrow = pg_fetch_row($crpayresult,0);
                                  $crpayuptodatetotal = $crrow[0];

                          }


                  $crpayuptodatetotal .=".00";







                 $payresult=pg_exec("select * from payment_voucher where  account_id=$clientid order by voucher_id");

                 $paynumrows = pg_numrows($payresult);




                 $recresult=pg_exec("select * from money_receipt where account_id=$clientid order by mreceipt_id");
                 $recnumrows = pg_numrows($recresult);


                 if ($paynumrows>$recnumrows)
                        {
                                $totalnumrows = $paynumrows;
                        }
                 else
                        {
                               $totalnumrows = $recnumrows;
                        }





                  for($tot_row=0;$tot_row<$totalnumrows;$tot_row++) {
                   echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                  //for Dr body-------------Receive----------------//
                  //	--------------------------------//
                                 if ($tot_row<$recnumrows)
                                        {

                                                $row = pg_fetch_row($recresult,$tot_row);
                                                $receiptid = $row[0];
                                                $voucherno = $row[13];
                                                $car_pur_off = $row[18];
                                                $voucherdate = $row[1];
                                                $amount = $row[2];
                                                $amount .=".00" ;


                                                        /////////////////////////////start Official option///////////////////////


                                                if ($car_pur_off=="official")
                                                        {
                                                                $carresult=pg_exec("select * from money_official_view where mreceipt_id=$receiptid" );

                                                                $carnumrows = pg_numrows($carresult);

                                                                if ($carnumrows==0)
                                                                        {
                                                                                $cartotal=0;

                                                                        }
                                                                else
                                                                        {
                                                                                $srow = pg_fetch_row($carresult,0);
                                                                                $rectotal = $srow[0];
                                                                                $voucherid = $srow[0];
                                                                                $voucherno = $srow[2];
                                                                                $voucherdate = $srow[1];
                                                                                $accountname = $srow[4];
                                                                                $offaccountname = $srow[11];
                                                                                $comment = $srow[13];
                                                                                //  $through = $srow[22];      $purticulars.=" $through";
                                                                                $recpurticulars =  "From ";$recpurticulars.="$accountname";$recpurticulars.=" On A/C Of ";$recpurticulars.="$srow[11]"; $recpurticulars.=" $comment";
                                                                        }


                                                        }


                                        }
                                 else
                                        {
                                                  $voucherdate = "";
                                                  $voucherno = "";
                                                  $recpurticulars = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                ";
                                                  $amount       = "";
                                        }











                                        print("<TD>$voucherdate</TD>");

                                        print("<TD>$voucherno</TD>");

                                        print("<TD>$recpurticulars</TD>");

                                        //   print("<TD>$folio</TD>");

                                        print("<TD align=right>$amount</TD>");
                                        print ("</TR>");

                                  }

                                              echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");
                                              print("<TD></TD>");
                                              print("<TD>$date</TD>");
                                              print("<TD><b>TOTAL</b></TD>");
                                              print("<TD></TD>");
                                              print("<TD></TD>");
                                           //  print("<TD></TD>");
                                              print("<TD align=right>$crrectotal</TD>");
                                              print ("</TR>");









                        print ("</Table>");    // Left table ends here

                        print ("</td>"); // parent table's left data ends

                        print ("<TD valign=top align=justify>"); // Parent table's right data


                        print ("<TABLE  border=0>");   // Starting right table

                        print ("<TR>");


                        $field_name2= array('&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;Voucher&nbsp;No.&nbsp;&nbsp;&nbsp;','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','&nbsp;&nbsp;Amount&nbsp;&nbsp;','&nbsp;&nbsp;Total&nbsp;&nbsp;');




                        for ($column_num =0; $column_num<6;$column_num++)
                                {

                                        print ("<TH BGCOLOR=\"#aabf5c\"> $field_name2[$column_num]</TH>");
                                }

                        print ("</TR>");


                       //Calculate the number of days of the selected month
                       $last_day = date("t",mktime(0,0,0,$month,2,$year));

                       $tot_row=0;


                       for($tot_row=0;$tot_row<$totalnumrows;$tot_row++)
                                {
                                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                                        //for Cr body-------------PAYMENT----------------//
                                        //	--------------------------------//
                                        if ($tot_row<=$paynumrows)
                                                {

                                                        $row = pg_fetch_row($payresult,$tot_row);
                                                        $voucherid = $row[0];
                                                        $voucherno = $row[13];
                                                        $car_pur_off = $row[17];
                                                        $voucherdate = $row[1];
                                                        $amount = $row[2];
                                                        $amount .=".00" ;




                                                        /////////////////////////////start Official option///////////////////////


                                                        if ($car_pur_off=="official")
                                                                {
                                                                        $carresult=pg_exec("select * from view_payment_official where voucher_id=$voucherid" );

                                                                        $carnumrows = pg_numrows($carresult);

                                                                        if ($carnumrows==0)
                                                                                {
                                                                                        $cartotal=0;

                                                                                }
                                                                        else
                                                                                {
                                                                                        $srow = pg_fetch_row($carresult,0);
                                                                                        $rectotal = $srow[0];
                                                                                        $voucherid = $srow[0];
                                                                                        $voucherno = $srow[2];
                                                                                        $voucherdate = $srow[1];
                                                                                        $accountname = $srow[4];
                                                                                        $offaccountname = $srow[11];
                                                                                        $comment = $srow[13];
                                                                                        //  $through = $srow[22];      $purticulars.=" $through";
                                                                                        $purticulars =  "To ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.="$srow[11]"; $purticulars.=" $comment";
                                                                                }


                                                                }


                                                }
                                        else
                                                {
                                                        $voucherdate = "vbn";
                                                        $voucherno = "cvb";
                                                }







                                        print("<TD>$voucherdate</TD>");

                                        print("<TD>$voucherno</TD>");

                                        print("<TD>$purticulars</TD>");

                                        //  print("<TD>$folio</TD>");

                                        print("<TD align=right>$amount</TD>");

                                        print ("</TR>");
                         }





                                        ///for print the first row cash in hand c/d .....  ///
                                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                                        for($asd=0;$asd<1;$asd++)
                                                {
                                                        print("<TD></TD>");
                                                }


                                        ///END of first row????//////




                                        ///calculate Cash in hand c/d ?????//////








                                        $balance=$crrectotal - $crpayuptodatetotal;

                                        $balance.=".00";


                                        $dralltotal = $drhandcash+$drrecthatdatetotal;

                                        $crhandcash = $dralltotal - $crpaytotal;
                                        $cralltotal = $crhandcash + $crpaytotal;

                                        $cralltotal .=".00";
                                        $crhandcash.=".00";
                                        // $crpaytotal.=".00";
                                        print("<TD></TD>");

                                        print("<TD><b>TOTAL</b></TD>");
                                        print("<TD></TD>");
                                        //  print("<TD></TD>");
                                        print("<TD align=right >$crpayuptodatetotal </TD>");
                                        print ("</TR>");
                                        ///END of first row????//////



                                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");


                                        print("<TD></TD>");


                                        // print("<TD></TD>");


                                        print ("</TR>");
                                        


                                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");
                                        print("<TD></TD>");
                                        print("<TD></TD>");
                                        print("<TD><b>BALANCE</b></TD>");


                                        print("<TD></TD>");
                                        //  print("<TD></TD>");
                                        print("<TD align=right>$balance</TD>");
                                        print ("</TR>");














                                        print ("</Table>");    // Right table ends here



                                        print ("</td>"); // parent table's right data ends


                                        print ("</tr>");// parent table's left data ends

                                        print ("</Table>");    // Parent table ends here

                                        print ("</div>");







 }  // If clientchoose is official... ends




?>








<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>">
<INPUT TYPE="hidden" name="month" value="<?php echo $month  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>">
<INPUT TYPE="hidden" name="datevalue" value="<?php echo $datevalue  ?>">
<INPUT TYPE="hidden" name="clientid" value="<?php echo $clientid  ?>">
<INPUT TYPE="hidden" name="clientchoose" value="<?php echo $clientchoose ?>">
<INPUT TYPE="hidden" name="allship" value="<?php echo $allship ?>">





 <table align="center">
 <tr>
 <td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Ok" name="okbutton" style=" width: 84; height: 25" onclick="printstat();javascript:window.print();"//javascript:window.close()>

 </td>
     </tr>

     <tr>
     <td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Cancel" name="exitbutton" style=" width: 84; height: 25" onclick= "javascript:window.close()">

     </td>
         </tr>

   </table>


<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="returnbutton" style=" width: 84; height: 25" onclick="set_main()">

</td>
    </tr>
  </table>
</form>


allship ("<?php echo $allship ?>")



</body>
</html>

