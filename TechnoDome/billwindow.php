<?php
// required variables
require("config.php");


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
}



function set_main()
{

<?php
	print("opener.location=\"http://ns.riverine.org/report.php?year=$year&month=$month&monthname=$monthname\"; ");
 ?>
	window.close();

}


function printwindow()
{
          ///// previously was bill-report.php |
          //                                  \ /
          var abc = "bill-report-client.php?shipid="+document.view_record.shipid.value+"&shipname="+document.view_record.shipname.value+"&shipownername="+document.view_record.shipownername.value+"&fromlocation="+document.view_record.fromlocation.value+"&tolocation="+document.view_record.tolocation.value+"&clientname="+document.view_record.clientname.value+"&tripid="+document.view_record.tripid.value+"&monthname="+document.view_record.monthname.value+"&year="+document.view_record.year.value+"&clientid="+document.view_record.clientid.value;
          alert(abc);
          window.open(abc,"Preview","toolbar=no,scrollbars=yes, innerWidth=1600,innerHeight=1200, alwaysRaised=1");

}






</script>

</head>

<body> <form name = "view_record" action = "billwindow.php" method = "post">
 <b><u><font size=+3><div align="center">BILL Processing Form</div></font></u></b>

<?php

// connects to database

//$conn=pg_connect("host=$host user=$user dbname=$database");

$query_string = "select departure_date,ship_id,ship_name,owner_name,account_name,from_loc,to_loc,matone_name,mattwo_name,quantity_one,quantity_two,fair_rate,unload_date,Received_from,clientname,receive_advance,receive_part,receive_balance,receive_total,advance_tk,part_tk,balance_tk,total_tk,trip_id from billprocessing order by schedule_id";         // I cut-- where balance_tk=0

$result = pg_exec($query_string);

$column_count = pg_numfields($result);

print ("<TABLE  border=1>\n");


if (TRUE)

        {

                print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");

                $field_name= array('Record','Depart&nbsp; Date','Ship&nbsp;ID','&nbsp;&nbsp;Ship&nbsp;Name&nbsp;&nbsp;','Owner&nbsp;ID','&nbsp;&nbsp;Owner&nbsp;Name&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp; From &nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;Mat-One&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;Mat-Two&nbsp;&nbsp;&nbsp;&nbsp;','Qty-One','Qty-Two','Fair Rate','Unload Date','Client ID','Client Name','Receive Advance','Receive Part','Receive balance','Receive Total','Paymant Advance','Paymant Part','Paymant Balance','Paymant Total','Pay Date','Trip ID');

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

for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++)
        {

                $row = pg_fetch_row($result,$count);

                $color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

                if ($button_check==$count )
                        {
                                $balancetk = $row[22];
                                $departuredate = $row[0];
                                $shipid = $row[1];
                                $shipname = $row[2];
                                $accountid = $row[3];
                                $shipownername = $row[4];


                                $fromlocation = $row[5];
                                $tolocation = $row[6];
                                $nameofmaterialone = $row[11];
                                $nameofmaterialtwo = $row[14];
                                $nameofshipcargo = $row[3];

                                $fromlocvalue =$row[6];
                                $tolocvalue =  $row[8];
                                $from_place = $row[7];
                                $to_place = $row[9];

                                $tripid = $row[23];
                                $clientname = $row[14];
                                $clientid = $row[13];
  }


 echo ("<TR align = center  valign = center BGCOLOR=\"#$color\"><TD>
<input type=\"submit\" value=\"$button\" name=\"b$count\" style=\" width: 40; height: 20\" onclick = \"select_record(document.view_record.b$count.name)\" >
</TD>");
for ($column_num =0; $column_num<$column_count;$column_num++)
	{
		print("<TD> $row[$column_num]</TD>\n");
	}
	print ("</TR>\n");$i++;
       }
	print ("</Table>");


?>

<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="scheduleid" value="<?php echo $scheduleid  ?>" >


<INPUT TYPE="hidden" name="year" value="<?php echo $year  ?>" >
<INPUT TYPE="hidden" name="month" value="<?php echo $month  ?>" >
<INPUT TYPE="hidden" name="monthname" value="<?php echo $monthname  ?>" >

<INPUT TYPE="hidden" name="tripid" value="<?php echo $tripid  ?>" >
<input type ="hidden" name ="shipownername" value="<?php echo $shipownername ?>">
<input type ="hidden" name ="shipname" value="<?php echo $shipname ?>">
<input type ="hidden" name ="shipid" value="<?php echo $shipid ?>">
<input type ="hidden" name ="fromlocation" value="<?php echo $fromlocation ?>">
<input type ="hidden" name ="tolocation" value="<?php echo $tolocation ?>">
<input type ="hidden" name ="clientname" value="<?php echo $clientname ?>">
<INPUT TYPE="hidden" name="clientid" value="<?php echo $clientid  ?>" >
<input type ="hidden" name ="materialtwo" value="<?php echo $materialtwo ?>">
<input type ="hidden" name ="nameofmaterialone" value="<?php echo $nameofmaterialone ?>">
<input type ="hidden" name ="nameofmaterialtwo" value="<?php echo $nameofmaterialtwo ?>">

<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Print/PreView" name="printbutton" style=" width: 84; height: 25" onclick= "printwindow()">

</td>

<td width="16%" height="32" valign="baseline" align="center"> <input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25" onclick= "set_main()">

</td>
    </tr>




    </tr>
  </table>
</form>
numrows("<?php echo $numrows ?>");
schedule("<?php echo $scheduleid ?>");
gotocheck("<?php echo $gotocheck ?>");
filling("<?php echo $filling ?> ");
button_check("<?php echo $button_check ?> ");
view_check("<?php echo $view_check ?> ");
shipname("<?php echo $shipname ?> ");
Month ("<?php echo $month ?> ");
year ("<?php echo $year ?> ");
</body>
</html>

