<?php
// required variables
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
	print("opener.location=\"http://riverine.org/report.php?year=$year&month=$month&monthname=$monthname\"; ");
 ?>
	window.close();

}










</script>

</head>

<body>
<form name = "test" action = "income_expenditure_report.php" method = "post">

 <b><div align="left"><font size="+2">RIVERINE SHIPPERS & TRADERS</font></b></div>
 <b><div align="right"><font size="+2">RIVERINE SHIPPERS & TRADERS</font></b></div>
<p><p></p></p>

<p><p></p></p>
<div align="left"><b><font size="+2">Month Of : <?php print ("$monthname"); ?></font></b>&nbsp;&nbsp;&nbsp;<b><font size="+2">, <?php echo $year ?></font></b></div>
<div align="right"><b><font size="+2">Month Of : <?php print ("$monthname"); ?></font></b>&nbsp;&nbsp;&nbsp;<b><font size="+2">, <?php echo $year ?></font></b></div>
<div align="left"><b><font size="+2">Clients Name : <?php print ("$clientname"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>

<div align="right"><b><font size="+2">Clients Name : <?php print ("$shipownername"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>

<div align="left"><b><font size="+2">On Account Of : <?php print ("$shipname"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>
<div align="right"><b><font size="+2">On Account Of : <?php print ("$shipname"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>

<div align="left"><b><font size="+2">Voyage </font></b>&nbsp;&nbsp;&nbsp;</div>
<div align="right"><b><font size="+2">Voyage </font></b>&nbsp;&nbsp;&nbsp;</div>


<div align="left"><b><font size="+2">From : <?php print ("$fromlocation"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>
<div align="right"><b><font size="+2">From : <?php print ("$fromlocation"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>

<div align="left"><b><font size="+2">To : <?php print ("$tolocation"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>
<div align="right"><b><font size="+2">To : <?php print ("$tolocation"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>

<div align="left"><b><font size="+2">Dated : <?php print ("$todate"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>
<div align="right"><b><font size="+2">Dated : <?php print ("$todate"); ?></font></b>&nbsp;&nbsp;&nbsp;</div>


<div align="left"><b><font size="+2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BILL</font></div><div align="right"><font size="+2">BILL</font></div>



<?php

//$result=pg_exec("select * from payment_voucher where car_pur_off='official' and (date_part('year', pay_voucher_date)=$year)and(date_part('month',pay_voucher_date)=$month)" );

//$numrows = pg_numrows($result);
//$row = pg_fetch_row($result,$numrows-1);



print ("<TABLE  border=1>");  // Starting of the parent table

  print ("<TR>"); // Parent tables's row starts

  print ("<TD valign=top align=justify>"); // Parent table's left data

  print ("<TABLE  border=0>");   // Starting left table

    print ("<TR>");


  $field_name= array('&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Particulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        ','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; X','&nbsp;Rate&nbsp;','&nbsp;Total &nbsp;','&nbsp;Total Amount&nbsp;');




  for ($column_num =0; $column_num<7;$column_num++)
    {

print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
     }
  print ("</TR>");


//Calculate the number of days of the selected month
$last_day = date("t",mktime(0,0,0,$month,2,$year));

$tot_row=0;





///for print the first row cash in hand b/d .....  ///

 echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");





  ///Receive bill particulars start here ****************//////
  ///****************************************************/////


 $drpayresult=pg_exec("select * from money_receipt where ship_id=$shipid and account_id=$clientid and trip_id=$tripid " );

 $drnumrows = pg_numrows($drpayresult);

            if ($drnumrows==0){
                $drpaybeforedatetotal=0;

               }
            else{
                for ($i=0;$i<drnumrows;$i++)

                $drrow = pg_fetch_row($drpayresult,$i);
                $receivedate = $drrow[1];

               }










                 $crpaytotal .=".00";






































   $drhandcash .=".00";

 print("<TD></TD>");
 print("<TD align=right>$drhandcash</TD>");
 print ("</TR>");
 ///END of first row????//////



 $payresult=pg_exec("select * from payment_voucher where  pay_voucher_date=to_date('$datevalue','YYYY-mm-dd') order by voucher_id");

 $paynumrows = pg_numrows($payresult);




 $recresult=pg_exec("select * from money_receipt where mreceipt_date=to_date('$datevalue','YYYY-mm-dd') order by mreceipt_id");
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

                  if ($car_pur_off=="Carry")

                  {
                     $carresult=pg_exec("select * from money_carrying_view  where mreceipt_id=$receiptid" );

                     $carnumrows = pg_numrows($carresult);

                     if ($carnumrows==0){
                         $cartotal=0;

                        }
                     else{
                         $srow = pg_fetch_row($carresult,0);
                         $rectotal = $srow[0];
                         $voucherid = $srow[0];
                         $voucherno = $srow[2];
                         $voucherdate = $srow[1];
                         $accountname = $srow[20];
                         $shipname = $srow[21];
                         $comment = $srow[26];
                         $through = $srow[22];
                         $purticulars =  "From Mr. ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$shipname; $purticulars.=" $comment"; $purticulars.=" $through";
                         }


                  }





                 }
                 else
                 {
                   $cashdate = "vbn";
                   $voucherno = "";
                   $purticulars = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                ";
                   $amount       = "";
                  }

                    /////////////////////////////start purchase option///////////////////////


                  if ($car_pur_off=="Sale")

                  {
                     $carresult=pg_exec("select * from money_sale_view where voucher_id=$voucherid" );

                     $carnumrows = pg_numrows($carresult);

                     if ($carnumrows==0){
                         $cartotal=0;

                        }
                     else{
                         $srow = pg_fetch_row($carresult,0);
                        // $rectotal = $srow[0];
                         $voucherid = $srow[0];
                         $voucherno = $srow[2];
                         $voucherdate = $srow[1];
                         $accountname = $srow[17];
                         $shipname = $srow[6];
                         $comment = $srow[21];
                         $through = $srow[22];
                         $purticulars =  "From Mr. ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$srow[6]; $purticulars.=" $comment"; $purticulars.=" $through";
                         }


                  }


                             print("<TD>$datevalue</TD>");

                              print("<TD>$voucherno</TD>");

                              print("<TD>$purticulars</TD>");

                              print("<TD>$folio</TD>");

                              print("<TD align=right>$amount</TD>");
                              print ("</TR>");

                  }

                              echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                              print("<TD>$datevalue</TD>");
                              print("<TD></TD>");
                              print("<TD></TD>");
                              print("<TD></TD>");
                              print("<TD></TD>");
                              print("<TD align=right>$dralltotal</TD>");
                              print ("</TR>");













































































///////before copying/////////////////////////////////////////////////////


//for($tot_row=0;$tot_row<$totalnumrows;$tot_row++) {
// echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

//for Dr body-----------------------------//
//	--------------------------------//
//               if ($tot_row<=$paynumrows)
//               {
//                $row = pg_fetch_row($payresult,$tot_row);
//                $cashdate = $row[1];
//                $voucherno = $row[13];
//            //    $purticulars =
//
//                }
//               else
//               {
//                 $cashdate = "vbn";
//                 $voucherno = "cvb";
//                }
//
//               print("<TD>$cashdate</TD>");
//
//                print("<TD>$voucherno</TD>");
//
//                print ("</TR>");
//     }

///////////////end of before copying/////////////////////////////











        print ("</Table>");    // Left table ends here

        print ("</td>"); // parent table's left data ends

        print ("<TD>"); // Middle  to have some space between both table

        print ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

        print ("</td>");  // Middle   ends here

        print ("<TD valign=top align=justify>"); // Parent table's right data


        print ("<TABLE  border=0>");   // Starting right table

          print ("<TR>");


        $field_name2= array('Date','Voucher No.','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purticulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ','Folio','Amount','Total');




        for ($column_num =0; $column_num<7;$column_num++)
          {

      print ("<TH BGCOLOR=\"#aabf5c\"> $field_name2[$column_num]</TH>");
           }
        print ("</TR>");


      //Calculate the number of days of the selected month
      $last_day = date("t",mktime(0,0,0,$month,2,$year));

      $tot_row=0;


    for($tot_row=0;$tot_row<$totalnumrows;$tot_row++) {
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

                      /////////////////////////////start Carrying option///////////////////////


                    if ($car_pur_off=="Carrying")

                    {
                       $carresult=pg_exec("select * from view_payment_carrying where voucher_id=$voucherid" );

                       $carnumrows = pg_numrows($carresult);

                       if ($carnumrows==0){
                           $cartotal=0;

                          }
                       else{
                           $srow = pg_fetch_row($carresult,0);
                           $rectotal = $srow[0];
                           $voucherid = $srow[0];
                           $voucherno = $srow[2];
                           $voucherdate = $srow[1];
                           $accountname = $srow[4];
                           $shipname = $srow[6];
                           $comment = $srow[21];
                           $through = $srow[24];
                           $purticulars =  "To Mr. ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$srow[6]; $purticulars.=" $comment"; $purticulars.=" $through";
                           }


                    }


                         /////////////////////////////start purchase option///////////////////////


                       if ($car_pur_off=="Purchase")

                       {
                          $carresult=pg_exec("select * from view_payment_purchase where voucher_id=$voucherid" );

                          $carnumrows = pg_numrows($carresult);

                          if ($carnumrows==0){
                              $cartotal=0;

                             }
                          else{
                              $srow = pg_fetch_row($carresult,0);
                              $rectotal = $srow[0];
                              $voucherid = $srow[0];
                              $voucherno = $srow[2];
                              $voucherdate = $srow[1];
                              $accountname = $srow[4];
                              $shipname = $srow[6];
                              $comment = $srow[20];
                              $through = $srow[22];
                              $purticulars =  "To Mr. ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$srow[6]; $purticulars.=" $comment"; $purticulars.=" $through";
                              }


                       }



                           /////////////////////////////start Official option///////////////////////


                         if ($car_pur_off=="official")

                         {
                            $carresult=pg_exec("select * from view_payment_official where voucher_id=$voucherid" );

                            $carnumrows = pg_numrows($carresult);

                            if ($carnumrows==0){
                                $cartotal=0;

                               }
                            else{
                                $srow = pg_fetch_row($carresult,0);
                                $rectotal = $srow[0];
                                $voucherid = $srow[0];
                                $voucherno = $srow[2];
                                $voucherdate = $srow[1];
                                $accountname = $srow[4];
                                $offaccountname = $srow[11];
                                $comment = $srow[13];
                              //  $through = $srow[22];      $purticulars.=" $through";
                                $purticulars =  "To ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$srow[6]; $purticulars.=" $comment";
                                }


                         }























































                   }
                   else
                   {
                     $cashdate = "vbn";
                     $voucherno = "cvb";
                    }





























































































                   print("<TD>$datevalue</TD>");

                    print("<TD>$voucherno</TD>");

                    print("<TD>$purticulars</TD>");

                    print("<TD>$folio</TD>");

                    print("<TD align=right>$amount</TD>");

                    print ("</TR>");
         }
















           ///for print the first row cash in hand c/d .....  ///
            echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");
            print("<TD>$datevalue</TD>");
            for($asd=0;$asd<1;$asd++)
            {
           print("<TD></TD>");
             }


            ///END of first row????//////




             ///calculate Cash in hand c/d ?????//////



            $crpayresult=pg_exec("select sum(amount) from payment_voucher where pay_voucher_date <= to_date('$datevalue','YYYY-mm-dd')" );

            $crnumrows = pg_numrows($crpayresult);

                       if ($crnumrows==0){
                           $crpayuptodatetotal=0;

                          }
                       else{
                           $crrow = pg_fetch_row($crpayresult,0);
                           $crpayuptodatetotal = $crrow[0];
                          }





            $crrecresult=pg_exec("select sum(amount) from money_receipt where mreceipt_date <= to_date('$datevalue','YYYY-mm-dd')" );
            $crnumrows = pg_numrows($crrecresult);


                            if ($crnumrows==0){
                                $crrectotal=0;

                               }
                            else{
                                $crrow = pg_fetch_row($crrecresult,0);
                                $crrectotal = $crrow[0];
                           //     print(098+$rectotal);
                                }


              $dralltotal = $drhandcash+$drrecthatdatetotal;

             $crhandcash = $dralltotal - $crpaytotal;
             $cralltotal = $crhandcash + $crpaytotal;

             $cralltotal .=".00";
             $crhandcash.=".00";
            // $crpaytotal.=".00";
            print("<TD>TOTAL</TD>");
            print("<TD></TD>");
            print("<TD></TD>");
            print("<TD align=right >$crpaytotal</TD>");
            print ("</TR>");
            ///END of first row????//////



             echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

             print("<TD>$datevalue</TD>");
             print("<TD></TD>");
             print("<TD>Cash In Hand c/d</TD>");
             print("<TD></TD>");
             print("<TD></TD>");

             print("<TD align=right>$crhandcash</TD>");
             print ("</TR>");












               echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

               print("<TD>$datevalue</TD>");
               print("<TD></TD>");
               print("<TD></TD>");
               print("<TD></TD>");
               print("<TD></TD>");
               print("<TD align=right>$cralltotal</TD>");
               print ("</TR>");














        print ("</Table>");    // Right table ends here



        print ("</td>"); // parent table's right data ends


        print ("</tr>");// parent table's left data ends

        print ("</Table>");    // Parent table ends here

     ///////////BILL of payment and receive ends here//////////////////////////////////////
     /////////////////////////////////////////////////////////////////////////////////////




    ///////////Details of payment and receive ends here//////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

        print ("<div align=\"left\"><b><font size=\"+2\">RECEIVE</font></div><div align=\"right\"><font size=\"+2\">PAYMENT</font></div>");

        print ("<TABLE  border=1>");  // Starting of the parent table

        print ("<TR>"); // Parent tables's row starts

        print ("<TD valign=top align=justify>"); // Parent table's left data

        print ("<TABLE  border=0>");   // Starting left table

        print ("<TR>");

        $field_name= array('&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Particulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        ','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;Credit&nbsp;','&nbsp;Balance &nbsp;','&nbsp;Total Amount&nbsp;');

        for ($column_num =0; $column_num<7;$column_num++)
                {

                        print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
                }

        print ("</TR>");


        ///for print the first row cash in hand b/d .....  ///

        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

        $drpayresult=pg_exec("select * from money_receipt where ship_id=$shipid and account_id=$clientid and trip_id=$tripid " );

        $drnumrows = pg_numrows($drpayresult);

                   if ($drnumrows==0){
                       $drpaybeforedatetotal=0;

                      }
                   else{                                                                                                                                                                                                                                                                                                                       for ($i=0;$i<drnumrows;$i++)

                       $drrow = pg_fetch_row($drpayresult,$i);
                       $receivedate = $drrow[1];

                      }





          print ("</Table>");    // Left table ends here

          print ("</td>"); // parent table's left data ends

          print ("<TD>"); // Middle  to have some space between both table

          print ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

          print ("</td>");  // Middle   ends here

          print ("<TD valign=top align=justify>"); // Parent table's right data


          print ("<TABLE  border=0>");   // Starting right table


           print ("<TR>");

           $field_name= array('&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Particulars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        ','    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;Debit&nbsp;','&nbsp;Balance &nbsp;','&nbsp;Total Amount&nbsp;');

           for ($column_num =0; $column_num<7;$column_num++)
                   {

                           print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
                   }

           print ("</TR>");







        print ("</Table>");    // Right table ends here

        print ("</td>"); // parent table's right data ends

        print ("</tr>");// parent table's left data ends

        print ("</Table>");    // Parent table ends here




?>






















<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>">
<INPUT TYPE="hidden" name="month" value="<?php echo $month  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>">
<INPUT TYPE="hidden" name="datevalue" value="<?php echo $datevalue  ?>">
<INPUT TYPE="hidden" name="accountid" value="<?php echo $accountid  ?>">

<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick="set_main()">

</td>
    </tr>
  </table>
</form>
recnumrows("<?php echo $recnumrows ?>");
totalnumrows("<?php echo $totalnumrows ?>");
paytotal("<?php echo $drpaytotal ?>");
rectotal("<?php echo $drrectotal ?>");
crrectotal("<?php echo $crrectotal ?>");
crpaytotal("<?php echo $crpaytotal ?>");
gotocheck("<?php echo $gotocheck ?>");
date("<?php echo $datevalue ?>");
button_check("<?php echo $button_check ?> ");
radiotest("<?php echo $radiotest ?> ");
</body>
</html>

