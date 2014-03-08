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


function custom_submit()
        {


             document.test.custom_report_value.value = "true";

             alert(document.test.month.value);

             document.test.submit();

        }








</script>

</head>

<body>
<form name = "test" action = "client_custom_report.php" method = "post">
<b><div align="center"><font size="+3">RIVERINE SHIPPERS & TRADERS</font></b></div>

<p><p></p></p>
<div align="center"><b><font size="+3">Report For <?php echo $clientname ?> </font></b></div>
<p><p></p></p>




<!--<div align="center"><b><font size="+2">For The Month Of : <?php print ("$monthname"); ?></font></b>&nbsp;&nbsp;&nbsp;<b><font size="+2">, <?php echo $year ?></font></b></div>
    -->








<BR><BR>





<div align="center">
<font size="+1"><b><u>Customize Your view:</u></b></font><b><br><br>
                      Enter Year :</b><input type ="text" size=5 name=year value="<?php print date ("Y")?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <b>Select Month :</b>&nbsp;&nbsp;
                     <select name="month" onselect="report()">
                     <!--<option value="<?php echo date("m") ?>" selected ><?php echo date("F") ?></option>-->
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
                    <input type="button" value="Show Me" name="showbutton" style=" width: 84; height: 25" onclick="custom_submit()">

                    <br><br><br><br><br><br>




  </div>




<!--<div align="left"><b><font size="+2">Ship Name : <?php print ("$shipname"); ?></font></b>
    -->
<?php
         echo("$monthname");

        $field_name_client = array('&nbsp;Date&nbsp;&nbsp;','&nbsp;&nbsp;Voucher No.&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','&nbsp;Debit&nbsp;','&nbsp;Credit&nbsp;','&nbsp;Balance&nbsp;');






                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

                /////////////////////////////////   If clientchoose is Client... Condition Starts//////////////////////////////

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////




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

  if($custom_report_value!="true")

  {
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



   }       ////////////  If custom selection is not true....... Ends

             //////////////////////////////////////////////////////
            /// up to this... Added by miraj
            /////////////////////////////////////////////////////




if($allship=="true")     ///////////////   Starting condition for selecting ships which have departure date in the selected month


 {


        $ships_list_result = pg_exec("select distinct ship_id from money_carrying_view where (account_id=$clientid and date_part('month',departure_date) = $month)");    ///// selects the number of ships associated with the client



        $ships_list_numrows = pg_numrows($ships_list_result);



        for($ship_count=0;$ship_count<$ships_list_numrows;$ship_count++)    /////////  Executes the loop for each ship


          {   /////////  Executes the loop for each ship



                        $ships_list  =pg_fetch_row($ships_list_result,$ship_count);   /////////  Finds out the ship_ids column wise and increment column number


                        $money_trip_result =  pg_exec("select distinct trip_id from money_carrying_view where ship_id=$ships_list[0] ");   //// finds the trip id for for a particular ship

                        $maxtripid = pg_numrows($money_trip_result);



                     //   $cargotripid  =pg_fetch_row($money_trip_result,0);


                    //    $maxtripid =  $cargotripid[0];


                        $ship_name_result = pg_exec("select ship_name from ship where ship_id = $ships_list[0]");   ///////  Finds the particular ship name


                        $ship_name_row = pg_fetch_row($ship_name_result,0);



                        $SHIPNAME = $ship_name_row[0];    ////// Put the shipname into the variable $SHIPNAME



                        print ("<div align=\"left\"><b><font size=\"+2\">Ship Name :&nbsp;&nbsp; $SHIPNAME1&nbsp;&nbsp; Total trip:$maxtripid</font></b></div>");


                       $trip_counter=0;

                        $tripnumber = 0;           //////// initialize the variable $tripnumber for the particular ship


                        for ($trip_counter=1;$trip_counter<=$maxtripid;$trip_counter++)    /////////  execute the loop for a particular ship upto its max trip number

                                {

                                           //// increments the variable for a particular ship's trip id


                                        $moneyresult=pg_exec("select * from money_carrying_view where ship_id= $ships_list[0] and account_id = $clientid and trip_id = $trip_counter and (date_part('month',departure_date) = $month)");


                                        $numrows = pg_numrows($moneyresult);

                                  /*



                                      */


                                        if ( $numrows !=0)
                                                {
                                                     //

                                                       $tripnumber ++;


                                                        $departure_date_query = pg_exec("select departure_date from cargo_schedule where ship_id = $ships_list[0] and trip_id=$trip_counter and received_from = $clientid ");


                                                        $departure_date_result  =pg_fetch_row($departure_date_query,0);


                                                        $ship_departure_date =  $departure_date_result[0];


                                                        $departure_numrows = pg_numrows($departure_date_query);



                                                     if($departure_numrows!=0)

                                                      {

                                                        print("<div align=\"center\">");

                                                        print ("<TABLE  border=1 align=justify valign =top>");  // Starting of the parent table

                                                        print ("<TR align = justify><U> <B>Trip No. : </B> $trip_counter</U>"); // Parent tables's row starts
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


                                                                        print ("</Table></div>");    // Table ends here

                                                                        print("<br><br><br>");


                                                      }   /// if departuredate condition ends


                                                }   /// if numrows condition ends





                                } /// outer for loop ends .... prints ship particulars according to tripid


                        } //////  executing for loop for each ship..Ends





       ///////////  body for custom report is to be written here

      }



?>

<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>">
<INPUT TYPE="hidden" name="month1" value="<?php echo $month1 ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>">
<INPUT TYPE="hidden" name="datevalue" value="<?php echo $datevalue  ?>">
<INPUT TYPE="hidden" name="clientid" value="<?php echo $clientid  ?>">
<INPUT TYPE="hidden" name="clientchoose" value="<?php echo $clientchoose ?>">
<INPUT TYPE="hidden" name="allship" value="<?php echo $allship ?>">
<INPUT TYPE="hidden" name="clientname" value="<?php echo $clientname  ?>">
<INPUT TYPE="hidden" name="custom_report_value" value="<?php echo $custom_report_value  ?>">




 <table align="center">
 <tr>
 <td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Ok" name="okbutton" style=" width: 84; height: 25" onclick="javascript:window.print();"//javascript:window.close()>

 </td>
     </tr>

     <tr>
     <td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Cancel" name="exitbutton" style=" width: 84; height: 25" onclick= "javascript:window.close()">

     </td>
         </tr>

   </table>


<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick="set_main()">

</td>
    </tr>
  </table>
</form>


allship ("<?php echo $allship ?>")
monthvalue ("<?php echo $month ?>")




</body>
</html>

