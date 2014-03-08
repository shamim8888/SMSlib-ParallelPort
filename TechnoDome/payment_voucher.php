<?php
        require("config.php");

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
                        $savecancel = "true";
                        $year = date ("Y");
                        $month = date("m") ;
                        // grabs all product information
                        $result = pg_exec("select * from view_payment_carrying ");
                        $numrows = pg_numrows($result);

                        if ($numrows==0)
                                {            
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
                                        $paytype = $row[16];                                        
                                        $bankname = $row[17];
                                        $bankbranch = $row[18];
					$chequeno = $row[19];
                                        $chequepaydate = $row[20];
					$comment = $row[21];
					$tkrate =$row[23];
					$partoradvance = $row[24];
                                        $departuredate = $row[25];
					$paylocation = $row[26];
					$through = $row[27];
					$shiptripid = $row[28];
					$tkratetwo =$row[29];

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
                                                                }
                                                        else
                                                                {                                                                        
									if ($returnfromviewship !="true" && $clientselect !="true")
                                                                                {
                                                                                        //print("we are in not returnfromviewship..0..yes.$numrows.");
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
											$partoradvance = $row[24];
											$departuredate = $row[25];
											$shiptripid = $row[28];
                                                                                        $tkratetwo =$row[29];
                                                                                        $paytype = $row[16];
                                                                                        $chequeno = $row[19];
                                                                                        $bankname = $row[17];
                                                                                        $branchname = $row[18];
                                                                                        $chequepaydate = $row[20];
											$comment = $row[21];
											$paylocation = $row[26];
											$through = $row[27];

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
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                }

                                                }

                                }


                        if ($radiotest =="purchase")
                                {
                                        //print("we are in purchase Voucher..$visitpurchase");

                                        if ($visitpurchase ==0)
                                                {
	                                                $result = pg_exec("select * from view_payment_purchase ");
                                                        $numrows=pg_numrows($result);                                                        
                                                        print($numrows);

                                                        if ($numrows==0)
                                                                {
                                                                        print("$numrows...we are in");
                                                                        $voucherid = 0;                                                                   
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
											$paytype = $row[16];
                                                                                        $bankname = $row[17];
                                                                                        $branchname = $row[18];
											$chequeno = $row[19];
                                                                                        $chequepaydate = $row[20];
											$comment = $row[22];
                                                                        		$tkrate =$row[23];
											$through = $row[24];
											$tkratetwo =$row[25];
											$partoradvance = $row[26];
											$paylocation = $row[27];
											$shiptripid = $row[28];
											
                                                                       		}
									$returnfromviewship = "false";
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
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                }

                                                }

                                }

                        if ($radiotest =="official")
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


                                        ////////////  End of voucher serial no. for official  ///////////

                                        ///////////////////////////////////////////////////////////////

                                        if ($visitofficial ==0)
                                                {
                                                        $result = pg_exec("select * from view_payment_official ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                        $voucherid = 0;
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
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                }
                                                }

                                }

                }                    ////// END of seenbefore else



                        /////************************* start button operation********************************//
                        ///for store a number in $gotocheck for prev,next,goto...
			///********************Navigation start***************************/
        		///***********************************************************/


	if ($navigation == "true")
    		{
                        print(".navigation...numrows...$numrows");
			if ($radiotest =="normal")
                        	{
	                        	$result = pg_exec("select * from view_payment_carrying ");                                                     
                                }

                        if ($radiotest =="purchase")
                                {
	                                $result = pg_exec("select * from view_payment_purchase ");
                                }

                        if ($radiotest =="official")
                                {
	                                $result = pg_exec("select * from view_payment_official ");
                                }
				
			$numrows=pg_numrows($result);
			
			//*******************  For TOP BUTTON         **********************

                        if ($filling == "topbutton")
                                {	
	                                $row = pg_fetch_row($result,0);
                                }

                        /******************** FOR PREVIOUS - nextrecord - bottombutton - gotobutton BUTTON  **********************************/
                        /****************************************************************************/

                        if (($filling == "prevrecord") || ($filling == "nextrecord") || ($filling == "bottombutton") || ($filling == "gotobutton"))
                                {                                        					
					$row = pg_fetch_row($result,$gotocheck-1);
                		}
	
 			///////////////////////////////////////////////////////////////////////
			/**************************** FOR DELETE BUTTON  *********************/

			if ($filling == "deletebutton")
        			{
					$deleteresult = pg_exec($conn,"DELETE  FROM payment_voucher WHERE (voucher_id = '$voucherid')");

                			if($radiotest=="normal")
                        			{
                                			$result = pg_exec("select * from view_payment_carrying");                                			
                        			}

                			if($radiotest=="purchase")
                        			{
                                			$result = pg_exec("select * from view_payment_purchase");
                        			}

                			if($radiotest=="official")
                        			{
                                			$result = pg_exec("select * from view_payment_official");
						}
					
					$numrows=pg_numrows($result);
					print("....numrows...$numrows");
                                	
					if ($numrows==0)
                                        	{
                                        		$voucherid = 0;
                                        	}
                                	else
                                        	{
                                        		if ($gotocheck > $numrows)
                                               			{
               	                                       			$gotocheck = $numrows;
               	                               			}
	                               			$row = pg_fetch_row($result,$gotocheck-1);
                               			}

        			} //end of deletebutton
	
		
			$voucherid = $row[0];
	                $voucherdate = $row[1];
                        $payserial = $row[2];
	                $clientname = $row[3];
			$accountname = $row[4];
		
		if ($radiotest != "official")
                	{
				$toloc = $row[9];
                                $matone = $row[11];
                                $mattwo = $row[13];
                                
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
				$tkrate = $row[23];
				$shiptripid = $row[28];
		
				if ($radiotest =="normal")
                			{              
                                		$comment = $row[21];                                		
						$partoradvance = $row[24];						
                                		$tkratetwo =$row[29];
                                		$departuredate = $row[25];
						$paylocation = $row[26];
						$through = $row[27];
					}
				
				if($radiotest=="purchase")
                        		{ 
                                		$comment = $row[22];
						$through = $row[24];
						$tkratetwo =$row[25];
						$partoradvance = $row[26];
						$paylocation = $row[27];
					}
			}
			
		if($radiotest=="official")
                        {
                                $payamount = $row[5];
                                $paytype = $row[6];
                                $bankname = $row[7];
                                $bankbranch = $row[8];
                                $chequeno = $row[9];
                                $chequepaydate = $row[10];
                                $expensetype = $row[11];
                                $comment = $row[13];
				$through = $row[14];			
			}
			
		$navigation = "false";	
	
	
	} //end of navigation

			/********************Navigation end***************************/
        	/***********************************************************/	



                /////////////////////////////////////////////////////////////////////

                /*******************     For ADD BUTTON      **********************/

                ///////////////////////////////////////////////////////////////////

                if (($filling == "addbutton" && $savecancel == "true") || ($filling == "editbutton" && $savecancel == "true"))
                        {
                                //$payamount = abs($payamount);
                                //$tkrate = abs($tkrate);
                                print("$filling\t....$savecancel....499");

                                ///********************** First Check for duplicate data****************************///
                                ///**************************************************************************///

                                $payserial = abs($payserial);
				if ($filling == "addbutton")
					{
                                		$dupresult= pg_exec($conn,"select * from payment_voucher where (voucher_no='$payserial') ");
                                	}					
					
				if ($filling == "editbutton")
					{
						$dupresult= pg_exec($conn,"select * from payment_voucher where (voucher_no='$payserial') and (voucher_id !='$voucherid')");
					}
                                
				$dupnumrows = pg_numrows($dupresult);
				print("$filling\t....$savecancel....516...$dupnumrows.///...");
				if ($dupnumrows !=0)
                                        {
                                                if ($radiotest =="normal")
                                                        {
                                                                $result = pg_exec("select * from view_payment_carrying");
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
										$partoradvance = $row[24];
										$shiptripid = $row[28];
                                                                                $tkratetwo = $row[29];
                                                                                $departuredate = $row[25];
										$paylocation = $row[26];
										$through = $row[27];
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
								$tkratetwo = $row[25];
								$partoradvance = $row[26];
								$paylocation = $row[27];
								$shiptripid = $row[28];

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
                                                if ($filling == "addbutton")
							{
								$add_edit_duplicate = 'false' ;

                                                		if($radiotest=="normal")
                                                        		{
                                                                		$car_pur_off = "Carrying";
                                                                		$payamount = abs($payamount);
										if ($shiptripid =="")
                                                                                        {
                                                                                                $shiptripid = 0;
                                                                                        }

                                                                                print ("$shiptripid");

                                                                                $payserial = abs($payserial);

                                                                                $result = pg_exec("select *  from cargo_schedule where ship_id = $shipname  and trip_id=$shiptripid  order by schedule_id");    // previously there was another condition after balance,--- total_tk!=0   and balance_tk!=0

                                                                                $cargo_numrows = pg_numrows($result);								
                                                             
                                                                                print($paytype) ;


                                                                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                                                //************************************For ADD IN PAYMENT VOUCHER & Cargo Schedule When "Carrying"  *********************

                                                                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                               

                                                                                if ($cargo_numrows==0)
                                                                                        {         // cargonumrows zero starts ... fresh entry for a ship

                                                                                                $cargotrip =pg_exec("select max(trip_id) from cargo_schedule where ship_id=$shipname");
                                                                                                $cargotripnumrows = pg_numrows($cargotrip);
												print("we have to check cargotripnumrows....$cargotripnumrows") ;
                                                                                                if($cargotripnumrows==0)
                                                                                                        {
                                                                                                                $ltripid =1;  //before it was tripid=0
                                                                                                        }
                                                                                                else
                                                                                                        {
                                                                                                                ///*********experimental...to adjust tripid automatically in payment voucher****************///
														print("we are in experimental position....") ;
														$exptrip =pg_exec("select max(trip_id) from payment_voucher where ship_id=$shipname and pay_voucher_date<='$voucherdate'");
														$expnumrows = pg_numrows($exptrip);
														if($expnumrows==0)
                                                                                                        		{
                                                                                                                		$ltripid =1;
                                                                                                        		}
														else
                                                                                                        		{
																$exptripid  =  pg_fetch_row($exptrip,0);
                                                                                                                		$ltripid =  $exptripid[0];
																$ltripid = $ltripid+1 ;
																print("position for tripid..$ltripid..") ;
																$exptripresult = pg_exec("select max(trip_id) from payment_voucher where (ship_id=$shipname and pay_voucher_date > '$voucherdate') ");
																$expnumrows = pg_numrows($exptripresult);
																print("total expnumrows...$expnumrows....") ;
																if($expnumrows==0)
                                                                                                        				{
                                                                                                                				$exptripid =0;
                                                                                                        				}
																else
                                                                                                        				{
																		$maxtripresult  =pg_fetch_row($exptripresult,0);
																		$aftertripid =  $maxtripresult[0];
																		print("find maximum tripid to edit after payvoucherdate...$aftertripid.") ;
																		for ($i = $aftertripid; $i>=$ltripid ; $i--)
																			{
																				$searchresult =pg_exec("select * from payment_voucher where ship_id=abs($shipname) and pay_voucher_date > '$voucherdate' and trip_id=abs($i) order by pay_voucher_date, voucher_no");
																				$searchnumrows = pg_numrows($searchresult);
																				print("find searchnumrows...$searchnumrows..and i ..$i.") ;
																				if($searchnumrows!=0)
                                                                                                        								{
                                                                                                                								for ($j = 0; $j<$searchnumrows ; $j++)
																							{
																								$partsearchresult =  pg_fetch_row($searchresult,$j);
																								$partvoucherid =     $partsearchresult[0];
																								$partvoucherdate =   $partsearchresult[1];
																								$partpayamount    =  $partsearchresult[2];
																								$partclientname =    $partsearchresult[3];
																								$partshipname =      $partsearchresult[4];
																								$partfromloc =       $partsearchresult[5];
																								$parttoloc =         $partsearchresult[6];
																								$partmatone =        $partsearchresult[7];
																								$partmattwo =        $partsearchresult[8];
																								$partpaytype =       $partsearchresult[9];
																								$partbankname =      $partsearchresult[10];
																								$partbankbranch =    $partsearchresult[11];
																								$partchequepaydate = $partsearchresult[12];
																								$partpayserial =     $partsearchresult[13];
																								$partpaylocation =   $partsearchresult[14];
																								$partdeparturedate = $partsearchresult[15];
																								$partcomment =       $partsearchresult[16];
																								$partcar_pur_off =   $partsearchresult[17];
																								$partchequeno   =    $partsearchresult[18];
																								$parttkrate =        $partsearchresult[20];
																								$parttripid =        $partsearchresult[21];
																								$partthrough =       $partsearchresult[22];
																								$partpartoradvance = $partsearchresult[23];
																								$parttkratetwo =     $partsearchresult[26];
																								
																								$parttripid++;
																								print("is it increased..$parttripid..") ;
																								if ($partdeparturedate=="")
                                                                                                             												{																								
																										if (trim($paytype)=="Cheque")
                                																							{
                                                               																					$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$partvoucherid','$partvoucherdate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequepaydate','$partpayserial','$partpaylocation','$partcomment','$partcar_pur_off','$parttkrate','$parttkratetwo','$parttripid','$partpartoradvance','$partthrough')");
																											}
							
																										if (trim($paytype)=="Cash")
                                																							{	
																												$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$partvoucherid','$partvoucherdate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partpayserial','$partpaylocation','$partcomment','$partcar_pur_off','$parttkrate','$parttkratetwo','$parttripid','$partpartoradvance','$partthrough')");
																											}
																									}																								
																								else
																									{
																										if (trim($paytype) =="Cash")
                                                                        																		{
                                                                                                                														$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id, pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$partvoucherid','$partvoucherdate','$partdeparturedate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partpayserial','$partcomment','$partcar_pur_off','$parttkrate','$partcargotripid','$partpartoradvance','$partthrough','$parttkratetwo')");
																											}
															
																										if (trim($paytype)=="Cheque")
                                                        																				{
																												$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id, pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$partvoucherid','$partvoucherdate','$partdeparturedate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequepaydate','$partpayserial','$partcomment','$partcar_pur_off','$parttkrate','$partcargotripid','$partpartoradvance','$partthrough','$parttkratetwo')");
																											}
																									}
																							
																							
																																							
																							}
																							///************************* start changing cargo schedule trip number**************/////
																							
																						$cargosearchresult1 =pg_exec("select * from cargo_schedule where ship_id=abs($shipname) and trip_id=abs($i) ");	
																						$cargosearchresult =  pg_fetch_row($cargosearchresult1,0);
																						$scheduleid =       $cargosearchresult[0];
																						$departuredate=    $cargosearchresult[1];
																					//	$ship_name=         $cargosearchresult[2];
																						$owner_name=        $cargosearchresult[3];                                                                                                
                                                                                                										$fromloc=       $cargosearchresult[4];
                                                                                                										$toloc=         $cargosearchresult[5];
                                                                                                										$matone=        $cargosearchresult[6];
                                                                                                										$mattwo=        $cargosearchresult[7];
                                                                                                										$quantityone=   $cargosearchresult[8];
                                                                                                										$quantitytwo=   $cargosearchresult[9];
                                                                                                										$goodquantityone= $cargosearchresult[8];
                                                                                                										$goodquantitytwo= $cargosearchresult[9];
																						$voucherdate =   $cargosearchresult[10];
                                                                                                										$advance =        $cargosearchresult [11];
                                                                                                										$parttk =         $cargosearchresult[12];
                                                                                                										$cargotripid =    $cargosearchresult [18];
                                                                                                										$balancetk =      $cargosearchresult [15];
                                                                                                										$totaltk =        $cargosearchresult[14];	           
                                                                                                										$receivetkratetwo= $cargosearchresult[28];
																						$unload_date = $cargosearchresult[19];
                                                                                                										$receiveadvance=$cargosearchresult[20];                                                                                                                
                                                                                                										$receiveparttk= $cargosearchresult[21];
                                                                                                										$receivetotaltk=$cargosearchresult[22];
																						$receivetkrate= $cargosearchresult[24];
																						$moneyreceivedate = $cargosearchresult[25];
                                                                                                										$receivefrom =  $cargosearchresult[26];
																						
																						$cargotripid++;

                                                                                                										if ($cargosearchresult[23]=="")
                                                                                                											{
                                                                                                        											$receivebalancetk = NULL;
                                                                                                        										}
                                                                                                										else
                                                                                                											{
                                                                                                        											$receivebalancetk=  $cargosearchresult[23];
                                                                                                        										}

                                                                                                										
                                                                                                										
																						if ($departuredate!="")
                                                                                                            										{   ///////   If departure date is not blank...Starts
                                                                                                               
                                                                                                                        									if ($unload_date!="")
                                                                                                                                									{  ///// Checking if unload date is not blank...Starts

                                                                                                                                										if ($moneyreceivedate!="")
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$unload_date','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                										//  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        										}

                                                                                                                                										else
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");

                                                                                                                                        										}

                                                                                                                              										}  /////   checking unload date is not blank.. Ends

                                                                                                                           									else
                                                                                                                              										{  ///// Checking if unload date is blank...Starts

                                                                                                                                										if ($moneyreceivedate!="")
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                										//  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        										}

                                                                                                                                										else
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
																																																																															print("....$quantityone....$quantitytwo.");							

                                                                                                                                        										}

                                                                                                                              										}  /////   checking unload date is blank.. Ends                                                                                                                        


                                                                                                            										} ///////  If derparture date is not blank... Ends

                                                                                                          									else
                                                                                                            										{   ///////   If departure date is blank...Starts
                                                                                                                		
                                                                                                                        									if($unload_date!="")
                                                                                                                          										{  ///// If unload date is not blank..Starts

                                                                                                                                										if ($moneyreceivedate!="")
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo','$unload_date')");                                                                                                                                              
                                                                                                                                        										}
                                                                                                                                										else
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo','$unload_date')");
                                                                                                                                        										}

                                                                                                                         										}   //// iF unload date is not blank.....Ends
                                                                                                                          									else

                                                                                                                             										{  ///// If unload date is  blank..Starts

                                                                                                                                										if ($moneyreceivedate!="")
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                
                                                                                                                                        										}

                                                                                                                                										else
                                                                                                                                        										{
                                                                                                                                                										$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                        										}

                                                                                                                             										}   //// iF unload date is  blank.....Ends                                                                                                                  


                                                                                                            										} ///////  If derparture date is  blank... Ends
		
																								
																					}
																				//print("<TD><font size=-1> $row[$column_num]</font></TD>\n");

																			}
																	}
																
															
															}
														
														
															
														///*********End Of experimental...to adjust tripid automatically****************///
														
														
														//$cargotripid  = pg_fetch_row($cargotrip,0);
                                                                                                               // $tripid =  $cargotripid[0];
                                                                                                        }

                                                                                                //$tripid = $tripid+1 ;

                                                                                                $partoradvance = "Advance";
												
												if (trim($paytype) =="Cash")
                                                                        				{        //Cash condition starts

                                                                                				print($paytype) ;
                                                                                                                $pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$ltripid','$partoradvance','$through','$tkratetwo')");
													}
													
												if (trim($paytype)=="Cheque")
                                                        						{
                                                                                           			print($paytype) ;
														$pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$ltripid','$partoradvance','$through','$tkratetwo')");
													}

                                                                                                $balancetk = $balancetk - $payamount;

                                                                                                $result = pg_exec($conn,"insert into cargo_schedule (pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,balance_tk,trip_id,fair_rate_two) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$ltripid','$tkratetwo')");


                                                                                        }    // cargo numrows zero condition ( Fresh entry ) ends

                                                                                else
                                                                                        {   //########## When the the condition for balance and total taka is not zero ####################

                                                                                                $upresult = pg_fetch_row($result,0);

                                                                                                $scheduleid =       $upresult[0];
												$departuredate=    $upresult[1];
												$ship_name=         $upresult[2];
												$owner_name=        $upresult[3];
                                                                                                
                                                                                                $fromloc=       $upresult[4];
                                                                                                $toloc=         $upresult[5];
                                                                                                $matone=        $upresult[6];
                                                                                                $mattwo=        $upresult[7];
                                                                                                $quantityone=   $upresult[8];
                                                                                                $quantitytwo=   $upresult[9];
                                                                                                $goodquantityone= $upresult[8];
                                                                                                $goodquantitytwo= $upresult[9];
												$receivedate=   $upresult[10];
                                                                                                $advance =        $upresult [11];
                                                                                                $parttk =         $upresult[12];
                                                                                                $cargotripid =    $upresult [18];

                                                                                                $balancetk =      $upresult [15];
                                                                                                $totaltk =        $upresult[14];
												
												$receivetkrate= $upresult[24];
                                                                                                $receivetkratetwo= $upresult[28];
                                                                                                $receiveadvance=$upresult[20];
                                                                                                                
                                                                                                $receiveparttk= $upresult[21];
                                                                                                $receivetotaltk=$upresult[22];

                                                                                                $receivefrom =  $upresult[26];

                                                                                                if ($upresult[23]=="")
                                                                                                	{
                                                                                                        	$receivebalancetk = NULL;
                                                                                                        }
                                                                                                else
                                                                                                	{
                                                                                                        	$receivebalancetk=  $upresult[23];
                                                                                                        }

                                                                                                $moneyreceivedate = $upresult[25];
                                                                                                $unload_date = $upresult[19];												

                                                                                                if($goodquantityone!="" and $goodquantityone!=0)    //  departuredate is supposed to be replaced by goodquantityone

                                                                                                        {       //################# For quantityone is  not blank or zero  ############

                                                                                                                $partoradvance = "Part";
														
														if (trim($paytype) =="Cash")
                                                                        						{        //Cash condition starts

                                                                                                                		$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo')");
															}
															
														if (trim($paytype)=="Cheque")
                                                        								{
                                                                                           					print($paytype) ;
																$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo')");
															}
															
                                                                                                                $parttk = $parttk+$payamount;

                                                                                                                $totaltk = (abs($goodquantityone) *  abs($tkrate)) + (abs($goodquantitytwo)  *  abs($tkratetwo)) ;

                                                                                                                $balancetk = $totaltk - ($parttk+$advance);

                                                               
                                                                                                        	if ($departuredate!="")

                                                                                                             		{  ///////////  If departure date is not blank..... Starts
                                                                                                                
                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {

                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends



                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends
                                                                                                                       

                                                                                                             		}   // For deaparture date not blank.......  ends

                                                                                                        	else
                                                                                                             		{  ///////////  If departure date is  blank..... Starts                                                                                                                

                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends
                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends                                                                                                                       

                                                                                                             		}   // For deaparture date is blank.......  ends


                                                                                                        }       // For quantityone is not zero or  blank...  ends

                                                                                                else
                                                                                                        {         //// For quantityone is blank or zero..... Starts

                                                                                                                print("Updating advance.........line no 901");
                                                                                                                $advance = $advance + $payamount;
                                                                                                                $balancetk = $totaltk - $advance;
														$payserial = abs($payserial);
                                                                                                                $partoradvance = "Advance";

                                                                                                                if (trim($paytype) =="Cash")
                                                                        						{        //Cash condition starts
																$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo')");
															}
															
														if (trim($paytype)=="Cheque")
                                                        								{
                                                                                           					print($paytype) ;															
																$pay_add_result2 = pg_exec("insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo')");
															}
                                                                                                                                                             

                                                                                                         	if ($departuredate!="")
                                                                                                            		{   ///////   If departure date is not blank...Starts
                                                                                                               
                                                                                                                        	if ($unload_date!="")
                                                                                                                                	{  ///// Checking if unload date is not blank...Starts

                                                                                                                                		if ($moneyreceivedate!="")
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$unload_date','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                		//  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        		}

                                                                                                                                		else
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");

                                                                                                                                        		}

                                                                                                                              		}  /////   checking unload date is not blank.. Ends

                                                                                                                           	else
                                                                                                                              		{  ///// Checking if unload date is blank...Starts

                                                                                                                                		if ($moneyreceivedate!="")
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                		//  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        		}

                                                                                                                                		else
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");

                                                                                                                                        		}

                                                                                                                              		}  /////   checking unload date is blank.. Ends                                                                                                                        


                                                                                                            		} ///////  If derparture date is not blank... Ends

                                                                                                          	else
                                                                                                            		{   ///////   If departure date is blank...Starts
                                                                                                                		
                                                                                                                        	if($unload_date!="")

                                                                                                                          		{  ///// If unload date is not blank..Starts

                                                                                                                                		if ($moneyreceivedate!="")
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo','$unload_date')");                                                                                                                                              
                                                                                                                                        		}
                                                                                                                                		else
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo','$unload_date')");
                                                                                                                                        		}

                                                                                                                         		}   //// iF unload date is not blank.....Ends
                                                                                                                          	else

                                                                                                                             		{  ///// If unload date is  blank..Starts

                                                                                                                                		if ($moneyreceivedate!="")
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                
                                                                                                                                        		}

                                                                                                                                		else
                                                                                                                                        		{
                                                                                                                                                		$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                        		}

                                                                                                                             		}   //// iF unload date is  blank.....Ends                                                                                                                  


                                                                                                            		} ///////  If derparture date is  blank... Ends


                                                                                                        }    // When updating advance(quantityone is zero or blank):::::::::::::: Condition Ends here


                                                                                        }        //************************END ADD IN CARGO FOR Carrying and CASH TYPE*************


                             
			      //************************END ADD IN CARGO FOR Carrying  CASH and CHEQUE TYPE*************


                                                        //////////END OF CARRYING + CHEQUE OPTION///////////////////////


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
				$partoradvance = $row[24];
				$through = $row[27];
                                $tkratetwo = $row[29];

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

			if ($shiptripid =="")
                        	{
                                	$shiptripid = 0;
                                }

                                        $payserial = abs($payserial);

                                        $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname  and trip_id=$shiptripid  ");

                                        $cargo_numrows = pg_numrows($result);  

                                        //print ("Entered in $paytype\t");

                                        //************************************For ADD IN PAYMENT VOUCHER & Purchase_Sale  Schedule FOR Purchase + CHEQUE*********************

                                        //   $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname and balance_tk!=0 and total_tk=0 order by schedule_id");
                                        

                                        if ($cargo_numrows==0)
                                                {         // cargonumrows zero starts ... fresh entry for a ship

                                                        print("Not cheque advance update.... Fresh Entry..line..1642");

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
                                                                     
							$partoradvance = "Advance";
							if (trim($paytype)=="Cheque")
                                				{
                                                               		$pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tkratetwo','$tripid','$partoradvance','$through')");
								}
							
							if (trim($paytype)=="Cash")
                                				{	
									$pay_add_result1 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tkratetwo','$tripid','$partoradvance','$through')");
								}                                                              

                                                        $balancetk = $balancetk - $payamount;
                                                        $result = pg_exec($conn,"insert into purchase_sale_schedule (paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,fair_rate_two,advance_tk,balance_tk,trip_id) values('$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$tkratetwo','$payamount','$balancetk','$tripid')");

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
							
                                                        //          $receivedate=   $payment_fields[10];
                                                        //          $owner_name=    $payment_fields[3];
                                                        $ship_name=     $upresult[1];
                                                        //$fromloc=       $upresult[3];
                                                        //$toloc=         $upresult[4];
                                                        //$matone=        $upresult[5];
                                                        //$mattwo=        $upresult[6];
                                                        $quantityone=   $upresult[7];
                                                        $quantitytwo=   $upresult[8];
                                                        $receivetkrate=     $upresult[20];
                                                        $receiveadvance=    $upresult[15];
                                                        //$departdate=    $payment_fields[1];
                                                        $receiveparttk=     $upresult[16];
                                                        $receivetotaltk=    $upresult[17];
                                                        $cargotripid=   $upresult[14];
                                                        $receivefrom =   $upresult[19];
							  //       $moneyreceivedate = $payment_fields[25];

                                                                 //       $unload_date = $payment_fields[19];

                                                        if ($upresult[18]=="")
                                                        	{
                                                                	$receivebalancetk = NULL;
                                                                }
                                                        else
                                                                {
                                                                        $receivebalancetk=  $upresult[18];
                                                                }


                                                        if ($quantityone!="" or $quantityone!=0)
                                                                {       //################# For deaparture date not blank2 ############

                                                                        $partoradvance = "Part";
									if (trim($paytype)=="Cheque")
                                						{
                                                                        		$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$through')");
										}
									if (trim($paytype)=="Cash")
                                						{
											$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$through')");
										}
                                                                        $parttk = $parttk+$payamount - $payamount_backup;

                                                                        print("\t$parttk");

                                                                        $totaltk = (abs($goodquantityone) * abs($tkrate)) + (($goodquantitytwo) * abs($tkratetwo));

                                                                        print("\t$totaltk");

                                                                        $balancetk = $totaltk - ($parttk+$advance); print("\t$balancetk");
                                                                                                                
                                                                        
                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,fair_rate_two,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$scheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$tkratetwo','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");
                                                                        
                                                                }        // For deaparture date not blank2  ends

                                                        else
                                                                {         //// For deaparture date (purchase_goodquantityone) blank3

                                                                        print("Updating advance");
                                                                        $advance = $advance + $payamount - $payamount_backup;
                                                                        $balancetk = $totaltk - $advance;

                                                                        $partoradvance = "Advance";

                                                                        if (trim($paytype)=="Cheque")
                                						{
											$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$through')");
										}
										
									if (trim($paytype)=="Cash")
                                						{
											$pay_add_result2 = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$through')");
										}
                                                      
                                                                                                                                           
                                                      
                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$pursalescheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,fair_rate_two,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,sale_fair_rate_two,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$pursalescheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$tkratetwo','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receivetkratetwo','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                  
                                                                }    // When updating advance:::::::::::::: Condition Ends here



                                                }        //************************END ADD IN Purchase_Sale_schedule FOR Purchase and Cheque TYPE*************
                              


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
                        $comment = $row[22];
                        $tkrate = $row[23];
			$tkratetwo = $row[25];
			$paylocation = $row[27];
			$shiptripid = $row[28];

                        $gotocheck = $numrows;



                }               /////////////*****************END OF PURCHASE OPTION *****************///////////////






        ////////////////////////////////////////////////////////////////////////////////////////////

        ////////////**********************START OF OFFICIAL OPTION *****************///////////////


        ///////////////////////////////////////////////////////////////////////////////////////////



                if($radiotest=="official")
                        {

                                $car_pur_off="official";

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




                                ///////////*******************START OF OFFICIAL + CHEQUE OPTION ***********///////////////
                                print("Add Check in $car_pur_off");
                             //   $voucherdate = date("Ymd");
                             //   print("$voucherdate");

                                if ($paytype=="Cheque")
                                        {
                                                print("Official&Cheque");
                                                $result = pg_exec($conn,"insert into payment_voucher (pay_voucher_date,amount,account_id,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno,off_accountname,through) values('$voucherdate','$payamount','$clientname','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno','$expensetype','$through')");
                                        }


                                ///////////*******************START OF OFFICIAL + CASH OPTION ***********///////////////


                                if ($paytype=="Cash")
                                        {
                                                $result = pg_exec("insert into payment_voucher (pay_voucher_date,amount,account_id,pay_type,voucher_no,comment,car_pur_off,off_accountname,through) values('$voucherdate','$payamount','$clientname','$paytype','$payserial','$comment','$car_pur_off','$expensetype','$through')");

                                        }



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
				$through = $row[14];

                                $gotocheck = $numrows;



                        }        //////////////******************** END OF OFFICIAL OPTION *****************///////////////////

		} ///end of addbutton


                }/////added by me to check duplicate record,,,its the end of else....



        }



	///////******************************************************************************************************///
	///////*****************************************************************************************************////
	//////*****************************************************************************************************////
	////************************* Starting EDIT BUTTON ****************************************************//////
	//////**************************** FOR EDIT BUTTON  ***************************************************//////



	if ($filling == "editbutton")
        	{
			print("we are in edit mode...proceed to check duplicate serialno...gotocheck is ..$gotocheck") ;
				 
				 ///*********************************************************************************///
				 ///********************** First Check for duplicate data****************************///
                                ///**************************************************************************///

                               
                                                print("duplicate record not found...proceed to next...gotocheck is ..$gotocheck");
						$add_edit_duplicate = 'false' ;

                                                if($radiotest=="normal")
                                                        {
                                                                print("we are in normal...radiotest is ...$radiotest..line no 1530...paytype is ...$paytype..");
								$car_pur_off = "Carrying";
                                                                $payamount = abs($payamount);

                                                                if ($shiptripid =="")
                                                                                        {
                                                                                                $shiptripid = 0;
                                                                                        }
                                                                                
                                                                print ("find shiptripid....$shiptripid.......and ...shipid is ...$shipname...gotocheck is ..$gotocheck...");
								$payserial = abs($payserial);
								
								$result = pg_exec("select *  from cargo_schedule where (ship_id = '$shipname'  and trip_id='$shiptripid') order by schedule_id");    // previously there was another condition after balance,--- total_tk!=0   and balance_tk!=0

                                                                $cargo_numrows = pg_numrows($result);								
																
                                                                print("cargo_numrows..$cargo_numrows....line no 1489...proceed to next...gotocheck is ..$gotocheck...") ;

                                                                     									                                                                           
                                                                if ($cargo_numrows==0)
                                                                	{         // cargonumrows zero starts ... fresh entry for a ship

										print ("there is no record in cargo_schedule..we have to insert a new one......$cargo_numrows...gotocheck is ..$gotocheck...");

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
                                                                                $partoradvance = "Advance";
										$balancetk = $balancetk - $payamount;
												
										if (trim($paytype) =="Cash")
                                                                        		{        //Cash condition starts

                                                                                		print("we are in cashmode...$paytype...line no 1509...proceed to next...gotocheck is ..$gotocheck...") ;
                                                                                                $pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through','$tkratetwo')");                                                                                                                              	
											}
												
										if (trim($paytype)=="Cheque")
                                                        				{
												print("we are in chequemode...$paytype...line no 1517...proceed to next...gotocheck is ..$gotocheck...") ;	
												$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through','$tkratetwo')");                                                                         
											}
										
										$result = pg_exec($conn,"insert into cargo_schedule (pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,balance_tk,trip_id,fair_rate_two,voucher_id) values('$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$payamount','$balancetk','$tripid','$tkratetwo','$voucherid')");

                                                                        }    // cargo numrows zero condition ( Fresh entry ) ends


                                                                else
                                                                	{   //########## When the the condition for balance and total taka is not zero ####################

										print ("we found record in cargo_schedule..we have to edit it...line no 1527......$cargo_numrows...gotocheck is ..$gotocheck...");
                                                                                $upresult = pg_fetch_row($result,0);
												
                                                                                $scheduleid   =     $upresult[0];																							
										$departuredate  =      $upresult[1];
										$ship_name  =       $upresult[2];
										$owner_name  =      $upresult[3];
										//$fromloc  =         $upresult[4];
                                                                                //$toloc  =           $upresult[5];
										//$matone  =          $upresult[6];
                                                                                //$mattwo  =          $upresult[7];
                                                                                $goodquantityone  = $upresult[8];
                                                                                $goodquantitytwo  = $upresult[9];
										//$payvoucherdate  =  $upresult[10];
                                                                                $advance   =        $upresult[11];
                                                                                $parttk   =         $upresult[12];
										$totaltk   =        $upresult[14];
										$balancetk   =      $upresult[15];
                                                                                $cargotripid   =    $upresult[18];                                                                                              													                                                                                                                                                                                              
                                                                                $unload_date   =    $upresult[19];
                                                                                $receiveadvance  =  $upresult[20];
										$receiveparttk    = $upresult[21];
                                                                                $receivetotaltk   = $upresult[22];                                                                                                
										$receivetkrate  =   $upresult[24];
										$moneyreceivedate = $upresult[25];
										$receivefrom 	=   $upresult[26];
                                                                                $receivetkratetwo = $upresult[28];                                                                                               
                                                                                print ("we found scheduleid in cargo_schedule..it is......$scheduleid and goodquantityone is... $goodquantityone");

                                                                                if ($upresult[23]=="")
                                                                                	{
                                                                                         	$receivebalancetk = NULL;
                                                                                        }
                                                                                 else
                                                                                 	{
                                                                                        	$receivebalancetk=  $upresult[23];
                                                                                        }
												                                                         
                                                                                                

                                                                                 if($partoradvance == "Part")    //  departuredate is supposed to be replaced by goodquantityone

                                                                                 	{       //################# For quantityone is  not blank or zero  ############

                                                                                        	print("we are in part...payvoucherdate is $payvoucherdate and voucherdate is $voucherdate..line no 1571 ..gotocheck is ..$gotocheck...");
												//$partoradvance = "Part";

                                                                                                if (trim($paytype) =="Cash")
                                                                        				{        //Cash condition starts														
														$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two,pay_location) values('$voucherid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo','$paylocation')");
                                                                                                        }
															
												if (trim($paytype)=="Cheque")
                                                        						{
														$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two,pay_location) values('$voucherid','$voucherdate','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo','$paylocation')");
													}
												$parttk = $parttk+$payamount-$payamount_backup;

                                                                                                $totaltk = (abs($goodquantityone)  *  abs($tkrate)) + (abs($goodquantitytwo)  *  abs($tkratetwo)) ;

                                                                                                $balancetk = $totaltk - ($parttk+$advance);

                                                                                                if ($departuredate!="")

                                                                                                	{  ///////////  If departure date is not blank..... Starts                                                                                                                                                                                                                                             
                                                                                                                
                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                print("line no ...1598 ..gotocheck is ..$gotocheck...");
																				$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                print("line no ...1603......gotocheck is ..$gotocheck...");
																				$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends

                                                                                                                                else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                print("line no ...1615 ..gotocheck is ..$gotocheck...");
																				$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                print("line no ...1623... ..gotocheck is ..$gotocheck...");
																				$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends



                                                                                                             }   // For deaparture date not blank.......  ends

                                                                                                        else
                                                                                                             {  ///////////  If departure date is  blank..... Starts                                                                                                              
                                                                                                               
                                                                                                                                if ($unload_date!="")
                                                                                                                                        {  ///// Checking unload date is not blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }
                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,voucher_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is not blank Ends
                                                                                                                                
																else
                                                                                                                                        {  ///// Checking unload date is  blank

                                                                                                                                                if($moneyreceivedate !="")
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                        }

                                                                                                                                                else
                                                                                                                                                        {
                                                                                                                                                                $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$voucherid','$departuredate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                        }

                                                                                                                                        }  ///// Checking unload date is  blank Ends
                                                                                                                      

                                                                                                             }   // For deaparture date is blank.......  ends


                                                                                                        }       // For quantityone is not zero or  blank...  ends


                                                                                                else
                                                                                                        {         //// For ADVANCE..... Starts

                                                                                                                print("Updating advance...line no...1695... ..gotocheck is ..$gotocheck..comment..$comment.");
                                                                                                                $advance = $advance + $payamount - $payamount_backup;
                                                                                                                $balancetk = $totaltk - $advance;
														$payserial = abs($payserial);
                                                                                                                $partoradvance = "Advance";

                                                                                                                if (trim($paytype) =="Cash")
                                                                        						{        //Cash condition starts
																$pay_add_result2 = pg_exec("DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two,pay_location) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo','$paylocation')");

																print("edit success...$paytype...line no...1684...");
															}
															
														if (trim($paytype)=="Cheque")
                                                        								{
																$pay_add_result2 = pg_exec("DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two,pay_location) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance','$through','$tkratetwo','$paylocation')");
																print("edit success...$paytype...line no...1690...");
															}
                                                                                                         	if ($departuredate!="")

                                                                                                         		{   ///////   If departure date is not blank...Starts
                                                                                                                
                                                                                                                            print("Departuredate is $departuredate... ..gotocheck is ..$gotocheck...");
															    if ($unload_date!="")
                                                                                                                            	{  ///// Checking if unload date is not blank...Starts

                                                                                                                                	if ($moneyreceivedate!="")
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$unload_date','$tkratetwo','$receivetkratetwo')");                                                                                                                                                
                                                                                                                                        	}

                                                                                                                                	else
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,unload_date,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$unload_date','$tkratetwo','$receivetkratetwo')");
                                                                                                                                        	}

                                                                                                                              	}  /////   checking unload date is not blank.. Ends


                                                                                                                           else
                                                                                                                           	{  ///// Checking if unload date is blank...Starts

                                                                                                                                	if ($moneyreceivedate!="")
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        	}

                                                                                                                                	else
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departuredate','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");

                                                                                                                                        	}

                                                                                                                              	}  /////   checking unload date is blank.. Ends
                                                                                                                     
                                                                                                        	} ///////  If derparture date is not blank... Ends

                                                                                                      	else

                                                                                                        	{   ///////   If departure date is blank...Starts                                                                                             

                                                                                                                          if($unload_date!="")
                                                                                                                          	{  ///// If unload date is not blank..Starts

                                                                                                                                	if ($moneyreceivedate!="")
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo','$unload_date')");

                                                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        	}

                                                                                                                                	else
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two,unload_date) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo','$unload_date')");

                                                                                                                                        	}

                                                                                                                             	}   //// iF unload date is not blank.....Ends

                                                                                                                          else
                                                                                                                          	{  ///// If unload date is  blank..Starts

                                                                                                                                	if ($moneyreceivedate!="")
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom','$tkratetwo','$receivetkratetwo')");

                                                                                                                                                	//  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                                                        	}

                                                                                                                                	else
                                                                                                                                        	{
                                                                                                                                                	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,money_fair_rate,receive_advance,receive_total,receive_part,receive_balance,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$goodquantityone','$goodquantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$tkratetwo','$receivetkratetwo')");
                                                                                                                                        	}

                                                                                                                             	}   //// iF unload date is  blank.....Ends

                                                                                                                
                                                                                                            	} ///////  If derparture date is  blank... Ends


                                                                                                        }    // When updating advance(quantityone is zero or blank):::::::::::::: Condition Ends here



                                                                                        }        //************************END ADD IN CARGO FOR Carrying and CASH TYPE*************

                                                                                             
				print("...line no...1783... ..gotocheck is ..$gotocheck...");

                                $result = pg_exec("select * from view_payment_carrying");
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
				$partoradvance = $row[24];
				$paylocation = $row[26];
				$departuredate = $row[25];
				$through = $row[27];
                                $tkratetwo = $row[29];

                            //    $gotocheck = $numrows;



                        }    ///end of actual work


      ////************************************************************************//////////////

      ///////////////*********STARTING PURCHASE OPTION***************************///////////////

      //////////////************************************************************////////////////

        if($radiotest=="purchase")
                {

                	$car_pur_off = "Purchase";
                	$payamount = abs($payamount);

                	print ("Entered in Purchase option ");

			if ($shiptripid =="")
                                                {
                                                        $shiptripid = 0;
                                                }

                        $payserial = abs($payserial);

                        $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname  and trip_id=$shiptripid  ");

                        $cargo_numrows = pg_numrows($result);



                        ///////////////////////////////////////////////////////////////////////////////////////////

                        ///////////////*********STARTING PURCHASE + CHEQUE OPTION*****************/////////////////

                        ///////////////////////////////////////////////////////////////////////////////////////////

                        
                                        print ("Entered in $paytype....total receord..$cargo_numrows...\t");

                                        //************************************For ADD IN PAYMENT VOUCHER & Purchase_Sale  Schedule FOR Purchase + CHEQUE*********************

                                        //   $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname and balance_tk!=0 and total_tk=0 order by schedule_id");
                                       
                                        if ($cargo_numrows==0)
                                                {         // cargonumrows zero starts ... fresh entry for a ship

                                                        print("Not cheque advance update.... Fresh Entry..line no..2656..");

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
							
							$partoradvance = "Advance";
							$balancetk = $balancetk - $payamount+$payamount_backup;
												
							if (trim($paytype) =="Cash")
                                                        	{        //Cash condition starts
                                                        		print("we are in cashmode...$paytype...line no 2713...proceed to next...gotocheck is ..$gotocheck...") ;
                                                                        $pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,bank_name,branch,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$bankname','$bankbranch','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through','$tkratetwo')");
                                                                                                              	
								}
	
							if (trim($paytype)=="Cheque")
                                				{
									print("we are in chequemode...$paytype...line no 2720...proceed to next...gotocheck is ..$gotocheck...") ;	
									$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$paylocation','$comment','$car_pur_off','$tkrate','$tripid','$partoradvance','$through','$tkratetwo')");                                                                         
                                                                                
								}
							
							
                                                         $result = pg_exec($conn,"insert into purchase_sale_schedule (paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,fair_rate_two,advance_tk,balance_tk,trip_id) values('$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$tkratetwo','$payamount','$balancetk','$tripid')");


                                                }    // cargo numrows zero condition ( Fresh entry ) ends


                                                //########## When the the condition for balance and total taka is not zero ####################

                                        else
                                                {
                                                        $upresult = pg_fetch_row($result,0);
							


                                                        $pursalescheduleid = $upresult[0];
							$ship_name=     $upresult[1];
							//$fromloc=       $upresult[3];
                                                        //$toloc=         $upresult[4];
                                                        //$matone=        $upresult[5];
                                                        //$mattwo=        $upresult[6];
                                                        $purchase_goodquantityone= $upresult[7];
                                                        $purchase_goodquantitytwo= $upresult[8];
                                                        $advance = $upresult [9];
                                                        $parttk = $upresult[10];
							$totaltk = $upresult[11];
							$balancetk = $upresult [12];
                                                        $cargotripid = $upresult [14];
							$receiveadvance=    $upresult[15];
							$receiveparttk=     $upresult[16];
                                                        $receivetotaltk=    $upresult[17];
							$receivefrom =   $upresult[19];
							$receivetkrate=     $upresult[20];
                                                        print("quantityone-'$goodquantityone'");
						//      f$moneyreceivedate = $payment_fields[25];

                                               //       $unload_date = $payment_fields[19];

							
                                                        print("Where totaltaka not zero,quantitytwo-'$goodquantitytwo'");
                    
                                                                        if ($upresult[18]=="")
                                                                                {
                                                                                        $receivebalancetk = NULL;
                                                                                }
                                                                        else
                                                                                {
                                                                                        $receivebalancetk=  $upresult[18];
                                                                                }



                                                        if ($partoradvance == "Part")
                                                                {       //################# For deaparture date not blank2 ############

                                                                        $partoradvance = "Part";
									if ($paytype=="Cheque")
                                						{

                                                                        		$pay_add_result2 = pg_exec("DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");
										}
										
									if ($paytype=="Cash")
                                						{
											$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$cargotripid','$partoradvance')");
										}

                                                                        $parttk = $parttk+$payamount-$payamount_backup;

                                                                        print("\t$parttk");

                                                                        $totaltk = (abs($purchase_goodquantityone)  *  abs($tkrate)) + (abs($purchase_goodquantitytwo) *  abs($tkratetwo));

                                                                        print("\t$totaltk");

                                                                        $balancetk = $totaltk - ($parttk+$advance); print("\t$balancetk");


                 
                                                                

                                                                       

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

                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$pursalescheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,fair_rate_two,advance_tk,part_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from) values('$pursalescheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$tkratetwo','$advance','$parttk','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom')");

                                                                                    //                            }

                                                                                   //            }  ///// Checking unload date is  blank Ends

                                                                        


                                                                }        // For deaparture date not blank2  ends


                                                        else
                                                                {         //// For deaparture date (purchase_goodquantityone) blank3
                                                                        
                                                                        $advance = $advance + $payamount - $payamount_backup;
                                                                        $balancetk = $totaltk - $advance;
									print("Updating advance.....$balancetk");
                                                                        $partoradvance = "Advance";
									

                                                                        if ($paytype=="Cheque")
                                						{
											$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,pay_location,through) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$chequeno','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$paylocation','$through')");

										}
									
									if ($paytype=="Cash")
                                						{	
											$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,pay_location,through) values('$voucherid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$payamount','$paytype','$payserial','$comment','$car_pur_off','$tkrate','$tkratetwo','$cargotripid','$partoradvance','$paylocation','$through')");
										}
                                                      

                                                                       // $receivefrom =   $payment_fields[19];

                                                                      //  $cargotripid=   $payment_fields[14];



                                                                        
                                                                                     /*           if ($moneyreceivedate!="")
                                                                                                        {

                                                                                                                $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$moneyreceivedate','$receivefrom')");

                                                                                                                //  $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into cargo_schedule (pur_sale_schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,matone_id,mattwo_id,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id) values('$scheduleid','$voucherdate','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$tkrate','$advance','$parttk','$totaltk','$balancetk','$cargotripid')");
                                                                                                        }

                                                                                                else
                                                                                                        {
                                                                                       */
                                                                                                                $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$pursalescheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,total_tk,balance_tk,trip_id,sale_fair_rate,receive_advance,receive_total,receive_part,receive_balance,received_from,voucher_id,pay_voucher_date) values('$pursalescheduleid','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$tkrate','$advance','$totaltk','$balancetk','$cargotripid','$receivetkrate','$receiveadvance','$receivetotaltk','$receiveparttk','$receivebalancetk','$receivefrom','$voucherid','$voucherdate')");

                                                                                       //                 }
                                                                          

                                                                }    // When updating advance:::::::::::::: Condition Ends here



                                                }        //************************END ADD IN Purchase_Sale_schedule FOR Purchase and Cheque TYPE*************
                                           


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


                        $amount = $row[15];
                        $paytype = $row[16];
                        $bankname = $row[17];
                        $bankbranch = $row[18];
                        $chequeno = $row[19];
                        $chequepaydate = $row[20];
                        $comment = $row[22];
                        $tkrate = $row[23];
			$through = $row[24];
			$tkratetwo = $row[25];
			$paylocation = $row[27];


                    //    $gotocheck = $numrows;



                }               /////////////*****************END OF PURCHASE OPTION *****************///////////////






        ////////////////////////////////////////////////////////////////////////////////////////////

        ////////////**********************START OF OFFICIAL OPTION *****************///////////////


        ///////////////////////////////////////////////////////////////////////////////////////////



                if($radiotest=="official")
                        {

                                $car_pur_off="official";

                                           print("official&Cash");
                                           print("$voucherdate");                               

                                ///////////*******************START OF OFFICIAL + CHEQUE OPTION ***********///////////////
                                print("Add Check in $car_pur_off");
                             //   $voucherdate = date("Ymd");
                             //   print("$voucherdate");

                                if ($paytype=="Cheque")
                                        {
                                                print("Official&Cheque");
                                                $result = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,amount,account_id,pay_type,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,chequeno,off_accountname,through) values('$voucherid','$voucherdate','$payamount','$clientname','$paytype','$bankname','$bankbranch','$chequepaydate','$payserial','$comment','$car_pur_off','$chequeno','$expensetype','$through')");
                                        }


                                ///////////*******************START OF OFFICIAL + CASH OPTION ***********///////////////


                                if ($paytype=="Cash")
                                        {
                                                $result = pg_exec("DELETE FROM payment_voucher WHERE (voucher_id = '$voucherid');insert into payment_voucher (voucher_id,pay_voucher_date,amount,account_id,pay_type,voucher_no,comment,car_pur_off,off_accountname,through) values('$voucherid','$voucherdate','$payamount','$clientname','$paytype','$payserial','$comment','$car_pur_off','$expensetype','$through')");
                                        }




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




                                $result = pg_exec("select * from view_payment_official");
                                $numrows=pg_numrows($result);
                                $row = pg_fetch_row($result,$gotocheck-1);

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
				$through = $row[14];

                          //      $gotocheck = $numrows;



                        }        //////////////******************** END OF OFFICIAL OPTION *****************///////////////////


         

		
        }//////end of edit button

	
	
	
	
	
	
	


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
								<?php
                                                        		if ($gotocheck==1)
                                                                		{
                                                                         		print("document.test.topbutton.disabled=true;
											document.test.prevrecord.disabled=true;");
                                                                                }
									if ($gotocheck==$numrows)
                                                                		{
                                                                         		print("document.test.bottombutton.disabled=true;
											document.test.nextrecord.disabled=true;");
                                                                                }

								?>
								
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
                                                                                document.test.tkrate.disabled=true;
                                                                                document.test.tkratetwo.disabled=true;
										document.test.fromloc.disabled=true;
										document.test.toloc.disabled=true;
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
                                                                                document.test.tkratetwo.disabled=false;
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
											print("");
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
			
			window.status = document.test.gotocheck.value+"/"+ numrows


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
								
                                
				document.test.clientname.disabled=false;                                		
                                document.test.payserial.disabled=false;
				document.test.payamount.disabled=false;
				document.test.amountinword.disabled=true;
				document.test.voucherdate.disabled=false;
                                document.test.paytype.disabled=false;
                                document.test.chequeno.disabled=false;
                                document.test.bankname.disabled=false;
                                document.test.bankbranch.disabled=false;
                                document.test.chequepaydate.disabled=false;
				document.test.comment.disabled=false;
				
				document.test.voucherdate.select();
        	                document.test.voucherdate.focus();
										
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

                                                        		if (document.test.filling.value == \"editbutton\")
										{
											document.test.shipname.disabled=false;
											document.test.voucherdate_backup.value=document.test.voucherdate.value;		                                		                                		
       	                        							document.test.payamount_backup.value=document.test.payamount.value;
											alert(document.test.voucherdate_backup.value+\" \"+document.test.payamount_backup.value);
						
										}                
							
									//document.test.clientname.disabled=false;
                                                                        //document.test.shipname.disabled=false;
                                                                        //document.test.amountinword.disabled=false;
                                                                        document.test.matone.disabled=false;
                                                                        document.test.mattwo.disabled=false;
                                                                        document.test.fromloc.disabled=false;
									document.test.toloc.disabled=false;
                                                                        
                                                                        document.test.tkrate.disabled=false;
                                                                        document.test.tkratetwo.disabled=false;
                                                                        document.test.departuredate.disabled=false;

                                                                }");

                                                        if ($radiotest=="normal")
                                                                {
									print("
										if (document.test.filling.value == \"editbutton\")
											{
												document.test.shipname.disabled=false;
											}
										else
											{
                                                                        			document.test.shipname.disabled=true;
											}
										");
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
									if (document.test.filling.value == \"editbutton\")
										{
											//document.test.shipname.disabled=false;
											document.test.voucherdate_backup.value=document.test.voucherdate.value;		                                		                                		
       	                        							document.test.payamount_backup.value=document.test.payamount.value;
											alert(document.test.voucherdate_backup.value+\" \"+document.test.payamount_backup.value);
										}
									else
										{
                                                                        		document.test.payserial.value = document.test.official_voucherno.value;
										}
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
                                                                document.test.tkratetwo.disabled=true;
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


                if ((document.test.filling.value == "addbutton") && (document.test.radiotest.value!="official"))
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
		if(theForm.voucherdate.value != theForm.voucherdate_backup.value) 
                	{
        	                alert('Sorry! Voucherdate is changed...you have to choose a client, then select desired Ship' );
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

                                if (theForm.matone.options[theForm.matone.selectedIndex].text == "")
                                        {
                                                alert("Please select First Material");
                                                theForm.matone.focus();
                                                return(false);
                                        }



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


                                 if (theForm.mattwo.options[theForm.mattwo.selectedIndex].text != "********")
                                         {


                                                if(theForm.tkratetwo.value == 0)
                                                        {
                                                                alert("<?php echo $txt_missing_takaratetwo ?>");
                                                                theForm.tkratetwo.select();
                                                                theForm.tkratetwo.focus();
                                                                return(false);
                                                        }




                                                if (isFinite(theForm.tkratetwo.value) != true)
                                                        {
                                                                alert('Invalid Number Argument In Fair Rate !');
                                                                theForm.tkratetwo.select();
                                                                theForm.tkratetwo.focus();
                                                                return(false);

                                                        }


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
               // alert( document.test.voucherid.value);
				<?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_payment.php?gotocheck=$gotocheck&radiotest=$radiotest&button_check=$button_check&testindicator=$voucherid\",\"view\",\"toolbar=no,scrollbars=yes\")");
                ?>

        }




function view_cargo()
        {
                document.test.setat.value="true";
                document.test.shipcargo.value=document.test.shipname.value;
                //alert( document.test.shipcargo.value);
                var abc = "view_payment_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&voucherdate="+document.test.voucherdate.value+"&voucherid="+document.test.voucherid.value+"&comment="+document.test.comment.value+"&through="+document.test.through.value+"&paylocation="+document.test.paylocation.value+"&olddeparturedate="+document.test.departuredate.value;

                //   alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }



function view_purchase_sale_cargo()
        {
                document.test.setat.value="true";
                document.test.shipcargo.value=document.test.shipname.value;
                alert( document.test.shipcargo.value);
                var abc = "view_purchase_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&voucherdate="+document.test.voucherdate.value+"&voucherid="+document.test.voucherid.value+"&comment="+document.test.comment.value+"&through="+document.test.through.value+"&paylocation="+document.test.paylocation.value;

                //   alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }






function print_record()
        {
                if (document.test.radiotest.value == "official")
                        {
                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;


                                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&voucherdate="+document.test.voucherdate.value+"&payserial="+document.test.payserial.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.ownername.value+"&shipcargo="+document.test.expensetype.options[document.test.expensetype.selectedIndex].text+"&print_comment="+document.test.comment.value+"&print_through="+document.test.through.value;
                                 alert (abc);
                        }

                else
                        {
                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&voucherdate="+document.test.voucherdate.value+"&payserial="+document.test.payserial.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.ownername.value+"&materialone="+document.test.matone.options[document.test.matone.selectedIndex].text+"&materialtwo="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&fairrate="+document.test.tkrate.value+"&fairratetwo="+document.test.tkratetwo.value+"&fromlocation="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&tolocation="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&cashorcheque="+document.test.paytype.options[document.test.paytype.selectedIndex].text+"&bankname="+document.test.bankname.value+"&bankbranch="+document.test.bankbranch.value+"&chequeno="+document.test.chequeno.value+"&chequedate="+document.test.chequepaydate.value+"&print_comment="+document.test.comment.value+"&print_through="+document.test.through.value;
                                alert (abc);
                        }

                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");
        }



function entertainment()
        {
                document.test.filling.value = "addbutton";
        }

function official_voucher()
        {

               if( document.test.radiotest.value == "official")
	       		{
				document.test.offvoucherpro.value = "true";
				document.test.setat.value = "true";
				document.test.savecancel.value = "false";
				document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
				document.test.submit();
			}
			

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
				document.test.gotocheck.value = 1 ;

                        }

                if (whatever=='pur')
                        {
                                document.test.radiotest.value = "purchase" ;
                                document.test.filling.value = "eggplant" ;
				document.test.gotocheck.value = 1 ;
                        }

                if (whatever=='office')
                        {
                                document.test.radiotest.value = "official" ;
                                document.test.filling.value = "eggplant" ;
				document.test.gotocheck.value = 1 ;
                        }


        }



</script>
<script language = javascript src="all_jscript_function.js"> </script>
<script language = javascript src="date_picker.js"> </script>







<STYLE>

BODY  { background: #b1ce93;  font-size: 8pt}


 </STYLE>


<body bgcolor= "#b1ce93" onload= "setattribute()">
<form name= "test" onsubmit="return form_validator(this)"  onreset = "button_job(document.test.cancelbutton.name);add_edit_press()" method= post action="payment_voucher.php">
<div align="center"><b><font face="Monotype Corsiva" size="5"><font color="darkBlue"><u>Payment Voucher</u></font></font></b></div>


<TABLE width="100%" border="1" bgcolor = "#00FFFF">
<TR>
<TD width="">

<?php
        if ($radiotest=="normal")
                {

                        print ("<b><font color=\"darkMagenta\"> <input type = \"radio\" name = \"purchase\" value = \"normal\" checked onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying

                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"  onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Purchase
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

                        <input type = \"radio\" name = \"purchase\" value = \"purchase\"   onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Purchase

                        <input type = \"radio\" name = \"purchase\" value = \"official\"  checked onclick= \"normal('office');document.test.submit()\">&nbsp;&nbsp; Official </font></b>");


                }

?>

</TD>

<TD width="30%"><b>Sl. No.&nbsp;&nbsp;&nbsp;
<input type=text name="payserial" value = "<?php echo $payserial ?>" size="12" >

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
<TD width="150"><input type="text" name="through" value = "<?php echo trim($through) ?>" size="20" onchange= "document.test.through.value=capfirst(document.test.through.value)"> </TD>


<td> <b>Date : </b><input type=text name="voucherdate" value ="<?php echo ltrim(rtrim($voucherdate))?>" size="15" onchange= "official_voucher()" ><a href="javascript:show_calendar('test.voucherdate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a></b>
</td> </TR>

</TABLE>

<TABLE width="849" border="1"><TR>


<td width="35"><b>On Account</b></td>


<?php

// grabs all product information

        if ($radiotest=="normal")
                { //starting normal option
			 print("<TD width=\"300\">");
                        print("<select size=\"1\" name=\"shipname\" OnChange=\"view_cargo()\"> ");



                        if ($shipselect=="true")               ///I've changed it --previous value was $shipselect=="false"       -date -2003-04-02
                                {

                                      echo "alert( Entered)";
                                      $result = pg_exec("select ship_id,ship_name from ship where account_id=$clientname");
                                      $row = pg_fetch_row($result,0);
                                      $shipname = $row[0];$nameofship = $row[1];
                                      print( "<option value= \"$shipname\" selected> $nameofship </option>  ");

                                }

                        else
                                {
                                    $result = pg_exec("select ship_id,ship_name,account_id from ship where account_id=$clientname");
                                    print( "<option value= \"$shipname\" selected> $nameofship </option>  ");

                                    $shipselect = "false";

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
		print("<TD width=\"350\">");
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

                print("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select size=\"1\" name=\"mattwo\">");

                print("<option value =\"$mattwo\"  selected>$mattwoname</option>\n");
                $num_mat2 = pg_numrows($result);


                for($i=0;$i<$num_mat2;$i++)
                        {
	                        $row_mat2 = pg_fetch_row($result,$i);

	                        print(" <option value =\"$row_mat2[0]\">$row_mat2[1]</option>\n");
	                }

                print("</select >");
		
		print("<b>@ Tk.</b> <input type=\"text\" name=\"tkrate\" value = \"$tkrate\" size=\"11\">");
		
		print("<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@ Tk.</b><input type=\"text\" name=\"tkratetwo\" value = \"$tkratetwo\" size=\"11\">");


                print("<TD><b>&nbsp;&nbsp;Cargo Vessel</b>:&nbsp;&nbsp;&nbsp; <select size=\"1\" name=\"shipname\" OnChange=\"view_purchase_sale_cargo()\"> ");

                print( "<option value=\"$shipname\" selected>$nameofship</option>  ");

                $result = pg_exec("select ship_id,ship_name from ship order by ship_name");

                $num_ship = pg_numrows($result);

                for($i=0;$i<$num_ship;$i++)
                        {
         	                $row_ship = pg_fetch_row($result,$i);

         	                print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
         	        }

                print(" </select></TD>");


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
                        <option >Loan Refund</option>
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
<TR><TD width="500"><b>In word</b> &nbsp; <font face="Times New Roman" size="2"><textarea rows="1" name="amountinword" cols="60"></textarea></font></p>
</td>

<?php

        if($radiotest!="official")
                {
                    //    if($radiotest=="normal")
                      //          {

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
                   //            */ //}

                    //    if($radiotest=="purchase")
                    //            {

                     //                   print("<TD width=\"50\"><b>@ Tk.</b></TD>
                              //                  <TD width=\"80\"><input type=\"text\" name=\"tkrate\" value = \"$tkrate\" size=\"11\"></TD>");
                      //          }

                }

 ?>

</TR></TABLE>


<?php

        if ($radiotest!="official")
                {
                        print("<TABLE border=1>");
                        


                        // grabs all product information

                        if ($radiotest=="normal")
                                {
                                        //problem starts
					print ("<TD width=90><b>Material One </b></td>");
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
                                        print ("<TD width=90><b>For </b></td>");
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


                }

?>

<TABLE width="651" border="1" >
<TR>
<TD width="60"> <b>Payment Mode: </b></TD>
<TD width="125"><select size="1" name="paytype" onchange = "paytype_option()">
  <option value ="<?php echo trim($paytype) ?>"  selected> <?php echo trim($paytype) ?></option>
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
                                <TD width=\"119\"><input type=\"text\" name=\"paylocation\" size=15 value = \"$paylocation\" onchange= \"document.test.paylocation.value=capfirst(document.test.paylocation.value)\"> </td>
                                <TD width=\"104\"><b>Departure Date:</b> </td>
                                <TD width=\"98\"><input type = \"text\" size=\"10\" name=\"departuredate\" value = \"$departuredate\" readonly></td>");
                }
?>

<TD width="64"><b>Comment: </b></td>
<TD width="358"><input type="text" name="comment" size="50" value = "<?php echo ltrim(rtrim($comment)) ?>" ></p>

</td></TR></TABLE>



<INPUT TYPE="hidden" name="seenbefore" value="1">
<input type="hidden" name ="radiotest" value="<?php echo $radiotest ?>">
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
<INPUT TYPE="hidden" name="voucherdate_backup" value="<?php echo $voucherdate_backup ?>" >
<INPUT TYPE="hidden" name="payamount_backup" value="<?php echo $payamount_backup ?>" >
<INPUT TYPE="hidden" name="partoradvance" value="<?php echo $partoradvance ?>" >
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >
<INPUT TYPE="hidden" name="offvoucherpro" value="<?php echo $offvoucherpro ?>" >


<div align="center"><?php button_print(); ?></div>

</form>


    shipselect("<?php echo $shipselect ?>");

    test("<?php echo $numsql ?>")
    radiotest("<?php echo $radiotest ?>")
    voucherid("<?php echo $voucherid ?>")
    pursalescheduleid("<?php echo $pursalescheduleid ?>")
    voucherno("<?php  echo $voucherno ?>")
    accountid("<?php echo $clientname ?>")
    fromloc("<?php echo $fromloc ?>")
    toloc("<?php  echo $toloc ?>")
    shipid("<?php echo $shipname ?>")
    shipselect("<?php echo $shipselect ?>")
    savecancel("<?php echo $savecancel ?>")
    filling("<?php echo $filling ?>")
    gotocheck("<?php  echo $gotocheck ?>")
    ownername("<?php echo $ownername ?>")
    purchase("<?php echo $purchase ?>")
    clientselect("<?php echo $clientselect ?>")
    clientname_value("<?php echo $clientname ?>")
    paytype("<?php $paytype ?>")
    tripid("<?php echo $shiptripid ?>");
    departure("<?php echo $departuredate ?>");
    matone("<?php echo $matone ?>");
    mattwo("<?php echo $mattwo?>");
    returnfromviewship("<?php echo $returnfromviewship ?>")
    visitnormal("<?php echo $visitnormal?>");
    visitpurchase("<?php echo $visitpurchase?>");
    another paytype("<?php echo $paytype ?>");
    partoradvance("<?php echo $partoradvance ?>");
    fairrate("<?php echo $tkrate ?>");

    voucherdate("<?php echo $voucherdate ?>");

    officialvoucherno("<?php echo $official_voucherno ?>");

	navigation("<?php echo $navigation ?>");
    setat("<?php echo $setat ?>");





</body>

</html>
