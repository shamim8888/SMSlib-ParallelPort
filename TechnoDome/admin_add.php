<?php

require("config.php");
//require("new_account_entry_form_experiment.php");


// grabs all product information
$result = pg_exec("select * from password order by account_id");

$numrows = pg_numrows($result);
//if ($numrows !=0)
//{
//        $row = pg_fetch_row($result,0);
//        $accountid = $row[0];
//}
//else
//{
//        $accountid = 0;
//}



//for store a number in $gotocheck for prev,next,goto...

// if ( is_integer($gotocheck)== 0)
//     {
//	$gotocheck = 1;
//     }



  //*******************  For TOP BUTTON         **********************

  if ($filling == "topbutton"){
  	$result = pg_exec("select * from password order by account_id");
  	$numrows=pg_numrows($result);
  	$row = pg_fetch_row($result,0);
  	$accountid = $row[0];
        $accounttype = $row[1];
  	$accountname = $row[2];
  	$officeaddress = $row[3];
  	$homeaddress = $row[4];
  	$offphone = $row[5];
  	$resphone = $row[6];
  	$mobilephone = $row[7];
  	}


  /******************** End OF TOP BUTTON  ***************************/

  /******************** FOR PREVIOUS BUTTON  **********************************/

  if ($filling == "prevrecord"){
  	$result = pg_exec("select * from password order by account_id");

  	$numrows = pg_numrows($result);
  	$numfields = pg_numfields($result);

  	$row = pg_fetch_row($result,$gotocheck-1);

        $accounttype = $row[1];
  	$accountname = $row[2];
  	$accountid = $row[0];
  	$officeaddress = $row[3];
  	$homeaddress = $row[4];
  	$offphone = $row[5];
  	$resphone = $row[6];
  	$mobilephone = $row[7];
  	}

  /**************************** END OF PREVIOUS BUTTON  *********************/


  /************************* FOR NEXT BUTTON ****************************/

  if ($filling == "nextrecord"){
  	$result = pg_exec("select * from password order by account_id");

  	$numrows=pg_numrows($result);

  	$row = pg_fetch_row($result,$gotocheck-1);
  	$accountid = $row[0];
        $accounttype = $row[1];
  	$accountname = $row[2];
  	$officeaddress = $row[3];
  	$homeaddress = $row[4];
  	$offphone = $row[5];
  	$resphone = $row[6];
  	$mobilephone = $row[7];
  	}

  /**************************** END OF NEXT BUTTON  *********************/




  /**************************** FOR BOTTOM BUTTON  *********************/

  if ($filling == "bottombutton"){
  	$result = pg_exec("select * from password order by account_id");
  	$numrows=pg_numrows($result);
  	$row = pg_fetch_row($result,($numrows-1));
  	$accountid = $row[0];
        $accounttype = $row[1];
  	$accountname = $row[2];
  	$officeaddress = $row[3];
  	$homeaddress = $row[4];
  	$offphone = $row[5];
  	$resphone = $row[6];
  	$mobilephone = $row[7];
  	}


  /**************************** FOR GOTO BUTTON  *********************/



  if ($filling == "gotobutton"){
  	$result = pg_exec("select * from password order by account_id");

  	$numrows=pg_numrows($result);

  	$row = pg_fetch_row($result,$gotocheck-1);


  	$accountname = $row[2];
  	$accountid = $row[0];
  	$officeaddress = $row[3];
  	$homeaddress = $row[4];
  	$offphone = $row[5];
  	$resphone = $row[6];
  	$mobilephone = $row[7];

  	}



  /*******************  For ADD BUTTON         **********************/


  if ($filling == "addbutton"){

  		$accountname = ltrim($accountname);

                  $dupresult= pg_exec($conn,"select * from password where (account_name='$accountname')");
                  $dupnumrows = pg_numrows($dupresult);
                  if ($dupnumrows !=0)
                          {
                                  //print("javascript:alert(\"Duplicate material Name\")");

                                  $add_edit_duplicate = 'true' ;
                                  $result = pg_exec("select * from password order by account_id");

                                  $numrows=pg_numrows($result);
                                  $numfields = pg_numfields($result);

                                  $row = pg_fetch_row($result,$gotocheck-1);
                                  $accountid = $row[0];

                                  $accountname = $row[2];
                                  $officeaddress = $row[3];
                                  $homeaddress = $row[4];
                                  $offphone = $row[5];
                                  $resphone = $row[6];
                                  $mobilephone = $row[7];



                          }
                   else
                          {
                              $add_edit_duplicate = 'false' ;




  		$result = pg_exec($conn,"insert into password (account_name,office_address,home_address,off_phone,res_phone,mobile_phone) values('$accountname','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

  		$result = pg_exec("select * from password order by account_id");
  	$numrows=pg_numrows($result);
  	$row = pg_fetch_row($result,($numrows-1));
          $accountid = $row[0];

          $accountname = $row[2];
          $officeaddress = $row[3];
          $homeaddress = $row[4];
          $offphone = $row[5];
          $resphone = $row[6];
          $mobilephone = $row[7];

          $gotocheck = $numrows;

       }
  }



  /**************************** FOR EDIT BUTTON  *********************/


  if ($filling == "editbutton"){


  	$result = pg_exec("select * from password order by account_id");

  	$numrows=pg_numrows($result);
          $accountname = ltrim($accountname);
          print("start\n");
          $dupresult= pg_exec($conn,"select * from password where (account_name='$accountname')");
          $dupnumrows = pg_numrows($dupresult);
      /*    if ($dupnumrows !=0)
                  {
                          //print("javascript:alert(\"Duplicate material Name\")");

                          $add_edit_duplicate = 'true' ;
                          $result = pg_exec("select * from password order by account_id");

                          $numrows=pg_numrows($result);
                          $numfields = pg_numfields($result);

                          $row = pg_fetch_row($result,$gotocheck-1);
                          $accountid = $row[0];

                          $accountname = ltrim(trim($row[2]));
                          $officeaddress = $row[3];
                          $homeaddress = $row[4];
                          $offphone = $row[5];
                          $resphone = $row[6];
                          $mobilephone = $row[7];



                  }
           else
                  {
                      $add_edit_duplicate = 'false' ;       */

                      print("Add start");
                      $firstch = chr(rand(60,122));
                      $secondch = chr(rand(60,127));
                      $salt .= $firstch; $salt .= $secondch;
                      echo "$firstch  ab  $secondch  bnm  $salt";
                      $enpassword = crypt($password);
  	$result = pg_exec($conn,"DELETE FROM password WHERE (account_id = '$accountid');INSERT INTO password (account_id,account_type,account_name,office_address,home_address,off_phone,res_phone,mobile_phone,username,password,userlevel) VALUES('$accountid','$accounttype','$accountname','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone','$username','$enpassword','$userlevel')");


  	$result = pg_exec("select * from password order by account_id");

  	$numrows=pg_numrows($result);



  	$row = pg_fetch_row($result,$gotocheck-1);
  	$accountid = $row[0];

  	$accountname =  ltrim(trim($row[2]));
  	$username =  ltrim(trim($row[8]));





        // }

  }



  /**************************** FOR DELETE BUTTON  *********************/

  if ($filling == "deletebutton"){
  		//$accountid=63;
  		$result = pg_exec("select * from password order by account_id");

  		$numrows=pg_numrows($result);

  		//$conn = pg_connect("host=$host dbname=$database user=$user" );
  		$result = pg_exec($conn,"DELETE  FROM password WHERE (account_id = '$accountid')");



  		$result = pg_exec("select * from password order by account_id");

  		$numrows=pg_numrows($result);

  		if ($gotocheck < $numrows)  {
          		//$gotocheck = ($gotocheck+1);

  			}
  		else
  			{$gotocheck = ($gotocheck-1);
  			}

  	$row = pg_fetch_row($result,$gotocheck-1);
  	$accountid = $row[0];
  	$accountname = $row[2];








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
document.test.accounttype.disabled=true;
document.test.accountname.disabled=true;
document.test.username.disabled=true;
document.test.password.disabled=true;
document.test.confirm_password.disabled=true;
document.test.userlevel.disabled=true;

document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;

document.test.addbutton.disabled=true;
document.test.deletebutton.disabled=true;
document.test.printbutton.disabled=true;

window.status = document.test.gotocheck.value+"/"+<?php echo $numrows ?>;
}


function form_validator(theForm)
{

	if(theForm.username.value == "") {
                theForm.username.select();
		 alert("User Name Is Empty...Please Enter A UserName");

		 return(false);
	}
        if(theForm.password.value == "") {
                theForm.password.select();
        	 alert("Password Is Empty...Please Enter Password");

        	 return(false);
        }





        	if(theForm.password.value != theForm.confirm_password.value ) {
                        theForm.password.select();
        		 alert("Password Not Match!!!");

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

document.test.accounttype.disabled=false;
document.test.accountname.disabled=false;
document.test.password.disabled=false;
document.test.username.disabled=false;
document.test.username.select();
document.test.confirm_password.disabled=false;
document.test.userlevel.disabled=false;

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
document.test.accounttype.disabled=true;
document.test.accountname.disabled=true;
document.test.username.disabled=true;
document.test.password.disabled=true;
document.test.confirm_password.disabled=true;
document.test.userlevel.disabled=true;


document.test.addbutton.disabled=true;
document.test.editbutton.disabled=false;
document.test.viewbutton.disabled=false;
document.test.savebutton.disabled=true;
document.test.cancelbutton.disabled=true;
document.test.deletebutton.disabled=false;
document.test.prevrecord.disabled=false;
document.test.nextrecord.disabled=false;
document.test.topbutton.disabled=false;
document.test.gotobutton.disabled=false;
document.test.printbutton.disabled=true;
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
 print("window.open (\"admin_view.php?gotocheck=$gotocheck&button_check=$button_check\",\"view\",\"toolbar=no,scrollbars=yes\")");
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
<p align="center"><font size="5"><b><u><font color="red">WARNING!</font></u></b></font></p>
<p align="center"><font size="5"><b><u><font color="blue">User Password Entry Form</font></u></b></font></p>

<form name= "test" onsubmit = "return form_validator(this)" onreset = "add_edit_press()" method=post action="admin_add.php" > <b>


<div align="center"><table border="4">
<p>
<tr>
<td><b><font color="blue">Type Of Account :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
<td>
 <input type="text" name="accounttype" value ="<?php echo $row[1]  ?>" size="15" readonly >
<!--
<select size="1" tabindex="1" name="accounttype" readonly>
    <option value="<?php echo $row[1] ?>" selected><?php echo $row[1]  ?></option>
    <option value="Client" >Client</option>
    <option value="Official" >Official</option>
    <option value="Shipowner" >Shipowner</option>


    </select>
    -->
</td>

</tr>
</p>

<p>
<tr>
<td><b>Account's Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="accountname" value ="<?php echo $row[2]  ?>" size="50" readonly onchange = "document.test.accountname.value=capfirst(document.test.accountname.value)"></td>
</tr>
</p>
<p>


<tr>
<td><b>User Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="username" value ="<?php echo $row[8]  ?>" size="20"></td>
</p>

</tr>

<tr>
<td><b>User Password:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="password" name="password" value ="<?php echo $row[9]  ?>" size="20"></td>
</p>

</tr>


<tr>
<td><b>Confirm Password:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="password" name="confirm_password" value ="<?php echo $row[9]  ?>" size="20"></td>
</p>

</tr>

<tr>
<td><b>User Level:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><select size="1" name="userlevel">
<option value="<?php echo $row[10]  ?>" selected><?php echo $row[10]  ?></option>
<option value="Administrator" >Administrator</option>
<option value="Client" >Client</option>
<option value="User" >User</option>
<option value="Visitor" >Visitor</option>
</td>
</p>

</tr>


</table></div>


<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="accountid" value="<?php echo $accountid  ?>">
<INPUT TYPE="hidden" name="add_edit_duplicate" value="false">
<BR>

<div align="center"><?php button_print(); ?></div>

</form>


    <!--numrows("<?php echo $numrows ?>");
        accountid("<?php echo $accountid ?>");
        gotocheck("<?php echo $gotocheck ?>");
        nameprompt("<?php echo $accountname ?> ");
        accounttype("<?php echo $row[1] ?>");
        -->


</body>

</html>
