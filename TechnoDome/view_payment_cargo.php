<?php
// required variables
require("config.php");


?>



<html>
<head>
<style type="text/css">

	body {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
	th   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; font-weight: bold; background-color: <?php echo $cfgThBgcolor;?>;}
	td   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt;}
	form   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
	h1   {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16pt; font-weight: bold}
	A:link    {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: none; color: blue}
	A:visited {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: none; color: blue}
	A:hover   {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; text-decoration: underline; color: red}
	A:link.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	A:visited.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	A:hover.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: red;}
	.nav {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #000000}
	.generic {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size:10pt; color: #000000}


	</style>

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
	        document.view_record.filling.value = "viewcheck";
			document.view_record.voucherdate_backup.value = document.view_record.voucherdate.value;
                if (document.view_record.button_check.value !=0)
                        {

                                document.view_record.gotocheck.value = document.view_record.button_check.value;

                        }

                //document.view_record.voucherdate.value = "<?php echo date("Y-m-d") ?>";
                alert(document.view_record.voucherdate.value);
                var sendtopay1="http://technodome.org/payment_voucher.php?gotocheck="+document.view_record.gotocheck.value+"&shipname="+document.view_record.shipcargovalue.value+"&nameofship="+document.view_record.nameofshipcargo.value+"&clientname="+document.view_record.clientoldvalue.value+"&accountname="+document.view_record.clientoldname.value+"&balancetk="+document.view_record.balancetk.value+"&radiotest="+document.view_record.radiotest.value+"&departuredate="+document.view_record.departuredate.value+"&matone="+document.view_record.materialonevalue.value+"&matonename="+document.view_record.materialonename.value+"&mattwo="+document.view_record.materialtwovalue.value+"&mattwoname="+document.view_record.materialtwoname.value+"&fromloc="+document.view_record.fromvalue.value+"&toloc="+document.view_record.tovalue.value+"&fromlocname="+document.view_record.fromlocname.value+"&tolocname="+document.view_record.tolocname.value+"&shiptripid="+document.view_record.tripid.value+"&tkrate="+document.view_record.fairrate.value+"&tkratetwo="+document.view_record.fairratetwo.value+"&voucherdate="+document.view_record.voucherdate.value+"&voucherdate_backup="+document.view_record.voucherdate_backup.value+"&voucherid="+document.view_record.voucherid.value+"&payserial="+document.view_record.voucherno.value+"&paytype=Cash&setat=true&savecancel=false&filling=addbutton&returnfromviewship=true&seenbefore=1";
                alert(sendtopay1);
                opener.location= sendtopay1;
	        window.close();

        }



function return_oldvalue()
        {
	        document.view_record.filling.value = "viewcheck";
			document.view_record.voucherdate_backup.value = document.view_record.voucherdate.value;

                if (document.view_record.button_check.value !=0)
                        {

                                document.view_record.gotocheck.value = document.view_record.button_check.value;   ///????????????
                        }

                // document.view_record.voucherdate.value = "<?php echo date("Y-m-d") ?>";

                var sendtopay1="http://technodome.org/payment_voucher.php?gotocheck="+document.view_record.gotocheck.value+"&radiotest="+document.view_record.radiotest.value+"&shipname="+document.view_record.shipoldvalue.value+"&nameofship="+document.view_record.shipoldname.value+"&accountname="+document.view_record.clientoldname.value+"&clientname="+document.view_record.clientoldvalue.value+"&matone="+document.view_record.matoneoldvalue.value+"&mattwo="+document.view_record.mattwooldvalue.value+"&matonename="+document.view_record.oldmatonename.value+"&mattwoname="+document.view_record.oldmattwoname.value+"&fromloc="+document.view_record.oldfromlocvalue.value+"&toloc="+document.view_record.oldtolocvalue.value+"&fromlocname="+document.view_record.oldfromlocname.value+"&tolocname="+document.view_record.oldtolocname.value+"&voucherdate="+document.view_record.voucherdate.value+"&voucherdate_backup="+document.view_record.voucherdate_backup.value+"&voucherid="+document.view_record.voucherid.value+"&payserial="+document.view_record.voucherno.value+"&comment="+document.view_record.comment.value+"&through="+document.view_record.through.value+"&paylocation="+document.view_record.paylocation.value+"&departuredate="+document.view_record.olddeparturedate.value+"&paytype=Cash&setat=true&savecancel=false&filling=addbutton&returnfromviewship=true&seenbefore=1";     // I removed--if any problem--restore it--  "&departuredate="+document.view_record.departuredate.value+
                alert(sendtopay1);
                opener.location= sendtopay1;
	        window.close();

        }




</script>

</head>

<body bgcolor="#F5F5F5" text="#000000" background ="bkg.gif">
<form name = "view_record" action = "view_payment_cargo.php" method = "post">


<?php

        ////////////////query for voucherno///////////////////////////

        $year = substr($voucherdate,0,4); //date ("Y");
        echo "$year ye";
		$month = substr($voucherdate,5,2); //date("m") ;
		echo "$month mo";
        $vounumrows = 0;
        $vouresult = pg_exec("select max(voucher_no) from payment_voucher where ((date_part('year',pay_voucher_date)=$year) and (date_part('month',pay_voucher_date)=$month) ) ");   //
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
                        $voucherno = substr($voucherdate,0,4); //date("Y");

                        $voucherno .= substr($voucherdate,5,2);//date("m");
                        $voucherno .="001";
                        $voucherno =abs($voucherno);

                }

        else
                {
                        $vourow = pg_fetch_row($vouresult,0);
                        print("shamimmiraj");
                        $voucherno = abs($vourow[0]);
                        $voucherno = abs($voucherno);
                        $voucherno = $voucherno+1;
                }


        ////////////////end of query for voucherno///////////////////////////



        $balancetk_query_string = "select balance_tk from cargoschedule_part_advance_view where (ship_id ='$shipcargo' and balance_tk !=0) order by schedule_id";






                                                                                                                                                                                                                  
        $query_string2 = "select schedule_id,departure_date,ship_id,ship_name,account_id,account_name,from_id,from_loc,to_id,to_loc,mat_one,matone_name,quantity_one,fair_rate,mat_two,mattwo_name,quantity_two,fair_rate_two,pay_voucher_date,pay_location,advance_tk,part_tk,total_tk,balance_tk,trip_id,unload_date,money_fair_rate,receive_advance,receive_part,receive_total,receive_balance,mreceipt_date from cargoschedule_part_advance_view where (ship_id ='$shipcargo' and (balance_tk !=0 or balance_tk=NULL)) order by schedule_id";

        $result = pg_exec($query_string2);
        

        $column_count = pg_numfields($result);

        print ("<TABLE  border=1>\n");


        if (TRUE)
        {
                print ("<TR><th BGCOLOR=\"#aabf5c\">RECORD</th>");

                for ($column_num =1; $column_num<=$column_count; $column_num++)
                        {
                                $field_name= array('','Scdl id','Dpt.&nbsp;Date','Ship&nbsp;ID','Ship&nbsp;name','Account&nbsp;ID','Owner&nbsp;name','From&nbsp;ID','From','To&nbsp;ID','To','Matone&nbsp;ID','Matone','Quantity','Fair&nbsp;rate','Mattwo&nbsp;ID','Mattwo','Quantity','Fair&nbsp;rate','Voucher&nbsp;Date','Pay&nbsp;Location','Advance&nbsp;tk','Part&nbsp;tk','Total&nbsp;tk','Balance&nbsp;tk','Trip_id','UnloadD&nbsp;ate','Fair&nbsp;rate(receive)','Receive&nbsp;Advance','Receive&nbsp;Part','Receive&nbsp;Total','Receive&nbsp;Balance','Mreceipt&nbsp;Date');

                                print ("<TH> $field_name[$column_num]</TH>");
                        }

                print ("</TR>");
        }


//Print Body of the Table



$j=0;
$abc = 1;
//$button_check=5;


//while($row = pg_fetch_row($result, $i))
$numrows=pg_numrows($result);


if($numrows!=0 and (floor($row[22])!=0 or floor($row[22])==""))  ////  second condition has been added so that balance amount of 0.00XXXXX is not supposed to be shown or counted
{
        for($count=0,$button=1;$count<$numrows,$button<=$numrows;$button++,$count++)
        {

                $row = pg_fetch_row($result,$count);

                $color = ($button_check==$count ? "5fF9F0" : "E9E9E9");

                if ($button_check==$count )
                {
                        $balancetk = $row[23];
                        $departuredate = $row[1];
                        $shipcargovalue = $row[2];
                        $nameofshipcargo = $row[3];
                        $fromvalue = $row[6];
                        $fromlocname = $row[7];
                        $tovalue = $row[8];
                        $tolocname = $row[9];
                        $materialonevalue = $row[10];
                        $materialonename = $row[11];
                        $materialtwovalue = $row[14];
                        $materialtwoname = $row[15];
                        $paymenttkrate = $row[13];
                        $fairratetwo = $row[17];

// $payment_type = $row[];
                        $tripid = $row[24];
                        $fairrate= $row[13];

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


} // End of the condition if numrows is not zero


  else{

    $shipcargovalue = $shipoldvalue;
    $nameofshipcargo = $shipoldname;
    $fromvalue = $oldfromlocvalue;
    $tovalue =   $oldtolocvalue;
    $fromlocname = $oldfromlocname;
    $tolocname =   $oldtolocname;
    $materialonevalue = $matoneoldvalue;
    $materialtwovalue = $mattwooldvalue;
    $materialonename = $oldmatonename;
    $materialtwoname = $oldmattwoname;





  }



        print ("</Table>");




?>

<INPUT TYPE ="hidden" name ="radiotest" value ="<?php echo $radiotest ?>">

<INPUT TYPE="hidden" name="view_check" value="<?php echo $view_check  ?>">
<INPUT TYPE="hidden" name="button_check" value="<?php echo $button_check  ?>">
<INPUT TYPE="hidden" name="filling" value="eggplant">

<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >

<INPUT TYPE="hidden" name="balancetk" value="<?php echo $balancetk  ?>" >
<INPUT TYPE="hidden" name="departuredate" value="<?php echo $departuredate ?>">
<INPUT TYPE="hidden" name="voucherdate" value="<?php echo $voucherdate ?>">


<INPUT TYPE="hidden" name="shipcargo" value="<?php echo $shipcargo ?>">
<INPUT TYPE="hidden" name="shipcargovalue" value="<?php echo $shipcargovalue ?>">
<INPUT TYPE="hidden" name="nameofshipcargo" value="<?php echo $nameofshipcargo ?>">
<INPUT TYPE="hidden" name="shipoldvalue" value="<?php echo $shipoldvalue ?>">
<INPUT TYPE="hidden" name="shipoldname" value="<?php echo $shipoldname ?>">




<input type ="hidden" name ="oldmatonename" value="<?php echo $oldmatonename ?>">
<input type ="hidden" name ="oldmattwoname" value="<?php echo $oldmattwoname ?>">
<input type ="hidden" name ="matoneoldvalue" value="<?php echo $matoneoldvalue ?>">
<input type ="hidden" name ="mattwooldvalue" value="<?php echo $mattwooldvalue ?>">

<input type ="hidden" name ="payment_type" value="<?php echo $payment_type ?>">
<input type ="hidden" name ="ownervalue" value="<?php echo $ownervalue ?>">
<input type ="hidden" name ="clientoldname" value="<?php echo $clientoldname ?>">
<input type ="hidden" name ="clientoldvalue" value="<?php echo $clientoldvalue ?>">
<input type ="hidden" name ="materialonename" value="<?php echo $materialonename ?>">
<input type ="hidden" name ="materialtwoname" value="<?php echo $materialtwoname ?>">
<input type ="hidden" name ="materialonevalue" value="<?php echo $materialonevalue ?>">
<input type ="hidden" name ="materialtwovalue" value="<?php echo $materialtwovalue ?>">

<input type ="hidden" name ="oldfromlocname" value="<?php echo $oldfromlocname ?>">
<input type ="hidden" name ="oldtolocname" value="<?php echo $oldtolocname ?>">
<input type ="hidden" name ="oldfromlocvalue" value="<?php echo $oldfromlocvalue ?>">
<input type ="hidden" name ="oldtolocvalue" value="<?php echo $oldtolocvalue ?>">
<input type ="hidden" name ="fromvalue" value="<?php echo $fromvalue ?>">
<input type ="hidden" name ="tovalue" value="<?php echo $tovalue ?>">
<input type ="hidden" name ="fromlocname" value="<?php echo $fromlocname ?>">
<input type ="hidden" name ="tolocname" value="<?php echo $tolocname ?>">
<input type ="hidden" name ="oldtkrate" value="<?php echo $oldtkrate ?>">
<input type ="hidden" name ="oldtkratetwo" value="<?php echo $oldtkratetwo ?>">
<input type ="hidden" name ="tripid" value="<?php echo $tripid ?>">
<input type ="hidden" name ="fairrate" value="<?php echo $fairrate ?>">
<input type ="hidden" name ="fairratetwo" value="<?php echo $fairratetwo ?>">
<input type ="hidden" name ="voucherdate_backup" value="<?php echo $voucherdate_backup ?>">
<input type ="hidden" name ="voucherno" value="<?php echo $voucherno ?>">
<input type ="hidden" name ="voucherid" value="<?php echo $voucherid ?>">
<input type ="hidden" name ="comment" value="<?php echo $comment ?>">
<input type ="hidden" name ="paylocation" value="<?php echo $paylocation ?>">
<input type ="hidden" name ="through" value="<?php echo $through ?>">
<input type ="hidden" name ="olddeparturedate" value="<?php echo $olddeparturedate ?>">



<table align="center">
<tr>
<td width="16%" height="32" valign="baseline" align="center">
<input type="button" value="OK" name="okbutton" style=" width: 84; height: 25" onclick= "set_main()">
<input type="button" value="Cancel" name="cancelbutton" style=" width: 84; height: 25" onclick= "return_oldvalue()">

</td>
    </tr>
  </table>
</form>

<!--numrows("<?php echo $numrows ?>");
    accountid("<?php echo $clientoldvalue ?>");
    payfairrate("<?php echo $fairrate ?>");
    accountname("<?php echo $clientoldname ?>");
    gotocheck("<?php echo $gotocheck ?>");
    filling("<?php echo $filling ?> ");
    button_check("<?php echo $button_check ?> ");
    view_check("<?php echo $shipcargo ?> ");
    departure date("<?php echo $departuredate ?> ");
    balance taka("<?php echo $balancetk ?> ");
    -->

   <!--voucherno("<?php echo $voucherno,$month,$year,$vounumrows ?> ");
       shiptripid("<?php echo $tripid ?>")
       -->

</body>
</html>
