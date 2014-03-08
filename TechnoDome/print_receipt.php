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
	        print("opener.location=\"http://riverine.org/money_receipt.php?filling=gotobutton&radiotest=$radiotest&purchase=$radiotest&gotocheck=$gotocheck\"; ");
        ?>

        window.close();
	        //window.open ("riverine.htm","account_add_insert_experiment.php","_main");
                //);
        }



</script>

  <div align="right"><font size=+3></font>

    <br>

   <font size=+3>  </font>

    <br>

   <font size=+3> </font>

    </div>

    <div align="center"><span style="font-size:14.5pt;font-family:Times New Roman"><b></b></span></div>

</head>

<body> <form name = "view_record" action = "view_payment.php" method = "post">



<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<b>Sl. No.&nbsp;&nbsp;&nbsp;</b> <?php echo $receiptserial ?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;




<b>Date :&nbsp;&nbsp;&nbsp;</b>  <?php echo $receivedate ?>



<br>
<br>
<br>
<br>

<span style="font-size:11.0pt;font-family:Arial"><b>Received With Thanks From</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>  <?php echo $clientname ?></font>
<br>

<br>

<span style="font-size:11.0pt;font-family:Arial"><b>Taka&nbsp;&nbsp;&nbsp;</b> </span> <?php echo $payamount ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>In Word &nbsp;&nbsp;&nbsp;</b></span>  <?php echo $amountinword ?>

<br>
<br>

<span style="font-size:11.0pt;font-family:Arial"><b>On Account Of&nbsp;&nbsp;&nbsp;</b> </span></span> <?php echo $shipcargo ?>
<br>
<br>



<span style="font-size:11.0pt;font-family:Arial"><b>For &nbsp;&nbsp;&nbsp;&nbsp;</b> </span> <?php echo $materialone ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@Tk &nbsp;&nbsp;&nbsp;</b></span>  <?php echo $fairrate ?>&nbsp;&nbsp;&nbsp;  <?php if ($materialtwo=="********"){ } else{ echo "<b>And</b>&nbsp;&nbsp;&nbsp;&nbsp;$materialtwo <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@Tk &nbsp;&nbsp;&nbsp;</b></span>   $fairratetwo &nbsp;&nbsp;&nbsp;";}  ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<br><br>
 <span style="font-size:11.0pt;font-family:Arial"><b>From &nbsp;&nbsp;&nbsp;</b></span> <?php echo $fromlocation ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>To &nbsp;&nbsp;&nbsp;</b> </span> <?php echo $tolocation ?>

<!--<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@Tk &nbsp;&nbsp;&nbsp;</b></span>  <?php echo $fairrate ?>&nbsp;&nbsp;&nbsp;-->

<br>
<br>


<span style="font-size:11.0pt;font-family:Arial"><b>Cash/Cheque No.&nbsp;&nbsp;&nbsp;</b> </span>  <?php echo $chequeno ?>&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>Bank&nbsp;&nbsp;&nbsp;</b>  </span> <?php echo $bankname ?>&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>Branch&nbsp;&nbsp;&nbsp;</b> </span>   <?php echo $bankbranch ?>&nbsp;&nbsp;&nbsp;
<span style="font-size:11.0pt;font-family:Arial"><b>Date&nbsp;&nbsp;&nbsp;</b>  </span> <?php echo $chequedate ?>

<br>
<br>

<span style="font-size:11.0pt;font-family:Arial"><b>Comment&nbsp;&nbsp;&nbsp;</b>  </span> <?php echo $print_comment ?>

<br>
<br>
<br>
<br>


<br>
<br>
<br>
<br>






<INPUT TYPE="hidden" name="radiotest" value="<?php echo $radiotest  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="voucherdate" value="<?php echo $voucherdate  ?>" >
<INPUT TYPE="hidden" name="receiptserial" value="<?php echo $receiptserial  ?>" >
<INPUT TYPE="hidden" name="bankname" value="<?php echo $bankname  ?>" >
<INPUT TYPE="hidden" name="bankbranch" value="<?php echo $bankbranch  ?>" >
<INPUT TYPE="hidden" name="chequedate" value="<?php echo $chequedate  ?>" >
<INPUT TYPE="hidden" name="chequeno" value="<?php echo $chequeno  ?>" >
<INPUT TYPE="hidden" name="receivedate" value="<?php echo $receivedate  ?>" >
<INPUT TYPE="hidden" name="print_comment" value="<?php echo $print_comment ?>" >




<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Ok" name="okbutton" style=" width: 84; height: 25" onclick= "printstat();javascript:window.print();setTimeout('window.close()',8000)">

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
