<?php
        // required variables
        require("config.php");

        if ($submitted == 1)
                {
                        echo "alert($dupnumrows...we are in viewcheck)";
                        $result = pg_exec("select * from accounts order by account_type,account_name");
                        $numrows = pg_numrows($result);

                        if ($numrows!=0)
                                {
                                        $row = pg_fetch_row($result,$gotocheck-1);
                                        $viewcheck = $row[0];
                                        echo "alert($viewcheck...we are in viewcheck)";
                                }


                        echo "alert(now we have to find the real gotocheck...we already got viewcheck)";
                        $result = pg_exec("select * from accounts order by account_id");
                        $numrows = pg_numrows($result);

                        if ($numrows!=0)
                                {
                                        $counter = 0 ;
                                        while ( $counter<=$numrows)
                                	        {

                                                        $row = pg_fetch_row($result,$counter);
                                                        if ($viewcheck == $row[0])
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







?>



<html>
<head>

<script language = javascript>



function select_record(buttonname)
{
 //eval("document.view_record."+buttonname+".value")= newvalue
        document.view_record.button_check.value = Number(buttonname.substr(1,3));
	document.view_record.filling.value = "viewcheck";
	document.view_record.gotocheck.value = Number(document.view_record.button_check.value)+1;
       // document.view_record.viewcheck.value = Number(document.view_record.button_check.value)+1;
}


function set_main()
{
	document.view_record.filling.value = "viewcheck";
	//document.view_record.gotocheck.value = document.view_record.button_check.value;
<?php
	print("opener.location=\"http://ns.riverine.org/account.php?filling=viewbutton&viewcheck=$viewcheck&gotocheck=$gotocheck&add_edit_duplicate=false&seenbefore=1\"; ");
 ?>
	window.close();
	//window.open ("riverine.htm","account_add_insert_experiment.php","_main");
//);
}



</script>

</head>

<body> <form name = "view_record" action = "view_account.php" method = "post">


<?php

// connects to database

//$conn=pg_connect("host=$host user=$user dbname=$database");

$query_string = "select * from accounts order by account_type,account_name";

 $result = pg_exec($query_string);

 $column_count = pg_numfields($result);
 
print ("<TABLE  border=1>\n");


if (TRUE)

{
  print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");
  for ($column_num =1; $column_num<=$column_count; $column_num++)
    { 
      $field_name= array('RECORD','ACCOUNT ID','ACCOUNT&nbsp;&nbsp;TYPE','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ACCOUNT&nbsp;&nbsp;NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','OFFICE&nbsp;&nbsp;ADDRESS','HOME&nbsp;&nbsp;ADDRESS','PHONE(OFF)','PHONE(RES)','MOBILE');

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

for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++) {

$row = pg_fetch_row($result,$count);

///test for indication from account screen

        if ($submitted != 1)
                {
                        $indicator = $row[0];
                        $color = ($indicator==$testindicator ? "5fF9F0" : "E9E9E9");
                }
        else
                {
                        $color = ($button_check==$count ? "5fF9F0" : "E9E9E9");
                }

///test for indication from account screen


//$color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

 echo ("<TR align = \"center\"  valign =\"center\"  BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$count\" style=\" width: 40; height: 20\" onclick = \"select_record(document.view_record.b$count.name)\" >
</TD>");
for ($column_num =0; $column_num<=$column_count;$column_num++)
	{
		print("<TD> $row[$column_num]</TD>\n");

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


<br>

<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick= "set_main()"> 

</td>
    </tr>
  </table>
</form>
numrows("<?php echo $numrows ?>");
accountid("<?php echo $accountid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
color("<?php echo $color ?> ");
</body>
</html>
