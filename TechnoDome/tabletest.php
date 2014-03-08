<?php
// required variables
require("config.php");
 ?>


<?php

// connects to database
$conn=pg_connect("host=localhost  dbname=riverine user=postgres ");


function display_query($query_string, $connection,$header, $table_params)
{
 $result = pg_exec($query_string);

 $column_count = pg_numfields($result);
 
print ("<TABLE $table_params>\n");



if ($header)
{
  print ("<TR>");
  for ( $column_num =0 ;  $column_num  <  $column_count  ;  $column_num++)
    { 
      $field_name =  pg_fieldname($result, $column_num);
//print (?<TH> $field_name</TH>?);
     }
 
print ("</TR>");
}

//Print Body of the Table
$i = 0; 
//$abc= <input type="button? value="Exit?  style=? width: 84; height: 25?>;
while ( $row = pg_fetch_row($result,$i) )
{
 echo"<TR align = left  valign = top><TD><input type="button? value="Exit?  style=? width: 84; height: 25?></TD>"

for ($column_num =0 ; $column_num < $column_count +1; $column_num++)
	{
		print("<TD>$row[$column_num]</TD>");
	}
	


		

print ("</TR>\n"); 
	++$i;
       }
	
print ("</Table>");
}




function display_table($tablename, $connection,$header, $table_params)
{
	$query_string = "select  *  from  $tablename";
	display_query ($query_string, $connection, $header, $table_params);
}

?>





<html>

<head>

<title>Product list</title>

<style>

A:Link {color:000000;text-decoration:none;}

A:Visited {color:000000;text-decoration:none;}

A:Hover {color:F70404;text-decoration:underline;}

</style>

</HEAD>

<BODY TEXT="#000000" BGCOLOR="#FFFFFF" LINK="#000000" VLINK="#000000" ALINK="#F70404">
display_table("accounts", $conn, TRUE, "BORDER=1");
</body>
</html>

