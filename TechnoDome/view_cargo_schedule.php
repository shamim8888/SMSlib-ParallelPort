<?php
// required variables
require("config.php");
 
if ($submitted == 1)
                {



                        if ($filling=="viewcheck")
                                {

                                        echo "alert($dupnumrows...we are in viewcheck and gotocheck $gotocheck)";
                                        $subresult = pg_exec("select * from cargo_account_mat_view order by ship_name, trip_id");
                                        $subnumrows = pg_numrows($subresult);

                                        if ($subnumrows!=0)
                                                {
                                                        $subrow = pg_fetch_row($subresult,$gotocheck-1);
                                                        $idviewcheck = $subrow[12];
                                                        echo "alert($idviewcheck...we are in viewcheck)";
                                                }


                                        echo "alert(...now we have to find the real gotocheck...we already got viewcheck)";
                                        $subresult = pg_exec("select * from cargo_account_mat_view order by schedule_id");
                                        $subnumrows = pg_numrows($subresult);

                                        if ($subnumrows!=0)
                                                {
                                                        $counter = 0 ;
                                                        while ( $counter<$subnumrows)
                                	                        {

                                                                        $subrow = pg_fetch_row($subresult,$counter);
                                                                        if ($idviewcheck == $subrow[12])
                                                                                {
                                                                                        echo "alert(Bingo ..we have found the gotocheck...we are in viewcheck)";
                                                                                        $gotocheck = $counter+1;
                                                                                        echo "alert(Bingo ..we have found the gotocheck...it's $gotocheck)";
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
						//echo "$query_string";

						$query_string = "select * from cargo_account_mat_view order by ship_name, trip_id";
                         $result = pg_exec($conn,$query_string);



                         $numrows=pg_numrows($result);

                         $totalnumofpage= $numrows%24==0?$numrows/24:floor($numrows/24)+1;
                         echo "numrows...$numrows cv $totalnumofpage bv";
                         $column_count = pg_numfields($result);





                        for($count=0;$count<$numrows;$count++)
                                {

                                        $row = pg_fetch_row($result,$count);

                                        ///test for indication from account screen

                                        $indicator = $row[12];
                                        if (abs($testindicator)==abs($indicator))
                                                {
                                                        //echo "we are in loop ";
                                                        $viewindicator=$count+1;
                                                }


                                }
                            echo "..test.. $testindicator.. viewindicator.. $viewindicator";
                           $pagenum = $viewindicator%24==0?$viewindicator/24:floor($viewindicator/24)+1;
                            echo "when we come from account -we are in start-page num is $pagenum";
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

                if (Number(document.test.pagenum.value)<=1)
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
        //alert(document.test.gotocheck.value);
       // document.test.viewcheck.value = Number(document.test.button_check.value)+1;
	}	





function set_main()
{
	document.test.filling.value = "viewcheck";
	document.test.gotocheck.value = document.test.button_check.value;
<?php
	print("opener.location=\"http://ns.technodome.org/cargo_schedule.php?filling=gotobutton&gotocheck=$gotocheck&seenbefore=1\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>
<script language = javascript src="all_jscript_function.js"></script>
</head>

<body onload= "set_attribute()" bgcolor="#067686"> <form name = "test" action = "view_cargo_schedule.php" method = "post">

<?php

// connects to database
$xz=($pagenum-1)*24;
//$conn=pg_connect("host=$host user=$user dbname=$database");

$query_string = "select schedule_id,departure_date,ship_name,account_name,from_loc,to_loc,matone_name,mattwo_name,quantity_one,fair_rate,quantity_two,fair_rate_two,unload_date,advance_tk,part_tk,balance_tk,total_tk,pay_voucher_date,trip_id from cargo_account_mat_view order by ship_name, trip_id LIMIT 24 OFFSET $xz";  //schedule_id

$result = pg_exec($query_string);

$column_count = pg_numfields($result);

print ("<TABLE  border=4>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">Record</th>");
  $field_name= array('Record','Schd_ID','Dpt.&nbsp;date','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ship&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mat_one&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mat_two&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','Qty.One','Fair&nbsp;Rate','Qty.Two','Fair&nbsp;Rate&nbsp;Two','UNLOAD&nbsp;DATE','Advance','Part','Balance','Total','Pay&nbsp;Date','Trip&nbsp;ID');
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

for($count=0,$button=$xz+1;$count<$numrows,$button<=$numrows+$xz;$button++,$count++) {

$row = pg_fetch_row($result,$count);

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

 echo ("<TR align = center  valign = center BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$button\" style=\" width: 40; height: 20\" onclick = \"select_record(document.test.b$button.name)\" >
</TD>");
for ($column_num =0; $column_num<$column_count;$column_num++)
	{
		print("<TD><font size=-1> $row[$column_num]</font></TD>\n");
	}
	print ("</TR>\n");$i++;
       }
	print ("</Table>");


?>
<INPUT TYPE="hidden" name="radiotest" value="<?php echo $radiotest  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>" >
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
totalnumofpage("<?Php echo $totalnumofpage ?>");
numrows("<?php echo $numrows ?>");
schedule("<?php echo $scheduleid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
</body>
</html>

