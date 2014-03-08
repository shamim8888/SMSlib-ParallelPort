<?php
// required variables
require("config.php");
if ($submitted == 1)
                {



                        if ($filling=="viewcheck")
                                {

                                       // echo "alert($dupnumrows...we are in viewcheck and gotocheck $gotocheck)";
                                        $subresult = pg_exec("select * from ship order by ship_name");
                                        $subnumrows = pg_numrows($subresult);

                                        if ($subnumrows!=0)
                                                {
                                                        $subrow = pg_fetch_row($subresult,$gotocheck-1);
                                                        $idviewcheck = $subrow[0];
                                                       // echo "alert($idviewcheck...we are in viewcheck)";
                                                }


                                        //echo "alert(now we have to find the real gotocheck...we already got viewcheck)";
                                        $subresult = pg_exec("select * from ship order by ship_id");
                                        $subnumrows = pg_numrows($subresult);

                                        if ($subnumrows!=0)
                                                {
                                                        $counter = 0 ;
                                                        while ( $counter<$subnumrows)
                                	                        {

                                                                        $subrow = pg_fetch_row($subresult,$counter);
                                                                        if ($idviewcheck == $subrow[0])
                                                                                {
                                                                                        //echo "alert(Bingo ..we have found the gotocheck...we are in viewcheck)";
                                                                                        $gotocheck = $counter+1;
                                                                                        //echo "alert(Bingo ..we have found the gotocheck...it's $gotocheck)";
                                                                                        break;
                                                                                }
                                                                        $counter++;
                                                                }

                                                }

                                }


                }


        else
                {

                        //echo "we are in start";
                        $query_string = "select * from ship order by ship_name";

                         $result = pg_exec($query_string);

                         $numrows=pg_numrows($result);

                         $totalnumofpage= $numrows%25==0?$numrows/25:floor($numrows/25)+1;
                         //echo $totalnumofpage;
                         $column_count = pg_numfields($result);





                        for($count=0;$count<$numrows;$count++)
                                {

                                        $row = pg_fetch_row($result,$count);

                                        ///test for indication from account screen

                                        $indicator = $row[0];

                                        if (abs($testindicator)==abs($indicator))
                                                {
                                                       // echo "we are in loop ";
                                                        $viewindicator=$count+1;
                                                }


                                }
                          //  echo "$testindicator viewindicator$viewindicator";
                           $pagenum = $viewindicator%25==0?$viewindicator/25:floor($viewindicator/25)+1;
                           // echo "when we come from account -we are in start-page num is $pagenum";
                           $button_pressed = $pagenum;
                        ///test for indication from account screen
                            $button_check= $viewindicator;









                }

?> 



<html>
<head>

<script language = javascript>

var totalnumofpage = <?php echo $totalnumofpage ?>;

var pagenum = <?php echo $pagenum ?>;

function set_attribute()
        {
               document.test.bottombutton.value = "Bottom Page "+String(totalnumofpage)  ;
               document.test.nextrecord.value = "Next Page "+String(pagenum==totalnumofpage?totalnumofpage:pagenum+1)  ;
               document.test.prevrecord.value = "Prior Page "+String(pagenum>1?pagenum-1:1)  ;

                if (document.test.pagenum.value<=1)
                        {
                            //    document.test.prevbutton.disabled=true;
                                document.test.prevrecord.disabled=true;


                        }
                if (Number(document.test.pagenum.value)>=Number(document.test.totalnumofpage.value))
                        {
                          //      document.test.nextbutton.disabled=true;
                                document.test.nextrecord.disabled=true;

                        }
             window.status = document.test.totalnumofpage.value+"/"+ pagenum  ;

        }

function select_record(buttonname)
	{
 //eval("document.test."+buttonname+".value")= newvalue
        document.test.button_check.value = Number(buttonname.substr(1,3));
		document.test.filling.value = "viewcheck";
		document.test.gotocheck.value = Number(document.test.button_check.value);
        document.test.button_pressed.value = document.test.pagenum.value;
        alert(document.test.gotocheck.value);
       // document.test.viewcheck.value = Number(document.test.button_check.value)+1;
	}


function set_main()
{       
	document.test.filling.value = "viewcheck";
	//document.view_record.gotocheck.value = document.view_record.button_check.value;
<?php	
	print("opener.location=\"http://technodome.org/ship.php?filling=gotobutton&gotocheck=$gotocheck&add_edit_duplicate=false&seenbefore=1\"; ");
 ?>
	window.close();

}

function prevnext(buttonname)
        {

                //eval("document.test."+buttonname+".value")= newvalue
                if (buttonname=='prev')
                        {

                            //    document.test.button_check.value = Number(buttonname.substr(1,3));
	                        document.test.filling.value = "preview";
                                document.test.pagenum.value =  document.test.pagenum.value - 1<=0?0:document.test.pagenum.value - 1;
                              //  document.test.button_pressed.value = document.test.pagenum.value;
	                        document.test.gotocheck.value = Number(document.test.button_check.value)+1;
                                // document.test.viewcheck.value = Number(document.test.button_check.value)+1;
                        }


               if (buttonname=='next')
                       {

                           //    document.test.button_check.value = Number(buttonname.substr(1,3));
                               document.test.filling.value = "next";
                               document.test.pagenum.value =  Number(document.test.pagenum.value) + 1>=Number(document.test.totalnumofpage.value)?Number(document.test.totalnumofpage.value):Number(document.test.pagenum.value) + 1;
                               document.test.gotocheck.value = Number(document.test.button_check.value)+1;
                               // document.test.viewcheck.value = Number(document.test.button_check.value)+1;
                              // document.test.button_pressed.value = document.test.pagenum.value;

                       }




        }




</script>

<script language = javascript src="all_jscript_function.js"></script>


</head>

<body bgcolor="#D6B4A3" onload= "set_attribute()"> <form name = "test" action = "view_ship.php" method = "post">


<?php

$xz=($pagenum-1)*25;


$query_string = "select * from ship_owner_names order by ship_name LIMIT 25 OFFSET $xz ";

 $result = pg_exec($query_string);

 $column_count = pg_numfields($result);
 
print ("<div align=\"center\"><TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">REC</th>");
  for ($column_num =0; $column_num<=$column_count; $column_num++)
    { 
      $field_name= array('ID','Ship Name','Owner ID','Ship Owner','Capacity (Mt)','Capacity (Cft)','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

print ("<TH BGCOLOR=\"#aabf5c\"> $field_name[$column_num]</TH>");
     }
  print ("</TR>");
}

//Print Body of the Table




$numrows=pg_numrows($result);

for($count=0,$button=$xz+1;$count<$numrows,$button<=$numrows+$xz;$button++,$count++) {

$row = pg_fetch_row($result,$count);

///test for indication from account screen

        if ($submitted != 1)
                {
                        $indicator = $row[0];
                        $color = ($indicator==$testindicator ? "5fF9F0" : "E9E9E9");
                }
        else
                {
                        if ($button_pressed==$pagenum)
                                {
                                        $color = ($button_check==$button ? "5fF9F0" : "E9E9E9");
                                }
                        else
                                {
                                        $color = "E9E9E9" ;
                                }
                }


 echo ("<TR align = center valign = center BGCOLOR=\"#$color\"><TD>

	<input type=\"submit\" value=\"$button\" name=\"b$button\" style=\" width: 40; height: 20\" onclick = \"select_record(document.test.b$button.name)\" >
	</TD>");


for ($column_num =0; $column_num<=$column_count;$column_num++)
	{
		print("<TD> $row[$column_num]</TD>\n");
	}
	print ("</TR>\n");

       }
	print ("</Table></div>");


	
	
?>


<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="add_edit_duplicate" value="false">
<INPUT TYPE="hidden" name="viewcheck" value="<?php echo $viewcheck  ?>" >
<INPUT TYPE="hidden" name="submitted" value="1" >
<INPUT TYPE="hidden" name="testindicator" value="<?php echo $testindicator  ?>" >
<INPUT TYPE="hidden" name="viewindicator" value="<?php echo $viewindicator  ?>" >
<INPUT TYPE="hidden" name="pagenum" value="<?php echo $pagenum  ?>" >
<INPUT TYPE="hidden" name="totalnumofpage" value="<?php echo $totalnumofpage  ?>" >
<INPUT TYPE="hidden" name="button_pressed" value="<?php echo $button_pressed  ?>">
<br>

<div align="center"><?php navforview_button_print() ?></div>

</form>
<!-- gotocheck("<?php echo $gotocheck ?>");-->
</body>
</html>
