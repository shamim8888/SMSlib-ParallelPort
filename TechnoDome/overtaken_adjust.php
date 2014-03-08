<?php
                // required variables
        require("config.php");


        if ($seenbefore==1)
                {


                        if($filling == "adjust")
                                {
                                        echo 'we are in adjust position' ;

                                                /*******************  For EDIT BUTTON         **********************/

                                        $change = 0;
                                        for ($i=0;$i<2;$i++)
                                                {

                                                        if ($change==0)
                                                                {
                                                                        $editresult = pg_exec("select * FROM cargo_schedule WHERE (schedule_id = '$mainscheduleid')");
                                                                }
                                                        else
                                                                {
                                                                        $editresult = pg_exec("select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");
                                                                }
                                                                        $editnumrows =pg_numrows($editresult);

                                                                        $saved_fields = pg_fetch_row($editresult,0);

                                                                        $scheduleid_q  = $saved_fields[0];
                                                                        $departuredate = $saved_fields[1];

                                                                        $ownername =  $saved_fields[3];
                                                                        $fromloc = $saved_fields[4];
                                                                        $toloc = $saved_fields[5];
                                                                        $matone = $saved_fields[6];
                                                                        $mattwo = $saved_fields[7];
                                                                        $goodquantityone = $saved_fields[8];
                                                                        $goodquantitytwo = $saved_fields[9];
                                                                        $payvoucherdate= $saved_fields[10];
                                                                        $advance_tk =  $saved_fields[11];
                                                                        $part_tk =  $saved_fields[12];
                                                                        $pay_location =  $saved_fields[13];
                                                                        $total_tk =  $saved_fields[14];
                                                                        $payment_balance = $saved_fields[15];
                                                                        $balance_tk =  $saved_fields[15];
                                                                        $voucherid =  $saved_fields[16];
                                                                        $pay_fair_rate= $saved_fields[17];

                                                                        $pay_fair_rate_two= $saved_fields[27];
                                                                        $advance_receive = $saved_fields[20];
                                                                        $part_receive = $saved_fields[21];
                                                                        $total_receive = $saved_fields[22];







                                                                        //$overtakenreceive =  $saved_fields[32];
                                                                        // $balance_receive = $saved_fields[23];








                                                                        $fairrate =  $saved_fields[17];
                                                                        $fairratetwo =  $saved_fields[27];
                                                                        $money_fairrate = $saved_fields[24];
                                                                        $money_fairrate_two = $saved_fields[28];

                                                                        $shipname = $shipid;
                                                                        $damerage =  $saved_fields[33];

                                                                        $overtakenadjustto =  $saved_fields[30];

                                                                        if ($change==1)
                                                                                {

                                                                                        $overtakenadjustfrom =  $mainscheduleid;
                                                                                        $overtaken_receive = $mainovertaken;
                                                                                }
                                                                        else
                                                                                {
                                                                                        $overtakenadjustto = $scheduleid;
                                                                                }

                                                                        $overtaken =  $saved_fields[29];


                                                                        echo "overtakenadjustto $overtakenadjustto and paymentvoucher date$payvoucherdate";
                                                                        echo "overtakenreceive $overtaken_receive";
                                                                        echo "fromid $fromloc";echo "fairrate $fairrate";
                                                                        echo "toid $toloc"; echo "fairratetwo $fairratetwo";
                                                                        echo "moneyfairrate $money_fairrate";echo "moneyfairratetwo $money_fairrate_two";
                                                                        echo "shipid $shipname";echo "advance_tk $advance_tk";echo "part_tk $part_tk";echo "balance_tk $balance_tk";
                                                                        echo "matone $matone";echo "overtakenadjustfrom   $overtakenadjustfrom";
                                                                        echo "smattwo $mattwo";
                                                                        echo "goddquantityone $goodquantityone";
                                                                        print("receive balance is$saved_fields[23] taka-------------");

                                                                        print("\tpayment balance is$saved_fields[15] taka-------------");

                                                                        if ($saved_fields[23]=="")
                                                                                {

                                                                                        $balance_receive="";
                                                                                        print("\nreceive balance When null, enter here");

                                                                                }

                                                                        else
                                                                                {

                                                                                        $balance_receive=$saved_fields[23];
                                                                                }




                                                                        if ($saved_fields[15]=="")
                                                                                {

                                                                                        $payment_balance="";
                                                                                        print("\nPayment balance When null, enter here");

                                                                                }

                                                                else
                                                                        {

                                                                                $payment_balance=$saved_fields[15];
                                                                        }






                                                                $money_fair_rate = $saved_fields[24];
                                                                $money_fair_rate_two = $saved_fields[28];
                                                                $money_received_from = $saved_fields[26];
                                                                $money_received_date = $saved_fields[25];


                                                                // $accountname = ltrim($accountname);

                                                                if ($payment_balance =="")
                                                                        {   // If payment balance is null starts



                                                                                if ($balance_receive=="")
                                                                                        {




                                                                                                if($unloaddate=="")
                                                                                                        {





                                                                                                                print("\nthis is the place where we write ...I add balance_tk field to get the balance for payment in the cargo schedule screen");



                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");

                                                                                                        }

                                                                                                else
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");

                                                                                                        }


                                                                                        }  /// If receive balance is null ...... ends


                                                                                else           ///// If receive balance is not zero
                                                                                        {

                                                                                                print("this is the place where we write when receive balance not zero");
                                                                                                $total_receive = (abs($goodquantityone * $money_fair_rate)+abs($goodquantitytwo * $money_fair_rate_two)) ;
                                                                                                $balance_receive = abs($total_receive) - (abs($advance_receive)+abs($part_receive));

                                                                                                if ($unloaddate=="")
                                                                                                        {
                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate, trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");      /// I CUT IT TO CHECK DATE PROBLEM --pay_voucher_date,---'$payvoucherdate',
                                                                                                        }

                                                                                                else
                                                                                                        {
                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate,  trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");  /// I CUT IT TO CHECK DATE PROBLEM --- pay_voucher_date,
                                                                                                        }


                                                                                        }  /// If receive balance is not null ...... ends


                                                                        } /////// If payment balance is null ..... ends

                                                                else
                                                                        {     //////// If payment balance is not null..... starts

                                                                                if ($balance_receive=="")
                                                                                        {
                                                                                                if($unloaddate=="")
                                                                                                        {
                                                                                                                echo "ym on dutty";
                                                                                                                echo $departuredate;
                                                                                                                echo "--ovetakenreceive---$overtaken_receive";
                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");

                                                                                                        }

                                                                                                else
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");

                                                                                                        }


                                                                                        } /// If receive balance is null ...... ends

                                                                                else           ///// If receive balance is not zero
                                                                                        {

                                                                                                echo "dfdfym on dutty";
                                                                                                $total_receive = (abs($goodquantityone) *  abs($money_fair_rate))+(abs($goodquantitytwo)  *  abs($money_fair_rate_two)) ;
                                                                                                $balance_receive = abs($total_receive) - (abs($advance_receive)+abs($part_receive));

                                                                                                if($unloaddate=="")
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");

                                                                                                        }

                                                                                                else
                                                                                                        {
                                                                                                                $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid_q');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive) values('$scheduleid_q','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtaken_receive')");
                                                                                                        }


                                                                                        }  /// If receive balance is not null ...... ends


                                                                        } ///////  If payment balance is not null...... ends






                                                                // $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,quantity_one,mat_two,quantity_two,trip_id) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone','$goodquantityone','$mattwo','$goodquantitytwo','$tripid')");
                                        	/*	        $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
                                        	                $numrows=pg_numrows($result);

                                        	                $row = pg_fetch_row($result,($gotocheck-1));

                                                                $scheduleid = $row[12];
                                                                $departuredate = $row[0];
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
                                                                $fairratetwo = $row[26];
                                                                $tripid = $row[24];
                                                                $unloaddate = $row[11];
                                                                $overtaken  = $row[27];
                                                                $overtaken_adjust_to  = $row[28];
                                                                $overtaken_adjust_from  = $row[29];
                                                                $overtaken_receive  = $row[30];


                                                  */





                                            //    }



                                                /**************************** END FOR EDIT BUTTON  *********************/



                                                $change = 1;

                                            } //end of loop






                                }




                }



















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
//	document.view_record.gotocheck.value = document.view_record.button_check.value;
<?php
	print("opener.location=\"http://www.test.com/cargo_schedule.php?filling=gotobutton&gotocheck=$gotocheck&seenbefore=1\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}


function adjust()
{
	document.view_record.filling.value = "adjust";
//	document.view_record.gotocheck.value = document.view_record.button_check.value;




	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}


</script>

</head>

<body> <form name = "view_record" action = "overtaken_adjust.php" method = "post">

<?php

// connects to database

//$conn=pg_connect("host=$host user=$user dbname=$database");

$query_string = "select schedule_id,departure_date,ship_name,account_name,from_loc,to_loc,matone_name,mattwo_name,quantity_one,quantity_two,fair_rate,unload_date,advance_tk,part_tk,balance_tk,total_tk,overtaken,overtaken_adjust_to,overtaken_receive,overtaken_adjust_from,pay_voucher_date,trip_id from cargo_account_mat_view where schedule_id>$mainscheduleid and ship_id=$shipid and trip_id>$maintripid  order by schedule_id";

$result = pg_exec($query_string);
$row = pg_fetch_row($result,0);

$departuredate = $row[1];

echo $row[0];
echo $row[1];
echo $row[2];




$column_count = pg_numfields($result);

print ("<TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");
  $field_name= array('RECORD','Schedule_id','Departure date','SHIP NAME','ACCOUNT NAME',' FROM ','TO  ','MAT_ONE','MAT_TWO','QTY.ONE','QTY.TWO','FAIR RATE','UNLOAD DATE','ADVANCE','PART','BALANCE','TOTAL','OVERTAKEN','OVERTAKEN_ADJUST','OVERTAKEN_FROM','OVERTAKEN_ADJUST_FROM','PAY DATE','TRIP ID');
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

       











        for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++)
                {

                        $row = pg_fetch_row($result,$count);

                        $color = ($button_check==$count ? "5fF9F0" : "E9E9E9");


                        if ($button_check==$count )
                                {

                                        $balancetk = $row[23];
                                        $departuredate = $row[1];
                                        $shipcargovalue = $row[2];
                                        $nameofshipcargo = $row[3];
                                        $fromvalue = $row[6];
                                        $fromlocname = $row[7];
                                        $tovalue = $row[8];
                                        $tolocname = $row[9];
                                        $materialonevalue = $row[10];
                                        $materialonename = $row[11];
                                        $materialtwovalue = $row[14];
                                        $materialtwoname = $row[15];
                                        $paymenttkrate = $row[13];
                                        $fairratetwo = $row[17];
                                        $scheduleid = $row[0];
                                        $tripid = $row[21];
                                        $fairrate= $row[13];
                                        $damerage = $row[28];
                                        $overtaken = $row[29];
                                        $overtakenadjustto = $row[30];
                                        $overtakenfrom = $row[31];
                                        $overtakenreceive = $row[32];

                                }

                         if ($overtakenfrom !=0)
                                {
                                        continue;
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

        print ("</Table>");


?>

<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="mainscheduleid" value="<?php echo $mainscheduleid  ?>" >
<INPUT TYPE="hidden" name="mainovertaken" value="<?php echo $mainovertaken ?>" >                                       

<INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>" >

<INPUT TYPE="hidden" name="shipid" value="<?php echo $shipid  ?>" >
<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid  ?>" >
<INPUT TYPE="hidden" name="maintripid" value="<?php echo $maintripid  ?>" >
<INPUT TYPE="hidden" name="seenbefore" value="1">
<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="submit" value="Adjust" name="adjustbutton" style=" width: 84; height: 25" onclick= "adjust()"></td>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick= "set_main()">

</td>
    </tr>
  </table>
</form>
departuredate("<?php echo $departuredate ?>");
mainschedule("<?php echo $mainscheduleid ?>");
mainovertaken("<?php echo $mainovertaken ?>");
maintripid("<?php echo $maintripid ?> ");
numrows("<?php echo $numrows ?>");
schedule("<?php echo $scheduleid ?>");

gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
shipid("<?php echo $shipid ?> ");
tripid("<?php echo $tripid ?> ");

</body>
</html>

