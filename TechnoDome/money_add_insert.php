<?php
        require("config.php");

        $abc = "Cash";

        /// connects to database
        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;
                        $savecancel = "true";
                        $setat ="false";
                        $visitcarry = 0;
                        $visitsale = 0;
                        $visitofficial = 0;
			$year = date ("Y");
                        $month = date("m") ;
                   //     $tripid = $row[17];
                        $radiotest = "normal";
                        // grabs all product information
                        $result = pg_exec("select * from money_carrying_view");
                        $numrows = pg_numrows($result);
                        
                        if ($numrows==0)
                                {
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
                                        $receivetkratetwo =$row[28];
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

                }


        else
                {              //if not seen before



                        if ($radiotest =="normal")
                                {
                                        if( $visitcarry ==0)
                                                {
	                                                $result = pg_exec("select * from money_carrying_view ");
                                                        $numrows=pg_numrows($result);
                                                        // $row = pg_fetch_row($result,0);

                                                        if ($numrows==0)
                                                                {
                                                                        $mreceiptid = 0;
                                                                }
                                                        else
                                                                {
                                                                        if ($returnfromviewship !="true")
                                                                                {
                                                                                        //print("we are in");
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
                                                                                        $receivetkratetwo =$row[28];
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

                                                                                   $returnfromviewship = "false";
                                                                }

	                                                $visitcarry = 1;
                                                        $visitsale = 0;
                                                        $visitofficial = 0;
                                                }

                                        else
                                                {
                                                        $result = pg_exec("select * from money_carrying_view ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                	$mreceiptid = 0;
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                }

                                                }


                                }



                        if ($radiotest =="sale")
                                {
                                        if ($visitsale ==0)
                                                {
	                                                $result = pg_exec("select * from money_sale_view ");
                                                        $numrows=pg_numrows($result);
                                                        //$row = pg_fetch_row($result,0);

                                                        if ($numrows==0)
                                                                {
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
                                                                        $comment = $row[27];

                                                                }

                                                        $visitsale = 1;
                                                        $visitcarry = 0;
                                                        $visitofficial = 0;

                                                }
                                        else
                                                {
                                                        $result = pg_exec("select * from money_sale_view ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                	$mreceiptid = 0;
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
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
                                                         
							 $official_vouresult = pg_exec("select max(mreceipt_serial) from money_receipt where ((date_part('year',mreceipt_date)=$year) and (date_part('month',mreceipt_date)=$month) ) ");

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


                                                        $result = pg_exec("select * from money_official_view ");
                                                        $numrows=pg_numrows($result);
                                                        //$row = pg_fetch_row($result,0);

                                                        if ($numrows==0)
                                                                {
                                                                        $mreceiptid = 0;
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,0);

                                                                        $mreceiptid = $row[0];
                                                                        $mreceiptserialno = $row[2];
                                                                        $mreceiptdate = $row[1];
                                                                        $accountname = $row[4];
                                                                        $expensetype = $row[11];
                                                                        $clientname = $row[3];
                                                                        $payamount = $row[5];
                                                                        $paytype = $row[6];
                                                                        $chequeno = $row[9];
                                                                        $bankname = $row[7];
                                                                        $bankbranch = $row[8];
                                                                        $chequereceivedate = $row[10];
                                                                        $receivelocation = $row[17];
                                                                        $comment = $row[13];

                                                                }

                                                        $visitsale = 0;
                                                        $visitcarry = 0;
                                                        $visitofficial = 1;

                                                }
                                        else
                                                {
                                                        $result = pg_exec("select * from money_official_view ");
                                                        $numrows=pg_numrows($result);

                                                        if ($numrows==0)
                                                                {
                                                                	$mreceiptid = 0;
                                                                }
                                                        else
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                                }
                                                }

                                }


                }  //////// END of seenbefore else




        /*      This portion has been commented for preciding addition

        if($radiotest=="normal")    {
        $result = pg_exec("select * from money_carrying_view order by mreceipt_id");
        }


        if($radiotest=="sale")    {
        $result = pg_exec("select * from money_sale_view order by mreceipt_id");
        }



        $numrows = pg_numrows($result);
        //$row = pg_fetch_row($result,0);        */


        //*******************  For TOP BUTTON         **********************

        if ($navigation == "true")
    		{
			print(".navigation...numrows...$numrows");
			
                        if($radiotest=="normal")
                                {
                                        $result = pg_exec("select * from money_carrying_view order by mreceipt_id");
                                }

                        if($radiotest=="sale")
                                {
                                        $result = pg_exec("select * from money_sale_view order by mreceipt_id");
                                }
				
			if ($radiotest =="official")
                                {
					$result = pg_exec("select * from money_official_view order by mreceipt_id");
				}
				
			$numrows=pg_numrows($result);
				
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

			        /**************************** FOR DELETE BUTTON  *********************/

        		if ($filling == "deletebutton")
                		{
		        		$deleteresult = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$mreceiptid')");

		        		if($radiotest=="normal")
                                		{
                                        		$result = pg_exec("select * from money_carrying_view order by mreceipt_id");
                                		}

                        		if($radiotest=="sale")
                                		{
                                        		$result = pg_exec("select * from money_sale_view order by mreceipt_id");
                                		}
				
					if ($radiotest =="official")
                                		{
							$result = pg_exec("select * from money_official_view order by mreceipt_id");
						}

		        		$numrows = pg_numrows($result);

                        		if ($numrows==0)
                                		{
                                        		$mreceiptid = 0;
                                		}
                        		else
                                		{
                                        		if ($gotocheck > $numrows)
                                                		{
        		                                		$gotocheck = $numrows;
			                        		}
		                        	 }	

	                                $row = pg_fetch_row($result,$gotocheck-1);
         
                		}

			if ($radiotest !="official")
                                {
                                        $mreceiptid = $row[0];
                                        $mreceiptserialno = $row[2];
                                        $mreceiptdate = $row[1];
                                        $accountname = $row[21];
                                        $nameofship = $row[22];
                                        $fromlocname = $row[23];
                                        $tolocname = $row[24];
                                        $materialonename = $row[25];
                                        $materialtwoname = $row[26];

                                        $clientname = $row[3];
                                        $shipname = $row[4];
                                        $fromloc = $row[5];
                                        $toloc = $row[6];
                                        $matone = $row[7];
                                        $mattwo = $row[8];
                                        $receivetkrate =$row[9];
                                        $receivetkratetwo =$row[28];
                                        $payamount = $row[10];
                                        $paytype = $row[12];
                                        $chequeno = $row[13];
                                        $bankname = $row[14];
                                        $bankbranch = $row[15];
                                        $chequereceivedate = $row[16];
                                        $receivelocation = $row[17];
                                        $tripid = $row[18];
                                        $departuredate = $row[19];

                                        $comment = $row[27];
                                }
                        else
                                {                                 
                                        $mreceiptid = $row[0];
                                        $mreceiptdate = $row[1];
                                        $mreceiptserialno = $row[2];
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


        /******************** End OF TOP BUTTON  ***************************/



        //////////////////////////////////////////////////////////////////////

        /*******************  For ADD BUTTON         ***********************/

        ////////////////////////////////////////////////////////////////////



        ////************ CONDITION FOR normal ***************///////

        if (($filling == "addbutton" && $savecancel=="true") || ($filling == "editbutton" && $savecancel == "true"))

                {  ////////  If filling addbutton  bracket

                        print("add start\t");


                        ///********************** First Check for duplicate data****************************///
                        ///**************************************************************************///

                        $mreceiptserialno = abs($mreceiptserialno);

                        print("$mreceiptserialno");

                        if ($filling == "addbutton")
				{
					$dupresult= pg_exec($conn,"select * from money_receipt where (mreceipt_serial='$mreceiptserialno') ");
				}
			
			if ($filling == "editbutton")
				{
					$dupresult= pg_exec($conn,"select * from money_receipt where (mreceipt_serial='$mreceiptserialno') and (mreceipt_id !='$mreceiptid')");
				}
                        $dupnumrows = pg_numrows($dupresult);

                        if ($dupnumrows !=0)
                                {
                                        if($radiotest=="normal")   //print("javascript:alert(\"Duplicate material Name\")");

                                                {
                                                        $result = pg_exec("select * from money_carrying_view ");

                                                        $numrows=pg_numrows($result);

                                                        if ($numrows !=0)
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);

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
                                                                        $receivetkratetwo =$row[28];
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

                                                }   /// If radiotest is normal ends


                                        if($radiotest=="sale")
                                                {
                                                        $result = pg_exec("select * from money_sale_view");

                                                        $numrows=pg_numrows($result);

                                                        if($numrows!=0)
                                                                {
                                                                        $row = pg_fetch_row($result,$gotocheck-1);

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
                                                                        $receivetkratetwo =$row[28];
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


                                                }

                                        if ($radiotest =="official")
                                                {
                                                        $result = pg_exec("select * from money_official_view");
                                                        $numrows=pg_numrows($result);
                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                        $mreceiptid = $row[0];
                                                        $mreceiptserialno = $row[2];
                                                        $mreceiptdate = $row[1];
                                                        $accountname = $row[21];

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

                                        		if ($radiotest=="normal")
                                                		{  //NORMAL BRACKET

                                                        		$carryorsale = "Carrying";
                                                        		print("Carrying\t");

                                                        		$mreceiptserialno = abs($mreceiptserialno);      ///before it was $serialno ...ask miraj
                                                        		$toloc = abs($toloc);
                                                 
                                                                        if ($shiptripid =="")
                                                                        	{
                                                                        		$shiptripid = 0;
                                                                        	}

                                                                        $serialno = abs($mreceiptserialno);

                                                                        $result = pg_exec($conn,"select *  from cargo_schedule where ship_id=$shipname and trip_id=$shiptripid order by schedule_id");      /// Another codition......"and total_tk!=0" has been ommitted             and ((receive_advance!=0 or receive_advance=0) and receive_balance!=0)

                                                                        $cargo_numrows = pg_numrows($result);

                                                                        if ($cargo_numrows==0)
                                                                        	{   //condition for when total taka and balance taka is  zero in cargo schedule BRACKET

                                                                        		$cargotrip =pg_exec("select max(trip_id) from cargo_schedule where ship_id=$shipname");

											$cargotripnumrows = pg_numrows($cargotrip);
											print("we have to check cargotripnumrows....$cargotripnumrows") ;
                                                                                                	
											///*********experimental...to adjust tripid automatically in payment voucher****************///
											if($cargotripnumrows==0)
                                                                                        	{
                                                                                                	$ltripid =1;  //before it was tripid=0
                                                                                                }
                                                                                        else
                                                                                        	{
                                                                                        		print("we are in experimental position....") ;
													$exptrip =pg_exec("select max(trip_id) from money_receipt where ship_id=$shipname and mreceipt_date<='$mreceiptdate'");
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
															$exptripresult = pg_exec("select max(trip_id) from money_receipt where (ship_id=$shipname and mreceipt_date > '$mreceiptdate') ");
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
																	print("find maximum tripid to edit after mreceiptdate...$aftertripid.") ;
																	for ($i = $aftertripid; $i>=$ltripid ; $i--)
																		{
																			$searchresult =pg_exec("select * from money_receipt where ship_id=abs($shipname) and mreceipt_date > '$mreceiptdate' and trip_id=abs($i) order by mreceipt_date, mreceipt_serial");
																			$searchnumrows = pg_numrows($searchresult);
																			print("find searchnumrows...$searchnumrows..and i ..$i.") ;
																			if($searchnumrows!=0)
                                                                                                        							{
                                                                                                                							for ($j = 0; $j<$searchnumrows ; $j++)
																						{
																							$partsearchresult =  pg_fetch_row($searchresult,$j);
																							
																							$partmreceiptid =      $partsearchresult[0];
																							$partreceivedate =   $partsearchresult[1];
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
																							$partchequereceivedate = $partsearchresult[12];
																							$partreceiveserial =     $partsearchresult[13];
																							$partdeparturedate =   $partsearchresult[14];
																							$partpaylocation = $partsearchresult[15];
																							$parttripid =       $partsearchresult[16];
																							$partcomment =   $partsearchresult[17];
																							$partcar_pur_off   =    $partsearchresult[18];
																							$parttkrate =        $partsearchresult[19];
																							$partchequeno =        $partsearchresult[20];
																							$partpartoradvance =       $partsearchresult[21];
																							$partreceivetkratetwo =     $partsearchresult[24];
																							$parttripid++;
																							print("is it increased..$parttripid..") ;
																							if ($partdeparturedate=="")
                                                                                                             											{																								
																									if (trim($paytype)=="Cheque")
                                																						{
																											$money_result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$partmreceiptid'); insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$partreceiptserial','$partreceivedate','$partpayamount','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequereceivedate','$partreceivetkrate','$partreceivelocation','$parttripid','$partcarryorsale','$partcomment','$partpartoradvance','$partreceivetkratetwo')");
																											//$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$partvoucherid','$partvoucherdate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequepaydate','$partpayserial','$partpaylocation','$partcomment','$partcar_pur_off','$parttkrate','$parttkratetwo','$parttripid','$partpartoradvance','$partthrough')");
																										}
							
																									if (trim($paytype)=="Cash")
                                																						{	
																											$money_result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$partmreceiptid'); insert into money_receipt (mreceipt_id,mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$partreceiptserial','$partreceivedate','$partpayamount','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpaytype','$partreceivetkrate','$partreceivelocation','$parttripid','$partcarryorsale','$partcomment','$partpartoradvance','$partreceivetkratetwo')");
																											//$pay_add_result1 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id,pay_voucher_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,pay_location,comment,car_pur_off,tk_rate,tk_rate_two,trip_id,part_or_advance,through) values('$partvoucherid','$partvoucherdate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partpayserial','$partpaylocation','$partcomment','$partcar_pur_off','$parttkrate','$parttkratetwo','$parttripid','$partpartoradvance','$partthrough')");
																										}
																								}																								
																							else
																								{
																									if (trim($paytype) =="Cash")
                                                                        																	{
                                                                                                                													$money_result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$partmreceiptid'); insert into money_receipt (mreceipt_id,mreceipt_serial,mreceipt_date,,departure_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$partreceiptserial','$partreceivedate','$partdeparturedate','$partpayamount','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpaytype','$partreceivetkrate','$partreceivelocation','$parttripid','$partcarryorsale','$partcomment','$partpartoradvance','$partreceivetkratetwo')");
																										//	$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id, pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$partvoucherid','$partvoucherdate','$partdeparturedate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partpayserial','$partcomment','$partcar_pur_off','$parttkrate','$partcargotripid','$partpartoradvance','$partthrough','$parttkratetwo')");
																										}
															
																									if (trim($paytype)=="Cheque")
                                                        																			{
																											$money_result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$partmreceiptid'); insert into money_receipt (mreceipt_serial,mreceipt_date,,departure_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$partreceiptserial','$partreceivedate','$partdeparturedate','$partpayamount','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequereceivedate','$partreceivetkrate','$partreceivelocation','$parttripid','$partcarryorsale','$partcomment','$partpartoradvance','$partreceivetkratetwo')");
																										//	$pay_add_result2 = pg_exec($conn,"DELETE FROM payment_voucher WHERE (voucher_id = '$partvoucherid'); insert into payment_voucher (voucher_id, pay_voucher_date,departure_date,account_id,ship_id,from_id,to_id,mat_one,mat_two,amount,pay_type,chequeno,bank_name,branch,cheque_pay_date,voucher_no,comment,car_pur_off,tk_rate,trip_id,part_or_advance,through,tk_rate_two) values('$partvoucherid','$partvoucherdate','$partdeparturedate','$partclientname','$partshipname','$partfromloc','$parttoloc','$partmatone','$partmattwo','$partpayamount','$partpaytype','$partchequeno','$partbankname','$partbankbranch','$partchequepaydate','$partpayserial','$partcomment','$partcar_pur_off','$parttkrate','$partcargotripid','$partpartoradvance','$partthrough','$parttkratetwo')");
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

																					
																					
																					
															$cargotripid  =pg_fetch_row($cargotrip,0);
                                                                                        				$tripid =  $cargotripid[0];
                                                                                        				$tripid = $tripid+1 ;


                                                                                        		////////ask miraj about departuredate because if

                                                                                   			/*     if($departuredate!="") ..... Condition has been  Commented on 24/3/2003 by Miraj
                                                                                                			{   //This is inside the condition when balance and total taka is zero  1

                                                                                                        			$partoradvance = "Part";

                                                                                                        			$money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");

                                                                                                			}  //This is inside the condition when balance and total taka is zero  ends ......1

                                                                                        			else
                                                                                                			{   //This is inside the condition when balance and total taka is zero  2

                                                                                          */              $partoradvance = "Advance";


                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");
                                                                                        //        }   // ends ....2

                                                                                        $receivebalancetk = $receivebalancetk - $payamount;   //payamount of money receipt



                                                                                        ///////////***************??????????**********************we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                                                                        ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                                                                        $shipownresult = pg_exec("select account_id from ship where ship_id=$shipname");
                                                                                        $shipown_numrows = pg_numrows($shipownresult);

                                                                                        if ($shipown_numrows==0)
                                                                                                {   //condition
                                                                                                        $shipownerid =  1;

                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $shipownerarray  =pg_fetch_row($shipownresult,0);
                                                                                                        $shipownerid =  $shipownerarray[0];

                                                                                                }


                                                                                        ///////////***************??????????***********   END OF           we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                                                                        ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////




                                                                                        $result = pg_exec($conn,"insert into cargo_schedule (mreceipt_date,received_from,ship_id,owner_name,from_id,to_id,mat_one,mat_two,money_fair_rate,receive_advance,receive_balance,trip_id,money_fair_rate_two) values('$receivedate','$clientname','$shipname','$shipownerid','$fromloc','$toloc','$matone','$mattwo','$receivetkrate','$payamount','$receivebalancetk','$tripid','$receivetkratetwo')");


                                                                                      //  print ("Added in money recpt. when total taka zero\n");



                                                                                }  // //condition for when total taka and balance taka is  zero in cargo schedule BRACKET CLOSE


                                                                        //////////// Condition for when tripid same and balance taka is not zero in cargo schedule

                                                                        else
                                                                                {

                                                                                        $upresult = pg_fetch_row($result,0); //// Here $result is
                                                                                        $receiveadvancetk = $upresult [20];
                                                                                        $receiveparttk = $upresult[21];
                                                                                        $scheduleid = $upresult[0];
                                                                                        $cargotripid = $upresult [18];
                                                                                        $goodquantityone = $upresult[8];
                                                                                        $goodquantitytwo = $upresult[9];
                                                                                        print ("$scheduleid");


                                                                                        $receivebalancetk = $upresult [23];
                                                                                        $receivetotaltk = ($goodquantityone * $receivetkrate) +($goodquantitytwo* $receivetkratetwo);



                                                                                        if($goodquantityone!="" and $goodquantityone!=0) //// previously the condition was $departuredate is not blank... ////////////  This is inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                                                                {
                                                                                                        $partoradvance ="Part";

                                                                                                  //      print ("$payamount");

                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");

                                                                                                        $receiveparttk = $receiveparttk+$payamount;
                                                                                                        $receivebalancetk = $receivetotaltk - ($receiveparttk+$receiveadvancetk);

                                                                                                 //       print("payment querystart & dept. date is not null\t");

                                                                                                        ///////////////////////////////////////////////////////////////////////
                                                                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                                                                        ////////////////////////////////////////////////////////////////////////

                                                                                                        $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                                                                                                        $payment_fields = pg_fetch_row($result,0);


                                                                                                        $voucherdate=   $payment_fields[10];
                                                                                                        $owner_name=    $payment_fields[3];
                                                                                                        $ship_name=     $payment_fields[2];
                                                                                                        $fromloc=       $payment_fields[4];
                                                                                                        $toloc=         $payment_fields[5];
                                                                                                        $matone=        $payment_fields[6];
                                                                                                        $mattwo=        $payment_fields[7];
                                                                                                        $quantityone=   $payment_fields[8];
                                                                                                        $quantitytwo=   $payment_fields[9];
                                                                                                        $paytkrate=     $payment_fields[17];
                                                                                                        $paytkratetwo=  $payment_fields[27];
                                                                                                        $payadvance=    $payment_fields[11];
                                                                                                        $departdate=    $payment_fields[1];
                                                                                                        $payparttk=     $payment_fields[12];
                                                                                                        $paytotaltk=    $payment_fields[14];

                                                                                                        if ($payment_fields[15]=="")
                                                                                                                {
                                                                                                                        $paybalancetk = NULL;
                                                                                                                }
                                                                                                        else
                                                                                                                {
                                                                                                                        $paybalancetk=  $payment_fields[15];
                                                                                                                }

                                                                                                        $cargotripid= $payment_fields[18];
                                                                                                        $unload_date = $payment_fields[19];
                                                                                                        print ("$departdate\t");


                                                                                                  if ($departdate!="")
                                                                                                  	{         /////////////   If departure date is not null.. then insert dept. date in sql insert statements....   Starts

                                                                                                        	if ($paybalancetk=="")
                                                                                                                	{  ////// If payment balance is blank ...... Starts

                                                                                                                        	if ($voucherdate !="")
                                                                                                                                	{       ///  If voucherdate is not blank ...Starts

                                                                                                                                        	if ($unloaddate!="")
                                                                                                                                                	{
                                                                                                                                                        	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                	}
                                                                                                                                        	else
                                                                                                                                                	{
                                                                                                                                                        	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                                                                                	}

                                                                                                                                	}  ///  If voucherdate is not blank ...Ends

                                                                                                                        	else
                                                                                                                                	{       ///  If voucherdate is blank ...Starts

                                                                                                                                        	if ($unloaddate!="")
                                                                                                                                                	{
                                                                                                                                                        	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                	}
                                                                                                                                        	else
                                                                                                                                                	{
                                                                                                                                                        	$result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                	}

                                                                                                                                	}  ///  If voucherdate is blank ...Ends

                                                                                                                }    /////////  If payment balance is null ....... Ends







                                                                                                        else       /////////  If payment balance is not null....... Starts

                                                                                                                {


                                                                                                                        if ($voucherdate !="")
                                                                                                                                {       ///  If voucherdate is not blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                }

                                                                                                                                }  ///  If voucherdate is not blank ...Ends



                                                                                                                        else

                                                                                                                                {       ///  If voucherdate is blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");


                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                                                                }

                                                                                                                                }  ///  If voucherdate is blank ...Ends



                                                                                                                } //////  If payment balance is not null .... Ends




                                                                                                    }   /////////  If departure date is not blank..... Ends





                                                                                                  else

                                                                                                    {  /////////  If departure date is  blank..... Starts


                                                                                                             if ($paybalancetk=="")

                                                                                                                     {  ////// If payment balance is blank ...... Starts


                                                                                                                             if ($voucherdate !="")
                                                                                                                                     {       ///  If voucherdate is not blank ...Starts

                                                                                                                                             if ($unloaddate!="")
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");


                                                                                                                                                     }

                                                                                                                                             else
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                                                                     }

                                                                                                                                     }  ///  If voucherdate is not blank ...Ends


                                                                                                                             else

                                                                                                                                     {       ///  If voucherdate is blank ...Starts

                                                                                                                                             if ($unloaddate!="")
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                             print("payment query cash done\t");

                                                                                                                                                     }

                                                                                                                                             else
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                                                                     }

                                                                                                                                     }  ///  If voucherdate is blank ...Ends


                                                                                                                     }    /////////  If payment balance is null ....... Ends







                                                                                                             else       /////////  If payment balance is not null....... Starts

                                                                                                                     {


                                                                                                                             if ($voucherdate !="")
                                                                                                                                     {       ///  If voucherdate is not blank ...Starts

                                                                                                                                             if ($unloaddate!="")
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                             print("payment query cash done\t");

                                                                                                                                                     }

                                                                                                                                             else
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                     }

                                                                                                                                     }  ///  If voucherdate is not blank ...Ends



                                                                                                                             else

                                                                                                                                     {       ///  If voucherdate is blank ...Starts

                                                                                                                                             if ($unloaddate!="")
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");


                                                                                                                                                     }

                                                                                                                                             else
                                                                                                                                                     {

                                                                                                                                                             $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                                                                     }

                                                                                                                                     }  ///  If voucherdate is blank ...Ends



                                                                                                                     } //////  If payment balance is not null .... Ends




                                                                                                    }  /////////  If departure date is blank..... Ends




                                                                                                }  //////////////   Condition ends for when quantity one is not blank for balance and total taka is not zero in cargo schedule (PART PAYMENT)




                                                                                        else
                                                                                                {    ////////////  (ADVANCE PAYMENT)This is for when quantityone is zero or is blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                                                                        $partoradvance ="Advance";

                                                                                                        $receiveadvance = $receiveadvancetk + $payamount;


                                                                                                        if ($receivetotaltk=="")
                                                                                                                {

                                                                                                                        $receivetotaltk = 0;

                                                                                                                }

                                                                                                        $receivebalancetk = $receivetotaltk - $receiveadvance;


                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");


                                                                                                        ///////////////////////////////////////////////////////////////////////
                                                                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                                                                        ////////////////////////////////////////////////////////////////////////

                                                                                                        $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                                                                                                        $payment_fields = pg_fetch_row($result,0);

                                                                                                        $voucherdate=   $payment_fields[10];
                                                                                                        $owner_name=    $payment_fields[3];
                                                                                                        $ship_name=     $payment_fields[2];
                                                                                                        $fromloc=       $payment_fields[4];
                                                                                                        $toloc=         $payment_fields[5];
                                                                                                        $matone=        $payment_fields[6];
                                                                                                        $mattwo=        $payment_fields[7];
                                                                                                        $quantityone=   $payment_fields[8];
                                                                                                        $quantitytwo=   $payment_fields[9];
                                                                                                        $paytkrate=     $payment_fields[17];
                                                                                                        $paytkratetwo=  $payment_fields[27];
                                                                                                        $payadvance=    $payment_fields[11];
                                                                                                        $departdate=    $payment_fields[1];
                                                                                                        $payparttk=     $payment_fields[12];
                                                                                                        $paytotaltk=    $payment_fields[14];

                                                                                                        if ($payment_fields[15]=="")
                                                                                                                {
                                                                                                                        $paybalancetk = "";

                                                                                                                }

                                                                                                        else
                                                                                                                {
                                                                                                                        $paybalancetk=  $payment_fields[15];

                                                                                                                }

                                                                                                        $cargotripid= $payment_fields[18];
                                                                                                        $unload_date = $payment_fields[19];




                                                                                                if ($departdate!="")

                                                                                                      {     //////  If departure date is not blank insert date in every insert sql statement ... Starts (within advance option)

                                                                                                        if ($paybalancetk=="")


                                                                                                                {  //////  If payment balance is null...... Starts

                                                                                                                        if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }


                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }



                                                                                                                                }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is null .........  Ends





                                                                                                        else  ///////   If payment balance is not null ...... Starts

                                                                                                                {

                                                                                                                        if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }



                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }



                                                                                                                                }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is not null .........  Ends



                                                                                                      }   ////////////    If departture date is not blank ... ends (within advance option)


                                                                                                else

                                                                                                      {     //////  If departure date is blank  ... Starts (within advance option)

                                                                                                        if ($paybalancetk=="")


                                                                                                                {  //////  If payment balance is null...... Starts

                                                                                                                        if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }


                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }



                                                                                                                                }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is null .........  Ends





                                                                                                        else  ///////   If payment balance is not null ...... Starts

                                                                                                                {

                                                                                                                        if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }



                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                                                                }



                                                                                                                                }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is not null .........  Ends



                                                                                                      }   ////////////    If departture date is  blank ... ends (within advance option)




                                                                                                }     ////////////End of ELSE  This is for when quantityone is zero or blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule



                                                                                }   // ELSE BRACKET CLOSE   ////////////// Condition for when tripid same and balance taka is not zero in cargo schedule



                                                          

/*********** END OF CARRYING AND CASH OPTION *****************/



/////////////////////////////////////////////////////////////////////////////////

/////////*********** CONDITION FOR CARRYING AND CHEQUE **************////////////

/////////////////////////////////////////////////////////////////////////////////


        if ($paytype == "Cheque")
                {      //PAYTYPE CHEQUE BRACKET

                        if ($shiptripid =="")
                                {
                                        $shiptripid = 0;
                                }
                        else
                                {
                                        $shiptripid = $shiptripid ;
                                }

                        $serialno = abs($mreceiptserialno);

                        $result = pg_exec("select *  from cargo_schedule where ship_id = $shipname  and trip_id=$shiptripid order by schedule_id");      /// Another codition......"and total_tk!=0" has been ommitted

                 //       print("add cheque/first query done\t");

                        $cargo_numrows = pg_numrows($result);

                        if ($cargo_numrows==0)
                                {   //condition for when total taka and balance taka is  zero in cargo schedule BRACKET

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

                                        /*



                                        $cargotrip =pg_exec("select max(trip_id) from cargo_schedule where ship_id=$shipname");

                                        $cargotripid  =pg_fetch_row($cargotrip,0);
                                        $tripid =  $cargotripid[0];
                                        $tripid = $tripid+1 ;




                                        if($departuredate!="")
                                                {   //This is inside the condition when balance and total taka is zero  1
                                                        $partoradvance = "Part";

                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");

                                                }  //ends ......1



                                        else
                                                {   //This is inside the condition when balance and total taka is zero  2
                                           */
                                                        $partoradvance = "Advance";

                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");
                                          //      }   // ends ....2

                                        $receivebalancetk = $receivebalancetk - $payamount;   //payamount of money receipt


                                          ///////////***************??????????**********************we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                          ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                          $shipownresult = pg_exec("select account_id from ship where ship_id=$shipname");

                                          $shipown_numrows = pg_numrows($shipownresult);

                                          if ($shipown_numrows==0)
                                                  {   //condition
                                                          $shipownerid =  1;

                                                  }
                                          else
                                                  {
                                                          $shipownerarray  =pg_fetch_row($shipownresult,0);
                                                          $shipownerid =  $shipownerarray[0];

                                                  }


                                          ///////////***************??????????***********   END OF           we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                          ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                        $result = pg_exec("insert into cargo_schedule (mreceipt_date,received_from,ship_id,owner_name,from_id,to_id,mat_one,mat_two,money_fair_rate,receive_advance,receive_balance,trip_id) values('$receivedate','$clientname','$shipname','$shipownerid','$fromloc','$toloc','$matone','$mattwo','$receivetkrate','$payamount','$receivebalancetk','$tripid')");

                        //                print ("Added in money recpt. when total taka zero or first advance\n");



                                }  // //condition for when total taka and balance taka is  zero in cargo schedule BRACKET CLOSE


                        //////////// Condition for when tripid same and balance taka is not zero in cargo schedule

                        else
                                {
                                        $upresult = pg_fetch_row($result,0); //// Here $result is
                                        $receiveadvancetk = $upresult [20];
                                        $receiveparttk = $upresult[21];
                                        $scheduleid = $upresult[0];
                                        $cargotripid = $upresult [18];
                                        $goodquantityone = $upresult[8];
                                        $goodquantitytwo = $upresult[9];
                          //              print ("$scheduleid ...line 1053");

                                        $receivebalancetk = $upresult [23];
                                        $receivetotaltk = abs(($goodquantityone * $receivetkrate)+($goodquantitytwo * $receivetkratetwo));


                                        if($goodquantityone!="" and $goodquantityone!=0)  //// previous condition was $dept.date !=""....////////////  This is inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                {

                                                        $partoradvance ="Part";

                            //                            print ("$payamount");

                                                        $money_result = pg_exec("insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$departuredate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");

                                                        $receiveparttk = $receiveparttk+$payamount;
                                                        $receivebalancetk = $receivetotaltk - ($receiveparttk+$receiveadvancetk);



                                                        ///////////////////////////////////////////////////////////////////////
                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                        ////////////////////////////////////////////////////////////////////////

                                                        $result = pg_exec("select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                                                        $payment_fields = pg_fetch_row($result,0);

                                                        $voucherdate=   $payment_fields[10];
                                                        $owner_name=    $payment_fields[3];
                                                        $ship_name=     $payment_fields[2];
                                                        $fromloc=       $payment_fields[4];
                                                        $toloc=         $payment_fields[5];
                                                        $matone=        $payment_fields[6];
                                                        $mattwo=        $payment_fields[7];
                                                        $quantityone=   $payment_fields[8];
                                                        $quantitytwo=   $payment_fields[9];
                                                        $paytkrate=     $payment_fields[17];
                                                        $paytkratetwo=  $payment_fields[27];
                                                        $payadvance=    $payment_fields[11];
                                                        $departdate=    $payment_fields[1];
                                                        $payparttk=     $payment_fields[12];
                                                        $paytotaltk=    $payment_fields[14];

                                                        if ($payment_fields[15]=="")
                                                                {
                                                                        $paybalancetk = "";
                                                                }
                                                        else
                                                                {
                                                                        $paybalancetk=  $payment_fields[15];
                                                                }

                                                        $cargotripid= $payment_fields[18];
                                                        $unload_date = $payment_fields[19];

                                                   if ($departdate !="")
                                                     {   //////  If departure date is not blank then inser date in every sql statements.....Starts

                                                        if ($paybalancetk=="")   ////////////  If payment balance is blank ..... Starts
                                                                {
                                                                        if ($voucherdate !="")
                                                                                { ////  If voucherdate is not blank..... Starts

                                                                                        if ($unloaddate!="")
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }

                                                                                }  /////  If voucherdate is not blank ..... Ends
                                                                        else
                                                                                {      //////////  If voucherdate is blank ........ starts

                                                                                        if ($unloaddate!="")
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }

                                                                                }  ////////  If pay voucher date is blank ..... Ends

                                                                }   ////////////   If payment balance is blank ....... Ends
                                                        
							else  ///////  If payment balance is not blank ....... Starts

                                                                {

                                                                        if ($voucherdate !="")
                                                                                { ////  If voucherdate is not blank..... Starts

                                                                                        if ($unloaddate!="")
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }

                                                                                }  /////  If voucherdate is not blank ..... Ends
                                                                        else
                                                                                {      //////////  If voucherdate is blank ........ starts

                                                                                        if ($unloaddate!="")
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");
                                                                                                }

                                                                                }  ////////  If pay voucher date is blank ..... Ends


                                                                }  /////////  If payment balance is not blank ........ Ends


                                                     }     /////////  If departure date is not blank ........ Ends

                                                else

                                                    {   //////  If departure date is  blank .....Starts

                                                       if ($paybalancetk=="")   ////////////  If payment balance is blank ..... Starts
                                                               {

                                                                       if ($voucherdate !="")
                                                                               { ////  If voucherdate is not blank..... Starts

                                                                                       if ($unloaddate!="")
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                               }


                                                                                       else
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                               }

                                                                               }  /////  If voucherdate is not blank ..... Ends

                                                                       else

                                                                               {      //////////  If voucherdate is blank ........ starts


                                                                                       if ($unloaddate!="")
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                               }


                                                                                       else
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                               }



                                                                               }  ////////  If pay voucher date is blank ..... Ends



                                                               }   ////////////   If payment balance is blank ....... Ends


                                                       else  ///////  If payment balance is not blank ....... Starts

                                                               {

                                                                       if ($voucherdate !="")
                                                                               { ////  If voucherdate is not blank..... Starts

                                                                                       if ($unloaddate!="")
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                               }


                                                                                       else
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                               }

                                                                               }  /////  If voucherdate is not blank ..... Ends

                                                                       else
                                                                               {      //////////  If voucherdate is blank ........ starts


                                                                                       if ($unloaddate!="")
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                               }


                                                                                       else
                                                                                               {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");

                                                                                               }



                                                                               }  ////////  If pay voucher date is blank ..... Ends



                                                               }  /////////  If payment balance is not blank ........ Ends


                                                    }     /////////  If departure date is not blank ........ Ends



                                                }  //////////////   Condition ends for when quantityone is not blank for balance and total taka is not zero in cargo schedule


                                        else
                                                {    ////////////  This is for when quantityone is blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                //        print("Updating advance...line 1262");

                                                        $partoradvance ="Advance";


                                                        $receiveadvancetk = $receiveadvancetk + $payamount;     /////////  problem

                                                        if ($receivetotaltk=="")
                                                                {
                                                                        $receivetotaltk = 0;

                                                                }

                                                        $receivebalancetk = $receivetotaltk - $receiveadvancetk;

                                                        $money_result = pg_exec("insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance,tk_rate_two) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance','$receivetkratetwo')");

                                                        ///////////////////////////////////////////////////////////////////////
                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                        ////////////////////////////////////////////////////////////////////////

                                                        $result = pg_exec($conn,"select * FROM cargo_schedule WHERE (schedule_id = '$scheduleid')");

                                                        $payment_fields = pg_fetch_row($result,0);

                                                        $voucherdate=   $payment_fields[10];
                                                        $owner_name=    $payment_fields[3];
                                                        $ship_name=     $payment_fields[2];
                                                        $fromloc=       $payment_fields[4];
                                                        $toloc=         $payment_fields[5];
                                                        $matone=        $payment_fields[6];
                                                        $mattwo=        $payment_fields[7];
                                                        $quantityone=   $payment_fields[8];
                                                        $quantitytwo=   $payment_fields[9];
                                                        $paytkrate=     $payment_fields[17];
                                                        $paytkratetwo=  $payment_fields[27];
                                                        $payadvance=    $payment_fields[11];
                                                        $departdate=    $payment_fields[1];
                                                        $payparttk=     $payment_fields[12];
                                                        $paytotaltk=    $payment_fields[14];

                                                        if ($payment_fields[15]=="")
                                                                {
                                                                        $paybalancetk = "";

                                                                }

                                                        else
                                                                {

                                                                        $paybalancetk=  $payment_fields[15];

                                                                }



                                                        $cargotripid= $payment_fields[18];
                                                        $unload_date = $payment_fields[19];


                                                   if ($departdate!="")

                                                      {   //////  If departure date is not blank.......  Starts

                                                         if ($paybalancetk=="")
                                                                {    //////////  If payment balance taka is blank ....  Starts

                                                                        if ($voucherdate!="")
                                                                                {     //// If voucherdate is not blank ......starts

                                                                                        if ($unload_date!="")
                                                                                                {       // unload date not blank ...starts..


                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                }   // unload date is not blank.... Ends

                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                }


                                                                                }     //// If voucherdate is not blank .... Ends


                                                                        else
                                                                                {       /////   If voucher date is blank.....  Starts


                                                                                        if ($unload_date!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                }

                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                }



                                                                                }  /////////  If voucher date is blank ..... Ends

                                                                }       ////////    If payment balance is null ..... Ends


                                                        else

                                                                {    //////////  If payment balance taka is not blank ....  Starts

                                                                        if ($voucherdate!="")
                                                                                {     //// If voucherdate is not blank ......starts

                                                                                        if ($unload_date!="")
                                                                                                {       // unload date not blank ...starts..

                                                                                                        $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                }   // unload date is not blank.... Ends

                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                }


                                                                                }     //// If voucherdate is not blank .... Ends


                                                                        else
                                                                                {       /////   If voucher date is blank.....  Starts


                                                                                        if ($unload_date!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                }

                                                                                      else
                                                                                                {

                                                                                                       $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,departure_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$departdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                }



                                                                                }  /////////  If voucher date is blank ..... Ends



                                                                }       ////////    If payment balance is not  null ..... Ends

                                                        }     ///////    If departure date is not blank ......Ends

                                                    else

                                                        {   ////// If departure date is blank... Starts


                                                                    if ($paybalancetk=="")
                                                                           {    //////////  If payment balance taka is blank ....  Starts

                                                                                   if ($voucherdate!="")
                                                                                           {     //// If voucherdate is not blank ......starts

                                                                                                   if ($unload_date!="")
                                                                                                           {       // unload date not blank ...starts..


                                                                                                                   $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                           }   // unload date is not blank.... Ends

                                                                                                   else
                                                                                                           {

                                                                                                                   $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                           }


                                                                                           }     //// If voucherdate is not blank .... Ends


                                                                                   else
                                                                                           {       /////   If voucher date is blank.....  Starts


                                                                                                   if ($unload_date!="")
                                                                                                           {

                                                                                                                   $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                           }

                                                                                                   else
                                                                                                           {

                                                                                                                   $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                           }



                                                                                           }  /////////  If voucher date is blank ..... Ends

                                                                           }       ////////    If payment balance is null ..... Ends


                                                                    else

                                                                           {    //////////  If payment balance taka is not blank ....  Starts

                                                                                   if ($voucherdate!="")
                                                                                           {     //// If voucherdate is not blank ......starts

                                                                                                   if ($unload_date!="")
                                                                                                           {       // unload date not blank ...starts..

                                                                                                                   $result = pg_exec($conn,"DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                           }   // unload date is not blank.... Ends

                                                                                                   else
                                                                                                           {

                                                                                                                   $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,pay_voucher_date,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$voucherdate','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");


                                                                                                           }


                                                                                           }     //// If voucherdate is not blank .... Ends


                                                                                   else
                                                                                           {       /////   If voucher date is blank.....  Starts


                                                                                                   if ($unload_date!="")
                                                                                                           {

                                                                                                                   $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                           }

                                                                                                 else
                                                                                                           {

                                                                                                                  $result = pg_exec("DELETE FROM cargo_schedule WHERE (schedule_id = '$scheduleid');  insert into cargo_schedule (schedule_id,owner_name,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,money_fair_rate,mreceipt_date,received_from,fair_rate_two,money_fair_rate_two) values('$scheduleid','$owner_name','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname','$paytkratetwo','$receivetkratetwo')");



                                                                                                           }



                                                                                           }  /////////  If voucher date is blank ..... Ends



                                                                           }       ////////    If payment balance is not  null ..... Ends

                                                                     }    ///////    If departure date is  blank ......Ends



                                                }          /////// ????????????????????



                                }   // ELSE BRACKET CLOSE





                }     // PAYTYPE CHEQUE BRACKET CLOSE




        }   // NORMAL OPTION BRACKET CLOSE


/******************END OF NORMAL OPTION****************/




/////////////////////////////////////////////////////////////////////////

/////////**************CONDITION FOR SALE **************/////////////////

/////////////////////////////////////////////////////////////////////////


 if ($radiotest=="sale")

  {

                        $carryorsale = "Sale";
                        print("Sale\t");


                        $mreceiptserialno = abs($mreceiptserialno);      ///before it was $serialno ...ask miraj

        ///////////////////////////////////////////////////////////////////////////////////

        /////////**************CONDITION FOR SALE AND CASH **************/////////////////

        ///////////////////////////////////////////////////////////////////////////////////



                                                        if ($paytype == "Cash")
                                                                {   //PAYTYPE CASH BRACKET


                                                                        if ($shiptripid =="")
                                                                                {
                                                                                        $shiptripid = 0;
                                                                                }






                                                                        $serialno = abs($mreceiptserialno);

                                                                        $result = pg_exec($conn,"select *  from purchase_sale_schedule where ship_id=$shipname and trip_id=$shiptripid order by pur_sale_schedule_id");      /// Another codition......"and total_tk!=0" has been ommitted             and ((receive_advance!=0 or receive_advance=0) and receive_balance!=0)

                                                                        $cargo_numrows = pg_numrows($result);

                                                                        if ($cargo_numrows==0)
                                                                                {   //condition for when total taka and balance taka is  zero in cargo schedule BRACKET

                                                                                        $cargotrip =pg_exec("select max(trip_id) from purchase_sale_schedule where ship_id=$shipname");

                                                                                        $cargotripid  =pg_fetch_row($cargotrip,0);
                                                                                        $tripid =  $cargotripid[0];
                                                                                        $tripid = $tripid+1 ;


                                                                                        ////////ask miraj about departuredate because if

                                                                                        if($sale_goodquantityone!="" or $sale_goodquantityone!=0)
                                                                                                {   //This is inside the condition when balance and total taka is zero  1

                                                                                                        $partoradvance = "Part";

                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");

                                                                                                }  //This is inside the condition when balance and total taka is zero  ends ......1

                                                                                        else
                                                                                                {   //This is inside the condition when balance and total taka is zero  2

                                                                                                        $partoradvance = "Advance";


                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");
                                                                                                }   // ends ....2

                                                                                        $receivebalancetk = $receivebalancetk - $payamount;   //payamount of money receipt



                                                                                        ///////////***************??????????**********************we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                                                                        ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                                                                    /*

                                                                                        $shipownresult = pg_exec("select account_id from ship where ship_id=$shipname");
                                                                                        $shipown_numrows = pg_numrows($shipownresult);

                                                                                        if ($shipown_numrows==0)
                                                                                                {   //condition
                                                                                                        $shipownerid =  1;

                                                                                                }
                                                                                        else
                                                                                                {
                                                                                                        $shipownerarray  =pg_fetch_row($shipownresult,0);
                                                                                                        $shipownerid =  $shipownerarray[0];

                                                                                                }
                                                                                      */

                                                                                        ///////////***************??????????***********   END OF           we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                                                                        ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////




                                                                                        $result = pg_exec($conn,"insert into purchase_sale_schedule (received_from,ship_id,from_id,to_id,matone_id,mattwo_id,sale_fair_rate,receive_advance,receive_balance,trip_id) values('$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$receivetkrate','$payamount','$receivebalancetk','$tripid')");


                                                                                        print ("Added in money recpt. when total taka zero for sale..line 1573\n");



                                                                                }  // //condition for when total taka and balance taka is  zero in cargo schedule BRACKET CLOSE


                                                                        //////////// Condition for when tripid same and balance taka is not zero in cargo schedule

                                                                        else
                                                                                {

                                                                                        $upresult = pg_fetch_row($result,0); //// Here $result is
                                                                                        $receiveadvancetk = $upresult [15];
                                                                                        $receiveparttk = $upresult[16];
                                                                                        $scheduleid = $upresult[0];
                                                                                        $cargotripid = $upresult [14];
                                                                                        $goodquantityone = $upresult[7];
                                                                                        $goodquantitytwo = $upresult[8];
                                                                                        print ("$scheduleid");

                                                                                        $receivebalancetk = $upresult [18];
                                                                                        $receivetotaltk = ($goodquantityone +$goodquantitytwo)* $receivetkrate;

                                                                                        if($sale_goodquantityone!="" or $sale_goodquantitytwo!=0)  ////////////  This is inside the  Condition for when total taka and balance taka is not zero in cargo schedule
                                                                                                {
                                                                                                        $partoradvance ="Part";

                                                                                                        print ("$payamount");

                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance')");

                                                                                                        $receiveparttk = $receiveparttk+$payamount;
                                                                                                        $receivebalancetk = $receivetotaltk - ($receiveparttk+$receiveadvancetk);

                                                                                                        print("payment querystart & dept. date is not null\t");

                                                                                                        ///////////////////////////////////////////////////////////////////////
                                                                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                                                                        ////////////////////////////////////////////////////////////////////////

                                                                                                        $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");

                                                                                                        $payment_fields = pg_fetch_row($result,0);


                                                                                                    //    $voucherdate=$payment_fields[10];
                                                                                                        $paidto_id= $payment_fields[2];
                                                                                                        $ship_name=   $payment_fields[1];
                                                                                                        $fromloc=    $payment_fields[3];
                                                                                                        $toloc=      $payment_fields[4];
                                                                                                        $matone=     $payment_fields[5];
                                                                                                        $mattwo=     $payment_fields[6];
                                                                                                        $quantityone=$payment_fields[7];
                                                                                                        $quantitytwo=$payment_fields[8];
                                                                                                        $paytkrate=     $payment_fields[13];
                                                                                                        $payadvance=    $payment_fields[9];
                                                                                                       // $departdate=$payment_fields[1];
                                                                                                        $payparttk=     $payment_fields[10];
                                                                                                        $paytotaltk=    $payment_fields[11];

                                                                                                        if ($payment_fields[12]=="")
                                                                                                                {
                                                                                                                        $paybalancetk = "";

                                                                                                                }

                                                                                                        else
                                                                                                                {

                                                                                                                        $paybalancetk=  $payment_fields[12];

                                                                                                                }


                                                                                                        $cargotripid= $payment_fields[14];
                                                                                                    //    $unload_date = $payment_fields[19];
                                                                                                        print ("$departdate\t");


                                                                                                        if ($paybalancetk=="")
                                                                                                                {  ////// If payment balance is blank ...... Starts


                                                                                                                 /*       if ($voucherdate !="")
                                                                                                                                {       ///  If voucherdate is not blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                                                                }

                                                                                                                                }  ///  If voucherdate is not blank ...Ends


                                                                                                                        else

                                                                                                                                {       ///  If voucherdate is blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {
                                                                                                                   */
                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                                    //                            }

                                                                                                                    //            }  ///  If voucherdate is blank ...Ends


                                                                                                                }    /////////  If payment balance is null ....... Ends


                                                                                                        else       /////////  If payment balance is not null....... Starts

                                                                                                                {

                                                                                                              /*
                                                                                                                        if ($voucherdate !="")
                                                                                                                                {       ///  If voucherdate is not blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                }

                                                                                                                                }  ///  If voucherdate is not blank ...Ends



                                                                                                                        else

                                                                                                                                {       ///  If voucherdate is blank ...Starts

                                                                                                                                        if ($unloaddate!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {
                                                                                                                */
                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                                 //                               }

                                                                                                                 //               }  ///  If voucherdate is blank ...Ends



                                                                                                                } //////  If payment balance is not null .... Ends






                                                                                                }  //////////////   Condition ends for when departure date is not blank for balance and total taka is not zero in cargo schedule




                                                                                        else
                                                                                                {    ////////////  This is for when departure date is blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                                                                        $partoradvance ="Advance";

                                                                                                        $receiveadvance = $receiveadvancetk + $payamount;


                                                                                                        if ($receivetotaltk=="")
                                                                                                                {

                                                                                                                        $receivetotaltk = 0;

                                                                                                                }

                                                                                                        $receivebalancetk = $receivetotaltk - $receiveadvance;


                                                                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance')");


                                                                                                        ///////////////////////////////////////////////////////////////////////
                                                                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                                                                        ////////////////////////////////////////////////////////////////////////

                                                                                                        $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");

                                                                                                        $payment_fields = pg_fetch_row($result,0);

                                                                                             //           $voucherdate=$payment_fields[10];
                                                                                                        $paidto_id= $payment_fields[2];
                                                                                                        $ship_name=   $payment_fields[1];
                                                                                                        $fromloc=    $payment_fields[3];
                                                                                                        $toloc=      $payment_fields[4];
                                                                                                        $matone=     $payment_fields[5];
                                                                                                        $mattwo=     $payment_fields[6];
                                                                                                        $quantityone=$payment_fields[7];
                                                                                                        $quantitytwo=$payment_fields[8];
                                                                                                        $paytkrate=     $payment_fields[13];
                                                                                                        $payadvance=    $payment_fields[9];
                                                                                             //           $departdate=$payment_fields[1];
                                                                                                        $payparttk=     $payment_fields[10];
                                                                                                        $paytotaltk=    $payment_fields[11];

                                                                                                        if ($payment_fields[12]=="")
                                                                                                                {
                                                                                                                        $paybalancetk = "";

                                                                                                                }

                                                                                                        else
                                                                                                                {
                                                                                                                        $paybalancetk=  $payment_fields[12];

                                                                                                                }

                                                                                                        $cargotripid= $payment_fields[14];
                                                                                             //           $unload_date = $payment_fields[19];

                                                                                                        if ($paybalancetk=="")
                                                                                                                {  //////  If payment balance is null...... Starts

                                                                                                                 /*       if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }


                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {

                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                   */                                     $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                     //                           }



                                                                                                                    //            }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is null .........  Ends





                                                                                                        else  ///////   If payment balance is not null ...... Starts

                                                                                                                {

                                                                                                                 /*       if ($voucherdate!="")
                                                                                                                                {        ////////////  If voucher date is not blank..... Starts


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }



                                                                                                                                }      /////////  If voucher date is not blank ....... Ends


                                                                                                                        else    /////////  If voucher date is blank ...... Starts

                                                                                                                                {


                                                                                                                                        if ($unload_date!="")
                                                                                                                                                {

                                                                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                                                }

                                                                                                                                        else

                                                                                                                                                {

                                                                                                                   */                                     $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvance','$receiveaparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");
                                                                                                                                                        print("payment query2 cash done\t");

                                                                                                                    //                            }



                                                                                                                    //            }    ////////   If voucher date is blank ....... Ends


                                                                                                                }    /////////   If payment balance is not null .........  Ends




                                                                                                }     ////////////End of ELSE  This is for when departure date is blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule



                                                                                }   // ELSE BRACKET CLOSE   ////////////// Condition for when tripid same and balance taka is not zero in cargo schedule



                                                                }   // PAYTYPE CASH BRACKET CLOSE

/*********** END OF CARRYING AND CASH OPTION *****************/











//   $money_add_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment) values('$serialno','$receivedate','$payamount','$clientname','$cargoname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment')");




    ///////////////////////////////////////////////////////////////////////////////////

   /////////**************CONDITION FOR SALE AND CHEQUE **************/////////////////

   ///////////////////////////////////////////////////////////////////////////////////


        if ($paytype == "Cheque")

                {      //PAYTYPE CHEQUE BRACKET

                        if ($shiptripid =="")
                                {
                                        $shiptripid = 0;
                                }

                        else
                                {
                                        $shiptripid = $shiptripid ;
                                }

                        $serialno = abs($mreceiptserialno);

                        $result = pg_exec("select *  from purchase_sale_schedule where ship_id = $shipname  and trip_id=$shiptripid order by pur_sale_schedule_id");      /// Another codition......"and total_tk!=0" has been ommitted


                //        print("add cheque/first query done\t");

                        $cargo_numrows = pg_numrows($result);

                        if ($cargo_numrows==0)
                                {   //condition for when total taka and balance taka is  zero in cargo schedule BRACKET

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

                                        /*



                                        $cargotrip =pg_exec("select max(trip_id) from purchase_sale_schedule where ship_id=$shipname");

                                        $cargotripid  =pg_fetch_row($cargotrip,0);
                                        $tripid =  $cargotripid[0];
                                        $tripid = $tripid+1 ;

                                        */


                                        if($sale_goodquantityone!="" or $sale_goodquantityone!=0)

                                                {   //This is inside the condition when balance and total taka is zero  1
                                                        $partoradvance = "Part";

                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");

                                                }  //ends ......1



                                        else
                                                {   //This is inside the condition when balance and total taka is zero  2
                                                        $partoradvance = "Advance";

                                                        $money_result = pg_exec($conn,"insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$receivelocation','$tripid','$carryorsale','$comment','$partoradvance')");
                                                }   // ends ....2

                                        $receivebalancetk = $receivebalancetk - $payamount;   //payamount of money receipt



                                          ///////////***************??????????**********************we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                          ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                      //    $shipownresult = pg_exec("select account_id from ship where ship_id=$shipname");
                                      //    $shipown_numrows = pg_numrows($shipownresult);

                                      //    if ($shipown_numrows==0)
                                      //            {   //condition
                                      //                    $shipownerid =  1;

                                      //            }
                                      //    else
                                      //            {
                                      //                    $shipownerarray  =pg_fetch_row($shipownresult,0);
                                      //                    $shipownerid =  $shipownerarray[0];

                                      //            }


                                          ///////////***************??????????***********   END OF           we have to insert the shipowner id ...other wise it will not show up in the view payment cargo view...
                                          ///////////////******************************************////////if this problem can be solved in other way remove this lines*********************//////

                                        $result = pg_exec("insert into purchase_sale_schedule (received_from,ship_id,paidto_id,from_id,to_id,matone_id,mattwo_id,sale_fair_rate,receive_advance,receive_balance,trip_id) values('$clientname','$shipname','$shipownerid','$fromloc','$toloc','$matone','$mattwo','$receivetkrate','$payamount','$receivebalancetk','$tripid')");

                                        print ("Added in money recpt. when total taka zero or first advance\n");



                                }  // //condition for when total taka and balance taka is  zero in cargo schedule BRACKET CLOSE


                        //////////// Condition for when tripid same and balance taka is not zero in cargo schedule

                        else
                                {
                                        $upresult = pg_fetch_row($result,0); //// Here $result is
                                        $receiveadvancetk = $upresult [15];
                                        $receiveparttk = $upresult[16];
                                        $scheduleid = $upresult[0];
                                        $cargotripid = $upresult [14];
                                        $goodquantityone = $upresult[7];
                                        $goodquantitytwo = $upresult[8];


                                        $receivebalancetk = $upresult [18];
                                        $receivetotaltk = (abs($goodquantityone +$goodquantitytwo)) * $receivetkrate;


                                        if($sale_goodquantityone!="" or $sale_goodquantityone!=0)  ////////////  This is (quantityone is not zero or null)inside the  Condition for when total taka and balance taka is not zero in cargo schedule
                                                {

                                                        $partoradvance ="Part";

                                    //                    print ("$payamount");

                                                        $money_result = pg_exec("insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance')");

                                                        $receiveparttk = $receiveparttk+$payamount;
                                                        $receivebalancetk = $receivetotaltk - ($receiveparttk+$receiveadvancetk);

                                    //                    print("payment querystart & dept. date is not null\t");

                                                        ///////////////////////////////////////////////////////////////////////
                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                        ////////////////////////////////////////////////////////////////////////

                                                        $result = pg_exec("select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");

                                                        $payment_fields = pg_fetch_row($result,0);

                                                        $voucherdate=$payment_fields[10];
                                                        $paidto_id= $payment_fields[2];
                                                        $ship_name=   $payment_fields[1];
                                                        $fromloc=    $payment_fields[3];
                                                        $toloc=      $payment_fields[4];
                                                        $matone=     $payment_fields[5];
                                                        $mattwo=     $payment_fields[6];
                                                        $quantityone=$payment_fields[7];
                                                        $quantitytwo=$payment_fields[8];
                                                        $paytkrate=     $payment_fields[13];
                                                        $payadvance=    $payment_fields[9];
                                                        $departdate=$payment_fields[1];
                                                        $payparttk=     $payment_fields[10];
                                                        $paytotaltk=    $payment_fields[11];

                                                        if ($payment_fields[12]=="")
                                                                {

                                                                        $paybalancetk = "";

                                                                }

                                                        else
                                                                {

                                                                        $paybalancetk=  $payment_fields[12];

                                                                }



                                                        $cargotripid= $payment_fields[14];
                                                //        $unload_date = $payment_fields[19];
                                                //        print ("$departdate\t");


                                                        if ($paybalancetk=="")   ////////////  If payment balance is blank ..... Starts
                                                                {

                                                                        if ($voucherdate !="")
                                                                                { ////  If voucherdate is not blank..... Starts

                                                                                        if ($unloaddate!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query cheque done\t");

                                                                                                }


                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                }

                                                                                }  /////  If voucherdate is not blank ..... Ends

                                                                        else

                                                                                {      //////////  If voucherdate is blank ........ starts


                                                                                        if ($unloaddate!="")
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query cheque done\t");

                                                                                                }


                                                                                        else
                                                                                                {
                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                }



                                                                                }  ////////  If pay voucher date is blank ..... Ends



                                                                }   ////////////   If payment balance is blank ....... Ends


                                                        else  ///////  If payment balance is not blank ....... Starts

                                                                {

                                                                        if ($voucherdate !="")
                                                                                { ////  If voucherdate is not blank..... Starts

                                                                                        if ($unloaddate!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query cheque done\t");

                                                                                                }


                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,pay_voucher_date,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                }



                                                                                }  /////  If voucherdate is not blank ..... Ends

                                                                        else
                                                                                {      //////////  If voucherdate is blank ........ starts


                                                                                        if ($unloaddate!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,departure_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$departdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query cheque done\t");

                                                                                                }


                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveparttk','$receivetotaltk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                }



                                                                                }  ////////  If pay voucher date is blank ..... Ends



                                                                }  /////////  If payment balance is not blank ........ Ends










                                                }  //////////////   Condition ends for when quantityone is not blank  or not null for balance and total taka is not zero in cargo schedule


                                        else
                                                {    ////////////  This is for when departure date is blank--- inside the  Condition for when total taka and balance taka is not zero in cargo schedule

                                                        print("Updating advance...");

                                                        $partoradvance ="Advance";


                                                        $receiveadvancetk = $receiveadvancetk + $payamount;     /////////  problem

                                                        if ($receivetotaltk=="")
                                                                {
                                                                        $receivetotaltk = 0;

                                                                }

                                                        $receivebalancetk = $receivetotaltk - $receiveadvancetk;

                                                        $money_result = pg_exec("insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,receive_location,trip_id,carry_sale_flag,comment,part_or_advance) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$receivelocation','$cargotripid','$carryorsale','$comment','$partoradvance')");

                                                        ///////////////////////////////////////////////////////////////////////
                                                        // To keep track the existing data of payment voucher in cargo schedule
                                                        ////////////////////////////////////////////////////////////////////////

                                                        $result = pg_exec($conn,"select * FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid')");

                                                        $payment_fields = pg_fetch_row($result,0);

                                                    //    $voucherdate=$payment_fields[10];
                                                        $paidto_id= $payment_fields[2];
                                                        $ship_name=   $payment_fields[1];
                                                        $fromloc=    $payment_fields[3];
                                                        $toloc=      $payment_fields[4];
                                                        $matone=     $payment_fields[5];
                                                        $mattwo=     $payment_fields[6];
                                                        $quantityone=$payment_fields[7];
                                                        $quantitytwo=$payment_fields[8];
                                                        $paytkrate=     $payment_fields[13];
                                                        $payadvance=    $payment_fields[9];
                                                    //    $departdate=$payment_fields[1];
                                                        $payparttk=     $payment_fields[10];
                                                        $paytotaltk=    $payment_fields[11];

                                                        if ($payment_fields[12]=="")
                                                                {
                                                                        $paybalancetk = "";

                                                                }

                                                        else
                                                                {

                                                                        $paybalancetk=  $payment_fields[12];

                                                                }



                                                        $cargotripid= $payment_fields[14];
                                                    //    $unload_date = $payment_fields[19];

                                                        if ($paybalancetk=="")
                                                                {    //////////  If payment balance taka is blank ....  Starts
                                                                    /*
                                                                        if ($voucherdate!="")
                                                                                {     //// If voucherdate is not blank ......starts

                                                                                        if ($unload_date!="")
                                                                                                {       // unload date not blank ...starts..


                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query2 cheque done; but some problems here...line 1279\t");

                                                                                                }   // unload date is not blank.... Ends

                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$clientname')");
                                                                                                        print("payment query2 cash done....line 1287\t");

                                                                                      //          }


                                                                                }     //// If voucherdate is not blank .... Ends


                                                                        else
                                                                                {       /////   If voucher date is blank.....  Starts


                                                                                        if ($unload_date!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                        print("payment query2 cheque done\t");

                                                                                                }

                                                                                        else
                                                                                                {

                                                                                       */               $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                        print("payment query2 cheque done\t");

                                                                                      //          }



                                                                           //     }  /////////  If voucher date is blank ..... Ends

                                                                }       ////////    If payment balance is null ..... Ends


                                                        else

                                                                {    //////////  If payment balance taka is not blank ....  Starts

                                                                    /*    if ($voucherdate!="")
                                                                                {     //// If voucherdate is not blank ......starts

                                                                                        if ($unload_date!="")
                                                                                                {       // unload date not blank ...starts..

                                                                                                        $result = pg_exec($conn,"DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,pay_voucher_date,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$voucherdate','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");
                                                                                                        print("payment query2 cash done\t");

                                                                                                }   // unload date is not blank.... Ends

                                                                                        else
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$clientname')");
                                                                                                        print("payment query2 cash done\t");

                                                                                     //           }


                                                                                }     //// If voucherdate is not blank .... Ends


                                                                        else
                                                                                {       /////   If voucher date is blank.....  Starts

                                                                           */
                                                                                /*        if ($unload_date!="")
                                                                                                {

                                                                                                        $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,mat_one,mat_two,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,mreceipt_date,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$unload_date','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$receivedate','$clientname')");

                                                                                                        print("payment query2 cash done...line1387\t");

                                                                                                }

                                                                                      else
                                                                                                {
                                                                                  */
                                                                                                       $result = pg_exec("DELETE FROM purchase_sale_schedule WHERE (pur_sale_schedule_id = '$scheduleid');  insert into purchase_sale_schedule (pur_sale_schedule_id,paidto_id,ship_id,from_id,to_id,matone_id,mattwo_id,quantity_one,quantity_two,fair_rate,advance_tk,part_tk,total_tk,balance_tk,trip_id,receive_advance,receive_part,receive_total,receive_balance,sale_fair_rate,received_from) values('$scheduleid','$paidto_id','$ship_name','$fromloc','$toloc','$matone','$mattwo','$quantityone','$quantitytwo','$paytkrate','$payadvance','$payparttk','$paytotaltk','$paybalancetk','$cargotripid','$receiveadvancetk','$receiveaparttk','$receivetotalk','$receivebalancetk','$receivetkrate','$clientname')");

                                                                                                       print("payment query2 cash done....line 2441\t");

                                                                                   //             }



                                                                          //      }  /////////  If voucher date is blank ..... Ends



                                                                }       ////////    If payment balance is not  null ..... Ends




                                                }          /////// ????????????????????



                                }   // ELSE BRACKET CLOSE





                }     // PAYTYPE CHEQUE BRACKET CLOSE









//



   }      ///////// END SALE OPTION /////////////////

   if($radiotest!="official")
           {

                if($radiotest=="normal")
                     {
                             $result = pg_exec("select * from money_carrying_view order by mreceipt_id");
                     }

                if($radiotest=="sale")
                     {
                             $result = pg_exec("select * from money_sale_view order by mreceipt_id");
                     }

                $numrows=pg_numrows($result);
                $numfields = pg_numfields($result);

                $row = pg_fetch_row($result,$numrows-1);

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



                $gotocheck = $numrows;



        }







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
                                        $result = pg_exec($conn,"insert into money_receipt (mreceipt_date,amount,account_id,pay_type,bank_name,branch,cheque_receive_date,mreceipt_serial,comment,carry_sale_flag,cheque_no,off_accountname) values('$receivedate','$payamount','$clientname','$paytype','$bankname','$bankbranch','$chequereceivedate','$mreceiptserialno','$comment','$car_pur_off','$chequeno','$expensetype')");

                                }


                        ///////////*******************START OF OFFICIAL + CASH OPTION ***********///////////////


                        if ($paytype=="Cash")
                                {

                                        print("official&Cash");
                                        print("$mreceiptdate");


                                            ////////////////query for voucherno///////////////////////////

                                            $year = date ("Y");
                                            $month = date("m") ;
                                            $vounumrows = 0;
                                            $vouresult = pg_exec("select max(mreceipt_serial) from money_receipt where ((date_part('year',mreceipt_date)=$year) and (date_part('month',mreceipt_date)=$month) ) ");   //
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
                                                            $mreceiptserial = $voucherno;

                                                    }

                                            else
                                                    {
                                                            $vourow = pg_fetch_row($vouresult,0);
                                                            print("shamimmiraj");
                                                            $voucherno = abs($vourow[0]);
                                                            $voucherno = abs($voucherno);
                                                            $voucherno = $voucherno+1;
                                                            $mreceiptserial = $voucherno;
                                                    }


                                            ////////////////end of query for voucherno///////////////////////////






                                        $result = pg_exec("insert into money_receipt (mreceipt_date,amount,account_id,pay_type,mreceipt_serial,comment,carry_sale_flag,off_accountname) values('$receivedate','$payamount','$clientname','$paytype','$mreceiptserial','$comment','$car_pur_off','$expensetype')");

                                }


                        $result = pg_exec("select * from money_official_view");
                        $numrows=pg_numrows($result);
                        $row = pg_fetch_row($result,$numrows-1);

                        $mreceiptid = $row[0];
                        $mreceiptdate = $row[1];
                        $mreceiptserialno = $row[2];
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

                        $gotocheck = $numrows;



                }        //////////////******************** END OF OFFICIAL OPTION *****************///////////////////


	}   //end of else

   }/////added by me to check duplicate record,,,its the end of else....

}       /**********************End Of ADD Button *******************/










/////////////////////////////////////////////////////////////////////

/**************************** FOR EDIT BUTTON  *********************/

/////////////////////////////////////////////////////////////////////

        if ($filling == "editbutton")
                {


                        $result = pg_exec("select * from money_receipt order by mreceipt_id");

	                $numrows=pg_numrows($result);

                        /*********STARTING EDIT + NORMAL OPTION ****************************/////

                        if($radiotest=="normal")
                                {
                                        echo("Edit Start") ;
                                        $carryorsale="Carry";

                                     /**************STARTING NORMAL+CHEQUE OPTION************//////
                                        if($paytype=="Cheque")
                                                {
	                                                $result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$moneyreceiptid');insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment')");

                                                }

                                     /********************STARTING NORMAL+CASH OPTION OPTION************////////

                                        if($paytype=="Cash")
                                                {
                                                        $result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$moneyreceiptid'); insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment')");
                                                }

                                        $result = pg_exec("select * from money_carrying_view order by mreceipt_id");
                                }

                        ////////////****************STARTING EDIT+SALE OPTION**********************/////////////

                        if($radiotest=="sale")
                                {
                                        $carryorsale="Sale";

                                        /**************STARTING SALE+CHEQUE OPTION************//////

                                        if($paytype=="Cheque")
                                                {
                                                        $result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$moneyreceiptid'); insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,cheque_no,bank_name,branch,cheque_receive_date,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$chequeno','$bankname','$bankbranch','$chequereceivedate','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment')");

                                                }

                                        /********************STARTING SALE+CASH OPTION OPTION************////////

                                        if($paytype=="Cash")
                                                {

                                                        $result = pg_exec($conn,"DELETE FROM money_receipt WHERE (mreceipt_id = '$moneyreceiptid'); insert into money_receipt (mreceipt_serial,mreceipt_date,amount,account_id,ship_id,from_id,to_id,mat_one,mat_two,pay_type,tk_rate,departure_date,receive_location,trip_id,carry_sale_flag,comment) values('$serialno','$receivedate','$payamount','$clientname','$shipname','$fromloc','$toloc','$matone','$mattwo','$paytype','$receivetkrate','$departuredate','$receivelocation','$tripid','$carryorsale','$comment')");

                                                }

                                        $result = pg_exec("select * from money_sale_view order by mreceipt_id");
                                }

		        $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

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


	


?>



<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Money Receipt</title>
<base target="_self">
</head>
<script language= javascript 1.5 >

var numrows=<?php echo $numrows ?>;

var gotocheck=<?php echo $gotocheck ?>;

function set_attribute()
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
                                                if (document.test.mreceiptid.value ==0)
                                                        {
                                                                button_option("norecord");

                                                        }

                                                else
                                                        {
                                                                button_option("normal");
                                                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);
                                                        }


                                                document.test.receivedate.disabled=true;
                                                document.test.comment.disabled=true;
                                                document.test.clientname.disabled=true;
                                                document.test.mreceiptserialno.disabled=true;
                                                //previous entries

                                                if(document.test.radiotest.value!="official")
                                                        {
                                                                document.test.receivelocation.disabled=true;






                                              //  document.test.shipname.disabled=true;





                                                                document.test.amountinword.disabled=true;
                                                                document.test.matone.disabled=true;
                                                                document.test.mattwo.disabled=true;
                                                                document.test.fromloc.disabled=true;
                                                                document.test.toloc.disabled=true;
                                                                document.test.receivetkrate.disabled=true;
                                                                document.test.receivetkratetwo.disabled=true;
                                                                document.test.departuredate.disabled=true;

                                                        }


                                                document.test.payamount.disabled=true;
                                                document.test.amountinword.disabled=true;
                                                document.test.paytype.disabled=true;
                                                document.test.chequeno.disabled=true;
                                                document.test.bankname.disabled=true;
                                                document.test.bankbranch.disabled=true;
                                                document.test.chequereceivedate.disabled=true;




                                                <?php

                                                        if ($radiotest=="normal")
                                                                {
                                                                        print("document.test.shipname.disabled=true;");
                                                                }

                                                        if ($radiotest=="sale")
                                                                {
                                                                        print("document.test.purchaseoption.disabled=true;");
                                                                }

                                                         if ($radiotest=="official")
                                                                 {
                                                                         print("document.test.expensetype.disabled=true;");
                                                                 }




                                                ?>


                                        }


                                if (document.test.setat.value =="true")
                                        {
                                                document.test.purchase[0].disabled=true;
                                                document.test.purchase[1].disabled=true;
                                                document.test.purchase[2].disabled=true;

                                                document.test.comment.disabled=false;
                                                document.test.clientname.disabled=false;
                                                document.test.mreceiptserialno.disabled=false;
                                                document.test.receivelocation.disabled=false;
                                                document.test.shipname.disabled=false;

                                                document.test.payamount.disabled=false;
                                                document.test.amountinword.disabled=true;
                                                document.test.matone.disabled=false;
                                                document.test.mattwo.disabled=false;
                                                document.test.fromloc.disabled=false;
                                                document.test.toloc.disabled=false;
                                                document.test.receivetkrate.disabled=false;
                                                document.test.receivetkratetwo.disabled=false;
                                                document.test.paytype.disabled=false;
                                                document.test.chequeno.disabled=false;
                                                document.test.bankname.disabled=false;
                                                document.test.bankbranch.disabled=false;
                                                document.test.departuredate.disabled=false;
                                                document.test.chequereceivedate.disabled=false;

                                                button_option("pressed");

                                                if (document.test.payamount.value != 0)
                                                        {
                                                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);
                                                        }


                                                <?php
                                                        if ($radiotest=="normal")
                                                                {
                                                                        print("document.test.shipname.disabled=false;");
                                                                }
                                                        if ($radiotest=="sale")
                                                                {
                                                                        print("document.test.purchaseoption.disabled=false;");
                                                                }

                                                ?>

                                                document.test.setat.value="false";
                                                document.test.savecancel.value = "true";  //if any problem just remove it
                                        }




                        }  // end of else of add_edit duplicate


			window.status = document.test.gotocheck.value+"/"+ numrows


        }  // end of set attribute function.




function add_edit_press(endis)
        {
                //document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                if (endis=='addedit')
                        {
                                document.test.purchase[0].disabled=true;
                                document.test.purchase[1].disabled=true;
                                document.test.purchase[2].disabled=true;


                                document.test.clientname.disabled=false;
                                document.test.mreceiptserialno.disabled=false;
                                document.test.amountinword.disabled=true;
                                document.test.receivedate.disabled=false;
                                document.test.comment.disabled=false;

                                document.test.paytype.disabled=false;
                                document.test.chequeno.disabled=false;

                                document.test.bankname.disabled=false;
                                document.test.bankbranch.disabled=false;
                                document.test.chequereceivedate.disabled=false;


                                button_option("pressed");


                                if (document.test.radiotest.value!="official")
                                        {


                                        }

                                <?php

                                        if ($radiotest!="official")
                                                {
                                                        print("{

                                                                        document.test.shipname.disabled=false;
                                                                        document.test.payamount.disabled=false;

                                                                        document.test.matone.disabled=false;
                                                                        document.test.mattwo.disabled=false;
                                                                        document.test.fromloc.disabled=false;
                                                                        document.test.toloc.disabled=false;
                                                                        document.test.receivetkrate.disabled=false;
                                                                        document.test.receivetkratetwo.disabled=false;
                                                                        document.test.receivelocation.disabled=false;
                                                                        document.test.departuredate.disabled=false;


                                                                }");



                                                                if ($radiotest=="normal")
                                                                        {
                                                                                print("document.test.shipname.disabled=false;");
                                                                        }

                                                                if ($radiotest=="sale")
                                                                        {
                                                                                print("document.test.purchaseoption.disabled=false;");
                                                                        }



                                                }


                                        if ($radiotest=="official")
                                                {


                                                        print("{
                                                                        //document.test.clientname.disabled=false;
                                                                        document.test.expensetype.disabled=false;
                                                                        document.test.payamount.disabled=false;
                                                                        //document.test.amountinword.disabled=false;

                                                                        //setvoucherdate_serial();

                                                                        alert(document.test.official_voucherno.value);

                                                                        document.test.mreceiptserialno.value = document.test.official_voucherno.value;

                                                                    //    document.test.paytype.options[document.test.paytype.selectedIndex].text = document.test.abc.value;



                                                                }");
                                                }

                                ?>


                        }



                else
	                {
                                document.test.purchase[0].disabled=false;
                                document.test.purchase[1].disabled=false;
                                document.test.purchase[2].disabled=false;

                                if (document.test.mreceiptid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");

                                        }

                                document.test.mreceiptserialno.disabled=true;
                                document.test.receivedate.disabled=true;
                                document.test.paytype.disabled=true;
                                document.test.chequeno.disabled=true;
                                document.test.comment.disabled=true;
                                document.test.bankname.disabled=true;
                                document.test.bankbranch.disabled=true;
                                document.test.chequereceivedate.disabled=true;

                                if(document.test.radiotest.value!="official")
                                        {
                                               // document.test.receivelocation.disabled=true;
                                        }


                                <?php

                                        if ($radiotest!="official")
                                                {
                                                        print("{
                                                                document.test.clientname.disabled=true;

                                                                document.test.receivelocation.disabled=true;

                                                                document.test.payamount.disabled=true;
                                                                document.test.shipname.disabled=true;
                                                                document.test.amountinword.disabled=true;
                                                                document.test.matone.disabled=true;
                                                                document.test.mattwo.disabled=true;
                                                                document.test.fromloc.disabled=true;
                                                                document.test.toloc.disabled=true;
                                                                document.test.receivetkrate.disabled=true;
                                                                document.test.receivetkratetwo.disabled=true;
                                                                document.test.departuredate.disabled=true;

                                                                }");


                                                }



                                ?>





                               // button_option("normal");

                                document.test.amountinword.value=moneyconvert(document.test.payamount.value);

                                <?php

                                        if ($radiotest=="normal")
                                                {
                                                        print("document.test.shipname.disabled=true;");
                                                }

                                        if ($radiotest=="sale")
                                                {
                                                        print("document.test.purchaseoption.disabled=true;");
                                                }

                                ?>


                        }



        }





function form_validator(theForm)
        {
                /*if(theForm.clientname.selectedIndex == -1)
                            {
                            	 alert("Please Select A Clientname");
                    		 theForm.clientname.focus();
                    		 return(false);
                    	}


                if (capfirst(theForm.clientname.options[theForm.clientname.selectedIndex].text)=="")
                        {
                               alert ("<?php echo $txt_missing_accountname ?>");
                           //    theForm.clientname.focus();
                               return(false);
                        }


                if (document.test.radiotest.value=="normal")
                        {

                                alert("Sorry...First you have to choose a client, then select desired Ship Name");
                                theForm.shipname.focus();
                                return(false);

                        }


                if((theForm.mreceiptserialno.value=="") || (theForm.mreceiptserialno.value==0))
                        {
        	                alert("<?php echo $txt_missing_payserial ?>");
                            //    theForm.mreceiptserialno.select();
        	            //    theForm.mreceiptserialno.focus();
        	                return(false);
                        }



                if(theForm.receivedate.value=="")
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

                if (isFinite(theForm.payamount.value) != true)
                        {
                                 alert('Invalid Number Argument In Paid Amount !');
                                 theForm.payamount.select();
                                 theForm.payamount.focus();
                                 return(false);

                        }


                 if (theForm.paytype.options[theForm.paytype.selectedIndex].text == "")
                         {
                                 alert("Please select Cash/Cheque as Pay type");
                                 theForm.paytype.focus();
                                 return(false);
                         }







               if (theForm.radiotest.value=="official")
                       {
                          if (theForm.expensetype.options[theForm.expensetype.selectedIndex].text == "")
                                  {
                                          alert("Please select On Account Of");
                                          theForm.expensetype.focus();
                                          return(false);
                                 }

                       }





                if ( Number(theForm.balancetk.value ) > 0)
                        {

                                if( Number(theForm.payamount.value) > Number(theForm.balancetk.value) )
                                        {
                                                var abcd = Number(theForm.payamount.value) - Number(theForm.balancetk.value);

                                                alert("Sorry! Receive Amount is "+abcd+" Taka more than Balance Amount");
                                                theForm.payamount.select();
                                                theForm.payamount.focus();
                                                return(false);
                                        }

                        }


               if (theForm.radiotest.value!="official")
                       {



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


                                if ( capfirst(theForm.fromloc.options[theForm.fromloc.selectedIndex].text) == "" )
                                        {
                                                alert("<?php echo $txt_missing_fromlocname ?>");
                                                theForm.fromloc.focus();
                                                return(false);
                                        }

                                if ( capfirst(theForm.toloc.options[theForm.toloc.selectedIndex].text) == "")
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


                                if (theForm.receivetkrate.value == 0)
                                        {
                                                alert("<?php echo $txt_missing_takarate ?>");
                                                theForm.receivetkrate.select();
                                                theForm.receivetkrate.focus();
                                                return(false);
                                        }

                                if (isFinite(theForm.receivetkrate.value) != true)
                                        {
                                                alert('Invalid Number Argument In Fair Rate !');
                                                theForm.receivetkrate.select();
                                                theForm.receivetkrate.focus();
                                                return(false);

                                        }




                                if (theForm.mattwo.options[theForm.mattwo.selectedIndex].text != "********")
                                        {

                                                if (theForm.receivetkratetwo.value == 0)
                                                        {
                                                                alert(theForm.mattwo.options[theForm.mattwo.selectedIndex].text);
                                                                alert("<?php echo $txt_missing_takaratetwo ?>");
                                                                theForm.receivetkratetwo.select();
                                                                theForm.receivetkratetwo.focus();
                                                                return(false);
                                                        }

                                                if (isFinite(theForm.receivetkratetwo.value) != true)
                                                        {
                                                                alert('Invalid Number Argument In Fair Rate !');
                                                                theForm.receivetkratetwo.select();
                                                                theForm.receivetkratetwo.focus();
                                                                return(false);

                                                        }



                                        }




                       }      /// Inside not equals to official option


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
             */
	        return (true);

        }



function print_record()
        {
              if (document.test.radiotest.value != "official")
                      {

                                if (document.test.radiotest.value == "sale")
                                        {
                                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;

                                                var abc = "print_receipt.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&receivedate="+document.test.receivedate.value;
                                        }

                                else
                                        {
                                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                                                var abc = "print_receipt.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&receivedate="+document.test.receivedate.value+"&receiptserial="+document.test.mreceiptserialno.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.ownername.value+"&materialone="+document.test.matone.options[document.test.matone.selectedIndex].text+"&materialtwo="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&fairrate="+document.test.receivetkrate.value+"&fairratetwo="+document.test.receivetkratetwo.value+"&fromlocation="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&tolocation="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&cashorcheque="+document.test.paytype.options[document.test.paytype.selectedIndex].text+"&bankname="+document.test.bankname.value+"&bankbranch="+document.test.bankbranch.value+"&chequeno="+document.test.chequeno.value+"&chequedate="+document.test.chequereceivedate.value+"&print_comment="+document.test.comment.value;
                                                alert (abc);
                                        }

                      }

              else
                        {
                                document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                                var abc = "print_receipt.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&receivedate="+document.test.receivedate.value+"&receiptserial="+document.test.mreceiptserialno.value+"&payamount="+document.test.payamount.value+"&amountinword="+document.test.amountinword.value+"&clientname="+document.test.ownername.value+"&cashorcheque="+document.test.paytype.options[document.test.paytype.selectedIndex].text+"&bankname="+document.test.bankname.value+"&bankbranch="+document.test.bankbranch.value+"&chequeno="+document.test.chequeno.value+"&chequedate="+document.test.chequereceivedate.value+"&print_comment="+document.test.comment.value+"&shipcargo="+document.test.expensetype.options[document.test.expensetype.selectedIndex].text;
                                alert (abc);
                        }





                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");


        }






function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_money_carry.php?gotocheck=$gotocheck&radiotest=$radiotest&button_check=$button_check&testindicator=$mreceiptid\",\"view\",\"toolbar=no,scrollbars=yes\")");

                ?>
        }



function view_cargo()
        {
                document.test.shipcargo.value=document.test.shipname.value;

         //       document.test.setat.value="true";    /// Added on 1st February

                alert( document.test.shipcargo.value);
                alert (document.test.shipname.options[document.test.shipname.selectedIndex].text);

                var abc = "view_money_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&paidtaka="+document.test.payamount.value+"&mreceiptid="+document.test.mreceiptid.value+"&receivedfrom="+document.test.clientname.value;

                alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }



function view_pur_sale_cargo()
        {
                document.test.shipcargo.value=document.test.shipname.value;

                alert( document.test.shipcargo.value);
                alert (document.test.shipname.options[document.test.shipname.selectedIndex].text);

                var abc = "view_sale_cargo.php?gotocheck="+String(document.test.gotocheck.value)+"&radiotest="+document.test.radiotest.value+"&shipcargo="+document.test.shipname.value+"&shipoldvalue="+document.test.shipname.value+"&shipoldname="+document.test.shipname.options[document.test.shipname.selectedIndex].text+"&clientoldvalue="+document.test.clientname.value+"&clientoldname="+document.test.clientname.options[document.test.clientname.selectedIndex].text+"&oldmatonename="+document.test.matone.options[document.test.matone.selectedIndex].text+"&matoneoldvalue="+document.test.matone.value+"&mattwooldvalue="+document.test.mattwo.value+"&oldmattwoname="+document.test.mattwo.options[document.test.mattwo.selectedIndex].text+"&oldfromlocname="+document.test.fromloc.options[document.test.fromloc.selectedIndex].text+"&oldtolocname="+document.test.toloc.options[document.test.toloc.selectedIndex].text+"&oldfromlocvalue="+document.test.fromloc.value+"&oldtolocvalue="+document.test.toloc.value+"&paidtaka="+document.test.payamount.value+"&mreceiptid="+document.test.mreceiptid.value;

                alert (abc);
                window.open(abc,"View","toolbar=no,scrollbars=yes");

        }


function entertainment()
         {

                 document.test.filling.value = "addbutton";

         }








function shipsel()
        {
                //document.test.shipselect.value = "true";
 	        document.test.setat.value = "true";
                //	document.test.clientselect.value = "true";
                document.test.savecancel.value = "false";
                document.test.comment.value = document.test.savecancel.value;
                //document.test.ownername.value = document.test.clientname.options[document.test.clientname.selectedIndex].text;
                //	document.test.submit();
        }



function normal (whatever)
        {
                if (whatever=='nor')
                        {
                                document.test.radiotest.value = "normal" ;
                                document.test.filling.value = "eggplant" ;
                        }
                if (whatever=='pur')
                        {

                                document.test.radiotest.value = "sale" ;
                                document.test.filling.value = "eggplant" ;
                        }

                 if (whatever=='office')
                         {
                                 document.test.radiotest.value = "official" ;
                                 document.test.filling.value = "eggplant" ;
                         }



        }



</script>

<script language = javascript src="all_jscript_function.js"></script>
<script language = javascript src="date_picker.js"></script>

<body  bgcolor= "#c5bdbd" onload= "set_attribute()">           <!--9FC4C2
                                                                  -->
<form name= "test" onsubmit = "return form_validator(this)"  onreset = "add_edit_press()" method= post action="money_add_insert.php">

<div align="center"><font size="5"><b><u>Money Receipt</u></b></font></div>


<TABLE width="100%" border="1" bgcolor = "#00FFFF">
<TR>
<TD width="">


<?php
        if ($radiotest=="normal")
                {

                        print ("<font color=\"darkRed\"><b><input type = \"radio\" name = \"purchase\" value = \"normal\" checked onclick= \"normal('nor');document.test.submit()\">&nbsp;&nbsp; Carrying
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type = \"radio\" name = \"purchase\" value = \"sale\"  onclick= \"normal('pur');document.test.submit()\">&nbsp;&nbsp; Sale

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







?>
</TD>


 <TD width="30%"><b>SL.NO.:</b><input type="text" name="mreceiptserialno" value="<?php echo $mreceiptserialno ?>" size=9 align="center"  >
 </td></TR> </TABLE>


 <TABLE width="100%" border="2">
  <TR>
  <TD width="">
 <B>
<font size="3">Received  From:</font> </B></TD>
<TD width=""> <select size="1" name="clientname"> <!--onchange="shipsel()"
                                                      -->
<option  value ="<?php echo $clientname ?>" selected ><?php echo $accountname ?></option>

<?php

        // grabs all product information
        $result = pg_exec("select account_id,account_name from accounts where account_type='Client' order by account_name");

        if($radiotest=="official")
                {

                        $result = pg_exec("select account_id,account_name from accounts where account_type='Official' order by account_name");

                }





        $num_client=pg_numrows($result);

        for($i=0;$i<$num_client;$i++)
                {
	                $client_row = pg_fetch_row($result,$i);

	                print("<option value = \"$client_row[0]\" >$client_row[1]</option>\n");
	        }

?>

</select> </TD>

<TD width=""><B>Date:</B></TD>
<TD width=""><input type=text name="receivedate" value="<?php echo $mreceiptdate?>" size=15 readonly><a href="javascript:show_calendar('test.receivedate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a></font></p>
</TD> </TR>
</TABLE>

<TABLE border="1" width="100%">
<TR>


<TD width=""><B>Taka:</B> </TD>

<TD width=""><input type="text" name="payamount" value="<?php echo $payamount ?>" size="8" onchange= "document.test.amountinword.value=moneyconvert(document.test.payamount.value)">&nbsp;&nbsp;
</TD>

<TD width=""><B>In word</B></TD> <font face="Times New Roman" size="2">
<TD width=""><textarea rows="2" name="amountinword" cols="50"></textarea></font> </TD>
</TR>
</TABLE>

<TABLE width="701"border="1">
<TR>


<TD width="90"><B>On Account:</B></TD>

<TD width="200">

<?php


// grabs all product information

if ($radiotest=="normal")
        {
                print("<select size=\"1\" name=\"shipname\"onchange=\"view_cargo()\">");
                print("<option value=\"$shipname\" selected>$nameofship </option>");

                $result = pg_exec("select ship_id,ship_name from ship order by ship_name");
                $num_ship = pg_numrows($result);

                for($i=0;$i<$num_ship;$i++)
                        {
	                        $row_ship = pg_fetch_row($result,$i);

	                        print("<option value = \"$row_ship[0]\" >$row_ship[1]</option>\n");
	                }

                print("</select></TD>");

        }


if ($radiotest=="sale")
        {
                print("<select size=\"1\" name=\"matone\">");
                print("<option value=\"$matone\" selected>$materialonename </option>");

                $result = pg_exec("select matone_id,matone_name from materialone order by matone_name");


                $num_mat = pg_numrows($result);

                for($i=0;$i<$num_mat;$i++)
                        {
	                        $row_mat = pg_fetch_row($result,$i);

	                        print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");
	                }

                print("</select>");

                print("<select size=\"1\" name=\"mattwo\">");
                print("<option value=\"$mattwo\" selected>$materialtwoname </option>");

                $result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");

                $num_mat2 = pg_numrows($result);

                for($i=0;$i<$num_mat2;$i++)
                        {
	                        $row_mat2 = pg_fetch_row($result,$i);

	                        print("<option value = \"$row_mat2[0]\" >$row_mat2[1]</option>\n");
	                }

                print("</select></TD>");

        }


if ($radiotest=="official")
       {
               print("<select size=\"1\" name=\"expensetype\" onchange=\"entertainment()\"> ");

               print("<option selected>$row[11]</option>\n");
               print("<option> Entertainment </option>\n
                       <option>Transport</option>
                       <option>Salary</option>
                       <option >House Rent & Utilities</option>
                       <option >Printing & Stationaries</option>
                       <option >Office Management</option>
                       <option >Furniture</option>
                       <option >Business Promotion</option>
                       <option >Miscellenious</option>
                       <option >Received Amount</option>
                       <option >Loan</option>
                        </select>");

               print(" </select>");



       }





?>






    <?php


// grabs all product information

        if ($radiotest=="normal")
                {
                     /*
                        print("<TD width=\"6\"><B>For:</B></TD>

                        <TD width=\"261\">");

                        print("<select size=\"1\" name=\"matone\">");
                        print("<option value = \"$matone\" selected>$materialonename</option>\n");

                        $result = pg_exec("select matone_id,matone_name from materialone order by matone_name");

                        $num_mat = pg_numrows($result);

                        for($i=0;$i<$num_mat;$i++)
                                {
	                                $row_mat = pg_fetch_row($result,$i);

	                                print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");
	                        }

                        print("</select>");

                        print("<select size=\"1\" name=\"mattwo\">");
                        print("<option value = \"$mattwo\" selected>$materialtwoname</option>\n");

                        $result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");

                        $num_mat = pg_numrows($result);

                        for($i=0;$i<$num_mat;$i++)
                                {
	                                $row_mat = pg_fetch_row($result,$i);

	                                print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");

                                }

                        print("</select>");

                      */

                            print("<TD width=\"83\"><B><b>From:</b></TD>");


                            print("<TD width=\"115\">
                                    <select size=1 name=\"fromloc\">
                                    <option value =\"$fromloc\" selected>$fromlocname</option> ");



                            // grabs all product information
                            $result = pg_exec("select from_id,from_loc from locationfrom order by from_loc");
                            $num_fromloc = pg_numrows($result);

                            for($i=0;$i<$num_fromloc;$i++)
                                    {
               	                        $row_fromloc = pg_fetch_row($result,$i);

               	                        print("<option value = \"$row_fromloc[0]\" >$row_fromloc[1]</option>\n");
               	                }

                            print("</select></TD>

                            <TD width=\"98\">
                            <B>To:</B>

                            <TD width=\"114\">
                            <select size=\"1\" name=\"toloc\">
                            <option value =\" $toloc \" selected> $tolocname </option> ");





                    // grabs all product information
                    $result = pg_exec("select to_id,to_loc from locationto order by to_loc");
                    $num_loc = pg_numrows($result);

                    for($i=0;$i<$num_loc;$i++)
                            {
               	                $row_loc = pg_fetch_row($result,$i);

               	                print("<option value = \"$row_loc[0]\" >$row_loc[1]</option>\n");
               	        }

                     print("</select></TD>");


                }



        if ($radiotest=="sale")
                {
                        print("<TD width=\"6\"><B>For:</B></TD>

                        <TD width=\"261\">");

                        print("<select size=\"1\" name=\"purchaseoption\">");
                        print("<option>Sale</option>\n");
                        print("</select>");

                }

?>


</TD> </TR>

</TABLE>

<TABLE width="949" border="1">
<TR>

<?php

if ($radiotest!="official")
        {

           /*

                print("<TD width=\"83\"><B><b>From:</b></TD>");


                print("<TD width=\"115\">
                        <select size=1 name=\"fromloc\">
                        <option value =\"$fromloc\" selected>$fromlocname</option> ");



                // grabs all product information
                $result = pg_exec("select from_id,from_loc from locationfrom order by from_loc");
                $num_fromloc = pg_numrows($result);

                for($i=0;$i<$num_fromloc;$i++)
                        {
	                        $row_fromloc = pg_fetch_row($result,$i);

	                        print("<option value = \"$row_fromloc[0]\" >$row_fromloc[1]</option>\n");
	                }

                print("</select></TD>

                <TD width=\"98\">
                <B>To:</B>

                <TD width=\"114\">
                <select size=\"1\" name=\"toloc\">
                <option value =\" $toloc \" selected> $tolocname </option> ");





        // grabs all product information
        $result = pg_exec("select to_id,to_loc from locationto order by to_loc");
        $num_loc = pg_numrows($result);

        for($i=0;$i<$num_loc;$i++)
                {
	                $row_loc = pg_fetch_row($result,$i);

	                print("<option value = \"$row_loc[0]\" >$row_loc[1]</option>\n");
	        }


        print("</select></TD>");    */


            print("<TD width=\"100\"><B>Material One:</B></TD>

            <TD width=\"161\">");

            print("<select size=\"1\" name=\"matone\">");
            print("<option value = \"$matone\" selected>$materialonename</option>\n");

            $result = pg_exec("select matone_id,matone_name from materialone order by matone_name");

            $num_mat = pg_numrows($result);

            for($i=0;$i<$num_mat;$i++)
                    {
                            $row_mat = pg_fetch_row($result,$i);

                            print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");
                    }

            print("</select>");

            print("<TD width=\"35\"><b>@ Tk.</b></TD>
            <TD width=\"70\"><input type=\"text\" name=\"receivetkrate\"value=\"$receivetkrate\" size=\"11\"> </TD> ");

            print("<TD width=\"90\"><B>Material Two:</B></TD>

            <TD width=\"161\">");

            print("<select size=\"1\" name=\"mattwo\">");
            print("<option value = \"$mattwo\" selected>$materialtwoname</option>\n");

            $result = pg_exec("select mattwo_id,mattwo_name from materialtwo order by mattwo_name");

            $num_mat = pg_numrows($result);

            for($i=0;$i<$num_mat;$i++)
                    {
                            $row_mat = pg_fetch_row($result,$i);

                            print("<option value = \"$row_mat[0]\" >$row_mat[1]</option>\n");

                    }

            print("</select>");




       ////  prints matone and mattwo..ends






        if ($radiotest=="sale")
                {
                        print("<TD><B>Cargo Vessel:</B></TD><TD><select size=\"1\" name=\"shipname\" onchange=\"view_pur_sale_cargo()\">");
                        print("<option value=\"$shipname\"selected>$nameofship</option>");

                        $result = pg_exec("select ship_id,ship_name from ship order by ship_name");
                        $num_cargo = pg_numrows($result);

                        for($i=0;$i<$num_cargo;$i++)
                                {
  	                                $row_cargo = pg_fetch_row($result,$i);

  	                                print("<option value = \"$row_cargo[0]\" >$row_cargo[1]</option>\n");
  	                        }
                        print("</select></TD>");

                }


     }

 ?>

 <?php

         if($radiotest!="official")
                 {


                        print("<TD width=\"35\"><b>@ Tk.</b></TD>
                        <TD width=\"70\"><input type=\"text\" name=\"receivetkratetwo\"value=\"$receivetkratetwo\" size=\"11\"> </TD> ");

                 }

 ?>

</tr>
</table>

<TABLE border="1"width="691">
<TR>

<TD width="94"><b>Receive Mode:</b></TD>

<TD width="122">  <select size="1" name="paytype">
    <option value="<?php echo $paytype ?>" selected><?php echo $paytype ?></option>
    <option>Cash</option>
    <option>Cheque</option>
  </select> </TD>

<TD width="113"> <b>Cheque No.</b></TD>
<TD width="126"><input type="text" name="chequeno" value="<?php echo $chequeno?>" size="18"></TD>
<TD width="37"><b>Bank</b> </TD>

<TD width="">
<input type="text" name="bankname"value="<?php echo $bankname?>" size="20" onchange= "document.test.bankname.value=capfirst(document.test.bankname.value)"> </TD>
</TR></TABLE>


<TABLE width="636" border=1>
<TR>


<TD width="94"> <b>Branch</b> </TD>
<TD width="122"> <input type="text" name="bankbranch" value="<?php echo $bankbranch?>" size="16" onchange= "document.test.bankbranch.value=capfirst(document.test.bankbranch.value)"> </TD>
<TD width="114"> <b>Date</b> </TD>
<TD width="278"> <input type="text" name="chequereceivedate" value="<?php echo $chequereceivedate ?>" size="16" readonly><a href="javascript:show_calendar('test.chequereceivedate');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif"  width=24 height=22 border=0></a></TD>

</TR>
</TABLE>

<?php

        if ($radiotest!="official")
                {

                        print("<TABLE width=\"586\"border=1>
                                <TR>
<TD width=\"94\"><B>Pay Location:</B></td>
<TD width=\"122\"><input type=\"text\" name=\"receivelocation\" value=\" $receivelocation\" size=15 onchange= \"document.test.receivelocation.value=capfirst(document.test.receivelocation.value)\"></TD>
<TD width=\"115\"><B>Departure Date:</B> </TD>
<TD width=\"227\"><input type=\"text\" size=\"12\" name=\"departuredate\" value=\" $departuredate \" readonly>
</TD></TR>
 </TABLE> ");

        }

?>

 <TABLE width = 586 border=1>
<TR>
<TD width=94><B>Comment:</B> </TD>

<TD width=><input type="text" name="comment"value="<?php echo $comment?>" size="60"></TD>
</TR>
</TABLE>

<br>
<INPUT TYPE="hidden" name="seenbefore" value="1">
<input type ="hidden" name="radiotest" value ="<?php echo $radiotest ?>">
<INPUT TYPE="hidden" name="filling" value="<?php echo $filling ?>">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="mreceiptid" value="<?php echo $mreceiptid  ?>">
<INPUT TYPE="hidden" name="savecancel" value="<?php echo $savecancel ?>">
<input type ="hidden" name ="shipcargo" value="<?php echo $shipcargo ?>">

<input type ="hidden" name ="shiptripid" value="<?php echo $shiptripid ?>">

<INPUT TYPE ="hidden" name ="ownername" value="<?php echo $ownername ?>">

<INPUT TYPE ="hidden" name ="balancetk" value="<?php echo $balancetk ?>">
<INPUT TYPE ="hidden" name ="shipcargo" value="<?php echo $shipcargo ?>">
<INPUT TYPE="hidden" name="setat" value="<?php echo $setat  ?>" >
<INPUT TYPE="hidden" name="add_edit_duplicate" value="<?php echo $add_edit_duplicate  ?>" >

<INPUT TYPE="hidden" name="sale_goodquantityone" value="<?php echo $sale_goodquantityone ?>">

<INPUT TYPE="hidden" name="print_comment" value="<?php echo $print_comment ?>" >

<INPUT TYPE="hidden" name="returnfromviewship" value="<?php echo $returnfromviewship ?>" >
<INPUT TYPE="hidden" name="official_voucherno" value="<?php echo $official_voucherno ?>" >

<INPUT TYPE="hidden" name="visitcarry" value="<?php echo $visitcarry  ?>" >
<INPUT TYPE="hidden" name="visitsale" value="<?php echo $visitsale  ?>" >
<INPUT TYPE="hidden" name="visitofficial" value="<?php echo $visitofficial  ?>" >
<INPUT TYPE="hidden" name="abc" value="Cash" >
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >




<div align="center"><?php button_print() ?></div>

</form>



numrows("<?php echo $numrows ?>");
    mreceiptid("<?php echo $mreceiptid ?>");
    fromloc("<?php echo $fromloc ?>");
    clientname("<?php echo $clientname ?>");
    gotocheck("<?php echo $gotocheck ?>");
    shipname("<?php echo $row[4] ?> ");
    radiotest("<?php echo $radiotest ?> ");
    paytype("<?php echo $paytype ?> ");
    button name("<?php echo $filling ?>");
    savecancel("<?php echo $savecancel ?> ");
    balancetk("<?php echo $balancetk ?> ");
    setat("<?php echo $setat ?> ");

    returnfromviewship("<?php echo $returnfromviewship ?>" );
    visitcarry("<?php echo $visitcarry ?>" );
    visitsale("<?php echo $visitsale  ?>" );
    


</body>

</html>
