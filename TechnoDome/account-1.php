<?php

        require("config.php");

        // grabs all product information
        $result = pg_exec("select * from accounts order by account_id");
        $numrows = pg_numrows($result);

        echo $numrows ;

        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $row[0]=0;
                                        $row[1]="";
                                        $accountid = 0;
                                }

                        else
                                {
                                        $row = pg_fetch_row($result,0);
                                        $accountid = $row[0];

                                }

                        //for store a number in $gotocheck for prev,next,goto...

                        if ( is_integer($gotocheck)== 0)
                                {
                                        $gotocheck = 1;
                                }


                }








        //*******************  For TOP BUTTON         **********************

        if ($filling == "topbutton")
                {
	                $result = pg_exec("select * from accounts order by account_id");
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

        if ($filling == "prevrecord")
                {
	                $result = pg_exec("select * from accounts order by account_id");

	                $numrows = pg_numrows($result);

        	        $row = pg_fetch_row($result,$gotocheck-1);

	                $accountname = $row[2];
	                $accountid = $row[0];
                        $accounttype = $row[1];
	                $officeaddress = $row[3];
	                $homeaddress = $row[4];
	                $offphone = $row[5];
	                $resphone = $row[6];
	                $mobilephone = $row[7];

                }

        /**************************** END OF PREVIOUS BUTTON  *********************/


        /************************* FOR NEXT BUTTON ****************************/

        if ($filling == "nextrecord")
                {
	                $result = pg_exec("select * from accounts order by account_id");

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

        if ($filling == "bottombutton")
                {
	                $result = pg_exec("select * from accounts order by account_id");
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



        if ($filling == "gotobutton")
                {
	                $result = pg_exec("select * from accounts order by account_id");           ////before it was "select * from accounts order by account_id"

	                $numrows=pg_numrows($result);

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



          /**************************** FOR view BUTTON  *********************/



          if ($filling == "viewbutton")
                  {
                         if ($viewcheck !=0)
                                {

                                       // echo "alert($viewcheck...we are in viewcheck)";
                                        $result = pg_exec("select * from accounts where account_id='$viewcheck'");           ////before it was "select * from accounts order by account_id"

                                        $viewnumrows=pg_numrows($result);

          	                        // $row = pg_fetch_row($result,$gotocheck-1);
                                        if ($viewnumrows !=0)
                                                {
                                                        $row = pg_fetch_row($result,0);

                                                        $accounttype = $row[1];
                                                        $accountname = $row[2];
                                                        $accountid = $row[0];
                                                        $officeaddress = $row[3];
                                                        $homeaddress = $row[4];
                                                        $offphone = $row[5];
                                                        $resphone = $row[6];
                                                        $mobilephone = $row[7];
                                                }
                                   }
                         else
                                   {
                                        $result = pg_exec("select * from accounts order by account_id");

                                        $viewnumrows=pg_numrows($result);

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




          	}



           /**************************** end of view BUTTON  *********************/




        /*******************  For ADD BUTTON         **********************/


        if ($filling == "addbutton")
                {

        		$accountname = ltrim($accountname);

                        $dupresult= pg_exec($conn,"select * from accounts where (account_name='$accountname') and (account_type='$accounttype')");
                        $dupnumrows = pg_numrows($dupresult);

                        if ($dupnumrows !=0)
                                {

                                        $add_edit_duplicate = 'true' ;
                                        $result = pg_exec("select * from accounts order by account_id");

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
                                        $accounttype = $row[1];



                                }

                        else
                                {
                                        $add_edit_duplicate = 'false' ;


		                        $result = pg_exec($conn,"insert into accounts (account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) values('$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");


                                        $pass_result = pg_exec($conn,"insert into password (account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) values('$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

                                         /********************backup start***************************/
                                         /***********************************************************/
                                          $fp = popen ("/usr/bin/PGUSER=postgres pg_dumpall > /FIRST/all.sql", "w");

                                        // $result = pg_exec("select * into /FIRST/accounts from accounts order by account_id");



                                      /* $Id: db_dump.php,v 1.20 2002/06/27 18:16:23 killroyboy Exp $ */

                            /*          $asfile  = "sendit";

                                      $crlf="\n";
                                      if (empty($asfile)) {
                                      	include("header.inc.php");
                                      	print "<div align=left><pre>\n";
                                      } else {
                                      	include("lib.inc.php");
                                      	header("Content-disposition: attachment; filename=\"$db.sql\"");
                                      	header("Content-type: application/octetstream");
                                      	header("Pragma: no-cache");
                                      	header("Expires: 0");

                                      	// doing some DOS-CRLF magic...
                                      	$client=getenv("HTTP_USER_AGENT");
                                      	if (ereg('[^(]*\((.*)\)[^)]*',$client,$regs)) {
                                      		$os = $regs[1];
                                      		// this looks better under WinX
                                      		if (eregi("Win",$os)) $crlf="\r\n";
                                      	}
                                      }

                                      function my_handler($sql_insert) {
                                      	global $crlf, $asfile;
                                      	if (empty($asfile)) {
                                      		echo htmlspecialchars("$sql_insert;$crlf");
                                      	} else {
                                      		echo "$sql_insert;$crlf";
                                      	}
                                      }

                                      print "$crlf/* -------------------------------------------------------- $crlf";
                                      print "  $cfgProgName $cfgVersion DB Dump$crlf";
                                      print "  http://sourceforge.net/projects/phppgadmin/$crlf";
                                      print "  $strHost: " . $cfgServer['host'];

                                      if (!empty($cfgServer['port'])) {
                                      	print ":" . $cfgServer['port'];
                                      }
                                      print "$crlf  $strDatabase : $cfgQuotes$db$cfgQuotes$crlf";
                                      print "  " . date("Y-m-d H:m:i") . $crlf;
                                      print "-------------------------------------------------------- */ //$crlf";
                              /*
                                      $get_seq_sql = "
                                      	SELECT relname
                                      	FROM pg_class
                                      	WHERE
                                      		NOT relname ~ 'pg_.*'
                                      		AND relkind ='S'
                                      	ORDER BY relname
                                      	";

                                      $seq = @pg_exec($link, pre_query($get_seq_sql));
                                      if (!$num_seq = @pg_numrows($seq)) {
                                      	print "/* $strNo $strSequences $strFound ";
                                      } else {
                                      	print "$crlf/* -------------------------------------------------------- $crlf";
                                      	print "  $strSequences $crlf";
                                      	print "--------------------------------------------------------  $crlf";

                                      	while ($i_seq < $num_seq) {
                                      		$sequence = @pg_result($seq, $i_seq, "relname");

                                      		$sql_get_props = "SELECT * FROM $cfgQuotes$sequence$cfgQuotes";
                                      		$seq_props = @pg_exec($link, pre_query($sql_get_props));
                                      		if (@pg_numrows($seq_props)) {
                                      			$row = @pg_fetch_array($seq_props, 0);
                                      			if ($what != "data") {
                                      				$row[last_value] = 1;
                                      			}
                                      			if ($drop) print "DROP SEQUENCE $cfgQuotes$sequence$cfgQuotes;$crlf";
                                      			print "CREATE SEQUENCE $cfgQuotes$sequence$cfgQuotes START $row[last_value] INCREMENT $row[increment_by] MAXVALUE $row[max_value] MINVALUE $row[min_value] CACHE $row[cache_value]; $crlf";
                                      		}
                                      		if (($row[last_value] > 1) && ($what == "data")) {
                                      			print "SELECT NEXTVAL('$sequence'); $crlf";
                                      			unset($row[last_value]);
                                      		}
                                      		$i_seq++;
                                      	}
                                      }

                                      $tables = @pg_exec($link, "SELECT tablename FROM pg_tables WHERE tablename !~ 'pg_.*' ORDER BY tablename");

                                      $num_tables = @pg_numrows($tables);
                                      if (!$num_tables) {
                                      	echo $strNoTablesFound;
                                      } else {

                                      	for ($i = 0; $i < $num_tables; $i++) {
                                      		$table = pg_result($tables, $i, "tablename");

                                      		print "$crlf/* -------------------------------------------------------- $crlf";
                                      		print "  $strTableStructure $cfgQuotes$table$cfgQuotes $crlf";
                                      		print "-------------------------------------------------------- ";

                                      		echo $crlf;
                                      		if ($drop) print "DROP TABLE $cfgQuotes$table$cfgQuotes;$crlf";
                                      		if (!$asfile) {
                                      			echo htmlentities(get_table_def($link, $table, $crlf));
                                      		} else {
                                      			echo get_table_def($link, $table, $crlf);
                                      		}
                                      		echo $crlf;

                                      		if ($what == "data") {

                                      			print "$crlf/* -------------------------------------------------------- $crlf";
                                      			print "  $strDumpingData $cfgQuotes$table$cfgQuotes $crlf";
                                      			print "--------------------------------------------------------  $crlf";

                                      			get_table_content($link, $table, "my_handler");
                                      		}
                                      	}
                                      }

                                      // tablename !~ 'pg_.*'
                                      $sql_get_views = "SELECT * FROM pg_views WHERE viewname !~ 'pg_.*'";

                                      $views = @pg_exec($link, pre_query($sql_get_views));
                                      if (!$num_views = @pg_numrows($views)) {
                                      	print "$crlf/* $strNo $strViews $strFound $crlf";
                                      } else {
                                      	print "$crlf/* -------------------------------------------------------- $crlf";
                                      	print "  $strViews $crlf";
                                      	print "--------------------------------------------------------  $crlf";

                                      	for ($i_views = 0; $i_views < $num_views; $i_views++) {
                                      		$view = pg_fetch_array($views, $i_views);
                                      		if ($drop) print "DROP VIEW $cfgQuotes$view[viewname]$cfgQuotes;$crlf";
                                      		print "CREATE VIEW $cfgQuotes$view[viewname]$cfgQuotes AS $view[definition] $crlf";
                                      	}
                                      }

                                      // Output functions

                                      // Max built-in oidi
                                      //$sql_get_max = "SELECT oid FROM pg_database WHERE datname = 'template1'";
                                      //$maxes = pg_exec($link, $sql_get_max);
                                      //$max = pg_result($maxes, 0, "oid");
                                      //$max = $row[datlastsysoid];
                                      //$max = 16384;

                                      $max = $builtin_max;

                                      // Skips system functions

                                      if ($common_ver < 7.1)
                                      {
                                      	$sql_get_funcs = "
                                      	SELECT
                                      		pc.oid,
                                      		proname,
                                      		lanname as language,
                                      		t.typname as return_type,
                                      		prosrc as source,
                                      		probin as binary,
                                      		oidvectortypes(pc.proargtypes) AS arguments
                                      	FROM
                                      		pg_proc pc, pg_language pl, pg_type t
                                      	WHERE
                                      		pc.oid > '$max'::oid
                                      		AND pc.prolang = pl.oid
                                      	";
                                      }

                                      else
                                      {
                                      	$sql_get_funcs = "
                                      	SELECT
                                      		pc.oid,
                                      		proname,
                                      		lanname as language,
                                      		format_type(prorettype, NULL) as return_type,
                                      		prosrc as source,
                                      		probin as binary,
                                      		oidvectortypes(pc.proargtypes) AS arguments
                                      	FROM
                                      		pg_proc pc, pg_language pl
                                      	WHERE
                                      		pc.oid > '$max'::oid
                                      		AND pc.prolang = pl.oid
                                      	";
                                      }

                                      print $crlf;

                                      $funcs = pg_exec($link, pre_query($sql_get_funcs)) or pg_die(pg_errormessage(), $sql_get_funcs, __FILE__, __LINE__);

                                      if (!$num_funcs = pg_numrows($funcs)) {
                                      	print "/* $strNo $strFuncs $strFound $crlf";
                                      } else {
                                      	print "$crlf/* -------------------------------------------------------- $crlf";
                                      	print "  $strFuncs $crlf";
                                      	print "--------------------------------------------------------  $crlf";

                                      	for ($i_funcs = 0; $i_funcs < $num_funcs; $i_funcs++) {
                                      		$func_info = @pg_fetch_array($funcs, $i_funcs);

                                      		if ($common_ver < 7.1) {
                                      			$strArgList = ereg_replace(" ", ", ", $func_info[arguments]);
                                      		} else {
                                      			$strArgList = $func_info[arguments];
                                      		}

                                      		if ($func_info[binary] != "-") {
                                      			$strBin = "'$func_info[binary]',";
                                      		} else {
                                      			unset($strBin);
                                      		}

                                      		if ($func_info[return_type] == "-") {
                                      			$func_info[return_type] = "OPAQUE";
                                      		}
                                      		if ($drop) print "DROP FUNCTION $cfgQuotes$func_info[proname]$cfgQuotes($strArgList);$crlf";
                                      		echo "CREATE FUNCTION $cfgQuotes$func_info[proname]$cfgQuotes($strArgList) RETURNS $func_info[return_type] AS $strBin'$func_info[source]' LANGUAGE '$func_info[language]'; $crlf";
                                      	}
                                      }

                                      // Output triggers

                                      // Some definitions
                                      $TRIGGER_TYPE_ROW			=	(1 << 0);
                                      $TRIGGER_TYPE_BEFORE		=	(1 << 1);
                                      $TRIGGER_TYPE_INSERT		=	(1 << 2);
                                      $TRIGGER_TYPE_DELETE		=	(1 << 3);
                                      $TRIGGER_TYPE_UPDATE		=	(1 << 4);

                                      $sql_get_triggers = "
                                      	SELECT
                                      		pt.*, pp.proname, pc.relname
                                      	FROM
                                      		pg_trigger pt, pg_proc pp, pg_class pc
                                      	WHERE
                                      		pp.oid=pt.tgfoid
                                      		and pt.tgrelid=pc.oid
                                      		and relname !~ '^pg_'
                                      ";

                                      $triggers = @pg_exec($link, pre_query($sql_get_triggers));
                                      if (!$num_triggers = @pg_numrows($triggers)) {
                                      	print "$crlf/* $strNo $strTriggers $strFound $crlf";
                                      } else {
                                      	print "$crlf/* -------------------------------------------------------- $crlf";
                                      	print "  $strTriggers $crlf";
                                      	print "--------------------------------------------------------  $crlf";

                                      	for ($i_triggers = 0; $i_triggers < $num_triggers; $i_triggers++) {
                                      		$trigger = pg_fetch_array($triggers, $i_triggers);
                                      		// Constraint or not
                                      		if ($trigger[tgisconstraint] == 't')
                                      			print "CREATE CONSTRAINT TRIGGER";
                                      		else
                                      			print "CREATE TRIGGER";
                                      		// Name
                                      		print " $cfgQuotes$trigger[tgname]$cfgQuotes";

                                      		// before/after
                                      		if ($trigger[tgtype] & $TRIGGER_TYPE_BEFORE)
                                      			print " BEFORE";
                                      		else
                                      			print " AFTER";

                                      		// Insert
                                      		$findx = 0;
                                      		if ($trigger[tgtype] & $TRIGGER_TYPE_INSERT) {
                                      			print " INSERT";
                                      			$findx++;
                                      		}

                                      		// Delete
                                      		if ($trigger[tgtype] & $TRIGGER_TYPE_DELETE) {
                                      			if ($findx > 0)
                                      				print " OR DELETE";
                                      			else
                                      				print " DELETE";
                                      			$findx++;
                                      		}

                                      		// Update
                                      		if ($trigger[tgtype] & $TRIGGER_TYPE_UPDATE) {
                                      			if ($findx > 0)
                                      				print " OR UPDATE";
                                      			else
                                      				print " UPDATE";
                                      		}

                                      		// On
                                      		print " ON $cfgQuotes$trigger[relname]$cfgQuotes";

                                      		// Contraints, deferrable
                                      		if ($trigger[tgisconstraint] == 't') {
                                      			if ($trigger[tgdeferrable] == 'f') print " NOT";
                                      			print " DEFERRABLE INITIALLY ";

                                      			if ($trigger[tginitdeferred] == 't')
                                      				print "DEFERRED";
                                      			else
                                      				print "IMMEDIATE";
                                      		}
                                      		echo " FOR EACH ROW";
                                      		echo " EXECUTE PROCEDURE $cfgQuotes$trigger[proname]$cfgQuotes ('";

                                      		// Strip of trailing delimiter
                                      		$tgargs = trim(substr($trigger[tgargs], 0, strlen($trigger[tgargs]) - 4));
                                      		$params = explode('\000', $tgargs);

                                      		for ($i = 0; $i < sizeof($params); $i++) {
                                      			$params[$i] = str_replace("'", "\\'", $params[$i]);
                                      		}
                                      		$params = implode("', '", $params);
                                      		if ($asfile) {
                                      			echo htmlspecialchars($params), "');$crlf";
                                      		} else {
                                      			echo $params, "');$crlf";
                                      		}
                                      	}
                                      }

                                      if(empty($asfile)) {
                                      	print "</pre></div>\n";
                                      	include ("footer.inc.php");
                                      }


















                                         /************************backup ends**************************/


                                        $result = pg_exec("select * from accounts order by account_id");
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

                                        $gotocheck = $numrows;

                                }


                }



        /**************************** FOR EDIT BUTTON  *********************/


        if ($filling == "editbutton")
                {

	                $result = pg_exec("select * from accounts order by account_id");

	                $numrows=pg_numrows($result);
                        $accountname = ltrim($accountname);
                        $accounttype = ltrim($accounttype);

                        $dupresult= pg_exec($conn,"select * from accounts where account_name='$accountname' and account_type='$accounttype' ");
                        $dupnumrows = pg_numrows($dupresult);

                        if($dupnumrows!=0)
                                {
                                        echo "alert($dupnumrows)";
                                        $duprow = pg_fetch_row($dupresult,0);
                                        if ($dupnumrows !=0 && $duprow[0] != $accountid)
                                                {

                                                        $add_edit_duplicate = 'true' ;
                                                        $result = pg_exec("select * from accounts order by account_id");

                                                        $numrows=pg_numrows($result);
                                                        $numfields = pg_numfields($result);

                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                        $accountid = $row[0];
                                                        $accounttype = $row[1];
                                                        $accountname = ltrim(trim($row[2]));
                                                        $officeaddress = $row[3];
                                                        $homeaddress = $row[4];
                                                        $offphone = $row[5];
                                                        $resphone = $row[6];
                                                        $mobilephone = $row[7];

                                                }
                                        else

                                                {
                                                        $add_edit_duplicate = 'false' ;

                                                        $result = pg_exec($conn,"DELETE FROM accounts WHERE (account_id = '$accountid');INSERT INTO accounts (account_id,account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) VALUES('$accountid','$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

                                                        $pass_result = pg_exec($conn,"DELETE FROM password WHERE (account_id = '$accountid');INSERT INTO password (account_id,account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) VALUES('$accountid','$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

                                                        $result = pg_exec("select * from accounts order by account_id");

                                                        $numrows=pg_numrows($result);

                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                        $accountid = $row[0];
                                                        $accounttype = $row[1];
                                                        $accountname =  ltrim(trim($row[2]));
                                                        $officeaddress = $row[3];
                                                        $homeaddress = $row[4];
                                                        $offphone = $row[5];
                                                        $resphone = $row[6];
                                                        $mobilephone = $row[7];

                                                }


                                }

                        else
                                {
                                        $add_edit_duplicate = 'false' ;

	                                $result = pg_exec($conn,"DELETE FROM accounts WHERE (account_id = '$accountid');INSERT INTO accounts (account_id,account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) VALUES('$accountid','$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

                                        $pass_result = pg_exec($conn,"DELETE FROM password WHERE (account_id = '$accountid');INSERT INTO password (account_id,account_name,account_type,office_address,home_address,off_phone,res_phone,mobile_phone) VALUES('$accountid','$accountname','$accounttype','$officeaddress','$homeaddress','$offphone','$resphone','$mobilephone')");

        	                        $result = pg_exec("select * from accounts order by account_id");

	                                $numrows=pg_numrows($result);



	                                $row = pg_fetch_row($result,$gotocheck-1);
	                                $accountid = $row[0];
                                        $accounttype = $row[1];
	                                $accountname =  ltrim(trim($row[2]));
	                                $officeaddress = $row[3];
	                                $homeaddress = $row[4];
	                                $offphone = $row[5];
	                                $resphone = $row[6];
	                                $mobilephone = $row[7];

                                }


                }




        /**************************** FOR DELETE BUTTON  *********************/

        if ($filling == "deletebutton")
                {

		        $result = pg_exec("select * from accounts order by account_id");

		        $numrows=pg_numrows($result);

		        $result = pg_exec($conn,"DELETE  FROM accounts WHERE (account_id = '$accountid')");


		        $result = pg_exec("select * from accounts order by account_id");

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
	                $accountid = $row[0];
	                $accountname = $row[2];
	                $officeaddress = $row[3];
	                $homeaddress = $row[4];
	                $offphone = $row[5];
	                $resphone = $row[6];
	                $mobilephone = $row[7];

                }



?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>New Account Entry Form</title>



<script type='text/javascript' src='awjsmenu10trial.js'></script>
<script type='text/javascript'>
AWJSMENU_B("awmenu10",4,"#F3A30C","#F7D05B","#0000FF",1,"#FF0000","#808080",1,"arial",9,0,0,1,1,1,0,0,0,0,0,70,14,"arrow_down.gif","arrow_right.gif",1,500,"","","");
awmenu101= new Array("Daily Entry","","",4,20,100);
awmenu101_1= new Array("Payment Voucher","","",0,20,100);
awmenu101_2= new Array("Money Receipt","","",0,20,100);
awmenu101_3= new Array("Cargo Schedule","","",0,20,100);
awmenu101_4= new Array("Adjustment","","",0,20,100);
awmenu102= new Array("Fixed Entry","","",4,20,100);
awmenu102_1= new Array("Account Entry","account.php","",0,20,100);
awmenu102_2= new Array("Ship Entry","","",0,20,100);
awmenu102_3= new Array("Location Entry","location.php","",0,20,100);
awmenu102_4= new Array("Material Entry","material.php","",0,20,100);
awmenu103= new Array("Reort","report.php","",0,20,100);
awmenu104= new Array("Back to home","software-home.html","",0,20,100);
</script>







</head>

<script language= javascript>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?> ;


var gotocheck = Number("<?php echo $gotocheck ?>");


var add_edit_duplicate = "<?php  echo $add_edit_duplicate ?>";


function setattribute()
        {
                if (document.test.add_edit_duplicate.value=='true')
                        {
                                alert("Duplicate Record Found");
                                document.test.accounttype.disabled=false;
                                document.test.add_edit_duplicate.value='false';

                                button_option("pressed");

                        }

                else
                        {

                                document.test.accounttype.disabled=true;
                                document.test.accountname.disabled=true;
                                document.test.officeaddress.disabled=true;
                                document.test.homeaddress.disabled=true;
                                document.test.offphone.disabled=true;
                                document.test.resphone.disabled=true;
                                document.test.mobilephone.disabled=true;
                                document.test.savebutton.disabled=true;
                                document.test.cancelbutton.disabled=true;

                                window.status = document.test.gotocheck.value+"/"+ numrows
                        }

        }



function form_validator(theForm)
        {


	        if(theForm.accountname.value == "")
                        {
		                alert("<?php echo $txt_missing_accountname ?>");
		                theForm.accountname.focus();
		                return(false);
	                }





                 if(capfirst(theForm.officeaddress.value) == "" && capfirst(theForm.homeaddress.value) == "")
                        {
		                alert("Please enter at least one Address!");
                                theForm.officeaddress.select();
		                theForm.officeaddress.focus();
		                return(false);
		        }

		 if(capfirst(theForm.offphone.value) == "" && capfirst(theForm.resphone.value) == "" && capfirst(theForm.mobilephone.value) == "")
                        {
		                 alert("Please enter at least one phone number!");
                                 theForm.offphone.select();
		                 theForm.offphone.focus();
		                 return(false);
		        }




                return (true);

        }





function add_edit_press(endis)
        {
                if (endis=='addedit')
                        {
                                document.test.accounttype.disabled=false;
                                document.test.accountname.disabled=false;
                                document.test.accountname.select();
                                document.test.officeaddress.disabled=false;
                                document.test.homeaddress.disabled=false;
                                document.test.offphone.disabled=false;
                                document.test.resphone.disabled=false;
                                document.test.mobilephone.disabled=false;

                                button_option("pressed");

                        }

                else
	                {
                                document.test.accounttype.disabled=true;
                                document.test.accountname.disabled=true;
                                document.test.officeaddress.disabled=true;
                                document.test.homeaddress.disabled=true;
                                document.test.offphone.disabled=true;
                                document.test.resphone.disabled=true;
                                document.test.mobilephone.disabled=true;

                                button_option("normal");

                	}

        }



function view_record()
        {
                <?php
                        //$button_check = $gotocheck - 1;
                        if ($gotocheck>1)
                                {
                                        $button_check = $gotocheck - 1;
                                }
                        else
                                {
                                        $button_check=0;
                                }


                print("window.open (\"view_account.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$accountid\",\"view\",\"toolbar=no,scrollbars=yes\")")?>;
        }


function print_record()
        {


                var abc = "print_payment.php?gotocheck="+String(document.test.gotocheck.value);


                window.open (abc,"Print/Preview","toolbar=no,scrollbars=yes");

        }


                ///////////////////////area for control tabs///////////////////////////

function blockA(e)
        {
                  var keyChar = String.fromCharCode(e.which);
                //  var charsymbol = e.charCodeAt();

                if (e.which == 0)
                        {
                                document.test.elements[2].select();}

                // else
                // return false;
                        }

function tabcontrol()
        {

                var tabval = document.test.tabindex  ;
                document.captureEvents(Event.KEYPRESS);
                document.onkeypress = blockA;

        }



/////////////////////tab control ends here///////////////////////////////////////



</script>

<script language= javascript src= "all_jscript_function.js"> </script>



<body bgcolor="#000000">
<!-- PLEASE INSERT THESE CODES BETWEEN <BODY> ... </BODY> TAGS! -->
<!-- START Javascript Menu Builder 1.0 config parameters. Don't modify these codes by yourself -->
<script>function AWJSMENU(){return}
</script>
<noscript>Your browser does not support Javascript!</noscript>
<!-- END Javascript Menu Builder 1.0 config parameters -->
<!-- PLEASE INSERT THESE CODES BETWEEN <BODY> ... </BODY> TAGS! -->








</body>
</HTML>
