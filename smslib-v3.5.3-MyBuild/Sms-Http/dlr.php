<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$_GET['s']="Test";
$_GET['gatewayId']="gatewayId";
$_GET['text']="text";
$_GET['from']='from';
$_GET['refNo']='RefNo';
?>
<!Doctype html>

<head><title>SMSServer HTTP Page</title></head>
<body>
<center><h1>SMSServer HTTP Page</h1><br></center>
       
    <a href="test1.php"></a>
    <h1><?php echo $_GET['s'];?></h1>
    <center> <strong>Gateway Id: </strong> <?php echo $_GET['gatewayId']; ?><br> 
    <strong>SMS Text: </strong><?php echo $_GET['text'];?><br>
        <strong>From: </strong> <?php echo $_GET['from'];?><br>
    
    <strong>Reference No: </strong><?php echo $_GET['refNo'];?>
    </center>

    
</body>
<html>
