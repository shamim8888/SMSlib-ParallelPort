<?php

        require("config.php");

        // grabs all product information
        $result = pg_exec("select * from materialone order by matone_id");
        $numrows = pg_numrows($result);
        /*$row = pg_fetch_row($result,0);*/

        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $row[0]=0;
                                        $row[1]="";
                                        $matid = 0;
                                }

                        else
                                {
                                        $row = pg_fetch_row($result,0);
                                        $matid = $row[0];

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
	                $result = pg_exec("select * from materialone order by matone_id");
	                $numrows=pg_numrows($result);
	                $row = pg_fetch_row($result,0);
	                $matid = $row[0];
	                $matname = $row[1];

	        }


        /******************** End OF TOP BUTTON  ***************************/

        /******************** FOR PREVIOUS BUTTON  **********************************/

        if ($filling == "prevrecord")
                {
	                $result = pg_exec("select * from materialone order by matone_id");

	                $numrows = pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

	                $matid = $row[0];
	                $matname = $row[1];

	        }


        /**************************** END OF PREVIOUS BUTTON  *********************/


        /************************* FOR NEXT BUTTON ****************************/

        if ($filling == "nextrecord")
                {
	                $result = pg_exec("select * from materialone order by matone_id");

	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);
	                $matid = $row[0];

	                $matname = $row[1];

	        }


        /**************************** END OF NEXT BUTTON  *********************/




        /**************************** FOR BOTTOM BUTTON  *********************/

        if ($filling == "bottombutton")
                {
	                $result = pg_exec("select * from materialone order by matone_id");
	                $numrows=pg_numrows($result);
	                $row = pg_fetch_row($result,($numrows-1));
	                $matid = $row[0];

                	$matname = $row[1];

	        }


        /**************************** FOR GOTO BUTTON  *********************/



        if ($filling == "gotobutton")
                {
	                $result = pg_exec("select * from materialone order by matone_id");

	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

	                $matid = $row[0];
	                $matname = $row[1];


	        }



        /*******************  For ADD BUTTON         **********************/


        if ($filling == "addbutton")
                {
		        $matname1 = strtolower(ltrim(rtrim($matname)));

                        $dupresult= pg_exec($conn,"select * from materialone where (matone_name='$matname')");
                        $dupnumrows = pg_numrows($dupresult);
                        if ($dupnumrows !=0)
                                {

                                        $add_edit_duplicate = 'true' ;
                                        $result = pg_exec("select * from materialone order by matone_id");

                                        $numrows=pg_numrows($result);

                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $matid = $row[0];
                                        $matname = $row[1];


                                }

                        else
                                {
                                        $add_edit_duplicate = 'false' ;

		                        $result = pg_exec($conn,"insert into materialone (matone_name) values('$matname')");
                                        $result = pg_exec($conn,"insert into materialtwo (mattwo_name) values('$matname')");
		                        $result = pg_exec("select * from materialone order by matone_id");

                                        $numrows=pg_numrows($result);
	                                $row = pg_fetch_row($result,($numrows-1));

                                        $matid = $row[0];
	                                $matname = $row[1];

                                        $gotocheck = $numrows;

                                }

                }



        /**************************** FOR EDIT BUTTON  *********************/


        if ($filling == "editbutton")
                {

	                $result = pg_exec("select * from materialone order by matone_id");

	                $numrows=pg_numrows($result);

                        $dupresult= pg_exec($conn,"select * from materialone where (matone_name='$matname')");
                        $dupnumrows = pg_numrows($dupresult);

                        if ($dupnumrows !=0)
                                {
                                        //print("javascript:alert(\"Duplicate material Name\")");

                                        $add_edit_duplicate = 'true' ;
                                        $result = pg_exec("select * from materialone order by matone_id");

                                        $numrows=pg_numrows($result);

                                        $row = pg_fetch_row($result,$gotocheck-1);

                                        $matid = $row[0];
                                        $matname = $row[1];


                                }
                        else
                                {
                                        $add_edit_duplicate = 'false' ;


	                                $result = pg_exec($conn,"DELETE FROM materialone WHERE (matone_id = '$matid');INSERT INTO materialone (matone_id,matone_name) VALUES('$matid','$matname')");
                                        $result = pg_exec($conn,"DELETE FROM materialtwo WHERE (mattwo_id = '$matid');INSERT INTO materialtwo (mattwo_id,mattwo_name) VALUES('$matid','$matname')");


	                                $result = pg_exec("select * from materialone order by matone_id");

		                        $numrows=pg_numrows($result);

	                                $row = pg_fetch_row($result,$gotocheck-1);
	                                $matid = $row[0];
	                                $matname = $row[1];

                                }


                }



        /**************************** FOR DELETE BUTTON  *********************/

        if ($filling == "deletebutton")
                {
		        //$matid=63;
		        $result = pg_exec("select * from materialone order by matone_id");

		        $numrows=pg_numrows($result);

		        $result = pg_exec($conn,"DELETE  FROM materialone WHERE (matone_id = '$matid')");

                        $result = pg_exec($conn,"DELETE  FROM materialtwo WHERE (mattwo_id = '$matid')");

		        $result = pg_exec("select * from materialone order by matone_id");

		        $numrows=pg_numrows($result);

		        if ($gotocheck <= $numrows)
                                {
        		                //$gotocheck = ($gotocheck+1);

			        }
		        else
			        {
                                        $gotocheck = ($gotocheck-1);
			        }

                        if ($numrows !=0)
                                {
	                                $row = pg_fetch_row($result,$gotocheck-1);
	                                $matid = $row[0];
	                                $matname = $row[1];

	                        }
                        else
                                {
                                        $matid =0;
                                        $matname="";
                                }


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

var add_edit_duplicate = <?php echo $add_edit_duplicate ?>;




function setattribute()
        {
                if (document.test.add_edit_duplicate.value=='true')
                        {
                                alert("Duplicate Record Found");

                                document.test.add_edit_duplicate.value = 'false';

                                button_option("pressed");

                        }


                else
                        {
                                document.test.matname.disabled=true;

                                if (document.test.matid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");
                                        }

                                window.status = document.test.gotocheck.value+"/"+ numrows

                        } //for duplicate else bracket

        }




function form_validator(theForm)
        {

        	if(theForm.matname.value == "")
                        {
        		        alert("<?php echo $txt_missing_matname ?>");
                                theForm.matname.select();
        		        theForm.matname.focus();
        		        return(false);
        	        }

	        return (true);
        }




function add_edit_press(endis)
        {
                if (endis=='addedit')
                        {
                                document.test.matname.disabled=false;
                                document.test.matname.select();
                                document.test.matname.focus();

                                button_option("pressed");

                        }

                else
	                {
                                document.test.matname.disabled=true;

                                if (document.test.matid.value ==0)
                                        {
                                                button_option("norecord");

                                        }

                                else
                                        {
                                                button_option("normal");

                                        }


	                }


        }



function del_confirm()
        {
                var agree = confirm ("Are You Sure to delete the Record?", "");

                if (agree==true)
                        {
		                document.test.filling.value = "deletebutton";
	                        document.test.submit();
	                }
        }



function view_record()
        {
                <?php
                        if ($gotocheck>1)
                                {
                                        $button_check = $gotocheck - 1;
                                }

                        else
                                {
                                        $button_check=0;
                                }


                        print("window.open (\"view_material.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$matid\",\"view\",\"toolbar=no,scrollbars=yes\")");
                ?>

        }




</script>

<script language= javascript src= "all_jscript_function.js"> </script>

<body bgcolor="#0142aa" onload= "setattribute()">
<p align="center"><font size="5"><b><u><font color="cyan">New Material Entry Form</font></u></b></font></p>
<p></p><br><br><br>
<form name= "test" onsubmit = "return form_validator(this)" onreset = "add_edit_press()" method=post action="material.php" > <b>

<div align="center"><table border=3>
<tr>
<p>
<td><b><font color="cyan">Enter Material Name:</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="matname" value ="<?php echo $row[1]?>" size="55" onchange = "document.test.matname.value=capfirst(document.test.matname.value)"></td>
</p>
</tr>
</table></div>










<INPUT TYPE="hidden" name="seenbefore" value="1">
<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="filling" value="<?php echo $filling  ?>">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="matid" value="<?php echo $matid  ?>">
<INPUT TYPE="hidden" name="add_edit_duplicate" value="<?php echo $add_edit_duplicate  ?>">
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >

<BR><br>

  <div align="center"><?php button_print() ?></div>

</form>
<!--numrows("<?php echo $numrows ?>");
    matid("<?php echo $matid ?>");
    gotocheck("<?php echo $gotocheck ?>");
    nameprompt("<?php echo $filling ?> ");
    view_check("<?php echo $matname ?> ");
    add_edit_duplicate ("<?php echo $add_edit_duplicate ?>");
    -->


</body>

</html>
