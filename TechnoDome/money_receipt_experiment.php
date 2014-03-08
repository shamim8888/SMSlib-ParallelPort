<?php         //Start of php

        require("config.php");

        $savecancel = "true";
        $setat ="false";


        // grabs all product information
        $result = pg_exec("select * from money_carrying_view");
        $numrows = pg_numrows($result);
        //$row = pg_fetch_row($result,0);

        $visitcarry = 0;
        $visitsale = 0;

        $tripid = $row[17];
        $radiotest = "normal";

        if ($numrows==0)
                {
                        $row[0]=0;
                 //       $row[1]="";
                        $mreceiptid = 0;

                }

        else
                {
                        $row = pg_fetch_row($result,0);


                        $mreceiptid = $row[0];
                        $mreceiptserialno = $row[2];
                        $mreceiptdate = $row[1];
                        $accountname = $row[21];
                        $nameofship = $row[22];
                        $fromlocname = $row[23];
                        $tolocname = $row[24];
                        $materialonename = $row[25];
                        $materialtwoname = $row[26];
                        $comment = $row[27];

                        $clientname = $row[3];
                        $shipname = $row[4];
                        $fromloc = $row[5];
                        $toloc = $row[6];
                        $matone = $row[7];
                        $mattwo = $row[8];
                        $receivetkrate =$row[9];
                        $payamount = $row[10];
                        $paytype = $row[12];
                        $chequeno = $row[13];
                        $bankname = $row[14];
                        $bankbranch = $row[15];
                        $chequereceivedate = $row[16];

                        $receivelocation = $row[17];
                        $tripid = $row[18];
                        $departuredate = $row[19];


                }



        //for store a number in $gotocheck for prev,next,goto...

        if ( is_integer($gotocheck)== 0)
                {
	                $gotocheck = 1;
                }

        //End of first php tag
?>


<html>
<head>

<title>Money Receipt</title>
<base target="_self">

</head>

<script language= javascript 1.5>

var numrows=<?php echo $numrows ?>;

var gotocheck= <?php echo $gotocheck ?>;


function set_attribute()
        {   //Starting setattribute function

                if (document.test.mreceiptid.value ==0)
                        {
                                button_option("norecord");

                        }

                else
                        {
                                button_option("normal");
                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);
                        }

                document.test.clientname.disabled=true;
                document.test.shipname.disabled=true;
                document.test.mreceiptserialno.disabled=true;
                document.test.receivelocation.disabled=true;
                document.test.payamount.disabled=true;
                document.test.amountinword.disabled=true;
                document.test.matone.disabled=true;
                document.test.mattwo.disabled=true;
                document.test.fromloc.disabled=true;
                document.test.toloc.disabled=true;
                document.test.receivetkrate.disabled=true;
                document.test.paytype.disabled=true;
                document.test.chequeno.disabled=true;
                document.test.bankname.disabled=true;
                document.test.bankbranch.disabled=true;
                document.test.chequereceivedate.disabled=true;
                document.test.departuredate.disabled=true;
                document.test.receivedate.disabled=true;
                document.test.comment.disabled=true;







        }   // End of setattribute function




function add_edit_press(endis)
        {     //Starting add_edit function
               // document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                if (endis=='addedit')
                        {
                                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******

                                document.test.purchase[0].disabled=true;
                                document.test.purchase[1].disabled=true;

                                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******



                                document.test.clientname.disabled=false;
                                document.test.shipname.disabled=false;
                                document.test.mreceiptserialno.disabled=false;
                                document.test.receivelocation.disabled=false;
                                document.test.payamount.disabled=false;
                                document.test.amountinword.disabled=true;
                                document.test.matone.disabled=false;
                                document.test.mattwo.disabled=false;
                                document.test.fromloc.disabled=false;
                                document.test.toloc.disabled=false;
                                document.test.receivetkrate.disabled=false;
                                document.test.paytype.disabled=false;
                                document.test.chequeno.disabled=false;
                                document.test.bankname.disabled=false;
                                document.test.bankbranch.disabled=false;
                                document.test.chequereceivedate.disabled=false;
                                document.test.departuredate.disabled=false;
                                document.test.receivedate.disabled=false;
                                document.test.comment.disabled=false;

                                button_option("pressed");

                                if (document.test.payamount.value != 0)
                                {
                                        document.test.amountinword.value=moneyconvert(document.test.payamount.value);
                                }


                        }
                else
	                {
                                document.test.clientname.disabled=true;
                                document.test.shipname.disabled=true;
                                document.test.mreceiptserialno.disabled=true;
                                document.test.receivelocation.disabled=true;
                                document.test.payamount.disabled=true;
                                document.test.amountinword.disabled=true;
                                document.test.matone.disabled=true;
                                document.test.mattwo.disabled=true;
                                document.test.fromloc.disabled=true;
                                document.test.toloc.disabled=true;
                                document.test.receivetkrate.disabled=true;
                                document.test.paytype.disabled=true;
                                document.test.chequeno.disabled=true;
                                document.test.bankname.disabled=true;
                                document.test.bankbranch.disabled=true;
                                document.test.chequereceivedate.disabled=true;
                                document.test.departuredate.disabled=true;
                                document.test.receivedate.disabled=true;
                                document.test.comment.disabled=true;

                                if (document.test.mreceiptid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");

                                        }









                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******

                                document.test.purchase[0].disabled=false;
                                document.test.purchase[1].disabled=false;

                                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******

                        }

        }  // End of add_edit function





function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_money_carry.php?gotocheck=$gotocheck&radiotest=$radiotest&button_check=$button_check\",\"view\",\"toolbar=no,scrollbars=yes\")");
                ?>
        }




function shipsel()
        {
                //document.test.shipselect.value = "true";
	        document.test.setat.value = "true";
                //      document.test.clientselect.value = "true";
                document.test.savecancel.value = "false";
                document.test.comment.value = document.test.savecancel.value;
                //document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                //	document.test.submit();
        }




function view_cargo()
        {
                document.test.shipcargo.value=document.test.shipname.value;
                alert( document.test.shipcargo.value)

                var abc = "view_money_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&paidtaka="+document.test.payamount.value+"&mreceiptid="+document.test.mreceiptid.value;

                alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }



        function form_validator(theForm)
                {

                         if(theForm.clientname.selectedIndex == -1)
                                 {
                                 	 alert("Please Select A Clientname");
                         		 theForm.clientname.focus();
                         		 return(false);
                         	 }

                        if ( capfirst(theForm.clientname.options[theForm.clientname.selectedIndex].text) == "" )
                                {
                                       alert("<?php echo $txt_missing_accountname ?>");
                                       theForm.clientname.focus();
                                       return(false);
                                }

                        if(theForm.mreceiptserialno.value == "" || theForm.mreceiptserialno.value == 0 )
                                {
                	                alert("<?php echo $txt_missing_payserial ?>");
                                        theForm.mreceiptserialno.select();
                	                theForm.mreceiptserialno.focus();
                	                return(false);
                                }

                        if(theForm.receivedate.value == "")
                                {
                	                alert("<?php echo $txt_missing_receivedate ?>");
                                        theForm.receivedate.select();
                	                theForm.receivedate.focus();
                	                return(false);
                                }

                         if(theForm.payamount.value == 0)
                                 {
                                        alert("<?php echo $txt_missing_payamount ?>");
                                         theForm.payamount.select();
                                        theForm.payamount.focus();
                                        return(false);
                                 }

                         if (theForm.matone.options[theForm.matone.selectedIndex].text == "")
                                 {
                                        alert("Please select First Material");
                                        theForm.matone.options[0].select();
                                        theForm.matone.focus();
                                        return(false);
                                 }

                         if (theForm.mattwo.options[theForm.mattwo.selectedIndex].text == "")
                                 {
                                         alert("Please select second Material...If there is only one material then choose -NONE-");
                                         theForm.matone.focus();
                                         return(false);
                                 }


                         if (capfirst(theForm.matone.options[theForm.matone.selectedIndex].text) == capfirst(theForm.mattwo.options[theForm.mattwo.selectedIndex].text))
                                 {
                                        alert("Sorry! Material One And Material Two Can Not Be The Same");
                                        theForm.mattwo.options[5].select();
                                        theForm.mattwo.focus();
                                        return(false);
                                 }


                         if(theForm.fromloc.options[theForm.fromloc.selectedIndex].text == "")
                                 {
                                        alert("<?php echo $txt_missing_fromlocname ?>");
                                        theForm.fromloc.focus();
                                        return(false);
                                 }

                         if(theForm.toloc.options[theForm.toloc.selectedIndex].text == "")
                                 {
                                        alert("<?php echo $txt_missing_tolocname ?>");
                                        theForm.toloc.focus();
                                        return(false);
                                 }

                         if (theForm.receivetkrate.value == 0)
                                 {
                                        alert("<?php echo $txt_missing_takarate ?>");
                                        theForm.receivetkrate.select();
                                        theForm.receivetkrate.focus();
                                        return(false);
                                 }

                        if (theForm.paytype.options[theForm.paytype.selectedIndex].text == "Cheque")
                                {
                                        alert("we are in paytype condition cheque");
                                        alert(theForm.chequeno.value);

                                        if( document.test.chequeno.value == "")
                                                {
                                                        alert("we are in chequeno");
                                                        alert("<?php echo $txt_missing_chequeno ?>");
                                                        theForm.chequeno.focus();
                                                        return(false);
                                                }

                                        if(theForm.bankname.value == "")
                                                {
                                                        alert("<?php echo $txt_missing_bankname ?>");
                                                        theForm.bankname.select();
                                                        theForm.bankname.focus();
                                                        return(false);
                                                }

                                        if(theForm.bankbranch.value == "")
                                                {
                                                        alert("<?php echo $txt_missing_bankbranch ?>");
                                                        theForm.bankbranch.select();
                                                        theForm.bankbranch.focus();
                                                        return(false);
                                                }


                                        if(theForm.chequereceivedate.value == "")
                                                {

                                                        alert("<?php echo $txt_missing_chequedate ?>");
                                                        theForm.chequereceivedate.select();
                                                        theForm.chequereceivedate.focus();
                                                        return(false);
                                                }



                                }


        	        return (true);

                }






function normal (whatever)
        {     //start of normal function

                if (whatever=='nor')
                        {
                                document.test.radiotest.value = "carrying" ;
                        }

                if (whatever=='pur')
                        {
                                document.test.radiotest.value = "sale" ;
                        }

        }    //End of normal function



</script>

<script language = javascript src="all_jscript_function.js"></script>

<script language = javascript src="date_picker.js"></script>


<body bgcolor= "#9FC4C2" onload= "set_attribute()">

<form name= "test" onsubmit = "return form_validator(this)"  onreset = "add_edit_press()" method= post action="money_add_insert.php">

<div align="center"><font size="5"><b><font color="blue"><u>Money Receipt</u></b></font></font></div>

<TABLE width="100%"border="1">
<TR>
<TD width="">


<font color="darkRed"><b><input type = "radio" name = "purchase" value = "normal" checked onclick= "normal('nor');document.test.submit()">&nbsp;&nbsp; Carrying
<input type = "radio" name = "purchase" value = "sale" onclick= "normal('pur');document.test.submit()">&nbsp;&nbsp;Sale </b></font></TD>
<TD width="30%"><b>Serial.No:</b><input type="text" name="mreceiptserialno" value="<?php echo $mreceiptserialno?>" size = 9 align="center"  ></TD>
</TR></TABLE>

<TABLE width="100%" border="2">
 <TR>
 <TD width="">
<B>
Received  From:</B></td>

<TD width="">
<select size="1" name="clientname"> <!--onchange="shipsel()"
                                        -->
  <option  value="<?php echo $clientname ?>"  selected><?php echo $accountname ?> </option>

<?php  //start php for client


// grabs all product information ////
$result = pg_exec("select account_id,account_name from accounts where account_type='Client' order by account_name");
$clientnumrows=pg_numrows($result);

 for($i=0;$i<$clientnumrows;$i++){
	$clientrow = pg_fetch_row($result,$i);

	print("<option value = \"$clientrow[0]\" >$clientrow[1]</option>\n");
	}

?>  ///End php for client

</select>
</TD>
<TD width="">

<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  -->
<B> Date:</B></TD><TD width=""><input type=text name="receivedate" value="<?php echo $mreceiptdate?>" size=15 readonly><a href="javascript:show_calendar('test.receivedate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
  </TD>
  </TR>
</TABLE>

<TABLE border="1" width="100%">
<TR>

<TD width=""><B>Taka:</B></td>
<TD width=""><input type="text" name="payamount" value ="<?php echo $payamount ?>" size="8" onchange= "document.test.amountinword.value=moneyconvert(document.test.payamount.value)" >

</TD>

<TD width=""> <B>In word</B> <font face="Times New Roman"></td>
<TD width="">
<textarea rows="2" name="amountinword" cols="52"></textarea></font>
 </TD>
 </TR>
 </TABLE>
<TABLE width="624"border="1">
 <TR>

  <TD width="90"><B>On Account</B> </td>

<TD width="123"><select size="1" name="shipname" onchange="view_cargo()">
 <option value="<?php echo $shipname ?>" selected><?php echo $nameofship ?> </option>

<?php


// grabs all product information
$result = pg_exec("select ship_id,ship_name from ship order by ship_name");
$num_ship = pg_numrows($result);

 for($i=0;$i<$num_ship;$i++){
	$row_ship = pg_fetch_row($result,$i);

	print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
	}

?>


  </select>  </TD>
<TD width="106"><B>For</B></TD>
<TD width="261"><select size="1" name="matone">

<option value="<?php echo $matone?>" selected><?php echo $materialonename ?></option>

    <?php

// grabs all product information
$result = pg_exec("select matone_id,matone_name from materialone order by matone_name");
$num_mat = pg_numrows($result);

 for($i=0;$i<$num_mat;$i++){
	$row_mat = pg_fetch_row($result,$i);

	print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");
	}

?>
  </select>
<select size="1" name="mattwo">
 <option value ="<?php echo $mattwo?>" selected><?php echo $materialtwoname?></option>
    <?php


// grabs all product information
$result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");
$num_mat2 = pg_numrows($result);

 for($i=0;$i<$num_mat2;$i++){
	$row_mat2 = pg_fetch_row($result,$i);

	print("<option value = \"$row_mat2[0]\" >$row_mat2[1]</option>\n");
	}

?>
  </select>
</TD> </TR>

</TABLE>


<TABLE width="649" border="1">
<TR>
<TD width="83"><B>From</B></TD>
<TD width="115">  <select size="1" name="fromloc"> <option value="<?php echo $fromloc?>" selected> <?php echo $fromlocname ?> </option>
    <?php


// grabs all product information
$result = pg_exec("select from_id,from_loc from locationfrom order by from_loc");
$num_fromloc = pg_numrows($result);

 for($i=0;$i<$num_fromloc;$i++){
	$row_fromloc = pg_fetch_row($result,$i);

	print("<option value = \"$row_fromloc[0]\" >$row_fromloc[1]</option>\n");
	}

?>
  </select>   </td>
  <TD width="98">
 <B> To</B> </TD>
<TD width="114">   <select size="1" name="toloc"><option value="<?php echo $toloc?>"><?php echo $tolocname?></option>

<?php


// grabs all product information
$result = pg_exec("select to_id,to_loc from locationto order by to_loc");
$num_toloc = pg_numrows($result);

 for($i=0;$i<$num_toloc;$i++){
	$row_toloc = pg_fetch_row($result,$i);

	print("<option value = \"$row_toloc[0]\" >$row_toloc[1]</option>\n");
	}

?>
  </select></td>
  <TD width="53"><B>@ Tk.</B></td>

<TD width="87"><input type="text" name="receivetkrate" value ="<?php echo $receivetkrate?>"size="11">

</td>
</tr>
</table>

<TABLE border="1"width="691">
<TR>
 <TD width="94"><B>Receive Mode:</B></TD>
 <TD width="122"> <select size="1" name="paytype">
    <option value="<?php echo $row[11] ?>" selected><?php echo $row[11]?></option>
    <option>Cash</option>
    <option>Cheque</option>

  </select>

  </TD>

<TD width="113"> <B>  Cheque No.</B></TD>

<TD width="136"><input type="text" name="chequeno" value="<?php echo $chequeno ?>"size="18"> </TD>
<TD width="37"> <B> Bank </B></TD>

<TD width="">
<input type="text" name="bankname" value="<?php echo $bankname?>"size="20"></td>
</TR> </TABLE>

<TABLE width="636" border=1>
<TR>
<TD width="94"><B> Branch</B></TD>
<TD width="122"> <input type="text" name="bankbranch" value="<?php echo $bankbranch?>"size="16"></TD>
<TD width="114"><B> Date</B></TD>
<TD width="278"> <input type="text" name="chequereceivedate" value="<?php echo $chequereceivedate?>" size="16"><a href="javascript:show_calendar('test.chequereceivedate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
</TD>
</TR>
</TABLE>

<TABLE width="586"border=1>
<TR>
<TD width="94"><B>Pay Location:</B></td>
<TD width="122"><input type="text" name="receivelocation" value="<?php echo $receivelocation?>"size=15>
 </TD>
<TD width="115"><B>Departure Date:</B></TD>
<TD width="227"><input type=text  name="departuredate" value="<?php echo $departuredate?>"size=10></select>
</TD></TR></TABLE>
<B>Comment:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text value="<?php echo $comment?>"name="comment" size="70">





<INPUT TYPE="hidden" name = "radiotest" value ="<?php echo $radiotest ?>">
<INPUT TYPE="hidden" name="filling" value="<?php echo $filling ?>">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="mreceiptid" value="<?php echo $mreceiptid  ?>">
<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid  ?>">
<INPUT TYPE="hidden" name ="shipcargo" value="<?php echo $shipcargo ?>">
<INPUT TYPE="hidden" name="savecancel" value="<?php echo $savecancel ?>">
<INPUT TYPE="hidden" name="setat" value="<?php echo $setat  ?>" >
<INPUT TYPE="hidden" name="add_edit_duplicate" value="false">


<div align="center"><?php button_print(); ?> </div>

 
</form>

<!--numrows("<?php echo $numrows ?>");
        moneyreceiptid("<?php echo $moneyreceiptid ?>");
        gotocheck("<?php echo $gotocheck ?>");
        nameprompt("<?php echo $shipname ?> ");
       savecancel("<?php echo $savecancel ?>");
    -->

    </body>

</html>
