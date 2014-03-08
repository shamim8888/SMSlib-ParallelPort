
<?php

  require ("config.php");

// grabs all product information
$result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
$numrows = pg_numrows($result);
$row = pg_fetch_row($result,0);
$scheduleid = $row[12];
$tripid = $row[24];
$voucherid =$row[16];
$payvoucherdate = $row[23];




if ( is_integer($gotocheck)== 0)
     {
	$gotocheck = 1;
     }

?>


<html>
<head>
  <title>Cargo Schedule</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Miraj">



</head>

<script language= javascript>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?>;

var gotocheck = <?php echo $gotocheck ?>;

function setattribute()  {
document.test.departuredate.disabled=true;
document.test.goodquantityone.disabled=true;
document.test.goodquantitytwo.disabled=true;
document.test.clientname.disabled=true;
document.test.unloaddate.disabled=true;
document.test.advancetk.disabled=true;
document.test.parttk.disabled=true;
document.test.balancetk.disabled=true;
document.test.totaltk.disabled=true;

document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;
document.test.addbutton.disabled=true;
document.test.deletebutton.disabled=true;

window.status = document.test.gotocheck.value+"/"+ numrows
}


function form_validator(theForm)
{
        if(theForm.departuredate.value == "") {
        	 alert("<?php echo $txt_missing_accountname ?>");
        	 theForm.departuredate.focus();
        	 return(false);
        }

        return (true);
}



function add_edit_press(endis)  {
if (endis=='addedit') {
document.test.departuredate.disabled=false;
document.test.goodquantityone.disabled=false;
document.test.goodquantitytwo.disabled=false;
document.test.clientname.disabled=false;
document.test.unloaddate.disabled=false;
document.test.advancetk.disabled=false;
document.test.parttk.disabled=false;
document.test.balancetk.disabled=false;
document.test.totaltk.disabled=false;


document.test.addbutton.disabled=true;
document.test.editbutton.disabled=true;
document.test.viewbutton.disabled=true;
document.test.deletebutton.disabled=true;
document.test.prevrecord.disabled=true;
document.test.nextrecord.disabled=true;
document.test.topbutton.disabled=true;
document.test.gotobutton.disabled=true;
document.test.bottombutton.disabled=true;
document.test.printbutton.disabled=true;
document.test.savebutton.disabled=false;
document.test.cancelbutton.disabled=false;
}

else
	{
document.test.departuredate.disabled=true;
document.test.goodquantityone.disabled=true;
document.test.goodquantitytwo.disabled=true;
document.test.clientname.disabled=true;
document.test.unloaddate.disabled=true;
document.test.advancetk.disabled=true;
document.test.parttk.disabled=true;
document.test.balancetk.disabled=true;
document.test.totaltk.disabled=true;


document.test.addbutton.disabled=true;
document.test.editbutton.disabled=false;
document.test.viewbutton.disabled=false;
document.test.deletebutton.disabled=true;
document.test.prevrecord.disabled=false;
document.test.nextrecord.disabled=false;
document.test.topbutton.disabled=false;
document.test.gotobutton.disabled=false;
document.test.printbutton.disabled=false;
document.test.bottombutton.disabled=false;
document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;
	}
}


function del_confirm()
{
 var agree = confirm ("Are You Sure to delete the Record?", "");
 if (agree==true){
		document.test.filling.value = "deletebutton";
	document.test.submit();
	   }
}

function view_record()
{<?php
$button_check = $gotocheck - 1;
 print("window.open (\"view_cargo_schedule.php?gotocheck=$gotocheck&button_check=$button_check\",\"view\",\"toolbar=no,scrollbars=yes\")")?>;
}


function print_record()
{


   // var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value);



  var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&shipcargo="+document.test.shipname.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.clientname.value;

   window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");


}





</script>

<script language= javascript src= "all_jscript_function.js"> </script>

<script language = javascript src="date_picker.js"></script>

<body bgcolor="#444444" onload = "setattribute()">
<form name = "test" onsubmit = "return form_validator(this)" onreset= "add_edit_press()"  method = "post" action ="cargo_schedule_add.php">
  <b><u><font size=+3><div align="center">BILL Form</div></font></u></b>
  <div align="Center">
  <TABLE border="0"><TR><TD><B>For The Month Of :</B></TD>
  <TD>
  <select name="selectmonth">
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

</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </TD>

   <TD>  <B> Year:</B></TD>
   <TD><select name="selectyear" >

   <?php
    for ($i=1990;$i<=2090;$i++){

       print("<option value=$i>$i</option>");
          }
       ?>
        </select>  </TD></TR>
 </TABLE>
 </div> <br>
<table border=0>
<tr><td><B>Departure Date:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><input type ="text" name = "departuredate" value = "<?php echo $row[0] ?>" size = 10><a href="javascript:show_calendar('test.departuredate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
<td><B>Date Of Unload:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><input type ="text" name = "unloaddate" value ="<?php echo $row[11] ?>"size = 10><a href="javascript:show_calendar('test.unloaddate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
</tr>
<tr><td><B>Cargo Vessel:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<td><select size=1 name="shipname" >
<option value= "<?php echo $row[19] ?>" selected> <?php echo $row[1] ?> </option>


 </select>


<td><B>Owner's Name:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<td><select size="1" name="ownername">
  <option value= "<?php echo $row[13] ?>" selected><?php echo $row[2] ?> </option>


</select>
</tr>
  <tr><td><B>From:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><select size="1" name="fromloc" >

   <option value ="<?php echo $row[14] ?>" selected> <?php echo $row[3]  ?> <option>
</select>

 <td><B>To:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="toloc" >
   <option value ="<?php echo $row[15] ?>" selected> <?php echo $row[4] ?> <option>


</select>

</tr>






  <tr><td><B>Name Of Good One:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><select size="1" name="matone" >

 <option value ="<?php echo $row[16] ?>" selected> <?php echo $row[5] ?> <option>

 </select>

&nbsp;&nbsp;&nbsp;&nbsp;<td><B>Quantity :</B>&nbsp;&nbsp;&nbsp;&nbsp;<td><input type ="text" name = "goodquantityone" value ="<?php echo $row[7] ?>"size = 10 onchange="document.test.totaltk.value=(Number(document.test.goodquantityone.value)+ Number(document.test.goodquantitytwo.value)) * (Number(document.test.fairrate.value)),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value))">
<tr>
<td><B>Name Of Good Two:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<td><select size="1" name="mattwo" >


<option value ="<?php echo $row[17] ?>" selected> <?php echo $row[6] ?> <option>


</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td><B>Quantity :</B>&nbsp;&nbsp;&nbsp;&nbsp;<td><input type ="text" name = "goodquantitytwo" value ="<?php echo $row[8] ?>"size = 10 onchange="document.test.totaltk.value=(Number(document.test.goodquantityone.value)+ Number(document.test.goodquantitytwo.value)) * (Number(document.test.fairrate.value)),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value))"></tr>
  <tr><td><B>Cargo Fair Rate:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "fairrate" value ="<?php echo $row[9] ?>"size = 10 ></tr>
  <tr><td><B>Advance:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "advancetk" value ="<?php echo $row[10] ?>"size = 10 >
  <td><B>Part taka:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "parttk" value ="<?php echo $row[20] ?>"size = 10 ></tr>
  <tr><td><B>Total:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "totaltk" value ="<?php echo $row[22] ?>"size = 10 >
  <td><B>Balance:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "balancetk" value ="<?php echo $row[21] ?>"size = 10 ></tr>

  <tr><td><B>client's name:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name = "clientname" size = 20 ></tr>

</table>

<?php
   button_print();
?>

<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>">
<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid ?>">
<INPUT TYPE="hidden" name="voucherid" value="<?php echo $voucherid ?>">
<INPUT TYPE="hidden" name="payvoucherdate" value="<?php echo $payvoucherdate ?>">


</form>
<!--numrows("<?php echo $numrows ?>");
    scheduleid("<?php echo $scheduleid ?>");
    gotocheck("<?php echo $gotocheck ?>");
    filling("<?php echo $filling ?> ");
    ship("<?php echo $row[19] ?>");
    deprt("<?php echo $row[0] ?>");
    unload("<?php echo $unloaddate ?>");
    mat1("<?php echo $matone ?> ");
    mat2("<?php echo $mattwo ?>");
    from("<?php echo $row[14] ?>");
    toloc("<?php echo $toloc ?>");
    total("<?php echo $totaltk ?> ");
    balance("<?php echo $balancetk ?>");
    part("<?php echo $parttk ?>");
    advance("<?php echo $advancetk ?>");
    qun1("<?php echo $goodqantityone ?> ");
    qun2("<?php echo $goodquantitytwo ?>");
    accountid("<?php echo $ownername ?>");
    gotocheck("<?php echo $gotocheck ?>");
    filling("<?php echo $filling ?> ");
    -->


 </body>
 </html>