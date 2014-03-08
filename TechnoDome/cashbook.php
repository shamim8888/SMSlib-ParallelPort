<?php
        // required variables
        require("config.php");
        //;$handcash = 0;
     //   $curr_month = date_Part('month',$datevalue);



        $curr_date = substr("$datevalue",8,2);
?>


<html>
<head>

<script language = javascript>


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
 <b><div align="center"><font size="+3">RIVERINE SHIPPERS & TRADERS</font></b></div>

<p><p></p></p>
<div align="center"><b><font size="+3">Cash Book</font></b></div>
<p><p></p></p>
<div align="center"><b><font size="+2">Date : <?php print ("$datevalue $curr_month" ); ?></font></b>&nbsp;&nbsp;&nbsp;<b><font size="+2"></font></b></div>
<table border=0 width=1800><TR><TD><font size="+2">Dr.</font></TD><TD><font size="+2">Cr.</font></TD></TR> </TABLE>


<?php

//$result=pg_exec("select * from payment_voucher where car_pur_off='official' and (date_part('year', pay_voucher_date)=$year)and(date_part('month',pay_voucher_date)=$month)" );

//$numrows = pg_numrows($result);
//$row = pg_fetch_row($result,$numrows-1);



print($curr_time);
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

$recdatevalue=  $datevalue;



///for print the first row cash in hand b/d .....  ///

 echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");
 print("<TD BGCOLOR=\"#D1C75C\">$datevalue</TD>");

 //print("<TD background=\"purple.jpeg\"></TD>");
 print("<TD BGCOLOR=\"#D1C75C\"></TD>");
 // print("<TD BGCOLOR=\"#D1C75C\"><B>Cash In Hand b/d</B></TD>");
 print("<TD background=\"purple.jpeg\"><B>Cash In Hand b/d</B></TD>");


  ///calculate Cash in hand b/d ?????//////



 $drpayresult=pg_exec("select sum(amount) from payment_voucher where pay_voucher_date < to_date('$datevalue','YYYY-mm-dd')" );

 $drnumrows = pg_numrows($drpayresult);

            if ($drnumrows==0){
                $drpaybeforedatetotal=0;

               }
            else{
                $drrow = pg_fetch_row($drpayresult,0);
                $drpaybeforedatetotal = $drrow[0];
               }





 $drrecresult=pg_exec("select sum(amount) from money_receipt where mreceipt_date < to_date('$datevalue','YYYY-mm-dd')" );
 $drnumrows = pg_numrows($drrecresult);


                 if ($drnumrows==0){
                     $drrecbeforedatetotal=0;

                    }
                 else{
                     $drrow = pg_fetch_row($drrecresult,0);
                     $drrecbeforedatetotal = $drrow[0];
                     }


  $drhandcash = $drrecbeforedatetotal - $drpaybeforedatetotal;


   $drrecresult=pg_exec("select sum(amount) from money_receipt where pay_type='Cash' and mreceipt_date = to_date('$datevalue','YYYY-mm-dd')" );
   $drnumrows = pg_numrows($drrecresult);


                   if ($drnumrows==0)
                   {
                       $drrecthatdatetotal_cash=0;

                      }

                   else
                   {
                       $drrow = pg_fetch_row($drrecresult,0);
                       $drrecthatdatetotal_cash = $drrow[0];
                       }


   ///  Need to be checked the following statement


   $drrecresult_cheque=pg_exec("select sum(amount) from money_receipt where pay_type='Cheque' and cheque_receive_date = to_date('$datevalue','YYYY-mm-dd')" );

   $drnumrows_cheque = pg_numrows($drrecresult_cheque);


                   if ($drnumrows_cheque==0)
                   {
                       $drrecthatdatetotal_cheque=0;

                      }

                   else
                   {

                       $drrow_cheque = pg_fetch_row($drrecresult_cheque,0);
                       $drrecthatdatetotal_cheque = $drrow_cheque[0];

                       }


                $drrecthatdatetotal = $drrecthatdatetotal_cheque+$drrecthatdatetotal_cash;


                $dralltotal = $drhandcash+$drrecthatdatetotal;
                $dralltotal .=".00";


  //////////////////////////// Followiung para has been written to calculate credit amount/////////

    $crpayresult=pg_exec("select sum(amount) from payment_voucher where pay_type='Cash' and pay_voucher_date = to_date('$datevalue','YYYY-mm-dd')" );
    $crnumrows = pg_numrows($crpayresult);


                    if ($crnumrows==0){
                        $crpaytotal_cash=0;

                       }
                    else{
                        $crrow = pg_fetch_row($crpayresult,0);
                        $crpaytotal_cash = $crrow[0];
                        }


   $crpayresult_cheque=pg_exec("select sum(amount) from payment_voucher where pay_type='Cheque' and cheque_pay_date = to_date('$datevalue','YYYY-mm-dd')" );
    $crnumrows_cheque = pg_numrows($crpayresult_cheque);


                    if ($crnumrows_cheque==0){
                        $crpaytotal_cheque=0;

                       }
                    else{
                        $crrow_cheque = pg_fetch_row($crpayresult_cheque,0);
                        $crpaytotal_cheque = $crrow_cheque[0];
                        }

                 $crpaytotal = $crpaytotal_cash+$crpaytotal_cheque;

                 $crpaytotal .=".00";

             //////////////////////// Upto this///////////////////////////
                 $drhandcash .=".00";

 print("<TD BGCOLOR=\"#D1C75C\"></TD>");
 print("<TD BGCOLOR=\"#D1C75C\" align=right>$drhandcash</TD>");
 print ("</TR>");
 ///END of first row????//////



 $payresult=pg_exec("select * from payment_voucher where  pay_voucher_date=to_date('$datevalue','YYYY-mm-dd') or cheque_pay_date = to_date('$datevalue','YYYY-mm-dd') order by voucher_id");

 $paynumrows = pg_numrows($payresult);




 $recresult=pg_exec("select * from money_receipt where mreceipt_date=to_date('$datevalue','YYYY-mm-dd') or cheque_receive_date = to_date('$datevalue','YYYY-mm-dd') order by mreceipt_id");
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
								$chequereceivedate = $row[12];
                                $amount = $row[2];
                                $amount .=".00" ;
								$bankname = $row[10];
								$bankname .=" Bank ";
								$branch = $row[11];
                                
								if (trim($paytype) == "Cheque")
                                                {
                                                        if ( $chequereceivedate !=  $datevalue)
                                                                {

                                                                        print("<TD BGCOLOR=\"#95B0E1\">we are here....$chequereceivdate..$datevalue.$amount..$voucherid.$car_pur_off..$carnumrows</TD>");
                                                                        continue;
                                                                }

                                                }	
								
								if ($car_pur_off=="Carrying")
                                        {

                                                $carresult=pg_exec("select * from money_carrying_view  where mreceipt_id=$receiptid" );

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
                                                                $accountname = $srow[21];
                                                                $shipname = $srow[22];
                                                                $comment = $srow[27];
                                                                $through = $srow[22];
                                                                $partoradvance = $srow[11];


                                                                $recpurticulars =  "From  ";$recpurticulars.="$accountname";$recpurticulars.=" On A/C Of ";$recpurticulars.=$shipname; $recpurticulars.="$partoradvance"; $recpurticulars.="$bankname"; $recpurticulars.="$branch"; $recpurticulars.="$comment";

                                                        }


                                        }




                                ////////////////////////////////////////////////////////////////////////
                                /////////////////////////////start sale option///////////////////////


                                if (trim($car_pur_off)=="Sale")
                                        {

                                                $carresult=pg_exec("select * from money_sale_view where mreceipt_id=$receiptid" );

                                                $carnumrows = pg_numrows($carresult);

                                                if ($carnumrows==0)
                                                        {
                                                                $cartotal=0;

                                                        }

                                                else
                                                        {

                                                                $srow = pg_fetch_row($carresult,0);
                                                                // $rectotal = $srow[0];
                                                                $voucherid = $srow[0];
                                                                $voucherno = $srow[2];
                                                                $voucherdate = $srow[1];
                                                                $accountname = $srow[21];
                                                                $shipname = $srow[22];
                                                                $comment = $srow[27];
                                                               // $through = $srow[22];
                                                                $recpurticulars =  "From  ";$recpurticulars.="$accountname";$recpurticulars.=" On A/C Of ";$recpurticulars.=$srow[22]; $recpurticulars.="$bankname"; $recpurticulars.="$branch"; $recpurticulars.=" $comment"; 
                                                                

                                                        }


                                        }


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
                                                                //$rectotal = $srow[0];
                                                                $voucherid = $srow[0];
                                                                $voucherno = $srow[2];
                                                                $voucherdate = $srow[1];
                                                                $accountname = $srow[4];
                                                                $offaccountname = $srow[11];
                                                                $comment = $srow[13];
                                                                //  $through = $srow[22];      $purticulars.=" $through";
                                                                $recpurticulars =  "From ";$recpurticulars.="$accountname";$recpurticulars.=" On A/C Of ";$recpurticulars.="$srow[11]"; $recpurticulars.="$bankname"; $recpurticulars.="$branch"; $recpurticulars.=" $comment";
                                                        }


                                        }


                        }
                 else
                        {
                                  $recdatevalue = "";
                                  $voucherno = "";
                                  $recpurticulars = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                ";
                                  $amount       = "";
                                  $car_pur_off  = "";

                        }




                 if ($car_pur_off=="Carrying")
                         {



                                 print("<TD BGCOLOR=\"#95B0E1\">$recdatevalue</TD>");

                                 print("<TD BGCOLOR=\"#95B0E1\">$voucherno</TD>");

                                 print("<TD BGCOLOR=\"#95B0E1\">$recpurticulars</TD>");

                                 //  print("<TD>$folio</TD>");

                                 print("<TD BGCOLOR=\"#95B0E1\" align=right>$amount</TD>");


                         }











                 if (trim($car_pur_off)=="Sale")
                         {



                                 print("<TD BGCOLOR=\"#C0C0C0\">$recdatevalue</TD>");

                                 print("<TD BGCOLOR=\"#C0C0C0\">$voucherno</TD>");

                                 print("<TD BGCOLOR=\"#C0C0C0\">$recpurticulars</TD>");

                                 //  print("<TD>$folio</TD>");

                                 print("<TD BGCOLOR=\"#C0C0C0\" align=right>$amount</TD>");


                         }


                  if ($car_pur_off=="official")
                          {



                                  print("<TD BGCOLOR=\"#80ff80\">$recdatevalue</TD>");

                                  print("<TD BGCOLOR=\"#80ff80\">$voucherno</TD>");

                                  print("<TD BGCOLOR=\"#80ff80\">$recpurticulars</TD>");

                                  //  print("<TD>$folio</TD>");

                                  print("<TD BGCOLOR=\"#80ff80\" align=right>$amount</TD>");


                          }



                        print ("</TR>");

                  }

                              echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                              print("<TD BGCOLOR=\"#FF00FF\">$datevalue</TD>");
                              print("<TD BGCOLOR=\"#FF00FF\"></TD>");
                              print("<TD BGCOLOR=\"#FF00FF\"></TD>");
                              print("<TD BGCOLOR=\"#FF00FF\"></TD>");
                           //  print("<TD></TD>");
                              print("<TD BGCOLOR=\"#FF00FF\" align=right>$dralltotal</TD>");
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
                                        $paytype = $row[9];
                                        $chequepaydate = $row[12];
                                        $amount = $row[2];
                                        $amount .=".00" ;
										$bankname = $row[10];
										$bankname .=" Bank ";
										$branch = $row[11];
                                        if (trim($paytype) == "Cheque")
                                                {
                                                        if ( $chequepaydate !=  $datevalue)
                                                                {

                                                                        print("<TD BGCOLOR=\"#95B0E1\">we are here....$chequepaydate..$datevalue.$amount..$voucherid.$car_pur_off..$carnumrows</TD>");
                                                                        continue;
                                                                }

                                                }



                                        /////////////////////////////start Carrying option///////////////////////


                                        if ($car_pur_off=="Carrying")
                                                {
                                                        $carresult=pg_exec("select * from view_payment_carrying where voucher_id=$voucherid" );

                                                        $carnumrows = pg_numrows($carresult);
														// print("<TD BGCOLOR=\"#95B0E1\">Carrying..we are here...$amount..$voucherid.$car_pur_off..$carnumrows</TD>");
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
                                                                        $shipname = $srow[6];
                                                                        $comment = $srow[21];
                                                                        $partadvance = $srow[24];
                                                                        $through = $srow[27];
                                                                        $purticulars =  "To  ";
                                                                        $purticulars.="$accountname";

                                                                        if(ltrim(rtrim($through))!="")
                                                                        {
                                                                        $purticulars.=" Through $through ";

                                                                        }

                                                                        $purticulars.=" On A/C Of ";
                                                                        $purticulars.=" $shipname";
																		$purticulars.="$bankname"; $purticulars.="$branch";
                                                                        $purticulars.=" $comment";

                                                                        //$purticulars.=" $partadvance";
                                                                }


                                                }


                                        /////////////////////////////start purchase option///////////////////////


                                        if ($car_pur_off=="Purchase")
                                                {
                                                        $carresult=pg_exec("select * from view_payment_purchase where voucher_id=$voucherid" );

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
                                                                        $shipname = $srow[6];
                                                                        $comment = $srow[20];
                                                                        $through = $srow[22];
                                                                        $purticulars =  "To Mr. ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.=$srow[6]; $purticulars.="$bankname"; $purticulars.="$branch"; $purticulars.=" $comment"; $purticulars.=" $through";
                                                                }


                                                }



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
                                                                        $purticulars =  "To ";$purticulars.="$accountname";$purticulars.=" On A/C Of ";$purticulars.="$srow[11]"; $purticulars.="$bankname"; $purticulars.="$branch"; $purticulars.=" $comment";
                                                                }


                                                }


                                }
                        else
                                {
                                        $cashdate = "vbn";
                                        $voucherno = "cvb";
                                }


                        if ($car_pur_off=="Carrying")
                                {



                                        print("<TD BGCOLOR=\"#95B0E1\">$datevalue</TD>");

                                        print("<TD BGCOLOR=\"#95B0E1\">$voucherno</TD>");

                                        print("<TD BGCOLOR=\"#95B0E1\">$purticulars</TD>");

                                        //  print("<TD>$folio</TD>");

                                        print("<TD BGCOLOR=\"#95B0E1\" align=right>$amount</TD>");


                                }


                          if ($car_pur_off=="Purchase")
                                  {



                                          print("<TD BGCOLOR=\"#C0C0C0\">$datevalue</TD>");

                                          print("<TD BGCOLOR=\"#C0C0C0\">$voucherno</TD>");

                                          print("<TD BGCOLOR=\"#C0C0C0\">$purticulars</TD>");

                                          //  print("<TD>$folio</TD>");

                                          print("<TD BGCOLOR=\"#C0C0C0\" align=right>$amount</TD>");


                                  }

                          if ($car_pur_off=="official")
                                  {



                                          print("<TD BGCOLOR=\"#80ff80\">$datevalue</TD>");

                                          print("<TD BGCOLOR=\"#80ff80\">$voucherno</TD>");

                                          print("<TD BGCOLOR=\"#80ff80\">$purticulars</TD>");

                                          //  print("<TD>$folio</TD>");

                                          print("<TD BGCOLOR=\"#80ff80\" align=right>$amount</TD>");


                                  }









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

                       if ($crnumrows==0)
                                {
                                       $crpayuptodatetotal=0;

                                }
                       else
                                {
                                        $crrow = pg_fetch_row($crpayresult,0);
                                        $crpayuptodatetotal = $crrow[0];
                                }





                        $crrecresult=pg_exec("select sum(amount) from money_receipt where mreceipt_date <= to_date('$datevalue','YYYY-mm-dd')" );
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


                        $dralltotal = $drhandcash+$drrecthatdatetotal;

                        $crhandcash = $dralltotal - $crpaytotal;
                        $cralltotal = $crhandcash + $crpaytotal;

                        $cralltotal .=".00";
                        $crhandcash.=".00";
                        // $crpaytotal.=".00";
                        print("<TD>TOTAL</TD>");
                        print("<TD></TD>");
                        //  print("<TD></TD>");
                        print("<TD align=right >$crpaytotal</TD>");
                        print ("</TR>");
                        ///END of first row????//////



                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                        print("<TD BGCOLOR=\"#D1C75C\">$datevalue</TD>");
                        print("<TD BGCOLOR=\"#D1C75C\"></TD>");
                        print("<TD Background=\"purple.jpeg\"><B>Cash In Hand c/d</B></TD>");
                        print("<TD BGCOLOR=\"#D1C75C\"></TD>");
                        // print("<TD></TD>");

                        print("<TD BGCOLOR=\"#D1C75C\" align=right>$crhandcash</TD>");
                        print ("</TR>");




                        echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");

                        print("<TD>$datevalue</TD>");
                        print("<TD></TD>");
                        print("<TD></TD>");
                        print("<TD></TD>");
                        //  print("<TD></TD>");
                        print("<TD align=right>$cralltotal</TD>");
                        print ("</TR>");





                        print ("</Table>");    // Right table ends here



                        print ("</td>"); // parent table's right data ends


                        print ("</tr>");// parent table's left data ends

                        print ("</Table>");    // Parent table ends here

                        print ("</div>");



?>









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







<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>">
<INPUT TYPE="hidden" name="month" value="<?php echo $month  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>">
<INPUT TYPE="hidden" name="datevalue" value="<?php echo $datevalue  ?>">







</form>
recnumrows("<?php echo $recnumrows ?>");
paynumrows("<?php echo $paynumrows ?>");
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

