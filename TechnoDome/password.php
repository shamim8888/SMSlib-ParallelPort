<?php

require("config.php");
//require("new_account_entry_form_experiment.php");


// grabs all product information
$result = pg_exec("select * from accounts order by account_id");
$numrows = pg_numrows($result);
$row = pg_fetch_row($result,0); 



$accountid = $row[0];

 
//for store a number in $gotocheck for prev,next,goto...

 if ( is_integer($gotocheck)== 0)
     {
	$gotocheck = 1;
     }





?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>New Account Entry Form</title>


</head>

<script language= javascript>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?>;

var gotocheck = <?php echo $gotocheck ?>;

function setattribute()  {
document.test.accountname.disabled=true;
document.test.officeaddress.disabled=true;
document.test.homeaddress.disabled=true;
document.test.offphone.disabled=true;
document.test.resphone.disabled=true;
document.test.mobilephone.disabled=true;
document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;

window.status = document.test.gotocheck.value+"/"+<?php echo $numrows ?>;
}


function form_validator(theForm)
{

	//if(theForm.accounttype.selectedIndex == -1) {
	//	 alert("<?php echo $txt_missing_accounttype ?>");
	//	 theForm.accounttype.focus();
	//	 return(false);
	//}

	if(theForm.accountname.value == "") {
		 alert("<?php echo $txt_missing_accountname ?>");
		 theForm.accountname.focus();
		 return(false);
	}
	

//	if (theForm.accounttype.selectedIndex != 2 && theForm.accounttype.selectedIndex != 4)
//	{
//		if(theForm.officeaddress.value == "") {
//		 	alert("<?php echo $txt_missing_officeaddress ?>");
//		 	theForm.officeaddress.focus();
//			return(false);
//			}
//
//		if(theForm.offphone.value == "" && theForm.resphone.value == "" && theForm.mobilephone.value == "") {
//		 	alert("Please enter at least one phone number!");
//		 	theForm.offphone.focus();
//		 	return(false);
//			}

		
//	}
	
	
	return (true);
}



function add_edit_press(endis)  {
if (endis=='addedit') {
document.test.accountname.disabled=false;
document.test.officeaddress.disabled=false;
document.test.homeaddress.disabled=false;
document.test.offphone.disabled=false;
document.test.resphone.disabled=false;
document.test.mobilephone.disabled=false;
document.test.addbutton.disabled=true;
document.test.editbutton.disabled=true;
document.test.viewbutton.disabled=true;
document.test.savebutton.disabled=false;
document.test.cancelbutton.disabled=false;
document.test.deletebutton.disabled=true;

document.test.prevrecord.disabled=true;
document.test.nextrecord.disabled=true;
document.test.topbutton.disabled=true;
document.test.gotobutton.disabled=true;
document.test.bottombutton.disabled=true;
document.test.printbutton.disabled=true;

}

else
	{
document.test.accountname.disabled=true;
document.test.officeaddress.disabled=true;
document.test.homeaddress.disabled=true;
document.test.offphone.disabled=true;
document.test.resphone.disabled=true;
document.test.mobilephone.disabled=true;

document.test.addbutton.disabled=false;
document.test.editbutton.disabled=false;
document.test.viewbutton.disabled=false;
document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;
document.test.deletebutton.disabled=false;
document.test.prevrecord.disabled=false;
document.test.nextrecord.disabled=false;
document.test.topbutton.disabled=false;
document.test.gotobutton.disabled=false;
document.test.printbutton.disabled=false;
document.test.bottombutton.disabled=false;

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
 print("window.open (\"table_button.php?gotocheck=$gotocheck&button_check=$button_check\",\"view\",\"toolbar=no,scrollbars=yes\")");
?>
}


function print_record()
{


    var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value);


   window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");

   }









</script>
<script language= javascript src= "all_jscript_function.js">  </script>

<body background= "wallpapers/ice.png" onload= "setattribute()">
<p align="center"><font size="5"><b><u><font color="blue">New Account Entry Form</font></u></b></font></p>
<p></p><br><br>
<form name= "test" onsubmit = "return form_validator(this)" onreset = "add_edit_press()" method=post action="account_add_insert_experiment.php" > <b>

<p>
<table>
<tr>
<td><b>Enter Account's Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="accountname" value ="<?php echo $row[2]  ?>" size="50" onchange = "document.test.accountname.value=capfirst(document.test.accountname.value)"></td>
</tr>
</p>
<p>
<tr>
<td><b>Office Address:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" name="officeaddress" value ="<?php echo $row[3]  ?>"  size="50" onchange = "document.test.officeaddress.value=capfirst(document.test.officeaddress.value)"></td>
</tr>
</p>
<p>
<tr>
<td><b>Home Address:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" name="homeaddress"  value ="<?php echo $row[4]  ?>" size="50" onchange = "document.test.homeaddress.value=capfirst(document.test.homeaddress.value)"></td>
</p>
</tr>
<p>
<tr>
<td><b>Office Phone Number:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="offphone" value ="<?php echo $row[5]  ?>" size="20"></td>
</p>
</tr>
<p>
<tr>
<td><b>Residence's Phone Number:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text"  name="resphone" value ="<?php echo $row[6]  ?>"  size="20"></td>
</p>
</tr>
<p>
<tr>
<td><b>Mobile Phone:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="mobilephone" value ="<?php echo $row[7]  ?>" size="20"></td>
</p>

</tr>
</table>


<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="accountid" value="<?php echo $accountid  ?>">
<INPUT TYPE="hidden" name="add_edit_duplicate" value="false">
<BR>

<div align="center"><?php button_print(); ?></div>

</form>
numrows("<?php echo $numrows ?>");
accountid("<?php echo $accountid ?>");
gotocheck("<?php echo $gotocheck ?>");
nameprompt("<?php echo $accountname ?> ");
</body>

</html>