<?php
        // required variables
        require("config.php");

        if ($submitted == 1)
                {



                        if ($filling=="viewcheck")
                                {

                                        //echo "alert($dupnumrows...we are in viewcheck and gotocheck $gotocheck)";
                                        $subresult = pg_exec("select * from accounts order by account_type,account_name");
                                        $subnumrows = pg_numrows($subresult);

                                        if ($subnumrows!=0)
                                                {
                                                        $subrow = pg_fetch_row($subresult,$gotocheck-1);
                                                        $idviewcheck = $subrow[0];
                                                        //echo "alert($idviewcheck...we are in viewcheck)";
                                                }


                                        //echo "alert(now we have to find the real gotocheck...we already got viewcheck)";
                                        $subresult = pg_exec("select * from accounts order by account_id");
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
                        $query_string = "select * from accounts order by account_type,account_name";

                         $result = pg_exec($query_string);

                         $numrows=pg_numrows($result);

                         $totalnumofpage= $numrows%22==0?$numrows/22:floor($numrows/22)+1;
                         //echo $totalnumofpage;
                         $column_count = pg_numfields($result);





                        for($count=0;$count<$numrows;$count++)
                                {

                                        $row = pg_fetch_row($result,$count);

                                        ///test for indication from account screen

                                        $indicator = $row[0];

                                        if (abs($testindicator)==abs($indicator))
                                                {
                                                        //echo "we are in loop ";
                                                        $viewindicator=$count+1;
                                                }


                                }
                            //echo "$testindicator viewindicator$viewindicator";
                           $pagenum = $viewindicator%22==0?$viewindicator/22:floor($viewindicator/22)+1;
                            //echo "when we come from account -we are in start-page num is $pagenum";
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
     //   alert(document.test.gotocheck.value);
       // document.test.viewcheck.value = Number(document.test.button_check.value)+1;
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










function set_main()
{
	document.test.filling.value = "viewcheck";
	//document.test.gotocheck.value = document.test.button_check.value;
<?php
	print("opener.location=\"http://technodome.org/account.php?filling=viewbutton&navigation=true&viewcheck=$viewcheck&gotocheck=$gotocheck&add_edit_duplicate=false&seenbefore=1\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>
<script language = javascript src="all_jscript_function.js"></script>


</head>

<body bgcolor="#8B855E" onload= "set_attribute()"> <form name = "test" action = "view_account.php" method = "post">


<?php




        $xz=($pagenum-1)*22;
        $query_string = "select * from accounts  order by account_type,account_name LIMIT 22 OFFSET $xz ";

        $result = pg_exec($query_string);

        $numrows=pg_numrows($result);

        // $totalnumofpage= $numrows%15==0?$numrows/15:floor($numrows/15)+1;
        //  echo $totalnumofpage;
        $column_count = pg_numfields($result);

        print ("<TABLE  border=4>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">REC</th>");
  for ($column_num =1; $column_num<=$column_count; $column_num++)
    {
      $field_name= array('REC','&nbsp;&nbsp;ID&nbsp;&nbsp;','Acct&nbsp;&nbsp;Type','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account&nbsp;&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Office&nbsp;&nbsp;Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HOME&nbsp;&nbsp;ADDRESS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;PHONE(OFF)&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;PHONE(RES)&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOBILE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

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

///test for indication from account screen


//$color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

 echo ("<TR align = \"center\"  valign =\"center\"  BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$button\" style=\" width: 40; height: 20\" onclick = \"select_record(document.test.b$button.name)\" >
</TD>");
	for ($column_num =0; $column_num<=$column_count;$column_num++)
		{
			print("<TD><font size=-1> $row[$column_num]</font></TD>\n");

		}
		print ("</TR>\n");$i++;
  }
	print ("</Table>");




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
<!--button_pressed("<?php echo $button_pressed ?> ");
pagenum("<?php  echo $pagenum ?>");
viewindicator("<?php echo $viewindicator ?> ");
numofpage("<?php  echo $totalnumofpage ?>");
numrows("<?php echo $numrows ?>");
accountid("<?php echo $accountid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
color("<?php echo $color ?> ");
</body>
</html>-->
