<?php

        require("config.php");
	require("/var/spool/voice/myfile.php");
        // connects to database

        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        $shipcargo = 0;
                        $shipselect = "false";
                        $clientselect = "false";
                        $visitnormal = 0;
                        $visitpurchase = 0;
                        $visitofficial = 0;
                        $setat ="false";
                        $radiotest="normal";
                        $adjradiotest="payment_voucher";

                        $savecancel = "true";
                        $year = date ("Y");
                        $month = date("m") ;

                        // grabs all product information
                        $result = pg_exec("select * from view_payment_carrying ");
                        $numrows = pg_numrows($result);

                        if ($numrows==0)
                                {
                                        $row[0]=0;
                                   //     $row[1]="";
                                        $voucherid = 0;
                                }

                        else
                                {
                                        $row = pg_fetch_row($result,0);

                                        $voucherid = $row[0];
                                        $voucherdate = $row[1];
                                        $payserial = $row[2];

                                        // Following are the name of the values
                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];


                                        // Follwing are the values
                                        $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
                                        $mattwo = $row[13];
                                        $payamount = $row[15];
                                        $tkrate =$row[23];
                                        $paytype = $row[16];
                                        $chequeno = $row[19];
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
                                        $chequepaydate = $row[20];
                                        $departuredate = $row[25];

                                }



                        if ( is_integer($gotocheck)== 0)
                                {

                                        $gotocheck = 1;
                                }



                }

        else
                {


                        if ($radiotest =="normal")
                                {
                                        if( $visitnormal ==0)
                                                {
                                                        $result = pg_exec("select * from view_payment_carrying ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
                                                                        //  $voucherdate = "";
                                                                }
                                                        else
                                                                {

                                                                        if ($returnfromviewship !="true" && $clientselect !="true")
                                                                                {
                                                                                        $row = pg_fetch_row($result,0);
                                                                                        $voucherid = $row[0];
                                                                                        $voucherdate = $row[1];
                                                                                        $payserial = $row[2];

                                                                                        // Following are the name of the values
                                                                                        $accountname = $row[4];
                                                                                        $nameofship = $row[6];
                                                                                        $fromlocname = $row[8];
                                                                                        $tolocname = $row[10];
                                                                                        $matonename = $row[12];
                                                                                        $mattwoname = $row[14];


                                                                                        // Follwing are the values
                                                                                        $clientname = $row[3];
                                                                                        $shipname = $row[5];
                                                                                        $fromloc = $row[7];
                                                                                        $toloc = $row[9];
                                                                                        $matone = $row[11];
                                                                                        $mattwo = $row[13];
                                                                                        $payamount = $row[15];
                                                                                        $tkrate =$row[23];
                                                                                        $paytype = $row[16];
                                                                                        $chequeno = $row[19];
                                                                                        $bankname = $row[17];
                                                                                        $branchname = $row[18];
                                                                                        $chequepaydate = $row[20];

                                                                                }

                                                                        $returnfromviewship = "false";

                                                                }

	                                                $visitnormal = 1;
                                                        $visitpurchase = 0;
                                                        $visitofficial = 0;
                                                }

                                        else
                                                {
                                                        $result = pg_exec("select * from view_payment_carrying ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
                                                                       // $voucherdate = "";
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                                }

                                                }

                                }






                        if ($radiotest =="purchase")
                                {
                                        print("we are in purchase Voucher..$visitpurchase");

                                        if ($visitpurchase ==0)
                                                {
	                                                $result = pg_exec("select * from view_payment_purchase ");
                                                        $numrows=pg_numrows($result);
                                                        //$row = pg_fetch_row($result,0);
                                                        print($numrows);

                                                        if ($numrows==0)
                                                                {
                                                                        print("$numrows...we are in");
                                                                        $voucherid = 0;
                                                                   //     $voucherdate = "";

                                                                }

                                                        else
                                                                {

                                                                      if ($returnfromviewship !="true" && $clientselect !="true")
                                                                       {

                                                                        $row = pg_fetch_row($result,0);

                                                                        $voucherid = $row[0];
                                                                        $voucherdate = $row[1];
                                                                        $payserial = $row[2];

                                                                        // Following are the name of the values
                                                                        $accountname = $row[4];
                                                                        $nameofship = $row[6];
                                                                        $fromlocname = $row[8];
                                                                        $tolocname = $row[10];
                                                                        $matonename = $row[12];
                                                                        $mattwoname = $row[14];

                                                                        // Follwing are the values
                                                                        $clientname = $row[3];
                                                                        $shipname = $row[5];
                                                                        $fromloc = $row[7];
                                                                        $toloc = $row[9];
                                                                        $matone = $row[11];
                                                                        $mattwo = $row[13];
                                                                        $payamount = $row[15];
                                                                        $tkrate =$row[23];
                                                                       }

                                                                }


                                                        $visitpurchase = 1;
                                                        $visitnormal = 0;
                                                        $visitofficial = 0;
                                                }

                                        else
                                                {
                                                        $result = pg_exec("select * from view_payment_purchase ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
                                                                    //  $voucherdate = "";

                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                        //  $shipname = $row[22];
                                                                        //  $nameofship = $row[23];

                                                                }

                                                }

                                }






                        if ($radiotest =="official")
                                {
                                        if ($visitofficial ==0)
                                                {

                                                        /////////////  Query for voucher serial no for official  ///////////////

                                                        $year = date ("Y");
                                                        $month = date("m") ;
                                                        $official_vounumrows = 0;



                                                        $official_vouresult = pg_exec("select max(voucher_no) from payment_voucher where ((date_part('year',pay_voucher_date)=$year) and (date_part('month',pay_voucher_date)=$month) ) ");

                                                        $official_vounumrows = pg_numrows($official_vouresult);

                                                        if ($official_vounumrows!=0)
                                                                {
                                                                        $official_testrow = pg_fetch_row($official_vouresult,0);
                                                                        $official_miraj = $official_testrow[0];

                                                                }

                                                        print($official_vounumrows);

                                                        print($official_miraj);
                                                        //$row = pg_fetch_row($result,0);
                                                        //$voucherid = $row[0];

                                                        if ($official_miraj=="")
                                                                {
                                                                        print("miraj");
                                                                        $official_voucherno = date("Y");

                                                                        $official_voucherno .= date("m");
                                                                        $official_voucherno .="001";
                                                                        $official_voucherno =abs($official_voucherno);

                                                                }

                                                        else
                                                                {
                                                                        $official_vourow = pg_fetch_row($official_vouresult,0);
                                                                        print("shamimmiraj");
                                                                        $official_voucherno = abs($official_vourow[0]);
                                                                        $official_voucherno = abs($official_voucherno);
                                                                        $official_voucherno = $official_voucherno+1;

                                                                        print ("\t$official_voucherno");

                                                                }


                                                        ////////////  End of vocher serial no. for official  ///////////








                                                        $result = pg_exec("select * from view_payment_official ");


                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
                                                                        //$voucherdate = "";
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,0);

                                                                        $voucherid = $row[0];
                                                                        $voucherdate = $row[1];

                                                                        $payserial = $row[2];
                                                                        $clientname = $row[3];
                                                                        $accountname = $row[4];
                                                                        $payamount = $row[5];
                                                                        $paytype = $row[6];
                                                                        $bankname = $row[7];
                                                                        $bankbranch = $row[8];
                                                                        $chequeno = $row[9];
                                                                        $chequepaydate = $row[10];
                                                                        $expensetype = $row[11];
                                                                        $comment = $row[13];


                                                                }



                                                        $visitpurchase = 0;
                                                        $visitnormal = 0;
                                                        $visitofficial = 1;
                                                }
                                        else
                                                {
                                                        $result = pg_exec("select * from view_payment_official ");
                                                        $numrows=pg_numrows($result);
                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
                                                                      //  $voucherdate = "";
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                                }
                                                }

                                }

                }                    ////// END of seenbefore else



















                        ///************************* start button operation********************************//
                        //for store a number in $gotocheck for prev,next,goto...


                        //*******************  For TOP BUTTON         **********************

                        if ($filling == "topbutton")
                                {
                                        if ($radiotest =="normal")
                                                {
	                                                $result = pg_exec("select * from view_payment_carrying ");
                                                        $numrows=pg_numrows($result);
	                                                $row = pg_fetch_row($result,0);

                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];

                                                        $payserial = $row[2];
	                                                $clientname = $row[3];
                                                        $toloc = $row[9];
                                                        $matone = $row[11];
                                                        $mattwo = $row[13];

                                                        $accountname = $row[4];
                                                        $nameofship = $row[6];
	                                                $shipname = $row[5];
                                                        $fromlocname = $row[8];
                                                        $tolocname = $row[10];
                                                        $fromloc = $row[7];
                                                        $matonename = $row[12];
                                                        $mattwoname = $row[14];

                                                        $payamount = $row[15];
	                                                $paytype = $row[16];
	                                                $bankname = $row[17];
                                                        $bankbranch = $row[18];
	                                                $chequeno = $row[19];
	                                                $chequepaydate = $row[20];
	                                                $comment = $row[21];
                                                        $tkrate = $row[23];
                                                        $departuredate = $row[25];

                                                }


                                        if ($radiotest =="purchase")
                                                {
	                                                $result = pg_exec("select * from view_payment_purchase ");
                                                        $numrows=pg_numrows($result);
	                                                $row = pg_fetch_row($result,0);

                                                        $voucherid = $row[0];
                                                        $voucherdate = $row[1];

                                                        $payserial = $row[2];
                                                        $clientname = $row[3];
                                                        $toloc = $row[9];
                                                        $matone = $row[11];
                                                        $mattwo = $row[13];

                                                        $accountname = $row[4];
                                                        $nameofship = $row[6];
                                                        $shipname = $row[5];
                                                        $fromlocname = $row[8];
                                                        $tolocname = $row[10];
                                                        $fromloc = $row[7];
                                                        $matonename = $row[12];
                                                        $mattwoname = $row[14];

                                                        $payamount = $row[15];
                                                        $paytype = $row[16];
                                                        $bankname = $row[17];
                                                        $bankbranch = $row[18];
                                                        $chequeno = $row[19];
                                                        $chequepaydate = $row[20];
                                                        $comment = $row[21];
                                                        $tkrate = $row[23];

                                                }






                                        if ($radiotest =="official")
                                                {
	                                                $result = pg_exec("select * from view_payment_official ");
                                                        $numrows=pg_numrows($result);
	                                                $row = pg_fetch_row($result,0);


                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];

                                                        $payserial = $row[2];
	                                                $clientname = $row[3];
                                                        $accountname = $row[4];
	                                                $payamount = $row[5];
	                                                $paytype = $row[6];
	                                                $bankname = $row[7];
                                                        $bankbranch = $row[8];
	                                                $chequeno = $row[9];
	                                                $chequepaydate = $row[10];
	                                                $expensetype = $row[11];
                                                        $comment = $row[13];

                                                }

                                                //$numrows=pg_numrows($result);
                                }


                        /******************** End OF TOP BUTTON  ***************************/
                        /******************************************************************/


                        /******************** FOR PREVIOUS BUTTON  **********************************/
                        /****************************************************************************/

                        if ($filling == "prevrecord")
                                {

                                        if ($radiotest =="normal")
                                                {
	                                                $result = pg_exec("select * from view_payment_carrying ");
                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                        $numrows=pg_numrows($result);

                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];

                                                        $payserial = $row[2];
                                                        $clientname = $row[3];
                                                        $shipname = $row[5];
                                                        $fromloc = $row[7];
                                                        $toloc = $row[9];
	                                                $matone = $row[11];
	                                                $mattwo = $row[13];

                                                        $accountname = $row[4];
                                                        $nameofship = $row[6];
                                                        $shipname = $row[5];
                                                        $fromlocname = $row[8];
                                                        $tolocname = $row[10];
                                                        $fromloc = $row[7];
                                                        $matonename = $row[12];
                                                        $mattwoname = $row[14];

                                                        $payamount = $row[15];
	                                                $paytype = $row[16];
	                                                $bankname = $row[17];
                                                        $bankbranch = $row[18];
	                                                $chequeno = $row[19];
	                                                $chequepaydate = $row[20];
	                                                $comment = $row[21];
                                                        $tkrate = $row[23];
                                                        $departuredate = $row[25];


                                                 }


                                        if ($radiotest =="purchase")
                                {
	                                $result = pg_exec("select * from view_payment_purchase");
                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $numrows=pg_numrows($result);

                                        $voucherid = $row[0];
                                        $voucherdate = $row[1];

                                        $payserial = $row[2];
                                        $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
                                        $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $shipname = $row[5];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];

                                        $payamount = $row[15];
                                        $paytype = $row[16];
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
                                        $chequeno = $row[19];
                                        $chequepaydate = $row[20];
                                        $comment = $row[21];
                                        $tkrate = $row[23];


                               }


                        if ($radiotest =="official")
                                {
	                                $result = pg_exec("select * from view_payment_official ");
                                        $numrows=pg_numrows($result);

                                        if ($numrows==0)
                                                {
                                                        $voucherid=0;
                                                        $voucherdate = "";

                                                }

                                        else
                                                {

                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];

                                                        $payserial = $row[2];

	                                                $clientname = $row[3];
                                                        $accountname = $row[4];
                                                        $payamount = $row[5];
	                                                $paytype = $row[6];
	                                                $bankname = $row[7];
                                                        $bankbranch = $row[8];
	                                                $chequeno = $row[9];
	                                                $chequepaydate = $row[10];
	                                                $expensetype = $row[11];
                                                        $comment = $row[13];
                                                }

                                }


                }


        /**************************** END OF PREVIOUS BUTTON  *********************/
        /*************************************************************************/



        /************************* FOR NEXT BUTTON ****************************/
        /*********************************************************************/


        if ($filling == "nextrecord")
                {
                        if ($radiotest =="normal")
                                {
	                                $result = pg_exec("select * from view_payment_carrying ");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
	                                $voucherdate = $row[1];

                                        $payserial = $row[2];
	                                $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
	                                $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];


                                        $payamount = $row[15];
	                                $paytype = $row[16];
	                                $bankname = $row[17];
                                        $bankbranch = $row[18];
	                                $chequeno = $row[19];
	                                $chequepaydate = $row[20];
	                                $comment = $row[21];
                                        $tkrate = $row[23];
                                        $departuredate = $row[25];

                                }


                        if ($radiotest =="purchase")
                                {
	                                $result = pg_exec("select * from view_payment_purchase ");

                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $voucherid = $row[0];
                                        $voucherdate = $row[1];
                                        $payserial = $row[2];
                                        $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
                                        $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];


                                        $payamount = $row[15];
                                        $paytype = $row[16];
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
                                        $chequeno = $row[19];
                                        $chequepaydate = $row[20];
                                        $comment = $row[21];
                                        $tkrate = $row[23];

                                }


                        if ($radiotest =="official")
                                {
	                                $result = pg_exec("select * from view_payment_official ");
                                        $numrows=pg_numrows($result);

                                        if ($numrows==0)
                                                {
                                                        $voucherid=0;
                                                        $voucherdate = "";

                                                }

                                        else
                                                {
                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];
	                                                $payserial = $row[2];
                                                        $accountname = $row[4];
                                                        $clientname = $row[3];
	                                                $payamount = $row[5];
	                                                $paytype = $row[6];
	                                                $bankname = $row[7];
                                                        $bankbranch = $row[8];
	                                                $chequeno = $row[9];
	                                                $chequepaydate = $row[10];
	                                                $expensetype = $row[11];
                                                        $comment = $row[13];
                                                }

                                }

                }

        /**************************** END OF NEXT BUTTON  *********************/
        /*********************************************************************/



        /**************************** FOR BOTTOM BUTTON  *********************/
        /********************************************************************/


        if ($filling == "bottombutton")
                {

                        if ($radiotest =="normal")
                                {
	                                $result = pg_exec("select * from view_payment_carrying ");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
	                                $voucherdate = $row[1];
	                                $payserial = $row[2];
	                                $clientname = $row[3];
	                                $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
	                                $matone = $row[11];
	                                $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];



                                        $payamount = $row[15];
	                                $paytype = $row[16];
	                                $bankname = $row[17];
                                        $bankbranch = $row[18];
	                                $chequeno = $row[19];
	                                $chequepaydate = $row[20];
	                                $comment = $row[21];
                                        $tkrate = $row[23];
                                        $departuredate = $row[25];



                                }

                        if ($radiotest =="purchase")
                                {
	                                $result = pg_exec("select * from view_payment_purchase");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
                                        $voucherdate = $row[1];
                                        $payserial = $row[2];
                                        $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
                                        $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];


                                        $payamount = $row[15];
                                        $paytype = $row[16];
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
                                        $chequeno = $row[19];
                                        $chequepaydate = $row[20];
                                        $comment = $row[22];
                                        $tkrate = $row[23];


                                }


                        if ($radiotest =="official")
                                {
	                                $result = pg_exec("select * from view_payment_official");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
	                                $voucherdate = $row[1];
	                                $payserial = $row[2];
                                        $accountname = $row[4];
                                        $clientname = $row[3];
	                                $payamount = $row[5];
	                                $paytype = $row[6];
	                                $bankname = $row[7];
                                        $bankbranch = $row[8];
	                                $chequeno = $row[9];
	                                $chequepaydate = $row[10];
	                                $expensetype = $row[11];
                                        $comment = $row[13];

                                }


                }

        /***********END OF BOTTOM BUTTON*******************************/
        /*************************************************************/



        /**************************** FOR GOTO BUTTON  *********************/
        /******************************************************************/


        if ($filling == "gotobutton")
                {
                        if ($radiotest =="normal")
                                {
	                                $result = pg_exec("select * from view_payment_carrying");
                                        $numrows=pg_numrows($result);

                                        if ($numrows==0)
                                                {

                                                }
                                        else
                                                {
                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                        $voucherid = $row[0];
	                                                $voucherdate = $row[1];
	                                                $payserial = $row[2];

                	                                $clientname = $row[3];
                                                        $shipname = $row[5];
                                                        $fromloc = $row[7];
                                                        $toloc = $row[9];
                                                        $matone = $row[11];
	                                                $mattwo = $row[13];

                                                        $accountname = $row[4];
                                                        $nameofship = $row[6];
                                                        $shipname = $row[5];
                                                        $fromlocname = $row[8];
                                                        $tolocname = $row[10];
                                                        $fromloc = $row[7];
                                                        $matonename = $row[12];
                                                        $mattwoname = $row[14];

                                                        $payamount = $row[15];
	                                                $paytype = $row[16];
	                                                $bankname = $row[17];
                                                        $bankbranch = $row[18];
	                                                $chequeno = $row[19];
	                                                $chequepaydate = $row[20];
	                                                $comment = $row[21];
                                                        $tkrate = $row[23];
                                                        $through = $row[27];
                                                        $departuredate = $row[25];
                                                }

                                }



                        if ($radiotest =="purchase")
                                {
	                                $result = pg_exec("select * from view_payment_purchase");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
                                        $voucherdate = $row[1];
                                        $payserial = $row[2];
                                        $clientname = $row[3];
                                        $shipname = $row[5];
                                        $fromloc = $row[7];
                                        $toloc = $row[9];
                                        $matone = $row[11];
                                        $mattwo = $row[13];

                                        $accountname = $row[4];
                                        $nameofship = $row[6];
                                        $fromlocname = $row[8];
                                        $tolocname = $row[10];
                                        $fromloc = $row[7];
                                        $matonename = $row[12];
                                        $mattwoname = $row[14];


                                        $payamount = $row[15];
                                        $paytype = $row[16];
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
                                        $chequeno = $row[19];
                                        $chequepaydate = $row[20];
                                        $comment = $row[21];
                                        $tkrate = $row[23];
                                        $through = $row[24];

                                }


                        if ($radiotest =="official")
                                {
	                                $result = pg_exec("select * from view_payment_official");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $voucherid = $row[0];
	                                $voucherdate = $row[1];
	                                $payserial = $row[2];
	                                $clientname = $row[3];
                                        $accountname = $row[4];
	                                $payamount = $row[5];
	                                $paytype = $row[6];
	                                $bankname = $row[7];
                                        $bankbranch = $row[8];
	                                $chequeno = $row[9];
	                                $chequepaydate = $row[10];
	                                $expensetype = $row[11];
                                        $comment = $row[13];



                                }



                }




                /////////////////////////////////////////////////////////////////////

                /*******************     For ADD BUTTON      **********************/

                ///////////////////////////////////////////////////////////////////

                if ($filling == "addbutton" && $savecancel == "true")
                        {
                                //$payamount = abs($payamount);
                                //$tkrate = abs($tkrate);
                                print("$filling\t$savecancel");



                                ///********************** First Check for duplicate data****************************///
                                ///**************************************************************************///

                                $payserial = abs($payserial);

                                $dupresult= pg_exec($conn,"select * from payment_voucher where (voucher_no='$payserial') ");
                                $dupnumrows = pg_numrows($dupresult);

                                if ($dupnumrows !=0)
                                        {

                                                if ($radiotest =="normal")
                                                        {
                                                                $result = pg_exec("select * from view_payment_carrying");
                                                                $numrows=pg_numrows($result);

                                                                if ($numrows==0)
                                                                        {

                                                                        }
                                                                else
                                                                        {
                                                                                $row = pg_fetch_row($result,$gotocheck-1);

                                                                                $voucherid = $row[0];
                                                                                $voucherdate = $row[1];
                                                                                $payserial = $row[2];

                                	                                        $clientname = $row[3];
                                                                                $shipname = $row[5];
                                                                                $fromloc = $row[7];
                                                                                $toloc = $row[9];
                                                                                $matone = $row[11];
                                                                                $mattwo = $row[13];

                                                                                $accountname = $row[4];
                                                                                $nameofship = $row[6];
                                                                                $shipname = $row[5];
                                                                                $fromlocname = $row[8];
                                                                                $tolocname = $row[10];
                                                                                $fromloc = $row[7];
                                                                                $matonename = $row[12];
                                                                                $mattwoname = $row[14];

                                                                                $payamount = $row[15];
                                                                                $paytype = $row[16];
                                                                                $bankname = $row[17];
                                                                                $bankbranch = $row[18];
                                                                                $chequeno = $row[19];
                                                                                $chequepaydate = $row[20];
                                                                                $comment = $row[21];
                                                                                $tkrate = $row[23];
                                                                                $departuredate = $row[25];
                                                                        }

                                                        }


                                                if ($radiotest =="purchase")
                                                        {
                                                                $result = pg_exec("select * from view_payment_purchase");
                                                                $numrows=pg_numrows($result);
                                                                $row = pg_fetch_row($result,$gotocheck-1);

                                                                $voucherid = $row[0];
                                                                $voucherdate = $row[1];
                                                                $payserial = $row[2];
                                                                $clientname = $row[3];
                                                                $shipname = $row[5];
                                                                $fromloc = $row[7];
                                                                $toloc = $row[9];
                                                                $matone = $row[11];
                                                                $mattwo = $row[13];

                                                                $accountname = $row[4];
                                                                $nameofship = $row[6];
                                                                $fromlocname = $row[8];
                                                                $tolocname = $row[10];
                                                                $fromloc = $row[7];
                                                                $matonename = $row[12];
                                                                $mattwoname = $row[14];


                                                                $payamount = $row[15];
                                                                $paytype = $row[16];
                                                                $bankname = $row[17];
                                                                $bankbranch = $row[18];
                                                                $chequeno = $row[19];
                                                                $chequepaydate = $row[20];
                                                                $comment = $row[21];
                                                                $tkrate = $row[23];

                                                        }


                                                if ($radiotest =="official")
                                                        {
                                                                $result = pg_exec("select * from view_payment_official");
                                                                $numrows=pg_numrows($result);
                                                                $row = pg_fetch_row($result,$gotocheck-1);

                                                                $voucherid = $row[0];
                                                                $voucherdate = $row[1];
                                                                $payserial = $row[2];
                                                                $clientname = $row[3];
                                                                $accountname = $row[4];
                                                                $payamount = $row[5];
                                                                $paytype = $row[6];
                                                                $bankname = $row[7];
                                                                $bankbranch = $row[8];
                                                                $chequeno = $row[9];
                                                                $chequepaydate = $row[10];
                                                                $expensetype = $row[11];
                                                                $comment = $row[13];


                                                        }



                                                $add_edit_duplicate = 'true' ;



                                        }

                                else       ////***********************************if not duplicate ..then the actual work start
                                        {
                                                $add_edit_duplicate = 'false' ;



                                                if($radiotest=="normal")
                                                        {
                                                                $car_pur_off = "Carrying";
                                                                $payamount = abs($payamount);

                                                                if ($paytype =="Cash")
                                                                        {        //Cash condition starts

                                                                                print($paytype) ;


                                                                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                                                //************************************For ADD IN PAYMENT VOUCHER & Cargo Schedule When "Carrying" And "Cash" *********************

                                                                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



                                                                                if ($shiptripid =="")
                                                                                        {
                                                                                                $shiptripid = 0;
                                                                                        }

                                                                                else
                                                                                        {
                                                                                                $shiptripid = $shiptripid ;
                                                                                        }

                                                                                print ("$shiptripid");

                                                                                $payserial = abs($payserial);

                                                                                $result = pg_exec("select *  from cargo_schedule where ship_id = $shipname  and trip_id=$shiptripid  order by schedule_id");    // previously there was another condition after balance,--- total_tk!=0   and balance_tk!=0

                                                                                $cargo_numrows = pg_numrows($result);

                                                                                if ($cargo_numrows==0)
                                                                                        {         // cargonumrows zero starts ... fresh entry for a ship

                                                                                                print("Not desired in advance update....");

                                                                                                $cargotrip =pg_exec("select max(trip_id) from cargo_schedule where ship_id=$shipname");
                                                                                                $cargotripnumrows = pg_numrows($cargotrip);

                                                                                                if($cargotripnumrows==0)
                                                                                                        {
                                                                                                                $tripid =0;
                                                                                                        }

                                                                                                else
                                                                                                        {
                                                                                                                $cargotripid  =pg_fetch_row($cargotrip,0);
                                                                                                                $tripid =  $cargotripid[0];

                                                                                                        }

                                                                                                $tripid = $tripid+1 ;



                                                                                           /*     if($departuredate!="")    //// This is inside the fresh entry option
                                                                                                        {
                                                                                                                print("\t$departuredate");
                                                                                                                $partoradvance = "Part";

                                                                                                                $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,departure_date,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$departuredate','$tkrate','$tripid','$partoradvance','$through')");

                                                                                                        }

                                                                                                else
                                                                                                        {   //// If there is no departure date  (Inside the fresh Entry)
                                                                                             */
                                                                                                                $partoradvance = "Advance";

                                                                                                                $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through')");

                                                                                            //            }


                                                                                                $balancetk = $balancetk - $payamount;

                                                                                                $result = pg_exec($conn,"insert into cargo_schedule (pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,balance_tk,trip_id) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$tripid')");


                                                                                        }    // cargo numrows zero condition ( Fresh entry ) ends




                                                                                else
                                                                                        {   //########## When the the condition for balance and total taka is not zero ####################


                                                                                                $upresult = pg_fetch_row($result,0);


                                                                                                $scheduleid =     $upresult[0];
                                                                                                $goodquantityone= $upresult[8];
                                                                                                $goodquantitytwo= $upresult[9];
                                                                                                $advance =        $upresult [11];
                                                                                                $parttk =         $upresult[12];
                                                                                                $cargotripid =    $upresult [18];

                                                                                                $balancetk =      $upresult [15];
                                                                                                $totaltk =        $upresult[14];

                                                                                                if($goodquantityone!="" and $goodquantityone!=0)    //  departuredate is supposed to be replaced by goodquantityone


                                                                                                        {       //################# For quantityone is  not blank or zero  ############

                                                                                                                $partoradvance = "Part";

                                                                                                                $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through')");

                                                                                                                $parttk = $parttk+$payamount;



                                                                                                                $totaltk = (abs($goodquantityone)+abs($goodquantitytwo))  *  abs($tkrate) ;



                                                                                                                $balancetk = $totaltk - ($parttk+$advance); print("\t$balancetk");


                                                                ////////////////////////////////////////////////////////////////////////
                                                                // To keep track the existing data of money receipt in cargo schedule //
                                                                ////////////////////////////////////////////////////////////////////////

                                                                                                                ////probably we don't need this query...because already we got that record....ask miraj

                                                                                                                $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");


                                                                                                                $payment_fields = pg_fetch_row($result,0);


                                                                                                                $receivedate=   $payment_fields[10];
                                                                                                                $owner_name=    $payment_fields[3];
                                                                                                                $ship_name=     $payment_fields[2];
                                                                                                                $fromloc=       $payment_fields[4];
                                                                                                                $toloc=         $payment_fields[5];
                                                                                                                $matone=        $payment_fields[6];
                                                                                                                $mattwo=        $payment_fields[7];
                                                                                                                $quantityone=   $payment_fields[8];
                                                                                                                $quantitytwo=   $payment_fields[9];
                                                                                                                $receivetkrate= $payment_fields[24];
                                                                                                                $receiveadvance=$payment_fields[20];
                                                                                                                $departdate=    $payment_fields[1];
                                                                                                                $receiveparttk= $payment_fields[21];
                                                                                                                $receivetotaltk=$payment_fields[22];

                                                                                                                $receivefrom =  $payment_fields[26];

                                                                                                                if ($payment_fields[23]=="")
                                                                                                                        {
                                                                                                                                $receivebalancetk = "";
                                                                                                                        }


                                                                                                                else
                                                                                                                        {

                                                                                                                                $receivebalancetk=  $payment_fields[23];

                                                                                                                        }


                                                                                                                $moneyreceivedate = $payment_fields[25];
                                                                                                                $cargotripid=   $payment_fields[18];
                                                                                                                $unload_date = $payment_fields[19];






                                                                                                        if ($departdate!="")

                                                                                                             {  ///////////  If departure date is not blank..... Starts


                                                                                                                if ($receivebalancetk=="")   /////////  If receivebalancetaka is null ....... starts
                                                                                                                        {

                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$unload_date','$receivefrom')");        //,received_from    ,'$receivefrom'
                                                                                                                                                        }
                                                                                                                                                ///up to this .....ask miraj

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date','$receivefrom')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends


                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");
                                                                                                                                                        }

                                                                                                                                                 ///up to this .....ask miraj


                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                                                                                ///Backup started.......

                                                                                                                                                                $fp = popen ("/usr/bin/last | grep \"no logout\" ", "r");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends

                                                                                                                        }   ////////   If receive balance taka is null ..... Ends


                                                                                                                else   ///////// If receive balance taka is not blank starts
                                                                                                                        {

                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date')");
                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends



                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends


                                                                                                                        }  /////////  If receive balance is not blank ........ Ends

                                                                                                             }   // For deaparture date not blank.......  ends

                                                                                                        else
                                                                                                             {  ///////////  If departure date is  blank..... Starts


                                                                                                                if ($receivebalancetk=="")   /////////  If receivebalancetaka is null ....... starts
                                                                                                                        {

                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$unload_date','$receivefrom')");        //,received_from    ,'$receivefrom'
                                                                                                                                                        }
                                                                                                                                                ///up to this .....ask miraj

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date','$receivefrom')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends


                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");
                                                                                                                                                        }

                                                                                                                                                 ///up to this .....ask miraj


                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                                                                                ///Backup started.......

                                                                                                                                                                $fp = popen ("/usr/bin/last | grep \"no logout\" ", "r");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends

                                                                                                                        }   ////////   If receive balance taka is null ..... Ends


                                                                                                                else   ///////// If receive balance taka is not blank starts
                                                                                                                        {

                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date')");
                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends



                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends


                                                                                                                        }  /////////  If receive balance is not blank ........ Ends

                                                                                                             }   // For deaparture date is blank.......  ends


                                                                                                        }       // For quantityone is not zero or  blank...  ends






                                                                                                else
                                                                                                        {         //// For quantityone is blank or zero..... Starts

                                                                                                                print("Updating advance");
                                                                                                                $advance = $advance + $payamount;
                                                                                                                $balancetk = $totaltk - $advance;

                                                                                                                $partoradvance = "Advance";

                                                                                                                $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through')");


                                                                ///////////////////////////////////////////////////////////////////////
                                                                // To keep track the existing data of money receipt in cargo schedule
                                                                ////////////////////////////////////////////////////////////////////////

                                                                                                                $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");


                                                                                                                $payment_fields = pg_fetch_row($result,0);


                                                                                                                $receivedate=   $payment_fields[10];
                                                                                                                $owner_name=    $payment_fields[3];
                                                                                                                $ship_name=     $payment_fields[2];
                                                                                                                $fromloc=       $payment_fields[4];
                                                                                                                $toloc=         $payment_fields[5];
                                                                                                                $matone=        $payment_fields[6];
                                                                                                                $mattwo=        $payment_fields[7];
                                                                                                                $quantityone=   $payment_fields[8];
                                                                                                                $quantitytwo=   $payment_fields[9];
                                                                                                                $receivetkrate=     $payment_fields[24];
                                                                                                                $receiveadvance=    $payment_fields[20];
                                                                                                                $departdate=    $payment_fields[1];
                                                                                                                $receiveparttk=     $payment_fields[21];
                                                                                                                $receivetotaltk=    $payment_fields[22];

                                                                                                                if ($payment_fields[23]=="")
                                                                                                                        {
                                                                                                                                $receivebalancetk = "";
                                                                                                                        }

                                                                                                                else
                                                                                                                        {
                                                                                                                                $receivebalancetk=  $payment_fields[23];

                                                                                                                        }

                                                                                                                $receivefrom =   $payment_fields[26];
                                                                                                                $moneyreceivedate = $payment_fields[25];
                                                                                                                $cargotripid=   $payment_fields[18];
                                                                                                                $unload_date = $payment_fields[19];


                                                                                                         if ($departdate!="")

                                                                                                            {   ///////   If departure date is not blank...Starts

                                                                                                                if ($receivebalancetk=="")  ////////// If receive balance taka is null ..... Starts
                                                                                                                        {
                                                                                                                           if ($unload_date!="")

                                                                                                                             {  ///Checking unload date is not blank .. Starts

                                                                                                                                if ($moneyreceivedate!="")
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from,unload_date) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom','$unload_date')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");

                                                                                                                                        }

                                                                                                                                else
                                                                                                                                        {


                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,unload_date) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date')");

                                                                                                                                        }

                                                                                                                                } /// Checking unload date is not blank..Ends


                                                                                                                           else
                                                                                                                                {  ///Checking unload date is  blank .. Starts

                                                                                                                                   if ($moneyreceivedate!="")
                                                                                                                                           {

                                                                                                                                                   $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                   //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");

                                                                                                                                           }

                                                                                                                                   else
                                                                                                                                           {


                                                                                                                                                   $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                                                           }

                                                                                                                                   } /// Checking unload date is  blank..Ends


                                                                                                                        } ////////////   If receive balance taka is null ... Ends



                                                                                                                else
                                                                                                                        {     //////////  If receive balance taka is not null .... Starts in updating advance condition


                                                                                                                            if ($unload_date!="")

                                                                                                                              {  ///// Checking if unload date is not blank...Starts

                                                                                                                                if ($moneyreceivedate!="")
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,unload_date) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$unload_date')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        }

                                                                                                                                else
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");

                                                                                                                                        }

                                                                                                                              }  /////   checking unload date is not blank.. Ends


                                                                                                                           else
                                                                                                                              {  ///// Checking if unload date is blank...Starts

                                                                                                                                if ($moneyreceivedate!="")
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        }

                                                                                                                                else
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$departdate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                                                        }

                                                                                                                              }  /////   checking unload date is blank.. Ends

                                                                                                                        }  ////////////  If receive balance taka is not null .... Ends in updating advance condition


                                                                                                            } ///////  If derparture date is not blank... Ends


                                                                                                          else

                                                                                                            {   ///////   If departure date is blank...Starts

                                                                                                                if ($receivebalancetk=="")  ////////// If receive balance taka is null ..... Starts
                                                                                                                        {
                                                                                                                                if ($moneyreceivedate!="")
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");

                                                                                                                                        }

                                                                                                                                else
                                                                                                                                        {


                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                                                        }


                                                                                                                        } ////////////   If receive balance taka is null ... Ends



                                                                                                                else
                                                                                                                        {     //////////  If receive balance taka is not null .... Starts in updating advance condition

                                                                                                                                if ($moneyreceivedate!="")
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        }

                                                                                                                                else
                                                                                                                                        {

                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                                                        }

                                                                                                                        }  ////////////  If receive balance taka is not null .... Ends in updating advance condition


                                                                                                            } ///////  If derparture date is  blank... Ends


                                                                                                        }    // When updating advance(quantityone is zero or blank):::::::::::::: Condition Ends here



                                                                                        }        //************************END ADD IN CARGO FOR Carrying and CASH TYPE*************



                                                                        } //////////END OF CARRYING + CASH OPTION///////////////////////



                                                /////////////////////////////////////////////////////////////////////

                                                ////////////STARTING OF CARRYING + CHEQUE OPTION/////////////////////

                                                /////////////////////////////////////////////////////////////////////

                                                if ($paytype=="Cheque")
                                                        {

                                                                print ("Entered in $paytype\t");

                                                                //************************************For ADD IN PAYMENT VOUCHER & Cargo Schedule FOR CARRYING + CHEQUE*********************


                                                                //   $result = pg_exec("select *  from cargo_schedule where ship_id = $shipname and balance_tk!=0 and total_tk=0 order by schedule_id");

                                                                if ($shiptripid =="")

                                                                        {
                                                                                $shiptripid = 0;
                                                                        }

                                                                else
                                                                        {
                                                                                $shiptripid = $shiptripid ;
                                                                        }


                                                                $payserial = abs($payserial);

                                                                $result = pg_exec("select *  from cargo_schedule where ship_id = $shipname and trip_id=$shiptripid  ");    // previously there was another condition after balance,--- total_tk!=0

                                                                $cargo_numrows = pg_numrows($result);

                                                                if ($cargo_numrows==0)

                                                                        {         // cargonumrows zero starts ... fresh entry for a ship

                                                                                print("Not desired in cheque advance update....");

                                                                                $cargotrip =pg_exec("select max(trip_id) from cargo_schedule where ship_id=$shipname");

                                                                                $cargotripnumrows = pg_numrows($cargotrip);

                                                                                if ($cargotripnumrows==0)
                                                                                        {
                                                                                                $tripid =0;
                                                                                        }

                                                                                else
                                                                                        {
                                                                                                $cargotripid  =pg_fetch_row($cargotrip,0);
                                                                                                $tripid =  $cargotripid[0];

                                                                                        }

                                                                                $tripid = $tripid+1 ;


                                                                                if($departuredate!="")    //// This is inside the fresh entry option
                                                                                        {
                                                                                             //   print("\t$departuredate");
                                                                                                $partoradvance = "Part";

                                                                                                $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,departure_date,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bank_name','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$departuredate','$tkrate','$tripid','$partoradvance','$through')");

                                                                                        }

                                                                                else
                                                                                        {   //// If there is no departure date  (Inside the fresh Entry)

                                                                                                $partoradvance = "Advance";

                                                                                                $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through')");

                                                                                        }


                                                                                $balancetk = $balancetk - $payamount;
                                                                                $result = pg_exec($conn,"insert into cargo_schedule (pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,balance_tk,trip_id) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$tripid')");


                                                                        }    // cargo numrows zero condition ( Fresh entry ) ends



                                                                        //########## When the the condition for balance and total taka is not zero Starts........ Updating an Existing Entry ####################


                                                                else
                                                                        {

                                                                                $upresult = pg_fetch_row($result,0);

                                                                                $goodquantityone= $upresult[8];
                                                                                $goodquantitytwo= $upresult[9];

                                                                                $advance = $upresult [11];
                                                                                $parttk = $upresult[12];
                                                                                $scheduleid = $upresult[0];
                                                                                $cargotripid = $upresult [18];
                                                                           //     print("abc");
                                                                           //     print("Where totaltaka not zero........line 1636");


                                                                                $balancetk = $upresult [15];
                                                                                $totaltk = $upresult[14];



                                                                                if($goodquantityone!="" and $goodquantityone!=0)   //// previous condition $departuredate!=""

                                                                                        {       //################# For departure date not blank2 ############

                                                                                                $partoradvance = "Part";

                                                                                                $parttk = $parttk+$payamount;

                                                                                                $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through')");


                                                                                              //  print("\t$parttk");

                                                                                                $balancetk = $totaltk - ($parttk+$advance);

                                                                                              //  print("\t$balancetk");


                                                                                ///////////////////////////////////////////////////////////////////////
                                                                                // To keep track the existing data of money receipt in cargo schedule
                                                                                ////////////////////////////////////////////////////////////////////////

                                                                                $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");


                                                                                $payment_fields = pg_fetch_row($result,0);


                                                                                $receivedate=   $payment_fields[10];
                                                                                $owner_name=    $payment_fields[3];
                                                                                $ship_name=     $payment_fields[2];
                                                                                $fromloc=       $payment_fields[4];
                                                                                $toloc=         $payment_fields[5];
                                                                                $matone=        $payment_fields[6];
                                                                                $mattwo=        $payment_fields[7];
                                                                                $quantityone=   $payment_fields[8];
                                                                                $quantitytwo=   $payment_fields[9];
                                                                                $receiveadvance=    $payment_fields[20];
                                                                                //$departdate=    $payment_fields[1];
                                                                                $receiveparttk=     $payment_fields[21];
                                                                                $receivetotaltk=    $payment_fields[22];
                                                                                $receivebalancetk=  $payment_fields[23];
                                                                                $receivetkrate=     $payment_fields[24];

                                                                                if ($payment_fields[23]=="")
                                                                                        {
                                                                                                $receivebalancetk  = "";
                                                                                              //  print ("Receive balance is $receivebalancetk");

                                                                                        }

                                                                                else
                                                                                        {
                                                                                                $receivebalancetk=  $payment_fields[23];
                                                                                            //    print ("Receive balance is $receivebalancetk..line 1696");
                                                                                        }

                                                                                $moneyreceivedate = $payment_fields[25];
                                                                                $cargotripid=       $payment_fields[18];
                                                                                $unload_date =      $payment_fields[19];

                                                                                $receivefrom =      $payment_fields[26];

                                                                                if ($receivebalancetk=="")   ///////   If receive balance taka is null .... Starts
                                                                                        {

                                                                                                if ($unload_date!="")
                                                                                                        {  ///// Checking unload date is not blank


                                                                                                                if($moneyreceivedate !="")
                                                                                                                        {
                                                                                                                             //   print("we are in line 1714");
                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$unload_date','$receivefrom')");

                                                                                                                        }


                                                                                                                else
                                                                                                                        {
                                                                                                                             //   print("we are in line 1723");
                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date')");

                                                                                                                        }

                                                                                                        }  ///// Checking unload date is not blank Ends


                                                                                                else
                                                                                                        {  ///// Checking unload date is  blank


                                                                                                                if($moneyreceivedate !="")
                                                                                                                        {
                                                                                                                              //  print("we are in line 1736");

                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate')");

                                                                                                                        }


                                                                                                                else
                                                                                                                        {
                                                                                                                             //   print("we are in line 1746");
                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                                        }

                                                                                                        }  ///// Checking unload date is  blank Ends



                                                                                        }    ///////////    If receive balance taka is null ...... Ends


                                                                                else  ///////////     If receive balance taka is not null  ....... Starts

                                                                                        {
                                                                                                if ($unload_date!="")
                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                if($moneyreceivedate !="")
                                                                                                                        {

                                                                                                                                print ("we are in line 1765");

                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date','$receivefrom')");

                                                                                                                        }

                                                                                                                else
                                                                                                                        {
                                                                                                                                print ("we are in line 1773");

                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");



                                                                                                                        }

                                                                                                        }  ///// Checking unload date is not blank Ends



                                                                                                else
                                                                                                        {  ///// Checking unload date is  blank


                                                                                                                if($moneyreceivedate !="")

                                                                                                                        {
                                                                                                                                print ("we are in line 1792");
                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                        }


                                                                                                                else
                                                                                                                        {
                                                                                                                                print ("we are in line 1800");
                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                                        }

                                                                                                        }  ///// Checking unload date is  blank Ends



                                                                                        }    ///////////    If receive balance taka is not null ...... Ends




                                                                        }      // For deaparture date not blank2  ends


                                                                                else      // For deaparture date  blank3

                                                                                        {

                                                                                        print("Updating advance");
                                                                                        $advance = $advance + $payamount;
                                                                                        $balancetk = $totaltk - $advance;

                                                                                        $partoradvance = "Advance";
                                                                                        $payserial = abs($payserial);

                                                                                        $pay_add_result2 = pg_exec("insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through')");


                                                                                ///////////////////////////////////////////////////////////////////////
                                                                                // To keep track the existing data of money receipt in cargo schedule
                                                                                ////////////////////////////////////////////////////////////////////////


                                                                                $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                                                                                $payment_fields = pg_fetch_row($result,0);


                                                                                $receivedate=   $payment_fields[10];
                                                                                $owner_name=    $payment_fields[3];
                                                                                $ship_name=     $payment_fields[2];
                                                                                $fromloc=       $payment_fields[4];
                                                                                $toloc=         $payment_fields[5];
                                                                                $matone=        $payment_fields[6];
                                                                                $mattwo=        $payment_fields[7];
                                                                                $quantityone=   $payment_fields[8];
                                                                                $quantitytwo=   $payment_fields[9];
                                                                                $receivetkrate=     $payment_fields[24];
                                                                                $receiveadvance=    $payment_fields[20];
                                                                                $departdate=    $payment_fields[1];
                                                                                $receiveparttk=     $payment_fields[21];
                                                                                $receivetotaltk=    $payment_fields[22];
                                                                                $receivebalancetk=    $payment_fields[22];


                                                                                if ($payment_fields[23]=="")
                                                                                        {
                                                                                                $receivebalancetk="";
                                                                                        }
                                                                                else
                                                                                        {
                                                                                                $receivebalancetk=$payment_fields[23];
                                                                                        }

                                                                                $moneyreceivedate = $payment_fields[25];
                                                                                $cargotripid=   $payment_fields[18];
                                                                                $unload_date = $payment_fields[19];

                                                                                $receivefrom = $payment_fields[26];



                                                                                if ($receivebalancetk=="")   ///////// If receivebalance taka is null .... Starts (in updating advance)
                                                                                        {
                                                                                                /////// Probably we don't need this part because if receive balance is null then there cannot be a money receive date

                                                                                                print ("Shouldn't enter if receivebalance is not null");

                                                                                                if ($moneyreceivedate!="")
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate')");

                                                                                                        }

                                                                                                        ///up to this part




                                                                                                else
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk')");

                                                                                                        }


                                                                                        }   ///////   If receive balance taka is null ... Ends



                                                                                else
                                                                                        {  /////  If receive balance taka is not null in updating advance...... Starts

                                                                                                if ($moneyreceivedate!="")
                                                                                                        {
                                                                                                                print ("we are in line 1897");
                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");


                                                                                                        }


                                                                                                //// Probably we don't need this part because if receive balance is not null then there must be money receive date  ....ask miraj


                                                                                                else
                                                                                                        {
                                                                                                                print("we are in line 1909");

                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk')");

                                                                                                        }
                                                                                                   ///up to this part


                                                                                        }   ///////   If receive balance taka is not null ... Ends  (in updating advance)




                                                                        }    // When updating advance:::::::::::::: Condition Ends here



                                                        }        //************************END ADD IN CARGO FOR Carrying and CHEQUE TYPE*************

                                                        //////////END OF CARRYING + CHEQUE OPTION///////////////////////

                                                      //************************END ADD IN PAYMENT VOUCHER AND CARGO FOR CHEQUE TYPE*************////////////
                                        }



                                $result = pg_exec("select * from view_payment_carrying");
                                $numrows=pg_numrows($result);
                                $row = pg_fetch_row($result,$numrows-1);

                                $voucherid = $row[0];
	                        $voucherdate = $row[1];
	                        $payserial = $row[2];
                                $clientname = $row[3];
                                $shipname = $row[5];
                                $fromloc = $row[7];
                                $toloc = $row[9];
	                        $matone = $row[11];
	                        $mattwo = $row[13];

                                $accountname = $row[4];
                                $nameofship = $row[6];
                                $shipname = $row[5];
                                $fromlocname = $row[8];
                                $tolocname = $row[10];
                                $fromloc = $row[7];
                                $matonename = $row[12];
                                $mattwoname = $row[14];


                                $amount = $row[15];
	                        $paytype = $row[16];
	                        $bankname = $row[17];
                                $bankbranch = $row[18];
	                        $chequeno = $row[19];
	                        $chequepaydate = $row[20];
	                        $comment = $row[21];
                                $tkrate = $row[23];

                                $gotocheck = $numrows;



                        }    ///end of actual work


      ////************************************************************************//////////////

      ///////////////*********STARTING PURCHASE OPTION***************************///////////////

      //////////////************************************************************////////////////

        if($radiotest=="purchase")
                {

                   $car_pur_off = "Purchase";
                   $payamount = abs($payamount);

                   print ("Entered in Purchase option ");




                        ///////////////////////////////////////////////////////////////////////////////////////////

                        ///////////////*********STARTING PURCHASE + CHEQUE OPTION*****************/////////////////

                        ///////////////////////////////////////////////////////////////////////////////////////////

                        if ($paytype=="Cheque")
                                {

                                        print ("Entered in $paytype\t");

                                        //************************************For ADD IN PAYMENT VOUCHER & Purchase_Sale  Schedule FOR Purchase + CHEQUE*********************


                                        //   $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname and balance_tk!=0 and total_tk=0 order by schedule_id");

                                        if ($shiptripid =="")
                                                {
                                                        $shiptripid = 0;
                                                }

                                        else
                                                {
                                                        $shiptripid = $shiptripid ;
                                                }


                                        $payserial = abs($payserial);

                                        $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname  and trip_id=$shiptripid  ");

                                        $cargo_numrows = pg_numrows($result);

                                        if ($cargo_numrows==0)
                                                {         // cargonumrows zero starts ... fresh entry for a ship

                                                        print("Not cheque advance update.... Fresh Entry..line2042");

                                                        $cargotrip =pg_exec("select max(trip_id) from purchase_sale_schedule where ship_id=$shipname");

                                                        $cargotripnumrows = pg_numrows($cargotrip);

                                                        if ($cargotripnumrows==0)
                                                                {
                                                                        $tripid =0;
                                                                }

                                                        else
                                                                {
                                                                        $cargotripid  =pg_fetch_row($cargotrip,0);
                                                                        $tripid =  $cargotripid[0];

                                                                }

                                                        $tripid = $tripid+1 ;


                                                        if($purchase_goodquantityone!="" or $purchase_goodquantityone!=0)    //// This is inside the fresh entry option ...this "purchase_goodquantityone" is returned from view_purchase_cargo form
                                                                {
                                                                        print("\t$purchase_goodquantityone");
                                                                        $partoradvance = "Part";

                                                                        $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bank_name','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance')");

                                                                }

                                                        else
                                                                {   //// If there is no departure date  (Inside the fresh Entry)

                                                                        $partoradvance = "Advance";

                                                                        $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance')");

                                                                }


                                                         $balancetk = $balancetk - $payamount;
                                                         $result = pg_exec($conn,"insert into purchase_sale_schedule (paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,balance_tk,trip_id) values('$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$tripid')");


                                                }    // cargo numrows zero condition ( Fresh entry ) ends


                                                //########## When the the condition for balance and total taka is not zero ####################

                                        else
                                                {
                                                        $upresult = pg_fetch_row($result,0);


                                                        $scheduleid = $upresult[0];
                                                        $goodquantityone= $upresult[7];
                                                        $goodquantitytwo= $upresult[8];
                                                        $advance = $upresult [9];
                                                        $parttk = $upresult[10];
                                                        $cargotripid = $upresult [14];
                                                        print("quantityone-'$goodquantityone'");
                                                        print("Where totaltaka not zero,quantitytwo-'$goodquantitytwo'");

                                                        $balancetk = $upresult [12];
                                                        $totaltk = $upresult[11];


                                                        if($purchase_goodquantityone!="" or $purchase_goodquantityone!=0)
                                                                {       //################# For deaparture date not blank2 ############

                                                                        $partoradvance = "Part";

                                                                        $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");

                                                                        $parttk = $parttk+$payamount;

                                                                        print("\t$parttk");

                                                                        $totaltk = (abs($goodquantityone)+abs($goodquantitytwo))  *  abs($tkrate) ;

                                                                        print("\t$totaltk");

                                                                        $balancetk = $totaltk - ($parttk+$advance); print("\t$balancetk");


                                          ////////////////////////////////////////////////////////////////////////
                                          // To keep track the existing data of money receipt in purchase sale schedule //
                                          ////////////////////////////////////////////////////////////////////////


                                                                        $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");


                                                                        $payment_fields = pg_fetch_row($result,0);


                                                              //          $receivedate=   $payment_fields[10];
                                                              //          $owner_name=    $payment_fields[3];
                                                                        $ship_name=     $payment_fields[1];
                                                                        $fromloc=       $payment_fields[3];
                                                                        $toloc=         $payment_fields[4];
                                                                        $matone=        $payment_fields[5];
                                                                        $mattwo=        $payment_fields[6];
                                                                        $quantityone=   $payment_fields[7];
                                                                        $quantitytwo=   $payment_fields[8];
                                                                        $receivetkrate=     $payment_fields[20];
                                                                        $receiveadvance=    $payment_fields[15];
                                                                        //$departdate=    $payment_fields[1];
                                                                        $receiveparttk=     $payment_fields[16];
                                                                        $receivetotaltk=    $payment_fields[17];
                                                                        $cargotripid=   $payment_fields[14];
                                                                        $receivefrom =   $payment_fields[19];

                                                                        if ($payment_fields[18]=="")
                                                                                {
                                                                                        $receivebalancetk = "";
                                                                                }


                                                                        else
                                                                                {

                                                                                        $receivebalancetk=  $payment_fields[18];

                                                                                }


                                                                 //       $moneyreceivedate = $payment_fields[25];

                                                                 //       $unload_date = $payment_fields[19];


                                                                        if ($receivebalancetk=="")   /////////  If receivebalancetaka is null ....... starts
                                                                                {

                                                                                /*        if ($unload_date!="")
                                                                                                {  ///// Checking unload date is not blank

                                                                                                        ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                        if($moneyreceivedate !="")
                                                                                                                {

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$unload_date','$receivefrom')");        //,received_from    ,'$receivefrom'
                                                                                                                }
                                                                                                        ///up to this .....ask miraj

                                                                                                        else
                                                                                                                {

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date','$receivefrom')");

                                                                                                                }

                                                                                                }  ///// Checking unload date is not blank Ends


                                                                                        else
                                                                                                {  ///// Checking unload date is  blank

                                                                                                        ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                        if($moneyreceivedate !="")
                                                                                                                {

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");
                                                                                                                }

                                                                                                         ///up to this .....ask miraj

                                                                                      */

                                                                                       //                 else
                                                                                       //                         {
                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivefrom')");
                                                                                       //

                                                                                      //                          }

                                                                                      //          }  ///// Checking unload date is  blank Ends

                                                                                }   ////////   If receive balance taka is null ..... Ends



                                                                        else   ///////// If receive balance taka is not blank starts
                                                                                {

                                                                                 /*

                                                                                        if ($unload_date!="")
                                                                                                {  ///// Checking unload date is not blank

                                                                                                        if($moneyreceivedate !="")
                                                                                                                {
                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date')");
                                                                                                                }

                                                                                                        else
                                                                                                                {

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");

                                                                                                                }

                                                                                                }  ///// Checking unload date is not blank Ends



                                                                                        else
                                                                                                {  ///// Checking unload date is  blank

                                                                                                        if($moneyreceivedate !="")
                                                                                                                {

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                }

                                                                                                        else
                                                                                                                {
                                                                                    */

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                    //                            }

                                                                                   //            }  ///// Checking unload date is  blank Ends


                                                                                }  /////////  If receive balance is not blank ........ Ends


                                                                }        // For deaparture date not blank2  ends


                                                        else
                                                                {         //// For deaparture date (purchase_goodquantityone) blank3

                                                                        print("Updating advance");
                                                                        $advance = $advance + $payamount;
                                                                        $balancetk = $totaltk - $advance;

                                                                        $partoradvance = "Advance";

                                                                        $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");


                                                         ///////////////////////////////////////////////////////////////////////
                                                         // To keep track the existing data of money receipt in purchase sale schedule
                                                         ////////////////////////////////////////////////////////////////////////

                                                                        $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");


                                                                        $payment_fields = pg_fetch_row($result,0);


                                                              //          $receivedate=   $payment_fields[10];
                                                              //          $owner_name=    $payment_fields[3];
                                                              //          $departdate=    $payment_fields[1];
                                                             //           $moneyreceivedate = $payment_fields[25];
                                                             //           $unload_date = $payment_fields[19];
                                                                        $ship_name=     $payment_fields[1];
                                                                        $fromloc=       $payment_fields[3];
                                                                        $toloc=         $payment_fields[4];
                                                                        $matone=        $payment_fields[5];
                                                                        $mattwo=        $payment_fields[6];
                                                                        $quantityone=   $payment_fields[7];
                                                                        $quantitytwo=   $payment_fields[8];
                                                                        $receivetkrate=     $payment_fields[20];
                                                                        $receiveadvance=    $payment_fields[15];

                                                                        $receiveparttk=     $payment_fields[16];
                                                                        $receivetotaltk=    $payment_fields[17];

                                                                        if ($payment_fields[18]=="")
                                                                                {
                                                                                        $receivebalancetk = "";
                                                                                }

                                                                        else
                                                                                {
                                                                                        $receivebalancetk=  $payment_fields[18];

                                                                                }

                                                                        $receivefrom =   $payment_fields[19];

                                                                        $cargotripid=   $payment_fields[14];



                                                                        if ($receivebalancetk=="")  ////////// If receive balance taka is null ..... Starts
                                                                                {

                                                                                  /*
                                                                                        if ($moneyreceivedate!="")
                                                                                                {

                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");

                                                                                                        //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into cargo_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");

                                                                                                }

                                                                                        else
                                                                                                {

                                                                                    */
                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivefrom')");

                                                                                     //           }


                                                                                } ////////////   If receive balance taka is null ... Ends



                                                                        else
                                                                                 {     //////////  If receive balance taka is not null .... Starts in updating advance condition

                                                                                     /*           if ($moneyreceivedate!="")
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into cargo_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                        }

                                                                                                else
                                                                                                        {
                                                                                       */
                                                                                                                $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                       //                 }


                                                                                  }  ////////////  If receive balance taka is not null .... Ends in updating advance condition



                                                                }    // When updating advance:::::::::::::: Condition Ends here



                                                }        //************************END ADD IN Purchase_Sale_schedule FOR Purchase and Cheque TYPE*************


                                }     ////////  End Of Purchase + Cheque option



                        //////////////////////////////////////////////////////////////////////////////////////////////////

                        /////////////////////*********STARTING PURCHASE + CASH OPTION *****************///////////////////

                        //////////////////////////////////////////////////////////////////////////////////////////////////

                        if ($paytype=="Cash")
                                {


                                                       print($paytype) ;


                                                       //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                       //************************************For ADD IN PAYMENT VOUCHER & Cargo Schedule When "Purchase" And "Cash" *********************

                                                       //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



                                                       if ($shiptripid =="")
                                                               {
                                                                       $shiptripid = 0;
                                                               }

                                                       else
                                                               {
                                                                       $shiptripid = $shiptripid ;
                                                               }

                                                       print ("$shiptripid");

                                                       $payserial = abs($payserial);

                                                       $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname  and trip_id=$shiptripid  order by pur_sale_schedule_id");    // previously there was another condition after balance,--- total_tk!=0   and balance_tk!=0

                                                       $cargo_numrows = pg_numrows($result);

                                                       if ($cargo_numrows==0)
                                                               {         // cargonumrows zero starts ... fresh entry for a ship

                                                                       print("Not Purchase advance update.... fresh purchase entry");

                                                                       $cargotrip =pg_exec("select max(trip_id) from purchase_sale_schedule where ship_id=$shipname");
                                                                       $cargotripnumrows = pg_numrows($cargotrip);

                                                                       if($cargotripnumrows==0)
                                                                               {
                                                                                       $tripid =0;
                                                                               }

                                                                       else
                                                                               {
                                                                                       $cargotripid  =pg_fetch_row($cargotrip,0);
                                                                                       $tripid =  $cargotripid[0];

                                                                               }

                                                                       $tripid = $tripid+1 ;



                                                                       if($purchase_goodquantityone!="" or $purchase_goodquantityone!=0)    //// This is inside the fresh entry option
                                                                               {

                                                                                       $partoradvance = "Part";

                                                                                       $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,matone_id,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance')");

                                                                               }

                                                                       else
                                                                               {   //// If there is no departure date(purchase_goodquantityone....comes from view_purchase_cargo file )  (Inside the fresh Entry)

                                                                                       $partoradvance = "Advance";

                                                                                       $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance')");

                                                                               }


                                                                       $balancetk = $balancetk - $payamount;

                                                                       $result = pg_exec($conn,"insert into purchase_sale_schedule (paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,balance_tk,trip_id) values('$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$tripid')");


                                                               }    // cargo numrows zero condition ( Fresh entry ) ends


                                                               //########## When the the condition for balance and total taka is not zero ####################

                                                       else
                                                               {
                                                                       $upresult = pg_fetch_row($result,0);


                                                                       $scheduleid = $upresult[0];
                                                                       $goodquantityone= $upresult[7];
                                                                       $goodquantitytwo= $upresult[8];
                                                                       $advance = $upresult [9];
                                                                       $parttk = $upresult[10];
                                                                       $cargotripid = $upresult [14];
                                                                       print("abc-'$goodquantityone'");
                                                                       print("Where totaltaka not zero-'$goodquantitytwo'");

                                                                       $balancetk = $upresult [12];
                                                                       $totaltk = $upresult[11];

                                                                       if($purchase_goodquantityone!=0 or $purchase_goodquantityone!="")    //////   previously there was departuredate

                                                                               {       //################# For deaparture goodquantityone not blank2 ############

                                                                                       $partoradvance = "Part";

                                                                                       $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");

                                                                                       $parttk = $parttk+$payamount;

                                                                                       print("\t$parttk");

                                                                                       $totaltk = (abs($goodquantityone)+abs($goodquantitytwo))  *  abs($tkrate) ;

                                                                                       print("\t$totaltk");

                                                                                       $balancetk = $totaltk - ($parttk+$advance); print("\t$balancetk");



                                                                                        ////////////////////////////////////////////////////////////////////////
                                                                                        // To keep track the existing data of money receipt in purchase sale schedule //
                                                                                        ////////////////////////////////////////////////////////////////////////



                                                                                       ////probably we don't need this query...because already we got that record....ask miraj

                                                                                       $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");


                                                                                       $payment_fields = pg_fetch_row($result,0);


                                                                                      // $receivedate=   $payment_fields[10];
                                                                                      // $paidto_id=    $payment_fields[2];
                                                                                       $ship_name=     $payment_fields[1];
                                                                                       $fromloc=       $payment_fields[3];
                                                                                       $toloc=         $payment_fields[4];
                                                                                       $matone=        $payment_fields[5];
                                                                                       $mattwo=        $payment_fields[6];
                                                                                       $quantityone=   $payment_fields[7];
                                                                                       $quantitytwo=   $payment_fields[8];
                                                                                       $receivetkrate=     $payment_fields[20];
                                                                                       $cargotripid=   $payment_fields[14];
                                                                                       $receiveadvance=    $payment_fields[15];
                                                                                       //$departdate=    $payment_fields[1];
                                                                                       $receiveparttk=     $payment_fields[16];
                                                                                       $receivetotaltk=    $payment_fields[17];

                                                                                       $receivefrom =   $payment_fields[19];

                                                                                       if ($payment_fields[18]=="")
                                                                                               {
                                                                                                       $receivebalancetk = "";
                                                                                               }


                                                                                       else
                                                                                               {

                                                                                                       $receivebalancetk=  $payment_fields[18];

                                                                                               }


                                                                                //       $moneyreceivedate = $payment_fields[25];

                                                                               //        $unload_date = $payment_fields[19];

                                                                                       if ($receivebalancetk=="")   /////////  If receivebalancetaka is null ....... starts
                                                                                               {

                                                                                              /*         if ($unload_date!="")
                                                                                                               {  ///// Checking unload date is not blank

                                                                                                                       ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                       if($moneyreceivedate !="")
                                                                                                                               {

                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$unload_date','$receivefrom')");        //,received_from    ,'$receivefrom'
                                                                                                                               }
                                                                                                                       ///up to this .....ask miraj

                                                                                                                       else
                                                                                                                               {
                                                                                                */

                                                                                                        //                               $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,unload_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$unload_date','$receivefrom')");

                                                                                                 //                              }



                                                                                                   //            }  ///// Checking unload date is not blank Ends


                                                                                                  /*     else
                                                                                                               {  ///// Checking unload date is  blank

                                                                                                                       ////probably we don't need this part because if receivebalance is null then there cannot be a mony receipt date


                                                                                                                       if($moneyreceivedate !="")
                                                                                                                               {

                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");
                                                                                                                               }

                                                                                                                        ///up to this .....ask miraj


                                                                                                                       else
                                                                                                                               {
                                                                                                    */

                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivefrom')");

                                                                                                     //                          }


                                                                                                    //           }  ///// Checking unload date is  blank Ends

                                                                                               }   ////////   If receive balance taka is null ..... Ends


                                                                                       else   ///////// If receive balance taka is not blank starts
                                                                                               {

                                                                                                 //      if ($unload_date!="")
                                                                                                 //              {  ///// Checking unload date is not blank

                                                                                                                 /*      if($moneyreceivedate !="")
                                                                                                                               {
                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date')");
                                                                                                                               }

                                                                                                                       else
                                                                                                                               {
                                                                                                                   */
                                                                                                                    //                   $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date')");

                                                                                                                   //            }

                                                                                                  //             }  ///// Checking unload date is not blank Ends



                                                                                                 //      else
                                                                                                 //              {  ///// Checking unload date is  blank

                                                                                                             /*          if($moneyreceivedate !="")
                                                                                                                               {

                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,departure_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                               }

                                                                                                                       else
                                                                                                                               {
                                                                                                               */
                                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                                                //               }

                                                                                                 //              }  ///// Checking unload date is  blank Ends


                                                                                               }  /////////  If receive balance is not blank ........ Ends




                                                                               }      // For goodquantityone (deaparture date) not blank2  ends






                                                                       else
                                                                               {         //// For goodquantityone (deaparture date)  blank3

                                                                                       print("Updating advance");
                                                                                       $advance = $advance + $payamount;
                                                                                       $balancetk = $totaltk - $advance;

                                                                                       $partoradvance = "Advance";

                                                                                       $pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");


                                       ///////////////////////////////////////////////////////////////////////
                                       // To keep track the existing data of money receipt in cargo schedule
                                       ////////////////////////////////////////////////////////////////////////

                                                                                       $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");


                                                                                       $payment_fields = pg_fetch_row($result,0);


                                                                                 //    $receivedate=   $payment_fields[10];
                                                                                 //      $paidto_id=    $payment_fields[2];
                                                                                       $ship_name=     $payment_fields[1];
                                                                                       $fromloc=       $payment_fields[3];
                                                                                       $toloc=         $payment_fields[4];
                                                                                       $matone=        $payment_fields[5];
                                                                                       $mattwo=        $payment_fields[6];
                                                                                       $quantityone=   $payment_fields[7];
                                                                                       $quantitytwo=   $payment_fields[8];
                                                                                       $receivetkrate=     $payment_fields[20];
                                                                                       $receiveadvance=    $payment_fields[15];
                                                                               //        $departdate=    $payment_fields[1];
                                                                                       $receiveparttk=     $payment_fields[16];
                                                                                       $receivetotaltk=    $payment_fields[17];

                                                                                       if ($payment_fields[18]=="")
                                                                                               {
                                                                                                       $receivebalancetk = "";
                                                                                               }

                                                                                       else
                                                                                               {
                                                                                                       $receivebalancetk=  $payment_fields[18];

                                                                                               }

                                                                                       $receivefrom =   $payment_fields[19];
                                                                               //        $moneyreceivedate = $payment_fields[25];
                                                                                       $cargotripid=   $payment_fields[14];
                                                                                   //  $unload_date = $payment_fields[19];




                                                                                       if ($receivebalancetk=="")  ////////// If receive balance taka is null ..... Starts
                                                                                               {
                                                                                                    /*   if ($moneyreceivedate!="")
                                                                                                               {

                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$moneyreceivedate','$receivefrom')");

                                                                                                                       //  $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");

                                                                                                               }

                                                                                                       else
                                                                                                               {
                                                                                                     */


                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivefrom')");

                                                                                                    //           }


                                                                                               } ////////////   If receive balance taka is null ... Ends



                                                                                       else
                                                                                               {     //////////  If receive balance taka is not null .... Starts in updating advance condition

                                                                                                   /*    if ($moneyreceivedate!="")
                                                                                                               {

                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                       //  $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                               }

                                                                                                       else
                                                                                                             {
                                                                                                   */

                                                                                                                       $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                                     //        }

                                                                                               }  ////////////  If receive balance taka is not null .... Ends in updating advance condition


                                                                               }    // When updating advance:::::::::::::: Condition Ends here



                                                               }        //************************END ADD IN Purchase_Sale_Schedule FOR purchase and CASH TYPE*************


                                }  /////////  End Of Purchase + Cash Option




                        $result = pg_exec("select * from view_payment_purchase");
                        $numrows=pg_numrows($result);
                        $row = pg_fetch_row($result,$numrows-1);

                        $voucherid = $row[0];
                        $voucherdate = $row[1];
                        $payserial = $row[2];
                        $clientname = $row[3];
                        $shipname = $row[5];
                        $fromloc = $row[7];
                        $toloc = $row[9];
                        $matone = $row[11];
                        $mattwo = $row[13];

                        $accountname = $row[4];
                        $nameofship = $row[6];
                        $fromlocname = $row[8];
                        $tolocname = $row[10];
                        $fromloc = $row[7];
                        $matonename = $row[12];
                        $mattwoname = $row[14];


                        $amount = $row[15];
                        $paytype = $row[16];
                        $bankname = $row[17];
                        $bankbranch = $row[18];
                        $chequeno = $row[19];
                        $chequepaydate = $row[20];
                        $comment = $row[21];
                        $tkrate = $row[23];


                        $gotocheck = $numrows;



                }               /////////////*****************END OF PURCHASE OPTION *****************///////////////






        ////////////////////////////////////////////////////////////////////////////////////////////

        ////////////**********************START OF OFFICIAL OPTION *****************///////////////


        ///////////////////////////////////////////////////////////////////////////////////////////



                if($radiotest=="official")
                        {

                                $car_pur_off="official";

                                ///////////*******************START OF OFFICIAL + CHEQUE OPTION ***********///////////////
                                print("Add Check in $car_pur_off");
                             //   $voucherdate = date("Ymd");
                             //   print("$voucherdate");

                                if ($paytype=="Cheque")
                                        {

                                                print("Official&Cheque");
                                                $result = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,amount,account_id,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno,off_accountname) values('$voucherdate','$payamount','$clientname','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno','$expensetype')");

                                        }


                                ///////////*******************START OF OFFICIAL + CASH OPTION ***********///////////////


                                if ($paytype=="Cash")
                                        {

                                                print("official&Cash");
                                                print("$voucherdate");


                                                    ////////////////query for voucherno///////////////////////////

                                                    $year = date ("Y");
                                                    $month = date("m") ;
                                                    $vounumrows = 0;
                                                    $vouresult = pg_exec("select max(voucher_no) from payment_voucher where ((date_part('year',pay_voucher_date)=$year) and (date_part('month',pay_voucher_date)=$month) ) ");   //
                                                    $vounumrows = pg_numrows($vouresult);

                                                    if ($vounumrows!=0)
                                                            {
                                                                    $testrow = pg_fetch_row($vouresult,0);
                                                                    $miraj = $testrow[0];

                                                            }

                                                    print($vounumrows);

                                                    print($miraj);
                                                    //$row = pg_fetch_row($result,0);
                                                    //$voucherid = $row[0];

                                                    if ($miraj=="")
                                                            {
                                                                    print("miraj");
                                                                    $voucherno = date("Y");

                                                                    $voucherno .= date("m");
                                                                    $voucherno .="001";
                                                                    $voucherno =abs($voucherno);
                                                                    $payserial = $voucherno;

                                                            }

                                                    else
                                                            {
                                                                    $vourow = pg_fetch_row($vouresult,0);
                                                                    print("shamimmiraj");
                                                                    $voucherno = abs($vourow[0]);
                                                                    $voucherno = abs($voucherno);
                                                                    $voucherno = $voucherno+1;
                                                                    $payserial = $voucherno;
                                                            }


                                                    ////////////////end of query for voucherno///////////////////////////






                                                $result = pg_exec("insert into payment_voucher (pay_voucher_date,amount,account_id,pay_type,voucher_no,comment,car_pur_off,off_accountname) values('$voucherdate','$payamount','$clientname','$paytype','$payserial','$comment','$car_pur_off','$expensetype')");

                                        }


                                $result = pg_exec("select * from view_payment_official");
                                $numrows=pg_numrows($result);
                                $row = pg_fetch_row($result,$numrows-1);

                                $voucherid = $row[0];
                                $voucherdate = $row[1];
                                $payserial = $row[2];
                                $clientname = $row[3];
                                $accountname = $row[4];
                                $amount = $row[5];
                                $paytype = $row[6];
                                $bankname = $row[7];
                                $bankbranch = $row[8];
                                $chequeno = $row[9];
                                $chequepaydate = $row[10];
                                $expensetype = $row[11];
                                $comment = $row[13];

                                $gotocheck = $numrows;



                        }        //////////////******************** END OF OFFICIAL OPTION *****************///////////////////




                }/////added by me to check duplicate record,,,its the end of else....



        }




//////*****************************************************************************************************////
////************************* Starting EDIT BUTTON ****************************************************//////
//////**************************** FOR EDIT BUTTON  ***************************************************//////


if ($filling == "editbutton")
        {

	        $result = pg_exec("select * from payment_voucher order by voucher_id");

	        $numrows=pg_numrows($result);
                ///////////************************* START OF EDIT + NORMAL OPTION *****************/////////////////

                if ($radiotest=="normal")
                        {
                                $car_pur_off ="Carrying";
	                        $result = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');  insert into payment_voucher (voucher_id,pay_voucher_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno) values('$voucherid','$voucherdate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno')");
                        }

                ///////////************************* START OF EDIT + PURCHASE OPTION *****************/////////////////

                if ($radiotest=="purchase")
                        {
                                $car_pur_off ="Purchase";
	                        $result = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,amount,account_id,from_id,to_id,mat_one,mat_two,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno) values('$voucherid','$voucherdate','$payamount','$clientname','$fromloc','$toloc','$matone','$mattwo','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno')");
                        }

                ///////////************************* START OF EDIT + OFFICIAL OPTION *****************/////////////////

                if ($radiotest=="official")
                        {
                                $car_pur_off ="Official";
	                        $result = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');  insert into payment_voucher (voucher_id,pay_voucher_date,amount,account_id,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno,off_accountname) values('$voucherid','$voucherdate','$payamount','$clientname','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno','$expensetype')");
                        }

	        $result = pg_exec("select * from payment_voucher order by voucher_id");

		$numrows=pg_numrows($result);
                                                           //////////////???????????????????has not been corrected the edit option
	        $row = pg_fetch_row($result,$gotocheck-1);

	        $voucherid = $row[0];
	        $voucherdate = $row[1];
	        $amount = $row[2];
	        $clientname = $row[3];
	        $paytype = $row[9];
	        $payserial = $row[13];
	        $comment = $row[16];
	        $chequeno = $row[18];
	        $bankname = $row[10];
	        $bankbranch = $row[11];//upto this all are common

        	$shipname = $row[4];
	        $fromloc = $row[5];
	        $toloc = $row[6];
	        $matone = $row[7];
	        $mattwo = $row[8];
	        $chequepaydate = $row[12];
	        $paylocation = $row[14];
	        $expensetype = $row[19];
        }

 ///////////////////////////////////////////////////////////////////////

/**************************** FOR DELETE BUTTON  *********************/

//////////////////////////////////////////////////////////////////////

if ($filling == "deletebutton")
        {

		$result = pg_exec("select * from payment_voucher order by voucher_id");

		$numrows=pg_numrows($result);

		$result = pg_exec($conn,"DELETE  FROM payment_voucher WHERE (voucher_id = '$voucherid')");

                if($radiotest=="normal")
                        {
                                $result = pg_exec("select * from view_payment_carrying");

                                $numrows=pg_numrows($result);

                                if ($numrows==0)
                                        {
                                                $row[0]=0;
                                                $row[1]="";
                                                $voucherid = 0;

                                        }
                                else
                                        {


                                               if ($gotocheck > $numrows)
                                                       {
                                                                $gotocheck = $numrows;

                 	                               }
                                               else
                 	                               {
                                                              // $gotocheck = ($gotocheck-1);
                 	                               }

                                               $row = pg_fetch_row($result,$gotocheck-1);

                                               $voucherid = $row[0];
                                               $voucherdate = $row[1];
                                               $payserial = $row[2];
                                               $clientname = $row[3];
                                               $shipname = $row[5];
                                               $fromloc = $row[7];
                                               $toloc = $row[9];
                                               $matone = $row[11];
                                               $mattwo = $row[13];

                                               $accountname = $row[4];
                                               $nameofship = $row[6];
                                               $shipname = $row[5];
                                               $fromlocname = $row[8];
                                               $tolocname = $row[10];
                                               $fromloc = $row[7];
                                               $matonename = $row[12];
                                               $mattwoname = $row[14];

                                               $amount = $row[15];
                                               $paytype = $row[16];
                                               $bankname = $row[17];
                                               $bankbranch = $row[18];
                                               $chequeno = $row[19];
                                               $chequepaydate = $row[20];
                                               $comment = $row[21];
                                               $tkrate = $row[23];
                                               $departuredate = $row[25];

                                               //$gotocheck = $numrows;
                                        }


                        }



                if($radiotest=="purchase")
                        {

                                $result = pg_exec("select * from view_payment_purchase");
                                $numrows=pg_numrows($result);

                                if ($numrows==0)
                                        {
                                                $row[0]=0;
                                                $row[1]="";
                                                $voucherid = 0;

                                        }
                                else
                                        {

                                                if ($gotocheck < $numrows)
                                                        {
                       	                                        //$gotocheck = ($gotocheck+1);

                       	                                }
                                                else
                       	                                {
                                                                $gotocheck = ($gotocheck-1);
                       	                                }

                                                $row = pg_fetch_row($result,$gotocheck-1);

                                                $voucherid = $row[0];
                                                $voucherdate = $row[1];
                                                $payserial = $row[2];
                                                $clientname = $row[3];
                                                $shipname = $row[5];
                                                $fromloc = $row[7];
                                                $toloc = $row[9];
                                                $matone = $row[11];
                                                $mattwo = $row[13];

                                                $accountname = $row[4];    // for ny problem change it to accountname
                                                $nameofship = $row[6];
                                                $fromlocname = $row[8];
                                                $tolocname = $row[10];
                                                $fromloc = $row[7];
                                                $matonename = $row[12];
                                                $mattwoname = $row[14];


                                                $amount = $row[15];
                                                $paytype = $row[16];
                                                $bankname = $row[17];
                                                $bankbranch = $row[18];
                                                $chequeno = $row[19];
                                                $chequepaydate = $row[20];
                                                $comment = $row[22];
                                                $tkrate = $row[23];


                                                //$gotocheck = $numrows;
                                        }


                        }


                if($radiotest=="official")
                        {

                                $result = pg_exec("select * from view_payment_official");
                                $numrows=pg_numrows($result);

                                if ($numrows==0)
                                        {
                                                $row[0]=0;
                                                $row[1]="";
                                                $voucherid = 0;

                                        }
                                else
                                        {



                                                if ($gotocheck > $numrows)
                                                        {
               	                                                $gotocheck = $numrows;

               	                                        }
                                                else
               	                                        {
                                                               // $gotocheck = ($gotocheck-1);
               	                                        }

                                                $row = pg_fetch_row($result,$gotocheck-1);

                                                $voucherid = $row[0];
                                                $voucherdate = $row[1];
                                                $payserial = $row[2];
                                                $clientname = $row[3];
                                                $amount = $row[5];
                                                $paytype = $row[6];
                                                $bankname = $row[7];
                                                $bankbranch = $row[8];
                                                $chequeno = $row[9];
                                                $chequepaydate = $row[10];
                                                $expensetype = $row[11];
                                                $comment = $row[14];
                                        }


                        }


        }


?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Payment Voucher</title>
<base target="_self">
</head>
<script language= javascript 1.5>
    var numrows = <?php echo $numrows ?>;

    var gotocheck = <?php echo $gotocheck ?> ;


function setattribute()
        {

                if (document.test.add_edit_duplicate.value=='true')
                        {
                                alert("Duplicate Record Found");

                                document.test.purchase[0].disabled=true;
                                document.test.purchase[1].disabled=true;
                                document.test.purchase[2].disabled=true;
                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);
                                document.test.amountinword.disabled=true;

                                document.test.add_edit_duplicate.value='false';

                                button_option("pressed");

                        }

                else
                        {

                                if (document.test.setat.value!="true")
                                        {

                                                if (document.test.voucherid.value ==0)
                                                        {
                                                                button_option("norecord");

                                                        }

                                                else
                                                        {
                                                                button_option("normal");
                                                        }








                                               // button_option("normal");

                                                document.test.comment.disabled=true;
                                                document.test.clientname.disabled=true;
                                                document.test.payserial.disabled=true;
                                                document.test.voucherdate.disabled=true;

                                                if(document.test.radiotest.value!="official")
                                                        {
                                                                document.test.paylocation.disabled=true;
                                                        }

                                                document.test.through.disabled=true;

                                                <?php
                                                        if ($numrows!=0)
                                                                {

                                                                        if ($payamount!=0)
                                                                                {
                                                                                        print("document.test.amountinword.value=moneyconvert(document.test.payamount.value)");
                                                                                }

                                                                }


                                                        if ($radiotest !="official")
                                                                {
                                                                        print("
                                                                                document.test.payamount.disabled=true;
                                                                                document.test.amountinword.disabled=true;
                                                                                document.test.matone.disabled=true;
                                                                                document.test.mattwo.disabled=true;
                                                                                document.test.fromloc.disabled=true;
                                                                                document.test.toloc.disabled=true;
                                                                                document.test.tkrate.disabled=true;
                                                                                document.test.paytype.disabled=true;
                                                                                document.test.chequeno.disabled=true;
                                                                                document.test.bankname.disabled=true;
                                                                                document.test.bankbranch.disabled=true;
                                                                                document.test.chequepaydate.disabled=true;
                                                                                document.test.departuredate.disabled=true;

                                                                                ");

                                                                        if ($radiotest=="normal")
                                                                                {
                                                                                        print("document.test.shipname.disabled=true;");
                                                                                }

                                                                        if ($radiotest=="purchase")
                                                                                {
                                                                                        print("document.test.purchaseoption.disabled=true;");
                                                                                        print("document.test.shipname.disabled=true;");
                                                                                }


                                                                }


                                                        if ($radiotest=="official")
                                                                {
                                                                        print("
                                                                                document.test.expensetype.disabled=true;
                                                                                document.test.payamount.disabled=true;
                                                                                document.test.amountinword.disabled=true;
                                                                                document.test.paytype.disabled=true;
                                                                                document.test.chequeno.disabled=true;
                                                                                document.test.bankname.disabled=true;
                                                                                document.test.bankbranch.disabled=true;
                                                                                document.test.chequepaydate.disabled=true;

                                                                                ");

                                                                }

                                                ?>
                                                //document.test.setat.value = "true";

                                        }       /// End of setat.value !=true condition


                                if (document.test.setat.value =="true")
                                        {
                                                document.test.purchase[0].disabled=true;
                                                document.test.purchase[1].disabled=true;
                                                document.test.purchase[2].disabled=true;

                                                document.test.comment.disabled=false;
                                                document.test.clientname.disabled=false;
                                                document.test.payserial.disabled=false;
                                                document.test.voucherdate.disabled=false;
                                                document.test.paylocation.disabled=false;
                                                document.test.through.disabled=false;
                                                document.test.amountinword.disabled=true;

                                                button_option("pressed");

                                                <?php
                                                        if ($numrows!=0)
                                                                {
                                                                        if ($payamount!=0)
                                                                                {
                                                                                        print("document.test.amountinword.value=moneyconvert(document.test.payamount.value)");

                                                                                }

                                                                }

                                                        //document.test.amountinword.value=moneyconvert(document.test.payamount.value);


                                                        if ($radiotest !="official")
                                                                {
                                                                        print("


                                                                                document.test.payamount.disabled=false;
                                                                                document.test.amountinword.disabled=true;
                                                                                document.test.matone.disabled=false;
                                                                                document.test.mattwo.disabled=false;
                                                                                document.test.fromloc.disabled=false;
                                                                                document.test.toloc.disabled=false;
                                                                                document.test.tkrate.disabled=false;
                                                                                document.test.paytype.disabled=false;
                                                                                document.test.chequeno.disabled=false;
                                                                                document.test.bankname.disabled=false;
                                                                                document.test.bankbranch.disabled=false;
                                                                                document.test.chequepaydate.disabled=false;
                                                                                document.test.departuredate.disabled=false;  ///////////////  Changed to false from true by miraj on 24th jan

                                                                                ");

                                                                        if ($radiotest=="normal")
                                                                                {
                                                                                        print("document.test.shipname.disabled=false;");
                                                                                }

                                                                        if ($radiotest=="purchase")
                                                                                {
                                                                                        print("document.test.purchaseoption.disabled=false;");
                                                                                        print("document.test.shipname.disabled=false;");
                                                                                }


                                                                }


                                                        if ($radiotest=="official")
                                                                {
                                                                        print("
                                                                                document.test.expensetype.disabled=false;
                                                                                document.test.payamount.disabled=false;
                                                                                document.test.amountinword.disabled=true;
                                                                                document.test.paytype.disabled=false;
                                                                                document.test.chequeno.disabled=false;
                                                                                document.test.bankname.disabled=false;
                                                                                document.test.bankbranch.disabled=false;
                                                                                document.test.chequepaydate.disabled=false;


                                                                                ");

                                                                }

                                                ?>

                                                document.test.setat.value="false";
                                                document.test.savecancel.value = "true";  //if any problem just remove it
                                        }


                        } // end of else of add_edit duplicate


        } // end of set attribute function.




function add_edit_press(endis)

        {

                //document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******

                if (endis=='addedit')
                        {
                                document.test.purchase[0].disabled=true;
                                document.test.purchase[1].disabled=true;
                                document.test.purchase[2].disabled=true;

                                button_option("pressed");

                                document.test.payamount.disabled=false;
                                document.test.comment.disabled=false;
                                document.test.amountinword.disabled=true;
                                document.test.clientname.disabled=false;
                                document.test.voucherdate.disabled=false;
                                document.test.payserial.disabled=false;

                                document.test.paytype.disabled=false;
                                document.test.chequeno.disabled=false;
                                document.test.bankname.disabled=false;
                                document.test.bankbranch.disabled=false;
                                document.test.chequepaydate.disabled=false;

                                if (document.test.radiotest.value!="official")
                                        {

                                                document.test.paylocation.disabled=false;
                                        }

                                document.test.through.disabled=false;

                                //document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                                <?php

                                        if ($radiotest!="official")
                                                {
                                                        print("{

                                                                        //document.test.clientname.disabled=false;
                                                                        //document.test.shipname.disabled=false;
                                                                        //document.test.amountinword.disabled=false;
                                                                        document.test.matone.disabled=false;
                                                                        document.test.mattwo.disabled=false;
                                                                        document.test.fromloc.disabled=false;
                                                                        document.test.toloc.disabled=false;
                                                                        document.test.tkrate.disabled=false;

                                                                        document.test.departuredate.disabled=false;

                                                                }");

                                                        if ($radiotest=="normal")
                                                                {
                                                                        print("document.test.shipname.disabled=true;");
                                                                }
                                                        if ($radiotest=="purchase")
                                                                {
                                                                        print("document.test.purchaseoption.disabled=false;");
                                                                        print("document.test.shipname.disabled=false;");
                                                                }

                                                }

                                        if ($radiotest=="official")
                                                {
                                                        print("{
                                                                        //document.test.clientname.disabled=false;
                                                                        document.test.expensetype.disabled=false;
                                                                        //document.test.amountinword.disabled=false;
                                                                        //setvoucherdate_serial();

                                                                        alert(document.test.official_voucherno.value);

                                                                        document.test.payserial.value = document.test.official_voucherno.value;

                                                                }");
                                                }

                                ?>

                        }

                else
	                {
                                ///////////////********************added by me on 2002/27/12**********************to disable the carrying - purchase - official******

                                document.test.purchase[0].disabled=false;
                                document.test.purchase[1].disabled=false;
                                document.test.purchase[2].disabled=false;

                                if (document.test.voucherid.value ==0)
                                        {
                                                button_option("norecord");
                                        }

                                else
                                        {
                                                button_option("normal");
                                        }

                              //  button_option("normal");

                                document.test.comment.disabled=true;
                                document.test.voucherdate.disabled=true;
                                document.test.payserial.disabled=true;

                                document.test.paytype.disabled=true;
                                document.test.chequeno.disabled=true;
                                document.test.bankname.disabled=true;
                                document.test.bankbranch.disabled=true;
                                document.test.chequepaydate.disabled=true;

                                if(document.test.radiotest.value!="official")
                                        {
                                                document.test.paylocation.disabled=true;
                                        }

                                document.test.through.disabled=true;
                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                                <?php

                                        if ($radiotest!="official")
                                                {
                                                        print("{
                                                                document.test.clientname.disabled=true;
                                                                //document.test.shipname.disabled=true;
                                                                document.test.payamount.disabled=true;
                                                                document.test.amountinword.disabled=true;
                                                                document.test.matone.disabled=true;
                                                                document.test.mattwo.disabled=true;
                                                                document.test.fromloc.disabled=true;
                                                                document.test.toloc.disabled=true;
                                                                document.test.tkrate.disabled=true;

                                                                document.test.departuredate.disabled=true;
                                                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                                                                }");

                                                        if ($radiotest=="normal")
                                                                {
                                                                        print("document.test.shipname.disabled=true;");
                                                                }

                                                        if ($radiotest=="purchase")
                                                                {
                                                                        print("document.test.purchaseoption.disabled=true;");
                                                                        print("document.test.shipname.disabled=true;");
                                                                }

                                                }


                                        if ($radiotest=="official")
                                                {
                                                        print("{
                                                                document.test.clientname.disabled=true;
                                                                document.test.expensetype.disabled=true;
                                                                document.test.payamount.disabled=true;
                                                                document.test.amountinword.disabled=true;

                                                                }");
                                                }

                                ?>

                        }


        }






function form_validator(theForm)
        {


                if (document.test.radiotest.value!="official")
                        {
                                if (theForm.shipname.disabled==true)
                                        {
                                                alert("Sorry...First you have to choose a client, then select desired Ship Name");

                                                theForm.shipname.focus();
                                                return(false);

                                        }

                        }



                if(theForm.payserial.value == 0)
                        {
                	        alert("<?php echo $txt_missing_payserial ?>");
                                theForm.payserial.select();
                	        theForm.payserial.focus();
                	        return(false);
                        }

                if (isFinite(theForm.payserial.value) != true)
                        {
                                alert('Invalid Number Argument In Serial No. !');
                                theForm.payamount.select();
                                theForm.payamount.focus();
                                return(false);

                        }

                if(theForm.voucherdate.value == "")
                        {
        	                alert("<?php echo $txt_missing_voucherdate ?>");
                                theForm.voucherdate.select();
        	                theForm.voucherdate.focus();
        	                return(false);
                        }

                if(theForm.payamount.value == 0)
                        {
         	                alert("<?php echo $txt_missing_payamount ?>");
                                theForm.payamount.select();
         	                theForm.payamount.focus();
         	                return(false);
                        }

                 if (isFinite(theForm.payamount.value) != true)
                         {
                                 alert('Invalid Number Argument In Paid Amount !');
                                 theForm.payamount.select();
                                 theForm.payamount.focus();
                                 return(false);

                         }



                if (theForm.radiotest.value!="official")
                        {

                         /*
                                if ( Number(theForm.balancetk.value) >0 )
                                        {

                                                if( Number(theForm.payamount.value) > Number(theForm.balancetk.value) )
                                                        {
                                                                var abcd = Number(theForm.payamount.value) - Number(theForm.balancetk.value);

                                                                alert("Sorry! Payment Amount is "+abcd+" Taka more than Balance Amount");
                                                                theForm.payamount.select();
                                                                theForm.payamount.focus();
                                                                return(false);
                                                        }

                                        }
                           */



                                if(theForm.tkrate.value == 0)
                                        {
        	                                alert("<?php echo $txt_missing_takarate ?>");
                                                theForm.tkrate.select();
        	                                theForm.tkrate.focus();
        	                                return(false);
                                        }




                                if (isFinite(theForm.tkrate.value) != true)
                                        {
                                                alert('Invalid Number Argument In Fair Rate !');
                                                theForm.tkrate.select();
                                                theForm.tkrate.focus();
                                                return(false);

                                        }




                                if (theForm.matone.options[theForm.matone.selectedIndex].text == "")
                                        {
        	                                alert("Please select First Material");
        	                                theForm.matone.focus();
        	                                return(false);
                                        }

                                if (theForm.mattwo.options[theForm.mattwo.selectedIndex].text == "")
                                        {
                                                alert("Please select second Material...If there is only one material then choose -********-");
                                                theForm.matone.focus();
                                                return(false);
                                        }

                                if (capfirst(theForm.matone.options[theForm.matone.selectedIndex].text) == capfirst(theForm.mattwo.options[theForm.mattwo.selectedIndex].text))
                                        {
                                                alert("Sorry! Material One And Material Two Can Not Be The Same");
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

                                if ( capfirst(theForm.fromloc.options[theForm.fromloc.selectedIndex].text) == capfirst(theForm.toloc.options[theForm.toloc.selectedIndex].text) )
                                        {
                                                alert("Sorry! From And TO Location Can Not Be The Same");
                                                theForm.toloc.focus();
                                                return(false);
                                        }


                        }      /// Inside not equals to official option

                if (theForm.paytype.options[theForm.paytype.selectedIndex].text == "Cheque")
                        {
                                alert("we are in paytype condition cheque");
                                alert(theForm.chequeno.value);

                                if(capfirst(document.test.chequeno.value) == "")
                                        {
                                                 alert("we are in chequeno");
                                                 alert("<?php echo $txt_missing_chequeno ?>");
                                                 theForm.chequeno.select();
                                                 theForm.chequeno.focus();
                                                 return(false);
                                        }

                                if(capfirst(theForm.bankname.value) == "")
                                        {
                                                alert("<?php echo $txt_missing_bankname ?>");
                                                theForm.bankname.select();
        	                                theForm.bankname.focus();
        	                                return(false);
                                        }

                                if(capfirst(theForm.bankbranch.value) == "")
                                        {
                                                alert("<?php echo $txt_missing_bankbranch ?>");
                                                theForm.bankbranch.select();
                                                theForm.bankbranch.focus();
                                                return(false);
                                        }


                                if(capfirst(theForm.chequepaydate.value) == "")
                                        {

                                                alert("<?php echo $txt_missing_chequedate ?>");
                                                theForm.chequepaydate.select();
                                                theForm.chequepaydate.focus();
                                                return(false);
                                        }


                        }

	        return (true);

        }




function paytype_option ()
        {
                 if (document.test.paytype.options[document.test.paytype.selectedIndex].text=='Cash')
                         {
                                 document.test.chequeno.disabled=true;
                                 document.test.bankname.disabled=true;
                                 document.test.bankbranch.disabled=true;
                                 document.test.chequepaydate.disabled=true;

                         }

                 else
                         {

                                document.test.chequeno.disabled=false;
                                document.test.bankname.disabled=false;
                                document.test.bankbranch.disabled=false;
                                document.test.chequepaydate.disabled=false;


                         }



        }




function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_payment.php?gotocheck=$gotocheck&radiotest=$radiotest&button_check=$button_check\",\"view\",\"toolbar=no,scrollbars=yes\")");
                ?>

        }




function view_cargo()
        {
                document.test.setat.value="true";
                document.test.shipcargo.value=document.test.shipname.value;
                alert( document.test.shipcargo.value);
                var abc = "view_payment_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&voucherdate="+document.test.voucherdate.value+"&voucherid="+document.test.voucherid.value;

                //   alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }



function view_purchase_sale_cargo()
        {
                document.test.setat.value="true";
                document.test.shipcargo.value=document.test.shipname.value;
                alert( document.test.shipcargo.value);
                var abc = "view_purchase_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&voucherdate="+document.test.voucherdate.value+"&voucherid="+document.test.voucherid.value;

                //   alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }






function print_record()
        {
                if (document.test.radiotest.value == "official")
                        {
                                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&voucherdate="+document.test.voucherdate.value;
                        }

                else
                        {
                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.options[document.test.clientname.selectedIndex].text+"&voucherdate="+document.test.voucherdate.value+"&payserial="+document.test.payserial.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.ownername.value+"&materialone="+document.test.matone.options[document.test.matone.selectedIndex].text+"&materialtwo="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&fairrate="+document.test.tkrate.value+"&fromlocation="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&tolocation="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&cashorcheque="+document.test.paytype.options[document.test.paytype.selectedIndex].text+"&bankname="+document.test.bankname.value+"&bankbranch="+document.test.bankbranch.value+"&chequeno="+document.test.chequeno.value+"&chequedate="+document.test.chequepaydate.value+"&print_comment="+document.test.comment.value+"&print_through="+document.test.through.value;
                                alert (abc);
                        }

                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");


        }



function entertainment()
        {

                document.test.filling.value = "addbutton";

        }



function shipsel()
        {
                if (document.test.radiotest.value!="official")
                        {
                                document.test.shipselect.value = "true";
		                document.test.setat.value = "true";
		                document.test.clientselect.value = "true";
                                document.test.savecancel.value = "false";
		                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
		                document.test.submit();
	                }

        }        // shipsel function ends



function normal (whatever)
        {
                if (whatever=='nor')
                        {
                                document.test.radiotest.value = "normal" ;
                                document.test.filling.value = "eggplant" ;

                        }

                if (whatever=='pur')
                        {
                                document.test.radiotest.value = "purchase" ;
                                document.test.filling.value = "eggplant" ;
                        }

                if (whatever=='office')
                        {
                                document.test.radiotest.value = "official" ;
                                document.test.filling.value = "eggplant" ;
                        }


        }


function adjnormal (whatever)
        {
                if (whatever=='money')
                        {
                                document.test.adjradiotest.value = "money_receipt" ;
                                document.test.filling.value = "eggplant" ;

                        }

                if (whatever=='payment')
                        {
                                document.test.adjradiotest.value = "payment_voucher" ;
                                document.test.filling.value = "eggplant" ;
                        }

                if (whatever=='damarage')
                        {
                                document.test.adjradiotest.value = "damarage" ;
                                document.test.filling.value = "eggplant" ;
                        }


                if (whatever=='overtaken')
                        {
                                document.test.adjradiotest.value = "overtaken" ;
                                document.test.filling.value = "eggplant" ;
                        }









        }






</script>
<script language = javascript src="all_jscript_function.js"> </script>
<script language = javascript src="date_picker.js"> </script>










<STYLE>

BODY  { background: #b1ce93;  font-size: 8pt}


 </STYLE>


<body bgcolor= "#b1ce93" onload= "setattribute()">
<form name= "test" onsubmit="return form_validator(this)"  onreset = "button_job(document.test.cancelbutton.name);add_edit_press()" method= post action="adjustment.php">
<div align="center"><b><font face="Monotype Corsiva" size="5"><font color="darkBlue"><u>ADJUSTMENT</u></font></font></b></div>


<TABLE width="100%" border="1" bgcolor = "#808000">

<TR>
<TD width="" ALIGN = center>

<?php

       if ($adjradiotest=="payment_voucher")
               {

                       print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"adjust\" value = \"money\"  onclick= \"adjnormal('money');document.test.submit()\">&nbsp;&nbsp; Money Receipt

                       <input type = \"radio\" name = \"adjust\" value = \"payment\"  checked onclick= \"adjnormal('payment');document.test.submit()\">&nbsp;&nbsp; Payment Voucher
                       <input type = \"radio\" name = \"adjust\" value = \"damarage\"  onclick= \"adjnormal('damarage');document.test.submit()\">&nbsp;&nbsp; Damerage
                       <input type = \"radio\" name = \"adjust\" value = \"overtaken\"  onclick= \"adjnormal('overtaken');document.test.submit()\">&nbsp;&nbsp; Over Taken </font></b>");

               }


        if ($adjradiotest=="money_receipt")
                {

                        print ("<b><font color=\"darkMagenta\"> <input type = \"radio\" name = \"adjust\" value = \"money\" checked onclick= \"adjnormal('money');document.test.submit()\">&nbsp;&nbsp; Money Receipt

                        <input type = \"radio\" name = \"adjust\" value = \"payment\"  onclick= \"adjnormal('payment');document.test.submit()\">&nbsp;&nbsp; Payment Voucher
                        <input type = \"radio\" name = \"adjust\" value = \"damarage\"  onclick= \"adjnormal('damarage');document.test.submit()\">&nbsp;&nbsp; Damerage
                        <input type = \"radio\" name = \"adjust\" value = \"overtaken\"  onclick= \"adjnormal('overtaken');document.test.submit()\">&nbsp;&nbsp; Over Taken </font></b>");

                }



        if ($adjradiotest=="damarage")
                {

                        print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"adjust\" value = \"money\"  onclick= \"adjnormal('money');document.test.submit()\">&nbsp;&nbsp; Money Receipt

                        <input type = \"radio\" name = \"adjust\" value = \"payment\"   onclick= \"adjnormal('payment');document.test.submit()\">&nbsp;&nbsp; Payment Voucher

                        <input type = \"radio\" name = \"adjust\" value = \"damarage\"  checked onclick= \"adjnormal('damarage');document.test.submit()\">&nbsp;&nbsp; Damerage
                        <input type = \"radio\" name = \"adjust\" value = \"overtaken\"  onclick= \"adjnormal('overtaken');document.test.submit()\">&nbsp;&nbsp; Over Taken </font></b>");

                }


         if ($adjradiotest=="overtaken")
                 {

                         print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"adjust\" value = \"money\"  onclick= \"adjnormal('money');document.test.submit()\">&nbsp;&nbsp; Money Receipt

                         <input type = \"radio\" name = \"adjust\" value = \"payment\"   onclick= \"adjnormal('payment');document.test.submit()\">&nbsp;&nbsp; Payment Voucher

                         <input type = \"radio\" name = \"adjust\" value = \"damarage\"   onclick= \"adjnormal('damarage');document.test.submit()\">&nbsp;&nbsp; Damerage
                         <input type = \"radio\" name = \"adjust\" value = \"overtaken\"  checked onclick= \"adjnormal('overtaken');document.test.submit()\">&nbsp;&nbsp; Over Taken </font></b>");

                 }





?>

</TD>


</TR>

 </TABLE>
<br>





<TABLE width="100%" border="1" bgcolor = "#00FFFF">
<TR>
<TD width="">

<?php

        if ($adjradiotest!="money_receipt")
                {


                        if ($radiotest=="normal")
                                {

                                        print ("<b><font color=\"darkMagenta\"> <input type = \"radio\" name = \"purchase\" value = \"normal\" checked onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying

                                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"  onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; <blink>Purchase</blink>
                                        <input type = \"radio\" name = \"purchase\" value = \"official\"  onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");

                                }

                        if ($radiotest=="purchase")
                                {

                                        print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"purchase\" value = \"normal\"  onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying

                                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"  checked onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Purchase
                                        <input type = \"radio\" name = \"purchase\" value = \"official\"  onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");


                                }


                        if ($radiotest=="official")
                                {

                                        print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"purchase\" value = \"normal\"  onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying

                                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"   onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; <blink>Purchase </blink>

                                        <input type = \"radio\" name = \"purchase\" value = \"official\"  checked onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");


                                }

                }



        if ($adjradiotest=="money_receipt")
                {


                         if ($radiotest=="normal")
                                 {

                                         print ("<font color=\"darkRed\"><b><input type = \"radio\" name = \"purchase\" value = \"normal\" checked onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying
                                         &nbsp;&nbsp;&nbsp;&nbsp;
                                         <input type = \"radio\" name = \"purchase\" value = \"sale\"  onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp;<blink> Sale </blink>

                                         <input type = \"radio\" name = \"purchase\" value = \"official\"  onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");

                                 }

                         if ($radiotest=="sale")
                                 {

                                         print ("<font color=\"darkRed\"><b><input type = \"radio\" name = \"purchase\" value = \"normal\"  onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying.
                                         &nbsp;&nbsp;&nbsp;&nbsp;

                                         <input type = \"radio\" name = \"purchase\" value = \"sale\"  checked onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Sale

                                         <input type = \"radio\" name = \"purchase\" value = \"official\"  onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");


                                 }

                        if ($radiotest=="official")
                                {

                                        print ("<b><font color=\"darkMagenta\">  <input type = \"radio\" name = \"purchase\" value = \"normal\"  onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying

                                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"   onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Sale

                                        <input type = \"radio\" name = \"purchase\" value = \"official\"  checked onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");


                                }





                }






?>

</TD>

<TD width="30%"><b>Sl. No.&nbsp;&nbsp;&nbsp;
<input type=text name="payserial" value = "<?php if ($radiotest =="normal"){ echo $payserial;} if ($radiotest =="purchase"){ echo $payserial ;} if ($radiotest =="official"){ echo $payserial;} ?>" size="12" >

</td>

</TR>

 </TABLE>
<br>


<TABLE border=1> <tr>
<TD width=29><b>To</b> </td>
<TD width="196">



<select size="1" name="clientname" onchange="shipsel()"> "

<?php

        if ($clientselect !="true")
                {
                        print("<option value= \"$clientname\"  selected>$accountname ");

                }   //$clientselect="true";

        else
                {
                        print ("<option value = \"$clientname\" selected>$ownername");  $clientselect="false";

                }   ////??????????why clientname   on 12th october ownername has been changed to accountname

?>

</option>


<?php

        // grabs all product information

        if($radiotest=="normal")
                {

                        $result = pg_exec("select account_id,account_name from accounts where account_type='Shipowner' order by account_name");
                }

        if($radiotest=="purchase")
                {

                        $result = pg_exec("select account_id,account_name from accounts where account_type='Client' order by account_name");

                }

        if($radiotest=="official")
                {

                        $result = pg_exec("select account_id,account_name from accounts where account_type='Official' order by account_name");

                }



        $accountrows=pg_numrows($result);

        for($i=0;$i<$accountrows;$i++)
                {

                        $accountrow = pg_fetch_row($result,$i);

	                print("<option value = \"$accountrow[0]\" >$accountrow[1]</option>\n");

                }

?>





</select>
</td>

<TD width="66"><b>Through:</b></td>
<TD width="150"><input type="text" name="through" value = "<?php if ($radiotest =="normal" ){ echo $row[27];} if ($radiotest =="purchase" ){ echo $row[24] ;} if ($radiotest =="official" ) { echo $row[14];} ?> " size=20 > </TD>


<td> <b>Date : </b><input type=text name="voucherdate" value ="<?php echo ltrim(rtrim($voucherdate))?>" size="15" ><a href="javascript:show_calendar('test.voucherdate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a></b>
</td> </TR>

</TABLE>

<TABLE width="849" border="1"><TR>


<td width="35"><b>On Account</b></td>

<TD width="300">
<?php

// grabs all product information

        if ($radiotest=="normal")
                { //starting normal option

                        print("<select size=\"1\" name=\"shipname\" OnChange=\"view_cargo()\"> ");

                        //print( "<option value= \" $row[5]\" selected> $row[6]  </option>  ");

                        if ($shipselect=="false")
                                {
                                        $result = pg_exec("select ship_id,ship_name,account_id from ship where account_id=$clientname");
                                        echo "alert( Entered)";

                                        $shipselect = "false";
                                }

                        else
                                {

                                        $result = pg_exec("select ship_id,ship_name from ship where account_id=$clientname");
                                        $row = pg_fetch_row($result,0);
                                        $shipname = $row[0];$nameofship = $row[1];
	                                print( "<option value= \"$shipname\" selected> $nameofship </option>  ");
                                }

                        $num_ship = pg_numrows($result);

                        for($i=0;$i<$num_ship;$i++)

                                {
	                                $row_ship = pg_fetch_row($result,$i);

	                                print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
	                        }

	                print(" </select>");
                }   //End of normal



if ($radiotest=="purchase")
        {  //starting purchase option

                $result = pg_exec("select matone_id,matone_name from materialone order by matone_name");

                print("<select size=\"1\" name=\"matone\">");

                print("<option value = \"$matone\"  selected>$matonename</option>\n");
                $num_mat1 = pg_numrows($result);

                for($i=0;$i<$num_mat1;$i++)
                        {
	                        $row_mat1 = pg_fetch_row($result,$i);

	                        print("<option value = \"$row_mat1[0]\" >$row_mat1[1]</option>\n");

                        }

                print("</select >");

                $result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");

                print("<select size=\"1\" name=\"mattwo\">");

                print("<option value =\"$mattwo\"  selected>$mattwoname</option>\n");
                $num_mat2 = pg_numrows($result);


                for($i=0;$i<$num_mat2;$i++)
                        {
	                        $row_mat2 = pg_fetch_row($result,$i);

	                        print(" <option value =\"$row_mat2[0]\">$row_mat2[1]</option>\n");
	                }

                print("</select >");

                print("<b>&nbsp;&nbsp;Cargo Vessel</b>:&nbsp;&nbsp;&nbsp; <select size=\"1\" name=\"shipname\" OnChange=\"view_purchase_sale_cargo()\"> ");

                print( "<option value=\"$shipname\" selected>$nameofship</option>  ");

                $result = pg_exec("select ship_id,ship_name from ship order by ship_name");

                $num_ship = pg_numrows($result);

                for($i=0;$i<$num_ship;$i++)
                        {
         	                $row_ship = pg_fetch_row($result,$i);

         	                print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
         	        }

                print(" </select>");


        }




 if ($radiotest=="official")
        {
                print("<select size=\"1\" name=\"expensetype\" onchange=\"entertainment()\"> ");

                print("<option selected>$row[11]</option>\n");
                print("<option >Business Promotion</option>\n
                        <option> Entertainment </option>
                        <option >Furniture</option>
                        <option >House Rent & Utilities</option>
                        <option >Loan</option>
                        <option >Miscellenious</option>
                        <option >Office Management</option>
                        <option >Printing & Stationaries</option>
                        <option >Received Amount</option>
                        <option>Salary</option>
                        <option>Transport</option>
                         </select>");

                print(" </select>");


        }


?>

</TD>

<TD width="45"> <b>Paid Tk</b></TD>

<TD width="129"><input type="text" name="payamount"  size="17" value ="<?php echo $payamount ?>" onchange= "document.test.amountinword.value=moneyconvert(document.test.payamount.value)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

</TR>

</TABLE>

<TABLE width="904" border="1">
<TR><TD width="555"><b>In word</b> &nbsp; <font face="Times New Roman" size="2"><textarea rows="1" name="amountinword" cols="60"></textarea></font></p>
</td>

<?php

        if($radiotest!="official")
                {
                        if($radiotest=="normal")
                                {

                                     print (" <TD width=98><b>From</b> </td><td width=154><select size=\"1\" name=\"fromloc\">");

                                     if( $radiotest=="normal")
                                             {
                                                     print("<option value = \"$fromloc\" selected>$fromlocname</option>\n");

                                             }

                                     if( $radiotest=="purchase")
                                             {
                                                     print("<option value = \"$fromloc\" selected>$fromlocname</option>\n");

                                             }
                                             // grabs all product information

                                     $result = pg_exec("select * from locationfrom order by from_loc");
                                     $num_loc1 = pg_numrows($result);

                                     for($i=0;$i<$num_loc1;$i++)
                                             {
                                                    $row_loc1 = pg_fetch_row($result,$i);

                                                    print("<option value = \"$row_loc1[0]\" >$row_loc1[1]</option>\n");

                                             }

                                             print("</select></td><TD width=\"55\"><b> To</b></td><TD width=\"115\"><select size=\"1\" name=\"toloc\"> ");

                                     if( $radiotest=="normal")
                                             {
                                                     print("<option value = \"$toloc\" selected>$tolocname</option>\n");
                                             }


                                     if( $radiotest=="purchase")
                                             {
                                                     print("<option value = \"$toloc\" selected>$tolocname</option>\n");

                                             }



                                     // grabs all product information
                                     $result = pg_exec("select * from locationto order by to_loc");
                                     $num_loc2 = pg_numrows($result);

                                     for($i=0;$i<$num_loc2;$i++)
                                             {
                                                     $row_loc2 = pg_fetch_row($result,$i);

                                                     print("<option value = \"$row_loc2[0]\" >$row_loc2[1]</option>\n");
                                             }
                                     echo("</select></td> ");



                                      /*
                                        print("<TD width=\"50\"><b>@ Tk.</b></TD>
                                                <TD width=\"80\"><input type=\"text\" name=\"tkrate\" value = \"$tkrate\" size=\"11\"></TD>");
                               */ }

                        if($radiotest=="purchase")
                                {

                                        print("<TD width=\"50\"><b>@ Tk.</b></TD>
                                                <TD width=\"80\"><input type=\"text\" name=\"tkrate\" value = \"$tkrate\" size=\"11\"></TD>");
                                }

                }

 ?>

</TR></TABLE>


<?php

        if ($radiotest!="official")
                {
                        print("<TABLE border=1>");
                        print ("<TD width=90><b>Material One </b></td>");


                        // grabs all product information

                        if ($radiotest=="normal")
                                {
                                        //problem starts

                                        print("<TD width=\"\">");
                                        print("<select size=\"1\" name=\"matone\">");
                                        print("<option value =\"$matone\" selected>$matonename</option>\n");
                                        $result = pg_exec("select matone_id,matone_name from materialone order by matone_name");
                                        $num_mat1 = pg_numrows($result);

                                        for($i=0;$i<$num_mat1;$i++)
                                                {
	                                                $row_mat1 = pg_fetch_row($result,$i);

	                                                print("<option value = \"$row_mat1[0]\" >$row_mat1[1]</option>\n");
                                                }

                                        print("</select >&nbsp;"); print ("</TD>");

                                        print("<TD width=\"50\"><b>@ Tk.</b></TD>
                                                <TD width=\"80\"><input type=\"text\" name=\"tkrate\" value = \"$tkrate\" size=\"11\"></TD>");

                                        print ("<TD width=90><b>Material Two </b></td>");

                                        print ("<TD>");

                                        print("<select size=\"1\" name=\"mattwo\">");
                                        print("<option value =\"$mattwo\" selected>$mattwoname</option>\n");
                                        $result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");
                                        $num_mat2 = pg_numrows($result);

                                        for($i=0;$i<$num_mat2;$i++)
                                                {
	                                                $row_mat2 = pg_fetch_row($result,$i);

	                                                print("<option value = \"$row_mat2[0]\" >$row_mat2[1]</option>\n");
	                                        }

                                        print("</select >");
                                        print("</TD>");

                                        print("<TD width=\"50\"><b>@ Tk.</b></TD>
                                                <TD width=\"80\"><input type=\"text\" name=\"tkratetwo\" value = \"$tkratetwo\" size=\"11\"></TD>");

                                }


                        if ($radiotest=="purchase")
                                {
                                        print("<TD width=227>");
                                        print("<select  name=\"purchaseoption\">");
                                        print("<option>Purchase</option>");

                                        print("</select>");
                                        print("</TD>");

                                }
                                //problem regarding printing
                      /*
                        print (" <TD width=98><b>From</b> </td><td width=154><select size=\"1\" name=\"fromloc\">");

                        if( $radiotest=="normal")
                                {
                                        print("<option value = \"$fromloc\" selected>$fromlocname</option>\n");

                                }

                        if( $radiotest=="purchase")
                                {
                                        print("<option value = \"$fromloc\" selected>$fromlocname</option>\n");

                                }
                                // grabs all product information

                        $result = pg_exec("select * from locationfrom order by from_loc");
                        $num_loc1 = pg_numrows($result);

                        for($i=0;$i<$num_loc1;$i++)
                                {
	                               $row_loc1 = pg_fetch_row($result,$i);

	                               print("<option value = \"$row_loc1[0]\" >$row_loc1[1]</option>\n");

                                }

                                print("</select></td><TD width=\"55\"><b> To</b></td><TD width=\"115\"><select size=\"1\" name=\"toloc\"> ");

                        if( $radiotest=="normal")
                                {
                                        print("<option value = \"$toloc\" selected>$tolocname</option>\n");
                                }


                        if( $radiotest=="purchase")
                                {
                                        print("<option value = \"$toloc\" selected>$tolocname</option>\n");

                                }



                        // grabs all product information
                        $result = pg_exec("select * from locationto order by to_loc");
                        $num_loc2 = pg_numrows($result);

                        for($i=0;$i<$num_loc2;$i++)
                                {
	                                $row_loc2 = pg_fetch_row($result,$i);

	                                print("<option value = \"$row_loc2[0]\" >$row_loc2[1]</option>\n");
	                        }
                        echo("</select></td> </tr></table>");     */

                        echo("</tr></table>");

/*<p align=\"left\">@ Tk.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ");

if ($radiotest=="normal")  {
print (" <input type=\"text\" name=\"tkrate\" value= \"$row[23]\" size=\"11\"> ");
}
  if ($radiotest=="purchase") {
print("<input type=\"text\" name=\"tkrate\" value=\"$row[21]\" size=\"11\"> ");
}  */

                }

?>

<TABLE width="651" border="1" >
<TR>
<TD width="60"> <b>Payment Mode: </b></TD>
<TD width="125"><select size="1" name="paytype" onchange = "paytype_option()">
  <option value ="<?php echo rtrim($paytype) ?>"  selected> <?php echo rtrim($paytype) ?></option>
  <option>Cash</option>
  <option>Cheque</option>

</select>
</td>
<TD width="61"><b>Cheque No.</b></td>
<TD width="99"><input type="text" name="chequeno" value="<?php echo ltrim(rtrim($chequeno)) ?>"  size="21" >&nbsp;&nbsp; </p>
</td> </TR></TABLE>

<TABLE width="754" border="1">
<TR>

<TD width="60"><b>Bank </b></TD>

<TD width="225"><input type="text" name="bankname" value="<?php echo ltrim(rtrim($bankname)) ?>" size="23" onchange= "document.test.bankname.value=capfirst(document.test.bankname.value)">
</td>
</TD><TD width="98"><b>Branch</b></td>

<TD width="155"><input type="text" name="bankbranch" value="<?php echo ltrim(rtrim($bankbranch)) ?>" size="18"  onchange= "document.test.bankbranch.value=capfirst(document.test.bankbranch.value)">&nbsp;
</td>
<TD width="55"><b>Date</b></TD>
<TD width="121"><input type="text" name="chequepaydate" value ="<?php echo ltrim(rtrim($chequepaydate)) ?>"  size="11" style="list-style-type: font-family"><a href="javascript:show_calendar('test.chequepaydate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a></p>
 </TR></TABLE>

<TABLE width="843" border="1"> <TR>

<?php
        if ($radiotest!="official")
                {
                        print("<TD width=\"60\"><b>Location:</td>
                                <TD width=\"119\"><input type=\"text\" name=\"paylocation\" size=15 value = \"$row[26]\"> </td>
                                <TD width=\"104\"><b>Departure Date:</b> </td>
                                <TD width=\"98\"><input type = \"text\" size=\"10\" name=\"departuredate\" value = \"$departuredate\" readonly></td>");
                }
?>

<TD width="64"><b>Comment: </b></td>
<TD width="358"><input type="text" name="comment" value = "<?php echo ltrim(rtrim($comment)) ?> "size=50></p>

</td></TR></TABLE>



<INPUT TYPE="hidden" name="seenbefore" value="1">
<input type="hidden" name ="radiotest" value="<?php echo $radiotest ?>">
<input type="hidden" name ="adjradiotest" value="<?php echo $adjradiotest ?>">
<input type="hidden" name ="shipcargo" value="<?php echo $shipcargo ?>">

<INPUT TYPE="hidden" name="filling" value="<?php echo $filling ?>">
<INPUT TYPE="hidden" name="savecancel" value="<?php echo $savecancel ?>">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="voucherid" value="<?php echo $voucherid  ?>">
<INPUT TYPE="hidden" name="visitnormal" value="<?php echo $visitnormal  ?>" >
<INPUT TYPE="hidden" name="visitpurchase" value="<?php echo $visitpurchase  ?>" >
<INPUT TYPE="hidden" name="visitofficial" value="<?php echo $visitofficial  ?>" >
<INPUT TYPE="hidden" name="setat" value="<?php echo $setat  ?>" >
<INPUT TYPE="hidden" name="shipselect" value="<?php echo $shipselect  ?>" >
<INPUT TYPE="hidden" name="clientselect" value="<?php echo $clientselect  ?>" >
<INPUT TYPE="hidden" name="ownername" value="<?php echo $ownername ?>" >
<INPUT TYPE="hidden" name ="balancetk" value="<?php echo $balancetk ?>">
<INPUT TYPE="hidden" name="add_edit_duplicate" value="<?php echo $add_edit_duplicate  ?>" >
<INPUT TYPE="hidden" name="shiptripid" value="<?php echo $shiptripid ?>" >
<INPUT TYPE="hidden" name="returnfromviewship" value="<?php echo $returnfromviewship ?>" >
<INPUT TYPE="hidden" name="official_voucherno" value="<?php echo $official_voucherno ?>" >
<INPUT TYPE="hidden" name="purchase_goodquantityone" value="<?php echo $purchase_goodquantityone ?>" >
<INPUT TYPE="hidden" name="print_comment" value="<?php echo $print_comment ?>" >
<INPUT TYPE="hidden" name="print_through" value="<?php echo $print_through ?>" >


<div align="center"><?php button_print(); ?></div>

</form>




<!--test("<?php echo $numsql ?>")
    radiotest("<?php echo $radiotest ?>")
    voucherid("<?php echo $voucherid ?>")
    voucherno("<?php  echo $voucherno ?>")
    accountid("<?php echo $clientname ?>")
    fromloc("<?php echo $fromloc ?>")
    toloc("<?php  echo $toloc ?>")
    ship("<?php echo $shipname ?>")
    shipselect("<?php echo $shipselect ?>")
    savecancel("<?php echo $savecancel ?>")
    filling("<?php echo $filling ?>")
    gotocheck("<?php  echo $gotocheck ?>")
    ownername("<?php echo $ownername ?>")
    purchase("<?php echo $purchase ?>")
    clientselect("<?php echo $clientselect ?>")
    clientname_value("<?php echo $clientname ?>")
    paytype("<?php if ($radiotest =="normal"){ print("we enter");echo $row[16];} if ($radiotest =="purchase"){ echo rtrim($row[14]) ;} if ($radiotest =="official"){ echo $row[6];} ?>")
    tripid("<?php echo $shiptripid ?>");
    departure("<?php echo $departuredate ?>");
    matone("<?php echo $matone ?>");
    mattwo("<?php echo $mattwo?>");
    returnfromviewship("<?php echo $returnfromviewship ?>")
    visitnormal("<?php echo $visitnormal?>");
    visitpurchase("<?php echo $visitpurchase?>");
    another paytype("<?php echo $paytype ?>");

    fairrate("<?php echo $tkrate ?>");

    voucherdate("<?php echo $voucherdate ?>");

    officialvoucherno("<?php echo $official_voucherno ?>");


    setat("<?php echo $setat ?>");
    -->



</body>

</html>
