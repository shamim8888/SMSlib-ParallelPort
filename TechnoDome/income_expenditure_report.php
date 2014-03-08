<?php
// required variables
require("config.php");


?>


<html>
<head>

<script language = javascript>


function set_main()
{

<?php
	print("opener.location=\"http://ns.riverine.org/report.php?year=$year&month=$month\"; ");
 ?>
	window.close();

}










</script>

</head>

<body>
<form name = "test" action = "income_expenditure_report.php" method = "post">
 <b><div align="center">RIVERINE SHIPPERS & TRADERS</b></div>

<p><p></p></p>
<div align="center"><b>EXPENDITURE & INCOME STATEMENT </b></div>
<p><p></p></p>





<?php

$result=pg_exec("select * from payment_voucher where car_pur_off='official' and (date_part('year', pay_voucher_date)=$year)and(date_part('month',pay_voucher_date)=$month)" );

//$numrows = pg_numrows($result);
//$row = pg_fetch_row($result,$numrows-1);

print ("<TABLE  border=1>\n");





  print ("<TR>");

  $field_names= array('Date','&nbsp;&nbsp;Salary&nbsp;&nbsp;','House&nbsp;Rent&nbsp;&&nbsp;Utilities','Printing,Photocopy','Office&nbsp;Management','Transport','Furnitures&nbsp;&&nbsp;Fixtures','Entertainment','Business&nbsp;Promotion','&nbsp;&nbsp;Loan&nbsp;&nbsp;','Loan&nbsp;Refund','Miscelleneous','&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;','   Received Amount     ','Advance','Remarks');

  $field_name= array('Date','Salary','House Rent & Utilities','Printing & Stationaries','Office Management','Transport','Furniture','Entertainment','Business Promotion','Loan','Loan Refund','Miscellenious','Total','   Received Amount     ','Advance','Remarks');


  for ($column_num =0; $column_num<15; $column_num++)
    {

print ("<TH BGCOLOR=\"#aabf5c\"> $field_names[$column_num]</TH>");
     }
  print ("</TR>");


//Calculate the number of days of the selected month
$last_day = date("t",mktime(0,0,0,$month,2,$year));

$tot_row=0;



for($tot_row=0;$tot_row<$last_day;$tot_row++)

 {
                echo ("<TR align = center  valign = center BGCOLOR=\"#fffff\">");
//for ($column_num =0; $column_num<$column_count;$column_num++)
//	{
                $date_column = $tot_row+1;
                //(string)$sss = ((string)$date_column)+((string)$month)+((string)$year);



               $sss="$year-"; $sss .="$month-";$sss .="$date_column";  print("<TD>$sss</TD>");

               $profit ="";

               $receiveamount_query = pg_exec("select total_tk, receive_total from cargo_schedule where (mreceipt_date='$sss' and  receive_balance='0')" );


               $receivenumrows = pg_numrows($receiveamount_query);


                if($receivenumrows!=0)

                        {
                                $receiveamount_row=pg_fetch_row($receiveamount_query,0);
                                $totalpayment = $receiveamount_row[0];
                                $totalreceive = $receiveamount_row[1];

                                $profit = $totalreceive - $totalpayment;
                        }










               for($count=1;$count<12;$count++)
                {


                        $salary_result=pg_exec("select sum(amount) from payment_voucher where (off_accountname='$field_name[$count]' and pay_voucher_date='$sss')");
                        $salary_numrows=pg_numrows($salary_result);

                        if($salary_numrows!=0)
                                {
                                        $salary_row=pg_fetch_row($salary_result,0);
                                }
                        else
                                {
                                        $salary_row[$count]=0;
                                }


                 print("<TD bgcolor=#C7B3A6 align=right>$salary_row[0]</TD>");


                  }
                     /// Follwing lines have been added by miraj to calculate total official expenses..start

                        $total_expense=pg_exec("select sum(amount) from payment_voucher where (car_pur_off='official' and pay_voucher_date='$sss')");
                        $total_expense_numrows=pg_numrows($total_expense);

                        if($total_expense_numrows!=0)
                                {
                                        $total_expense_row=pg_fetch_row($total_expense,0);
                                }
                        else
                                {
                                        $total_expense_row[$count]=0;
                                }




                print("<TD bgcolor=#E3ACA1 align=right>$total_expense_row[0]</TD>");

                ////////   Upto this

                print("<TD bgcolor=#ABD539 align=right>$profit</TD>");










                print ("</TR>");




     }

             print ("<TR>");
             print("<TD bgcolor=#7B8EC3><B>TOTAL</B></TD>");


               ///////////  Calculate item wise official expense total  //////////////////

               for($count=1;$count<12;$count++)
                {

                        $item_total_result=pg_exec("select sum(amount) from payment_voucher where car_pur_off='official' and off_accountname='$field_name[$count]' and (date_part('year', pay_voucher_date)=$year)and(date_part('month',pay_voucher_date)=$month)" );

                        $item_total_numrows=pg_numrows($item_total_result);

                        if($item_total_numrows!=0)
                                {
                                        $item_total_row=pg_fetch_row($item_total_result,0);
                                }
                        else
                                {
                                        $item_total_row[$count]=0;
                                }


                 print("<TD bgcolor=#E1B0D5 align=right>$item_total_row[0]</TD>");


                  }

                 ///////////  Calculate item wise official expense total  ends //////////////////









                       ///////////  Calculate grand official expense total  //////////////////

                        $grand_total_result=pg_exec("select sum(amount) from payment_voucher where car_pur_off='official'  and (date_part('year', pay_voucher_date)=$year)and(date_part('month',pay_voucher_date)=$month)" );

                        $grand_total_numrows=pg_numrows($grand_total_result);

                        if($grand_total_numrows!=0)
                                {
                                        $grand_total_row=pg_fetch_row($grand_total_result,0);
                                }
                        else
                                {
                                        $grand_total_row[$count]=0;
                                }


                 print("<TD bgcolor=#CECC9F align=right>$grand_total_row[0]</TD>");

                 ///////////  Calculate grand official expense total ends //////////////////


              print ("</TR>");





print ("</Table>");











?>






















<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>">
<INPUT TYPE="hidden" name="month" value="<?php echo $month  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >

<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick="set_main()">

</td>
    </tr>
  </table>
</form>
numrows("<?php echo $numrows ?>");
accountid("<?php echo $accountid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
radiotest("<?php echo $radiotest ?> ");
</body>
</html>

