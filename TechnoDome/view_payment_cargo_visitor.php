<?php
// required variables
require("config.php");


?>



<html>
<head>
<style type="text/css">

	body {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
	th   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; font-weight: bold; background-color: <?php echo $cfgThBgcolor;?>;}
	td   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt;}
	form   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
	h1   {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16pt; font-weight: bold}
	A:link    {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: none; color: blue}
	A:visited {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: none; color: blue}
	A:hover   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: underline; color: red}
	A:link.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	A:visited.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	A:hover.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: red;}
	.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	.generic {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size:10pt; color: #000000}


	</style>

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
        if (document.view_record.button_check.value !=0){
	document.view_record.gotocheck.value = document.view_record.button_check.value;
         }

        var sendtopay1="http://riverine.org/payment_add1.php?gotocheck="+document.view_record.gotocheck.value+"&shipname="+document.view_record.shipcargovalue.value+"&nameofship="+document.view_record.nameofshipcargo.value+"&clientname="+document.view_record.clientoldvalue.value+"&accountname="+document.view_record.clientoldname.value+"&balancetk="+document.view_record.balancetk.value+"&radiotest="+document.view_record.radiotest.value+"&departuredate="+document.view_record.departuredate.value+"&matone="+document.view_record.materialonevalue.value+"&matonename="+document.view_record.materialonename.value+"&mattwo="+document.view_record.materialtwovalue.value+"&mattwoname="+document.view_record.materialtwoname.value+"&fromloc="+document.view_record.fromvalue.value+"&toloc="+document.view_record.tovalue.value+"&fromlocname="+document.view_record.fromlocname.value+"&tolocname="+document.view_record.tolocname.value+"&setat=true&savecancel=false&filling=addbutton";

        opener.location= sendtopay1;
	window.close();

}


function return_oldvalue()
{
	document.view_record.filling.value = "viewcheck";
        if (document.view_record.button_check.value !=0){
	document.view_record.gotocheck.value = document.view_record.button_check.value;   ///????????????
         }

        var sendtopay1="http://riverine.org/payment_add1.php?gotocheck="+document.view_record.gotocheck.value+"&balancetk="+document.view_record.balancetk.value+"&radiotest="+document.view_record.radiotest.value+"&departuredate="+document.view_record.departuredate.value+"&shipname="+document.view_record.shipoldvalue.value+"&nameofship="+document.view_record.shipoldname.value+"&accountname="+document.view_record.clientoldname.value+"&clientname="+document.view_record.clientoldvalue.value+"&matone="+document.view_record.matoneoldvalue.value+"&mattwo="+document.view_record.mattwooldvalue.value+"&materialonename="+document.view_record.oldmatonename.value+"&materialtwoname="+document.view_record.oldmattwoname.value+"&fromloc="+document.view_record.oldfromlocvalue.value+"&toloc="+document.view_record.oldtolocvalue.value+"&fromlocname="+document.view_record.oldfromlocname.value+"&tolocname="+document.view_record.oldtolocname.value+"&setat=true&savecancel=false&filling=addbutton";
         alert(sendtopay1);
        opener.location= sendtopay1;
	window.close();


}




</script>

</head>

<body bgcolor="#F5F5F5" text="#000000" background ="bkg.gif">
<form name = "view_record" action = "view_payment_cargo.php" method = "post">


<?php

// connects to database



$query_string = "select * from cargoschedule_part_advance_view where (ship_id ='$shipcargo' and balance_tk !=0) order by schedule_id";

 $query_string2 = "select schedule_id,departure_date,ship_name,account_name,from_loc,to_loc,matone_name,quantity_one,mattwo_name,quantity_two,pay_voucher_date,pay_location,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,money_fair_rate,receive_advance,receive_part,receive_total,receive_balance,mreceipt_date from cargoschedule_part_advance_view where (ship_id ='$shipcargo' and balance_tk !=0) order by schedule_id";

 $result = pg_exec($query_string);

 $column_count = pg_numfields($result);

print ("<TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");
  for ($column_num =1; $column_num<$column_count; $column_num++)
    {
      $field_name= array('','Scdl id','Dpt. Date','ship_name','account_name','from_loc','to_loc','matone_name','quantity_one','mattwo_name','quantity_two','pay_voucher_date','pay_location','fair_rate','advance_tk','part_tk','total_tk','balance_tk','trip_id','unload_date','money_fair_rate','receive_advance','receive_part','receive_total','receive_balance','mreceipt_date');

print ("<TH> $field_name[$column_num]</TH>");
     }
  print ("</TR>");
}

//Print Body of the Table



$j=0;
$abc = 1;
//$button_check=5;


//while($row = pg_fetch_row($result, $i))
$numrows=pg_numrows($result);

if($numrows!=0){
for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++) {

$row = pg_fetch_row($result,$count);

$color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

if ($button_check==$count ){
 $balancetk = $row[15];
 $departuredate = $row[1];
 $shipcargovalue = $row[2];
 $nameofshipcargo = $row[3];
 $fromvalue = $row[6];
 $fromlocname = $row[7];
 $tovalue = $row[8];
 $tolocname = $row[9];
 $materialonevalue = $row[10];
 $materialonename = $row[11];
 $materialtwovalue = $row[12];
 $materialtwoname = $row[13];
 $paymenttkrate = $row[18];
// $payment_type = $row[];


}

 echo ("<TR align = center  valign = center BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$count\" style=\" width: 40; height: 20\" onclick = \"select_record(document.view_record.b$count.name)\" >
</TD>");
for ($column_num =0; $column_num<$column_count;$column_num++)
	{
		print("<TD> $row[$column_num]</TD>\n");
	}
	print ("</TR>\n");$i++;
       }

      } // End of the condition if numrows is not zero


  else{

    $shipcargovalue = $shipoldvalue;
    $nameofshipcargo = $shipoldname;
    $fromvalue = $oldfromlocvalue;
    $tovalue =   $oldtolocvalue;
    $fromlocname = $oldfromlocname;
    $tolocname =   $oldtolocname;
    $materialonevalue = $matoneoldvalue;
    $materialtwovalue = $mattwooldvalue;
    $materialonename = $oldmatonename;
    $materialtwoname = $oldmattwoname;





  }



        print ("</Table>");




?>

<INPUT TYPE ="hidden" name ="radiotest" value ="<?php echo $radiotest ?>">

<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">

<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >

<INPUT TYPE="hidden" name="balancetk" value="<?php echo $balancetk  ?>" >
<INPUT TYPE="hidden" name="departuredate" value="<?php echo $departuredate ?>">
<INPUT TYPE="hidden" name="voucherdate" value="<?php echo $voucherdate ?>">


<INPUT TYPE="hidden" name="shipcargo" value="<?php echo $shipcargo ?>">
<INPUT TYPE="hidden" name="shipcargovalue" value="<?php echo $shipcargovalue ?>">
<INPUT TYPE="hidden" name="nameofshipcargo" value="<?php echo $nameofshipcargo ?>">
<INPUT TYPE="hidden" name="shipoldvalue" value="<?php echo $shipoldvalue ?>">
<INPUT TYPE="hidden" name="shipoldname" value="<?php echo $shipoldname ?>">




<input type ="hidden" name ="oldmatonename" value="<?php echo $oldmatonename ?>">
<input type ="hidden" name ="oldmattwoname" value="<?php echo $oldmattwoname ?>">
<input type ="hidden" name ="matoneoldvalue" value="<?php echo $matoneoldvalue ?>">
<input type ="hidden" name ="mattwooldvalue" value="<?php echo $mattwooldvalue ?>">

<input type ="hidden" name ="payment_type" value="<?php echo $payment_type ?>">
<input type ="hidden" name ="ownervalue" value="<?php echo $ownervalue ?>">
<input type ="hidden" name ="clientoldname" value="<?php echo $clientoldname ?>">
<input type ="hidden" name ="clientoldvalue" value="<?php echo $clientoldvalue ?>">
<input type ="hidden" name ="materialonename" value="<?php echo $materialonename ?>">
<input type ="hidden" name ="materialtwoname" value="<?php echo $materialtwoname ?>">
<input type ="hidden" name ="materialonevalue" value="<?php echo $materialonevalue ?>">
<input type ="hidden" name ="materialtwovalue" value="<?php echo $materialtwovalue ?>">

<input type ="hidden" name ="oldfromlocname" value="<?php echo $oldfromlocname ?>">
<input type ="hidden" name ="oldtolocname" value="<?php echo $oldtolocname ?>">
<input type ="hidden" name ="oldfromlocvalue" value="<?php echo $oldfromlocvalue ?>">
<input type ="hidden" name ="oldtolocvalue" value="<?php echo $oldtolocvalue ?>">
<input type ="hidden" name ="fromvalue" value="<?php echo $fromvalue ?>">
<input type ="hidden" name ="tovalue" value="<?php echo $tovalue ?>">
<input type ="hidden" name ="fromlocname" value="<?php echo $fromlocname ?>">
<input type ="hidden" name ="tolocname" value="<?php echo $tolocname ?>">
<input type ="hidden" name ="oldtkrate" value="<?php echo $oldtkrate ?>">


<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center">
<input type="button" value="OK" name="okbutton" style=" width: 84; height: 25" onclick= "set_main()">
<input type="button" value="Cancel" name="cancelbutton" style=" width: 84; height: 25" onclick= "return_oldvalue()">

</td>
    </tr>
  </table>
</form>
numrows("<?php echo $numrows ?>");
accountid("<?php echo $clientoldvalue ?>");
accountname("<?php echo $clientoldname ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $shipcargo ?> ");
departure date("<?php echo $departuredate ?> ");
balance taka("<?php echo $balancetk ?> ");
</body>
</html>
