<?php

        require("config.php");


        // grabs all product information
        $result = pg_exec("select * from ship_owner_names order by ship_id");
        $numrows = pg_numrows($result);

        if ($seenbefore != 1)
                {
                        $add_edit_duplicate = "false" ;

                        if ($numrows==0)
                                {
                                        $row[0]=0;
                                        $row[1]="";
                                        $shipid = 0;
                                }

                        else
                                {
                                        $row = pg_fetch_row($result,0);
                                        $shipid = $row[0];

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
	                $result = pg_exec("select * from ship_owner_names order by ship_id");
	                $numrows=pg_numrows($result);
	                $row = pg_fetch_row($result,0);
	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];
	        }


        /******************** End OF TOP BUTTON  ***************************/

        /******************** FOR PREVIOUS BUTTON  **********************************/

        if ($filling == "prevrecord")
                {
	                $result = pg_exec("select * from ship_owner_names order by ship_id");

	                $numrows = pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];
	        }


        /**************************** END OF PREVIOUS BUTTON  *********************/


        /************************* FOR NEXT BUTTON ****************************/

        if ($filling == "nextrecord")
                {
	                $result = pg_exec("select * from ship_owner_names order by ship_id");

	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);
	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];
	        }


        /**************************** END OF NEXT BUTTON  *********************/



        /**************************** FOR BOTTOM BUTTON  *********************/

        if ($filling == "bottombutton")
                {
	                $result = pg_exec("select * from ship_owner_names order by ship_id");
	                $numrows=pg_numrows($result);
	                $row = pg_fetch_row($result,($numrows-1));
	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];
	        }


        /**************************** FOR GOTO BUTTON  *********************/



        if ($filling == "gotobutton")
                {
	                $result = pg_exec("select * from ship_owner_names order by ship_id");

	                $numrows=pg_numrows($result);

	                $row = pg_fetch_row($result,$gotocheck-1);

	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];

	        }



        /*******************  For ADD BUTTON         **********************/


        if ($filling == "addbutton")
                {

                        $shipname = ltrim($shipname);

                        $dupresult= pg_exec($conn,"select * from ship where (ship_name='$shipname') ");
                        $dupnumrows = pg_numrows($dupresult);
                        if ($dupnumrows !=0)
                                {

                                        $add_edit_duplicate = 'true' ;

                                        $result = pg_exec("select * from ship_owner_names order by ship_id");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $shipid = $row[0];
                                        $shipname = trim($row[1]);
                                        $shipowner = $row[3];
                                        $mt = $row[4];
                                        $cft = $row[5];
                                        $comment = $row[6];


                                }

                        else
                                {
                                        $add_edit_duplicate = 'false' ;


                                        $result = pg_exec($conn,"insert into ship (ship_name,account_id,mt,cft,comment) values('$shipname','$shipowner','$mt','$cft','$comment')");

                                        $result = pg_exec("select * from ship_owner_names order by ship_id");
                                        $numrows=pg_numrows($result);
                                        $row = pg_fetch_row($result,($numrows-1));
                                        $shipid = $row[0];
                                        $shipname = $row[1];
                                        $shipowner = $row[3];
                                        $mt = $row[4];
                                        $cft = $row[5];
                                        $comment = $row[6];
                                        $gotocheck = $numrows;


                                }



                }

        /*************************End Of Add Button*************************/



        /**************************** FOR EDIT BUTTON  *********************/


        if ($filling == "editbutton")
                {

	                $result = pg_exec("select * from ship order by ship_id");

	                $numrows=pg_numrows($result);


                        $dupresult= pg_exec($conn,"select * from ship where (ship_name='$shipname')");
                        $dupnumrows = pg_numrows($dupresult);

                        if ($dupnumrows !=0)
                                {

                                        echo "alert($dupnumrows)";
                                        $duprow = pg_fetch_row($dupresult,0);
                                        if ($dupnumrows !=0 && $duprow[0] != $shipid)
                                                {
                                                        $add_edit_duplicate = 'true' ;

                                                        $result = pg_exec("select * from ship_owner_names order by ship_id");

                                                        $numrows=pg_numrows($result);

                                                        $row = pg_fetch_row($result,$gotocheck-1);

                                                        $shipid = $row[0];
                                                        $shipname = $row[1];
                                                        $shipowner = $row[3];
                                                        $mt = $row[4];
                                                        $cft = $row[5];
                                                        $comment = $row[6];
                                                }

                                        else
                                                {
                                                        $add_edit_duplicate = 'false' ;

                                                        $result = pg_exec($conn,"DELETE FROM ship WHERE (ship_id = '$shipid');INSERT INTO ship (ship_id,ship_name,account_id,mt,cft,comment) VALUES('$shipid','$shipname','$shipowner','$mt','$cft','$comment')");

                                                        $result = pg_exec("select * from ship_owner_names order by ship_id");

                                                        $numrows=pg_numrows($result);

                                                        $row = pg_fetch_row($result,$gotocheck-1);
                                                        $shipid = $row[0];
                                                        $shipname = $row[1];
                                                        $shipowner = $row[3];
                                                        $mt = $row[4];
                                                        $cft = $row[5];
                                                        $comment = $row[6];

                                                }


                                }
                        else
                                {
                                        $add_edit_duplicate = 'false' ;

                                        $result = pg_exec($conn,"DELETE FROM ship WHERE (ship_id = '$shipid');INSERT INTO ship (ship_id,ship_name,account_id,mt,cft,comment) VALUES('$shipid','$shipname','$shipowner','$mt','$cft','$comment')");

                                        $result = pg_exec("select * from ship_owner_names order by ship_id");

                                        $numrows=pg_numrows($result);

                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $shipid = $row[0];
                                        $shipname = $row[1];
                                        $shipowner = $row[3];
                                        $mt = $row[4];
                                        $cft = $row[5];
                                        $comment = $row[6];

                                }


                }



        /**************************** FOR DELETE BUTTON  *********************/

        if ($filling == "deletebutton")
                {
		        //$accountid=63;
		        $result = pg_exec("select * from ship order by ship_id");

		        $numrows=pg_numrows($result);

		        $result = pg_exec($conn,"DELETE  FROM ship WHERE (ship_id = '$shipid')");

		        $result = pg_exec("select * from ship_owner_names order by ship_id");

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
	                $shipid = $row[0];
	                $shipname = $row[1];
	                $shipowner = $row[2];
	                $mt = $row[3];
	                $cft = $row[4];
	                $comment = $row[5];



                }



?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Ship Entry Form</title>
</head>

<script language= javascript>

var numrows = <?php echo $numrows ?>;
var gotocheck = <?php echo $gotocheck ?>;

function setattribute()  //Sets button attribute on body load
        {
                if (document.test.add_edit_duplicate.value=='true')
                        {
                                alert("Duplicate Record Found");

                                document.test.add_edit_duplicate.value = 'false';

                                button_option("pressed");

                        }


                else
                        {
                                 document.test.shipname.disabled=true;
                                 document.test.mt.disabled=true;
                                 document.test.cft.disabled=true;
                                 document.test.comment.disabled=true;
                                 document.test.shipowner.disabled=true;
                                 document.test.savebutton.disabled=true;
                                 document.test.cancelbutton.disabled=true;

                                if (document.test.shipid.value ==0)
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

	        if(theForm.shipowner.selectedIndex == -1)
                        {
		                alert("<?php echo $txt_missing_shipowner ?>");
		                theForm.shipowner.focus();
		                return(false);
	                }

	        if(theForm.shipname.value == "")
                        {
		                alert("<?php echo $txt_missing_shipname ?>");
                                theForm.shipname.select();
                                theForm.shipname.focus();
		                return(false);
	                }

                if(theForm.mt.value == 0 && theForm.cft.value == 0)
                        {
         	                alert("Please enter either Ship Capacity in Metric Ton or Cubic Feet or Both");
                                theForm.mt.select();
         	                theForm.mt.focus();
         	                return(false);
        	        }

                if (isFinite(theForm.mt.value) != true)
                        {
                                alert('Invalid Number Argument In Ship Capacity (In Metric Ton) !');
                                theForm.mt.select();
                                theForm.mt.focus();
                                return(false);

                        }


                if (isFinite(theForm.cft.value) != true)
                        {
                                alert('Invalid Number Argument In Ship Capacity (In Cubic Feet) !');
                                theForm.cft.select();
                                theForm.cft.focus();
                                return(false);

                        }

	        return (true);


        }






function add_edit_press(endis)
        {    //Setting button attributes on press
                if (endis=='addedit')
                        {
                                document.test.shipname.disabled=false;
                                document.test.mt.disabled=false;
                                document.test.cft.disabled=false;
                                document.test.comment.disabled=false;
                                document.test.shipowner.disabled=false;

                                button_option("pressed");

                        }

                else
	                {
                                document.test.shipname.disabled=true;
                                document.test.mt.disabled=true;
                                document.test.cft.disabled=true;
                                document.test.comment.disabled=true;
                                document.test.shipowner.disabled=true;

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




function add_clear()
        {
                document.test.shipname.value="";
                document.test.mt.value="";
                document.test.cft.value="";
                document.test.comment.value="";
                document.test.shipowner.selectedIndex = 0;
        }





function view_record()
        {
                <?php
                        $button_check = $gotocheck - 1;
                        print("window.open (\"view_ship.php?gotocheck=$gotocheck&button_check=$button_check&testindicator=$shipid\",\"view\",\"toolbar=no,scrollbars=yes\")");

                ?>

        }



</script>
<script language = "javascript" src="all_jscript_function.js"></script>

<body bgcolor="#D6B4A3" onload= "setattribute()">

<center><b><u><font size=+3><font color="#8a0f9f">Ship Entry Form</font></font></u></b></center>
<form name = "test" onsubmit = "return form_validator(this)"  onreset = "add_edit_press()" method= "post" action= "ship.php">

<br>
<div align="center">
<table border="4">
<tr>

<td><b>Ship Name:&nbsp;</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" name="shipname"  size="50" value="<?php echo $row[1]  ?>" onchange = "document.test.shipname.value = capfirst(document.test.shipname.value)"></td>

</tr>

<tr>
<td><b>Ship Owner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>


<td><select size="1" name="shipowner">
<option value = "<?php echo $row[2] ?>" selected > <?php echo $row[3]  ?></option>
<?php
// grabs all product information
$result = pg_exec("select account_id,account_name from accounts where account_type='Shipowner' order by account_name");
$tot_rows=pg_numrows($result);

 for($i=0;$i<$tot_rows;$i++){
	$owner = pg_fetch_row($result,$i);
	print("<option value = \"$owner[0]\" >$owner[1]</option>\n");
	}

?>
</select></td>

</tr>


<tr>

<td><b>Ship Capacity (In Metric Ton) :&nbsp;&nbsp;</b></td>

<td><input type="text" name="mt"  size="25" value="<?php echo $row[4]  ?>" ></td>

</tr>

<tr>

<td><b>Ship Capacity (In Cft):&nbsp;</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" name="cft"  size="25" value="<?php echo $row[5]  ?>"  ></td>
</tr>


<tr>
<td><b>Ship Description:&nbsp;</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" name="comment"  size="50" value="<?php echo $row[6]  ?>"></td>
<br>&nbsp;&nbsp;
</tr>




</table></div>

<INPUT TYPE="hidden" name="seenbefore" value="1">
<INPUT TYPE="hidden" name="filling" value="<?php echo $filling  ?>">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck ?>">
<INPUT TYPE="hidden" name="shipid" value="<?php echo $shipid  ?>">
<INPUT TYPE="hidden" name="add_edit_duplicate" value="<?php echo $add_edit_duplicate  ?>">
<INPUT TYPE="hidden" name="navigation" value="<?php echo $navigation ?>" >

<BR>

<div align="center">
  <center>
  <?php button_print(); ?>
  </center>
</div>


</center>

</form>



<!--numrows("<?php echo $numrows ?>");
    shipownerValue("<?php echo $shipowner ?>");

    gotocheck("<?php echo $gotocheck ?>");

    filling("<?php echo $filling ?>");
    -->


</body>

</html>
