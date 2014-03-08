<?php

// required variables

require("config.php");

$payamount .=".00";

?>



<html>
<head>

<script language = javascript>





function printstat()

{
 //eval("document.view_record."+buttonname+".value")= newvalue
        document.view_record.okbutton.style.background = "#FFFFFF";
        document.view_record.okbutton.style.border = 0;
        document.view_record.okbutton.value = "";
	document.view_record.exitbutton.style.background = "#FFFFFF";
        document.view_record.exitbutton.style.border = 0;
        document.view_record.exitbutton.value = "";
       // document.view_record.exitbutton.style.width = "0";
        document.view_record.exitbutton.style.hidden = true;
	document.view_record.filling.value = "viewcheck";
	document.view_record.gotocheck.value = Number(document.view_record.button_check.value)+1;
}


function set_main()
{       
	document.view_record.filling.value = "viewcheck";
	document.view_record.gotocheck.value = document.view_record.button_check.value;
<?php	
	print("opener.location=\"http://riverine.org/payment_add1.php?filling=gotobutton&radiotest=$radiotest&purchase=$radiotest&gotocheck=$gotocheck\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>
  <!--<img src="techno1.gif" width=28 height=50 border=0>
      -->

    <div align="right"><font size=+3><b>&nbsp;</b></font></div>
    <br>
    <div align="center"><h2>&nbsp;</h2></div>
</head>

<body> <form name = "view_record" action = "view_payment.php" method = "post">

<br><br><br><br>
<b>Sl. No.&nbsp;&nbsp;&nbsp;</b> <?php echo $payserial ?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;




<b>Date :&nbsp;&nbsp;&nbsp;</b>  <?php echo $voucherdate ?>







<br>
<br>
<br><br>

<b>Paid Tk.&nbsp;-&nbsp;&nbsp;&nbsp;</b>  <?php echo $payamount ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>In Word &nbsp;&nbsp;&nbsp;</b>  <?php echo $amountinword ?>
<br>
<br>
<b>To &nbsp;&nbsp;&nbsp;</b>  <?php echo $clientname ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:10.0pt;font-family:Arial"><b>Through&nbsp;&nbsp;&nbsp;</b>  </span> <?php echo $print_through ?>
<br>
<br>

<b>On Account Of&nbsp;&nbsp;&nbsp;</b>  <?php echo $shipcargo ?>
<br>
<br>

<?php

if($radiotest!="official")

{


print ("<b>For &nbsp;&nbsp;&nbsp;&nbsp;</b>  $materialone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@Tk &nbsp;&nbsp;&nbsp;</b>   $fairrate &nbsp;&nbsp;&nbsp;");

        if ($materialtwo=="********")
                {

                }
        else
                {

                echo ("<b>And</b>&nbsp;&nbsp;&nbsp;&nbsp;$materialtwo <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@Tk &nbsp;&nbsp;&nbsp;</b>   $fairratetwo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp");

                }

print("<br>");

print("<br>");


print("<b>From &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>  $fromlocation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> $tolocation");

}

?>

<br>
<br>

<b>Cash/Cheque No.&nbsp;&nbsp;&nbsp;</b>   <?php echo $chequeno ?>&nbsp;&nbsp;&nbsp;
<b>Bank&nbsp;&nbsp;&nbsp;</b>   <?php echo $bankname ?>&nbsp;&nbsp;&nbsp;
<b>Branch&nbsp;&nbsp;&nbsp;</b>   <?php echo $bankbranch ?>&nbsp;&nbsp;&nbsp;
<b>Date&nbsp;&nbsp;&nbsp;</b>   <?php echo $chequedate ?>



<br>
<br>

<span style="font-size:10.0pt;font-family:Arial"><b>Comment&nbsp;&nbsp;&nbsp;</b>  </span> <?php echo $print_comment ?>









<?php


if ($radiotest == "normal")
        {
                $query_string = "select * from view_payment_carrying ";
        }


if ($radiotest == "purchase")
        {
                $query_string = "select * from view_payment_purchase ";
        }


if ($radiotest == "official")
        {
                $query_string = "select * from view_payment_official ";
        }

?>





<INPUT TYPE="hidden" name="radiotest" value="<?php echo $radiotest  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="bankname" value="<?php echo $bankname  ?>" >
<INPUT TYPE="hidden" name="bankbranch" value="<?php echo $bankbranch  ?>" >
<INPUT TYPE="hidden" name="chequedate" value="<?php echo $chequedate  ?>" >
<INPUT TYPE="hidden" name="chequeno" value="<?php echo $chequeno  ?>" >
<INPUT TYPE="hidden" name="print_comment" value="<?php echo $print_comment ?>" >
<INPUT TYPE="hidden" name="print_through" value="<?php echo $print_through ?>" >






<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Ok" name="okbutton" style=" width: 84; height: 25" onclick= "printstat();javascript:window.print();setTimeout('window.close()',10000)">

</td>
    </tr>

    <tr>
    <td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Cancel" name="exitbutton" style=" width: 84; height: 25" onclick= "javascript:window.close()">

    </td>
        </tr>

  </table>
</form>






</body>
</html>
