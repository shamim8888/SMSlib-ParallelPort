<?php
// required variables
require("config.php");


?> 



<html>
<head>

<script language = javascript>



function select_record(buttonname)
{
 //eval("document.view_record."+buttonname+".value")= newvalue
	document.view_record.button_check.value = Number(buttonname.substr(1,3));
	document.view_record.filling.value = "viewcheck";
	document.view_record.gotocheck.value = Number(document.view_record.button_check.value)+1;
}


function set_main()
{       
	document.view_record.filling.value = "viewcheck";
	document.view_record.gotocheck.value = document.view_record.button_check.value;
<?php	
	print("opener.location=\"http://riverine.org/payment_add1.php?filling=gotobutton&radiotest=$radiotest&purchase=$radiotest&gotocheck=$gotocheck&savecancel=true\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>

</head>

<body> <form name = "view_record" action = "view_payment.php" method = "post">


<?php

 if ($radiotest == "normal")   {
$query_string = "select pay_voucher_date,account_name,ship_name,from_loc,to_loc,matone_name,mattwo_name,tk_rate,amount,pay_type,bank_name,branch,chequeno,cheque_pay_date,car_pur_off,comment from view_payment_carrying ";
 }
 if ($radiotest == "purchase")   {
$query_string = "select pay_voucher_date,account_name,ship_name,from_loc,to_loc,matone_name,mattwo_name,tk_rate,amount,pay_type,bank_name,branch,chequeno,cheque_pay_date,car_pur_off,comment from view_payment_purchase ";
 }
   if ($radiotest == "official")   {
$query_string = "select pay_voucher_date,account_name,amount,pay_type,bank_name,branch,chequeno,cheque_pay_date,car_pur_off,comment from view_payment_official ";
 }

 $result = pg_exec($conn,$query_string);

 $column_count = pg_numfields($result);

print ("<TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");
  for ($column_num =1; $column_num<$column_count; $column_num++)
    {
      $field_name= array('RECORD','VOUCHER DATE','&nbsp;&nbsp;ACCOUNT&nbsp;NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;SHIP&nbsp;NAME&nbsp;','FROM&nbsp;','&nbsp;&nbsp;TO&nbsp;&nbsp;','MAT_ONE','MAT_TWO','&nbsp;RATE&nbsp;','&nbsp;AMOUNT&nbsp;','PAY&nbsp;TYPE','BANK&nbsp;NAME','BRANCH','CHEQUE&nbsp;NO.','CHEQUE&nbsp;PAY','CARRY/PUR/OFFICIAL','COMMENT');

print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
     }
  print ("</TR>");
}

//Print Body of the Table



$j=0;
$abc = 1;
//$button_check=5;


//while($row = pg_fetch_row($result, $i))
$numrows=pg_numrows($result);

for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++) {

$row = pg_fetch_row($result,$count);

$color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

 echo ("<TR align = center  valign = center BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$count\" style=\" width: 40; height: 20\" onclick = \"select_record(document.view_record.b$count.name)\" >
</TD>");
for ($column_num =0; $column_num<$column_count;$column_num++)
	{
		print("<TD> $row[$column_num]</TD>\n");
	}
	print ("</TR>\n");$i++;
       }
	print ("</Table>");


	
	
?>

<INPUT TYPE="hidden" name="radiotest" value="<?php echo $radiotest  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >

<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick= "set_main()"> 

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
