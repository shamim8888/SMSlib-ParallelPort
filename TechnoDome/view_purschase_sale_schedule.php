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
	print("opener.location=\"http://riverine.org/purchase_sale_schedule.php?filling=gotobutton&gotocheck=$gotocheck&seenbefore=1\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>

</head>

<body> <form name = "view_record" action = "view_cargo_schedule.php" method = "post">

<?php

// connects to database

$conn=pg_connect("host=$host user=$user dbname=$database");

$query_string = "select departure_date,ship_name,account_name,from_loc,to_loc,matone_name,mattwo_name,quantity_one,quantity_two,fair_rate,unload_date,advance_tk,part_tk,balance_tk,total_tk,pay_voucher_date,trip_id from cargo_account_mat_view order by schedule_id";

$result = pg_exec($query_string);

$column_count = pg_numfields($result);

print ("<TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");
  $field_name= array('RECORD','Departure date','SHIP NAME','ACCOUNT NAME',' FROM ','TO  ','MAT_ONE','MAT_TWO','QTY.ONE','QTY.TWO','FAIR RATE','UNLOAD DATE','ADVANCE','PART','BALANCE','TOTAL','PAY DATE','TRIP ID');
  for ($column_num =1; $column_num<=$column_count; $column_num++)
    {

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

<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
 <INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>" >
<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick= "set_main()">

</td>
    </tr>
  </table>
</form>
numrows("<?php echo $numrows ?>");
schedule("<?php echo $scheduleid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
</body>
</html>

