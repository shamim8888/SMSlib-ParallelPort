<?php

        require("config.php");
        //require("new_account_entry_form_experiment.php");


        // grabs all product information
        $result = pg_exec("select * from locationfrom order by from_id");
        $numrows = pg_numrows($result);

        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $row[0]=0;
                                        $row[1]="";
                                        $fromid = 0;
                                }

                        else
                                {
                                        $row = pg_fetch_row($result,0);
                                        $fromid = $row[0];

                                }

                        //for store a number in $gotocheck for prev,next,g

                        if ( is_integer($gotocheck)== 0)
                                {
                                        $gotocheck = 1;
                                }


                }



//*******************  For TOP BUTTON         **********************

if ($filling == "topbutton"){
	$result = pg_exec("select * from locationfrom order by from_id");
	$numrows=pg_numrows($result);
	$row = pg_fetch_row($result,0);
	$fromid = $row[0];
	$locname = $row[1];
	
	}


/******************** End OF TOP BUTTON  ***************************/

/******************** FOR PREVIOUS BUTTON  **********************************/

if ($filling == "prevrecord"){
	$result = pg_exec("select * from locationfrom order by from_id");
	
	$numrows = pg_numrows($result);
	$numfields = pg_numfields($result);

	$row = pg_fetch_row($result,$gotocheck-1); 
	
	$fromid = $row[0];
	$locname = $row[1];
	
	}

/**************************** END OF PREVIOUS BUTTON  *********************/


/************************* FOR NEXT BUTTON ****************************/

if ($filling == "nextrecord"){
	$result = pg_exec("select * from locationfrom order by from_id");
	
	$numrows=pg_numrows($result);
	$numfields = pg_numfields($result);

	$row = pg_fetch_row($result,$gotocheck-1); 
	$fromid = $row[0];
	
	$locname = $row[1];
	
	}

/**************************** END OF NEXT BUTTON  *********************/




/**************************** FOR BOTTOM BUTTON  *********************/

if ($filling == "bottombutton"){
	$result = pg_exec("select * from locationfrom order by from_id");
	$numrows=pg_numrows($result);
	$numfields = pg_numfields($result);
	$row = pg_fetch_row($result,($numrows-1)); 
	$fromid = $row[0];
	
	$locname = $row[1];
	
	}


/**************************** FOR GOTO BUTTON  *********************/



if ($filling == "gotobutton"){
	$result = pg_exec("select * from locationfrom order by from_id");
	
	$numrows=pg_numrows($result);
	$numfields = pg_numfields($result);

	$row = pg_fetch_row($result,$gotocheck-1); 
	
	$fromid = $row[0];
	$locname = $row[1];
	
	
	}



/*******************  For ADD BUTTON         **********************/


if ($filling == "addbutton"){

		$locname = ltrim($locname);
		$result = pg_exec($conn,"insert into locationfrom (from_loc) values('$locname')");
		$result = pg_exec($conn,"insert into locationto (to_loc) values('$locname')");

		$result = pg_exec("select * from locationfrom order by from_id");
	$numrows=pg_numrows($result);
	$numfields = pg_numfields($result);
	$row = pg_fetch_row($result,($numrows-1)); 
	$fromid = $row[0];
	
	$locname = $row[1];
		

}



/**************************** FOR EDIT BUTTON  *********************/


if ($filling == "editbutton"){


	$result = pg_exec("select * from locationfrom order by from_id");

	$numrows=pg_numrows($result);
        $locname = ltrim($locname);
        $dupresult= pg_exec($conn,"select * from locationfrom where from_loc = '$locname' ");
        $dupnumrows = pg_numrows($dupresult);
        $duprow = pg_fetch_row($dupresult,0);
        if ($dupnumrows !=0 && $duprow[0] != $fromid)
                {

                                         //print("javascript:alert(\"Duplicate material Name\")");

                                        $add_edit_duplicate = 'true' ;
                                        $result = pg_exec("select * from locationfrom order by from_id");

                                        $numrows=pg_numrows($result);
                                        $numfields = pg_numfields($result);

                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $fromid = $row[0];

                                        $locname = ltrim(trim($row[2]));


                }
         else
                {
                $add_edit_duplicate = 'false' ;

	$result = pg_exec($conn,"DELETE FROM locationfrom WHERE (from_id = '$fromid');INSERT INTO locationfrom (from_id,from_loc) VALUES('$fromid','$locname')");

	$result = pg_exec($conn,"DELETE FROM locationto WHERE (to_id = '$fromid');INSERT INTO locationto (to_id,to_loc) VALUES('$fromid','$locname')");


	
	$result = pg_exec("select * from locationfrom order by from_id");
	
		$numrows=pg_numrows($result);
		
		

	$row = pg_fetch_row($result,$gotocheck-1); 
	$fromid = $row[0];
	$locname = $row[1];
	
	}

}



/**************************** FOR DELETE BUTTON  *********************/

if ($filling == "deletebutton"){
		//$fromid=63;
		$result = pg_exec("select * from locationfrom order by from_id");
	
		$numrows=pg_numrows($result);

		//$conn = pg_connect("host=$host dbname=$database user=$user" );
		$result = pg_exec($conn,"DELETE  FROM locationfrom WHERE (from_id = '$fromid')"); 
		$result = pg_exec($conn,"DELETE  FROM locationto WHERE (to_id = '$fromid')"); 


		$result = pg_exec("select * from locationfrom order by from_id");
	
		$numrows=pg_numrows($result);
		
		if ($gotocheck < $numrows)  {
        		//$gotocheck = ($gotocheck+1);

			}
		else 
			{$gotocheck = ($gotocheck-1);
			}

	$row = pg_fetch_row($result,$gotocheck-1); 
	$fromid = $row[0];
	$locname = $row[1];
	
		
}



?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>New Account Entry Form</title>

</head>

<script language= javascript>

// the variable holds the value of $numrows
var numrows = <?php echo $numrows ?>;
 var gotocheck = <?php echo $gotocheck ?>;

function setattribute()
        {
                if (document.test.add_edit_duplicate.value=='true')
                        {
                                alert("Duplicate Record Found");
                                document.test.add_edit_duplicate.value='false';

                                button_option("pressed");

                        }

                else

                        {
                                document.test.locname.disabled=true;
                                document.test.savebutton.disabled=true;
                                document.test.cancelbutton.disabled=true;

                                if (document.test.fromid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");
                                        }


                                window.status = document.test.gotocheck.value+"/"+ numrows
                        }


        }




function form_validator(theForm)
        {

	        if(theForm.locname.value == "") {
		alert("<?php echo $txt_missing_locname ?>");
		theForm.locname.focus();
		return(false);
	}
	

	
		
	
	//add_edit_press();
	return (true);
}



function add_edit_press(endis)
        {
                if (endis=='addedit')
                        {
                                document.test.locname.disabled=false;

                                button_option("pressed");

                        }

                else
	                {
                                document.test.locname.disabled=true;

                                if (document.test.shipid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");

                                        }


                	}

        }






function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_location.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$fromid\",\"view\",\"toolbar=no,scrollbars=yes\")")?>;

        }



</script>

<script language= javascript src= "all_jscript_function.js"> </script>

<body background= "wallpapers/Chicken-Songs-2.jpg" onload= "setattribute()">
<p align="center"><font size="5"><b><u><font color="yellow">New Location Entry Form</font></u></b></font></p>
<p></p><br><br><br>
<form name= "test" onsubmit = "return form_validator(this)" onreset = "add_edit_press()" method=post action="location.php" > <b>
<p><div align="center"><b><font color="yellow">Enter Location Name:</font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="locname" value =" <?php echo $row[1]  ?>" size="57" onchange = "document.test.locname.value=capfirst(document.test.locname.value)"></div></p>



<INPUT TYPE="hidden" name="seenbefore" value="1">
<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="fromid" value="<?php echo $fromid  ?>">

<INPUT TYPE="hidden" name="add_edit_duplicate" value="<?php echo $add_edit_duplicate  ?>" >
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >

<BR><br>

  <div align="center"><?php button_print() ?></div>


</form>


<!--numrows("<?php echo $numrows ?>");
    fromid("<?php echo $fromid ?>");
    gotocheck("<?php echo $gotocheck ?>");
    nameprompt("<?php echo $filling ?> ");
    view_check("<?php echo $abc ?> ");
    -->

</body>

</html>
