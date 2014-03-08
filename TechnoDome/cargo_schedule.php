<?php

        require ("config.php");

        // grabs all product information
        $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
        $numrows = pg_numrows($result);


        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $scheduleid = 0;
                                        $voucherdate = "";
                                }
                        else
                                {

                                        $row = pg_fetch_row($result,0);
                                        $scheduleid = $row[12];
                                        $shipname = $row[19];
                                        $tripid = $row[24];
                                        $voucherid =$row[18];
                                        $payvoucherdate = $row[23];
                                        $overtaken  = $row[27];
                                        $overtaken_adjust_to  = $row[28];
                                        $overtaken_adjust_from  = $row[29];
                                        $overtaken_receive  = $row[30];







                                }


                        if ( is_integer($gotocheck)== 0)
                                {
                                        $gotocheck = 1;
                                }



                }




        /*$row = pg_fetch_row($result,0);*/

        //*******************  For TOP BUTTON         **********************

        if ($filling == "topbutton")
                {
	                $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
	                $numrows=pg_numrows($result);
	                $row = pg_fetch_row($result,0);

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

                }

        /******************** End OF TOP BUTTON  ***************************/

        /******************** FOR PREVIOUS BUTTON  **********************************/

        if ($filling == "prevrecord")
                {
	                $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");

	                $numrows = pg_numrows($result);
	                $numfields = pg_numfields($result);

                	$row = pg_fetch_row($result,$gotocheck-1);

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

	        }

        /**************************** END OF PREVIOUS BUTTON  *********************/


        /************************* FOR NEXT BUTTON ****************************/

        if ($filling == "nextrecord")
                {
	                $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");

	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

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




        	}

        /**************************** END OF NEXT BUTTON  *********************/




        /**************************** FOR BOTTOM BUTTON  *********************/

        if ($filling == "bottombutton")
                {
	                $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
	                $numrows=pg_numrows($result);
	                $numfields = pg_numfields($result);
	                $row = pg_fetch_row($result,($numrows-1));

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





                }


        /**************************** FOR GOTO BUTTON  *********************/



        if ($filling == "gotobutton")
                {
	                $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");

	                $numrows=pg_numrows($result);
	                $numfields = pg_numfields($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

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



	        }



        /*******************  For EDIT BUTTON         **********************/


        if ($filling == "editbutton")
                {
                        //    $result =pg_exec($conn,"select * from cargo_schedule order by schedule_id");
                        //    $numrows =pg_numrows($result);

                        $editresult = pg_exec("select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                        $editnumrows =pg_numrows($editresult);

                        $saved_fields = pg_fetch_row($editresult,0);

                        $payment_balance = $saved_fields[15];
                        $pay_fair_rate= $saved_fields[17];
                        $pay_fair_rate_two= $saved_fields[27];
                        $advance_receive = $saved_fields[20];
                        $part_receive = $saved_fields[21];
                        $total_receive = $saved_fields[22];
                        // $balance_receive = $saved_fields[23];





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



                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");

                                                                }

                                                        else
                                                                {

                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");

                                                                }


                                                }  /// If receive balance is null ...... ends


                                        else           ///// If receive balance is not zero
                                                {
                                                        echo "here-15";


                                                        $total_receive = (abs($goodquantityone * $money_fair_rate)+abs($goodquantitytwo * $money_fair_rate_two)) ;
                                                        $balance_receive = abs($total_receive) - (abs($advance_receive)+abs($part_receive));

                                                        if ($unloaddate=="")
                                                                {
                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate, trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");      /// I CUT IT TO CHECK DATE PROBLEM --pay_voucher_date,---'$payvoucherdate',
                                                                }

                                                        else
                                                                {
                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,voucher_id,fair_rate,  trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");  /// I CUT IT TO CHECK DATE PROBLEM --- pay_voucher_date,
                                                                }


                                                }  /// If receive balance is not null ...... ends


                                } /////// If payment balance is null ..... ends

                        else
                                {     //////// If payment balance is not null..... starts

                                        if ($balance_receive=="")
                                                {
                                                        if($unloaddate=="")
                                                                {

                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");

                                                                }

                                                        else
                                                                {

                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,money_fair_rate,money_fair_rate_two,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$money_fair_rate','$money_fair_rate_two','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");

                                                                }


                                                } /// If receive balance is null ...... ends

                                        else           ///// If receive balance is not zero
                                                {

                                                        echo "here-16";

                                                        $total_receive = (abs($goodquantityone) *  abs($money_fair_rate))+(abs($goodquantitytwo)  *  abs($money_fair_rate_two)) ;
                                                        $balance_receive = abs($total_receive) - (abs($advance_receive)+abs($part_receive));

                                                        if($unloaddate=="")
                                                                {
                                                                          echo "here-16";
                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$shipname','$ownername','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");

                                                                }

                                                        else
                                                               {
                                                                        $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,advance_tk,part_tk,total_tk,balance_tk,voucher_id,fair_rate,pay_voucher_date,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,money_fair_rate_two,mreceipt_date,received_from,fair_rate_two,overtaken,overtaken_adjust_to,overtaken_adjust_from,overtaken_receive,damerage) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone' ,'$mattwo','$goodquantityone','$goodquantitytwo','$advancetk','$parttk','$totaltk','$balancetk','$voucherid','$fairrate','$payvoucherdate','$tripid','$advance_receive','$part_receive','$total_receive','$balance_receive','$money_fair_rate','$money_fair_rate_two','$money_received_date','$money_received_from','$fairratetwo','$overtaken','$overtakenadjustto','$overtakenadjustfrom','$overtakenreceive','$damerage')");
                                                                }


                                                }  /// If receive balance is not null ...... ends


                                } ///////  If payment balance is not null...... ends






                        // $result = pg_exec($conn,"delete from cargo_schedule where (schedule_id='$scheduleid');insert into cargo_schedule (schedule_id,departure_date,unload_date,ship_id,owner_name,from_id,to_id,mat_one,quantity_one,mat_two,quantity_two,trip_id) values('$scheduleid','$departuredate','$unloaddate','$shipname','$ownername','$fromloc','$toloc','$matone','$goodquantityone','$mattwo','$goodquantitytwo','$tripid')");
		        $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");
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








        }



        /**************************** END FOR EDIT BUTTON  *********************/


        /**************************** FOR DELETE BUTTON  *********************/

        if ($filling == "deletebutton")
                {
		        //$scheduleid=63;
		        $result = pg_exec("select * from cargo_schedule order by schedule_id");

		        $numrows=pg_numrows($result);

		        //$conn = pg_connect("host=$host dbname=$database user=$user" );
		        $result = pg_exec($conn,"DELETE  FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");



		        $result = pg_exec("select * from cargo_account_mat_view order by schedule_id");

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


                }



?>

<html>
<head>
  <title>Cargo Schedule</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">


</head>

<script language= javascript 1.5>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?>;

var gotocheck=<?php echo $gotocheck ?>;

function setattribute()
        {

                if (Number(document.test.overtaken.value) ==0)
                        {
                              //   document.test.adjustbutton.disabled=true;
                        }


                document.test.departuredate.disabled=true;
                document.test.goodquantityone.disabled=true;
                document.test.goodquantitytwo.disabled=true;
                document.test.fairrate.disabled=true;
                document.test.departuredate.disabled=true;
                document.test.unloaddate.disabled=true;
            //    document.test.clientname.disabled=true;
                document.test.savebutton.disabled=true;
                document.test.cancelbutton.disabled=true;
                document.test.addbutton.disabled=true;
                document.test.deletebutton.disabled=true;
                document.test.adjustbutton.disabled=true;

                window.status = document.test.gotocheck.value+"/"+ numrows

        }


function form_validator(theForm)
        {

  /*              if(theForm.departuredate.value == "")
                        {
     	                        alert("<?php echo $txt_missing_departuredate ?>");
                                theForm.departuredate.select();
     	                        theForm.departuredate.focus();
     	                        return(false);
                        }

   */
                 if(theForm.goodquantityone.value!= 0)
                         {

                               if(theForm.departuredate.value == "")
                                     {
                                             alert("<?php echo $txt_missing_departuredate ?>");
                                             theForm.departuredate.select();
                                             theForm.departuredate.focus();
                                             return(false);
                                     }
                           }












          /*
                 if(capfirst(theForm.mattwo.options[theForm.mattwo.selectedIndex].text) != "********")
                         {

                                if(theForm.goodquantitytwo.value == 0)
                                        {
                                                alert("Please Enter GoodTwo Quantity");
                                                theForm.goodquantitytwo.select();
                                                theForm.goodquantitytwo.focus();
                                                return(false);
                                        }

                         }

           */
		return (true);

        }









function add_edit_press(endis)
        {
                if (endis=='addedit')
                        {

                                document.test.departuredate.disabled=false;
                                document.test.goodquantityone.disabled=false;
                                document.test.goodquantitytwo.disabled=false;
                                document.test.clientname.disabled=false;
                                document.test.fairrate.disabled=false;
                                document.test.departuredate.disabled=false;
                                document.test.unloaddate.disabled=false;
                                document.test.advancetk.disabled=false;
                                document.test.parttk.disabled=false;
                                document.test.balancetk.disabled=false;
                                document.test.totaltk.disabled=false;
                                if (document.test.overtaken_adjust_to.value==0)
                                        {
                                                document.test.adjustbutton.disabled=false;
                                        }

                                button_option("pressed");

                        }

                else
	                {
                                document.test.departuredate.disabled=true;
                                document.test.goodquantityone.disabled=true;
                                document.test.goodquantitytwo.disabled=true;
                            //    document.test.clientname.disabled=true;
                                document.test.fairrate.disabled=true;
                                document.test.departuredate.disabled=true;
                                document.test.unloaddate.disabled=true;
                                document.test.advancetk.disabled=true;
                                document.test.parttk.disabled=true;
                                document.test.balancetk.disabled=true;
                                document.test.totaltk.disabled=true;

                                if (document.test.scheduleid.value ==0)
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
                        print("window.open (\"view_cargo_schedule.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$scheduleid\",\"view\",\"toolbar=no,scrollbars=yes\")")?>;
        }


function adjust_record()
        {
                var buttoncheck = document.test.gotocheck.value-1;
                var abc = "overtaken_adjust.php?gotocheck="+String(document.test.gotocheck.value)+"&button_check="+String(buttoncheck)+"&mainovertaken="+String(document.test.overtaken.value)+"&shipid="+String(document.test.shipname.value)+"&mainscheduleid="+String(document.test.scheduleid.value)+"&maintripid="+String(document.test.tripid.value);
                alert(abc);
                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");







        }

function overtakencal()
        {
                if (document.test.balancetk.value<0)
                        {
                          document.test.overtaken.value= Math.abs(document.test.balancetk.value);

                         }

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

<body onload="setattribute()" bgcolor="#067686"  >
<form name = "test" onsubmit = "return form_validator(this)" onreset="add_edit_press()"method = "post" action ="cargo_schedule.php">
  <b><u><font size=+2><div align="center">Cargo Schedule Form</div></font></u></b>
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
<tr><td><B>Departure Date:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><input type ="text" name = "departuredate" value="<?php echo $row[0] ?>" size =12><a href="javascript:show_calendar('test.departuredate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><B> Date Of Unload:</B><td><input type ="text" name = "unloaddate" value="<?php echo $row[11]?>"size = 10><a href="javascript:show_calendar('test.unloaddate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a>
 </tr>

<tr>
<td><B>Cargo Vessel:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td> <select size=1 name="shipname">
<option value= "<?php echo $row[19] ?>" selected> <?php echo $row[1] ?> </option>


 </select>

 <td><B>Owner's Name:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td> <select size="1" name="ownername">
  <option value= "<?php echo $row[13] ?>" selected><?php echo $row[2] ?> </option>

</select>
</tr>

<tr>
<td><B>From:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <td> <select size="1" name="fromloc" >

   <option value ="<?php echo $row[14] ?>" selected><?php echo $row[3]?> </option>

</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><B>To:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="toloc" >
   <option value ="<?php echo $row[15] ?>" selected> <?php echo $row[4] ?> </option>

</select>

</tr>


<tr><td><B>Name Of Good One:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="matone" >

 <option value ="<?php echo $row[16] ?>" selected> <?php echo $row[5] ?> </option>


</select>
<td><B>Quantity :</B><td><input type ="text" name = "goodquantityone" value="<?php echo $row[7]?>"size = 10 onchange="document.test.totaltk.value=((Number(document.test.goodquantityone.value))* (Number(document.test.fairrate.value))+ (Number(document.test.goodquantitytwo.value))* (Number(document.test.fairratetwo.value))),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value)+Number(document.test.overtakenfrom.value));overtakencal()">
</tr>

<tr> <td><B>Name of Good two:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td><select size="1" name="mattwo">

  <option value ="<?php echo $row[17] ?>" selected> <?php echo $row[6] ?> </option>


</select>
<td><B>Quantity :</B><td><input type ="text" name = "goodquantitytwo" value="<?php echo $row[8]?>"size = 10 onchange="document.test.totaltk.value=((Number(document.test.goodquantityone.value))*(Number(document.test.fairrate.value))+ (Number(document.test.goodquantitytwo.value))*(Number(document.test.fairratetwo.value))),document.test.balancetk.value=Number(document.test.totaltk.value)-(Number(document.test.parttk.value)+Number(document.test.advancetk.value));overtakencal()"></tr>
  <tr><td><B>Cargo Fair Rate:</B><td><input type ="text" name = "fairrate" value ="<?php echo $row[9]?>"size = 10 readonly>

  <td><B>Fair Rate Two:</B><td><input type ="text" name = "fairratetwo" value ="<?php echo $row[26]?>"size = 10 readonly></tr>

  <tr><td><B>Advance:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="advancetk" value="<?php echo $row[10]?>"size = 15 readonly>
  <td><B>Part taka:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="parttk" value ="<?php echo $row[20]?>"size = 10 readonly></tr>
  <tr><td><B>Total:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="totaltk" value ="<?php echo $row[22]?>"size = 10 readonly>
  <td><B>Balance:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="balancetk" value ="<?php echo floor($balancetk)?>"size = 10 readonly></tr>


  <?php

  if(abs($row[25]!=0))
  {
   $clientname_result = pg_exec("select account_name from accounts where account_id=abs($row[25])");
   $clientname_numrows = pg_numrows($clientname_result);

   if ($clientname_numrows!=0)
        {

                $clientname_row = pg_fetch_row($clientname_result,0);

         }
   }
  ?>

  <tr><td><B>Damerage:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="damerage" size ="20" value ="<?php echo $damerage ?>" >
  <td><B>OverTaken From:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="overtakenfrom" size ="20" value ="<?php echo $overtaken_receive ?>" > </td>
  </tr>

  <tr><td><B>client's name:</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <td><input type ="text" name ="clientname" size ="40" value ="<?php echo $clientname_row[0] ?>" readonly>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><B>OverTaken :</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><input type ="text" name ="overtaken" size ="20" value ="<?php echo $overtaken ?>" > </td>
  <td><input type="button" value="adjust" name="adjustbutton" style=" width: 84; height: 25" onclick="adjust_record()"></td></tr>

</table>

<div align="center"><?php button_print(); ?></div>



<INPUT TYPE="hidden" name="seenbefore" value="1">
<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>">
<INPUT TYPE="hidden" name="visitnormal" value="<?php echo $visitnormal  ?>" >
<INPUT TYPE="hidden" name="visitpurchase" value="<?php echo $visitpurchase  ?>" >
<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid ?>">
<INPUT TYPE="hidden" name="voucherid" value="<?php echo $voucherid ?>">
<INPUT TYPE="hidden" name="payvoucherdate" value="<?php echo $payvoucherdate ?>">
<INPUT TYPE="hidden" name="overtaken_adjust_to" value="<?php echo $overtaken_adjust_to ?>">
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >


</form>

ship("<?php echo $shipname ?>");
overtaken_adjust_to("<?php echo $overtaken_adjust_to ?>");
<!--numrows("<?php echo $numrows ?>");
    scheduleid("<?php echo $scheduleid ?>");
    gotocheck("<?php echo $gotocheck ?>");
    nameprompt("<?php echo $filling ?> ");
    ship("<?php echo $shipname ?>");
    deprt("<?php echo $departuredate ?>");
    unload("<?php echo $unloaddate ?>");
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
    -->


</body>
</html>
