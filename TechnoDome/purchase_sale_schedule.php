<?php

        require ("config.php");

        // grabs all product information
        $result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
        $numrows = pg_numrows($result);


        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $pursalescheduleid = 0;
                                        $voucherdate = "";
                                }
                        else
                                {

                                        $row = pg_fetch_row($result,0);
                                        $pursalescheduleid = $row[0];
                                        $tripid = $row[15];
                                        $voucherid =$row[17];
                                        $payvoucherdate = $row[23];

                                }


                        if ( is_integer($gotocheck)== 0)
                                {
                                        $gotocheck = 1;
                                }



                }




        		/********************Navigation start***************************/
        			/***********************************************************/


		if ($navigation == "true")
    		{
        		//*******************  For TOP BUTTON         **********************

        		if ($filling == "topbutton")
                	{
	                	$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                	$numrows=pg_numrows($result);
	                	$row = pg_fetch_row($result,0);                  
                	}

        		/******************** FOR PREVIOUS BUTTON  **********************************/

        		if ($filling == "prevrecord")
                	{
	                	$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                	$numrows = pg_numrows($result);
                		$row = pg_fetch_row($result,$gotocheck-1); 
	        		}

		        /************************* FOR NEXT BUTTON ****************************/

        		if ($filling == "nextrecord")
                	{
	                	$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                	$numrows=pg_numrows($result);
	                	$row = pg_fetch_row($result,$gotocheck-1);
         			}

        		/**************************** FOR BOTTOM BUTTON  *********************/

        		if ($filling == "bottombutton")
                	{
	                	$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                	$numrows=pg_numrows($result);
	                	$numfields = pg_numfields($result);
	                	$row = pg_fetch_row($result,($numrows-1));
                 	}


        		/**************************** FOR GOTO BUTTON  *********************/

        		if ($filling == "gotobutton")
                	{
	                	$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                	$numrows=pg_numrows($result);
	                	$numfields = pg_numfields($result);
	                	$row = pg_fetch_row($result,$gotocheck-1); 
	        		}


        		/**************************** FOR DELETE BUTTON  *********************/

        		if ($filling == "deletebutton")
                	{
		        		//$scheduleid=63;
		        		$result = pg_exec("select * from purchase_sale_schedule order by pur_sale_schedule_id");

		        		$numrows=pg_numrows($result);

		        		//$conn = pg_connect("host=$host dbname=$database user=$user" );
		        		$result = pg_exec($conn,"DELETE  FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$pursalescheduleid')");

		        		$result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");

		        		$numrows=pg_numrows($result);

		        		if ($gotocheck < $numrows)
                            {
        		               //$gotocheck = ($gotocheck+1);

			        		}
		        		else
			        		{
                                        $gotocheck = ($gotocheck-1);
			        		}

	                	$row = pg_fetch_row($result,$gotocheck-1);
   
                	}
	
						
			$pursalescheduleid = $row[0];

                        $shipname = $row[19];
                        $ownername = $row[13];
                        $fromloc = $row[14];
                        $toloc = $row[15];
                        $matone = $row[16];
                        $mattwo = $row[17];
                        $goodquantityone = $row[7];
                        $goodquantitytwo = $row[8];
                        $payvoucherdate = $row[16];
						$fairrate = $row[9];
						$fairratetwo = $row[10];
                        $advancetk = $row[11];
                        $parttk = $row[12];
                        $totaltk = $row[22];
                        $balancetk = $row[21];
                        $voucherid = $row[18];
                        $tripid = $row[15];
                        $unloaddate = $row[11];
		
				
		} //end of navigation	
			

        /*******************  For EDIT BUTTON         **********************/


        if ($filling == "editbutton")
                {
                        //    $result =pg_exec($conn,"select * from purchase_sale_schedule order by pur_sale_schedule_id");
                        //    $numrows =pg_numrows($result);

                        $editresult = pg_exec("select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$pursalescheduleid')");

                        $editnumrows =pg_numrows($editresult);

                        $saved_fields = pg_fetch_row($editresult,0);

                        $payment_balance = $saved_fields[12];
                        $pay_fair_rate= $saved_fields[17];
                        $advance_receive = $saved_fields[20];
                        $part_receive = $saved_fields[21];
                        $total_receive = $saved_fields[22];
                        // $balance_receive = $saved_fields[23];





                        print("receive balance is$saved_fields[18] taka-------------");

                        print("\tpayment balance is$saved_fields[12] taka-------------");

                        if ($saved_fields[18]=="")
                                {

                                        $balance_receive = NULL;
                                        print("\nreceive balance When null, enter here");

                                }

                        else
                                {

                                        $balance_receive=$saved_fields[18];
                                }




                        if ($saved_fields[12]=="")
                                {

                                        $payment_balance = NULL;
                                        print("\nPayment balance When null, enter here");

                                }

                        else
                                {

                                        $payment_balance=$saved_fields[12];
                                }






                        $money_fair_rate = $saved_fields[24];
                        $money_received_from = $saved_fields[26];
                        $money_received_date = $saved_fields[25];


                        // $accountname = ltrim($accountname);

                        

                                                        $total_receive = (abs($goodquantityone) *  abs($sale_fair_rate)) + (abs($goodquantitytwo)  *  abs($sale_fair_rate_two)) ;
                                                        $balance_receive = abs($total_receive) - (abs($advance_receive)+abs($part_receive));

                                                        if($unloaddate=="")
                                                                {

                                                                        $result = pg_exec($conn,"delete from purchase_sale_schedule where (pur_sale_schedule_id='$pursalescheduleid');insert into purchase_sale_schedule (pur_sale_schedule_id,ship_id,paidto_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,fair_rate_two,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,sale_fair_rate_two,received_from) values('$pursalescheduleid','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$fairratetwo','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from')");

                                                                }

                                                        else
                                                                {
																		print("...line no 241..");
                                                                        $result = pg_exec($conn,"delete from purchase_sale_schedule where (pur_sale_schedule_id='$pursalescheduleid');insert into purchase_sale_schedule (pur_sale_schedule_id,ship_id,paidto_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,fair_rate_two,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,sale_fair_rate_two,mreceipt_date,received_from) values('$pursalescheduleid','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$fairratetwo','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from')");
                                                                }


           


                   






                        // $result = pg_exec($conn,"delete from purchase_sale_schedule where (pur_sale_schedule_id='$scheduleid');insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,quantity_one,mat_two,quantity_two,trip_id) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone','$goodquantityone','$mattwo','$goodquantitytwo','$tripid')");
		        $result = pg_exec("select * from pur_sale_schedule_view order by pur_sale_schedule_id");
	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,($gotocheck-1));

                        $pursalescheduleid = $row[0];

                        $shipname = $row[19];
                        $ownername = $row[13];
                        $fromloc = $row[14];
                        $toloc = $row[15];
                        $matone = $row[16];
                        $mattwo = $row[17];
                        $goodquantityone = $row[7];
                        $goodquantitytwo = $row[8];
                        $payvoucherdate = $row[23];
                        $advancetk = $row[10];
                        $parttk = $row[20];
                        $totaltk = $row[22];
                        $balancetk = $row[21];
                        $voucherid = $row[18];
                        $fairrate = $row[9];
						$fairratetwo = $row[10];
                        $tripid = $row[24];
                        $unloaddate = $row[11];

        }



        /**************************** END FOR EDIT BUTTON  *********************/





?>

<html>
<head>
  <title>Purchase & Sale Schedule</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">


</head>

<script language= javascript 1.5>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?>;

var gotocheck=<?php echo $gotocheck ?>;

function setattribute()
        {

				if (document.test.pursalescheduleid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");
                                        }
                document.test.goodquantityone.disabled=true;
                document.test.goodquantitytwo.disabled=true;
                document.test.fairrate.disabled=true;
				document.test.fairratetwo.disabled=true;

                
                
                document.test.savebutton.disabled=true;
                document.test.cancelbutton.disabled=true;
                document.test.addbutton.disabled=true;
                document.test.deletebutton.disabled=true;


                window.status = document.test.gotocheck.value+"/"+ numrows

        }


function form_validator(theForm)
        {

            /*    if(theForm.departuredate.value == "")
                        {
     	                        alert("<?php echo $txt_missing_departuredate ?>");
                                theForm.departuredate.select();
     	                        theForm.departuredate.focus();
     	                        return(false);
                        }
              */

                 if(theForm.goodquantityone.value == 0)
                         {
                                 alert("Please Enter GoodOne Quantity");
                                 theForm.goodquantityone.select();
                                 theForm.goodquantityone.focus();
                                 return(false);
                         }


                 if(capfirst(theForm.mattwo.options[theForm.mattwo.selectedIndex].text) != "")
                         {

                                if(theForm.goodquantitytwo.value == 0)
                                        {
                                                alert("Please Enter GoodTwo Quantity");
                                                theForm.goodquantitytwo.select();
                                                theForm.goodquantitytwo.focus();
                                                return(false);
                                        }

                         }


		return (true);

        }









function add_edit_press(endis)
        {
                if (endis=='addedit')
                        {


                                document.test.goodquantityone.disabled=false;
                                document.test.goodquantitytwo.disabled=false;
                                
                                document.test.fairrate.disabled=false;
								document.test.fairratetwo.disabled=false;                                

                                document.test.advancetk.disabled=false;
                                document.test.parttk.disabled=false;
                                document.test.balancetk.disabled=false;
                                document.test.totaltk.disabled=false;

                                button_option("pressed");

                        }

                else
	                {

                                document.test.goodquantityone.disabled=true;
                                document.test.goodquantitytwo.disabled=true;
                                
                                document.test.fairrate.disabled=true;
								document.test.fairratetwo.disabled=false;
                                
                                document.test.advancetk.disabled=true;
                                document.test.parttk.disabled=true;
                                document.test.balancetk.disabled=true;
                                document.test.totaltk.disabled=true;

                                if (document.test.pursalescheduleid.value ==0)
                                        {
                                               button_option("norecord");
                                               document.test.addbutton.disabled=true;
                                        }
                                else
                                        {
                                               button_option("normal");
                                               document.test.addbutton.disabled=true;
                                               document.test.deletebutton.disabled=true;
                                        }


	                }


        }





function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_purchase_sale_schedule.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$pursalescheduleid\",\"view\",\"toolbar=no,scrollbars=yes\")")?>;
        }




function print_record()
        {

                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value);

                // var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&voucherdate="+document.test.voucherdate.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.clientname.value;

                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");

        }



</script>

<script language= javascript src= "all_jscript_function.js"> </script>

 <script language= javascript src= "date_picker.js"> </script>

<body onload="setattribute()" bgcolor="#064686"  >
<form name = "test" onsubmit = "return form_validator(this)" onreset="add_edit_press()"method = "post" action ="purchase_sale_schedule.php">
  <b><u><font size=+2 color="white"><div align="center">Purchase & Sale Schedule Form</div></font></u></b>
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
        for ($i=1990;$i<=2090;$i++)
                {

                        print("<option value=$i>$i</option>");
                }

?>

</select>  </TD></TR>
</TABLE>
</div> <br>


<table border =0>




<tr>
<td><B><font color="white">Cargo Vessel:</font></B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td> <select size=1 name="shipname">
<option value= "<?php echo $row[19] ?>" selected> <?php echo $row[1] ?> </option>


 </select>

 <td><B><font color="white">Owner's Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></font>
<td> <select size="1" name="ownername">
  <option value= "<?php echo $row[13] ?>" selected><?php echo $row[2] ?> </option>

</select>
</tr>

<tr>
<td><B><font color="white">From:</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <td> <select size="1" name="fromloc" >

   <option value ="<?php echo $row[14] ?>" selected> <?php echo $row[3]  ?> <option>

</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><font color="white"><B>To:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="toloc" >
   <option value ="<?php echo $row[15] ?>" selected> <?php echo $row[4] ?> <option>

</select>

</tr>


<tr><td><font color="white"><B>Name Of Good One:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="matone" >

 <option value ="<?php echo $row[16] ?>" selected> <?php echo $row[5] ?> <option>


</select>
<td><font color="white"><B>Quantity :</B></font><td><input type ="text" name = "goodquantityone" value="<?php echo $goodquantityone ?>"size = 10 onchange="document.test.totaltk.value=(Number(document.test.goodquantityone.value)+ Number(document.test.goodquantitytwo.value)) * (Number(document.test.fairrate.value)),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value))">
</tr>

<tr> <td><font color="white"><B>Name of Good two:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="mattwo">

  <option value ="<?php echo $row[17] ?>" selected> <?php echo $row[6] ?> <option>


</select>
<td><font color="white"><B>Quantity :</B></font><td><input type ="text" name = "goodquantitytwo" value="<?php echo $goodquantitytwo ?>"size = 10 onchange="document.test.totaltk.value=(Number(document.test.goodquantityone.value)+ Number(document.test.goodquantitytwo.value))*(Number(document.test.fairrate.value)),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value))"></tr>
  <tr><td><font color="white"><B> Rate:</B></font><td><input type ="text" name = "fairrate" value ="<?php echo $fairrate ?>"size = 10 readonly>
  <td><font color="white"><B>Fair Rate Two:</B></font><td><input type ="text" name = "fairratetwo" value ="<?php echo $fairratetwo?>"size = 10 readonly></tr>
  <tr><td><font color="white"><B>Advance:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="advancetk" value="<?php echo $advancetk?>"size = 15 readonly>
  <td><font color="white"><B>Part taka:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="parttk" value ="<?php echo $parttk?>"size = 10 readonly></tr>
  <tr><td><font color="white"><B>Total:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="totaltk" value ="<?php echo $totaltk?>"size = 10 readonly>
  <td><font color="white"><B>Balance:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="balancetk" value ="<?php echo $balancetk?>"size = 10 readonly></tr>


  <!--<tr><td><B>client's name:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <td><input type ="text" name = "clientname" size = 20 ></tr>
      -->

</table>
<br>
<br>
<div align="center"><?php button_print(); ?></div>



<INPUT TYPE="hidden" name="seenbefore" value="1">
<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="pursalescheduleid" value="<?php echo $pursalescheduleid  ?>">
<INPUT TYPE="hidden" name="visitnormal" value="<?php echo $visitnormal  ?>" >
<INPUT TYPE="hidden" name="visitpurchase" value="<?php echo $visitpurchase  ?>" >
<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid ?>">
<INPUT TYPE="hidden" name="voucherid" value="<?php echo $voucherid ?>">
<INPUT TYPE="hidden" name="payvoucherdate" value="<?php echo $payvoucherdate ?>">
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >


</form>
numrows("<?php echo $numrows ?>");
purscheduleid("<?php echo $pursalescheduleid ?>");
gotocheck("<?php echo $gotocheck ?>");
nameprompt("<?php echo $filling ?> ");
ship("<?php echo $shipname ?>");


mat1("<?php echo $matone ?> ");
mat2("<?php echo $mattwo ?>");
from("<?php echo $row[14] ?>");
toloc("<?php echo $toloc ?>");
total("<?php echo $totaltk ?> ");
balance("<?php echo $balancetk ?>");
part("<?php echo $parttk ?>");
advance("<?php echo $advancetk ?>");
qun1("<?php echo $goodquantityone ?> ");
qun2("<?php echo $row[8] ?>");
voudte("<?php echo $goodquantitytwo ?>");

</body>
</html>
