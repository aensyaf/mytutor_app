<?php
    error_reporting(0);
    include_once("dbconnect.php");

    $email = $_GET['email'];
    $mobile = $_GET['mobile'];
    $amount = $_GET['amount'];
    $name = $_GET['name'];

    $data = array(
        'id' =>  $_GET['billplz']['id'],
        'paid_at' => $_GET['billplz']['paid_at'] ,
        'paid' => $_GET['billplz']['paid'],
        'x_signature' => $_GET['billplz']['x_signature']
    );

    $paidstatus = $_GET['billplz']['paid'];
    if ($paidstatus=="true"){
        $paidstatus = "Success Payment";
        $status = "Paid";
    }else{
        $paidstatus = "Failed Payment";
        $status = "Failed";
    }

    $receiptid = $_GET['billplz']['id'];
    $signing = '';

    foreach ($data as $key => $value) {
        $signing.= 'billplz'.$key . $value;
        if ($key === 'paid') {
            break;
        } else {
            $signing .= '|';
        }
    }
    
    function printTable($receiptid,$name,$email,$amount,$paidstatus,$message){
    echo "
        <html>
        <head>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>
        </head>

        <div = class='w3-padding'> <h4>Thank you for your payment</h4>
        
        <p>The following is your receipt</p></div>
        
        <div class='w3-container w3-padding'>
            <table class='w3-table w3-striped w3-bordered'>
            <tr><th>Receipt ID</th><td>$receiptid<td></tr>
            <tr><th>Paid By</th><td>$name<td></tr>
            <tr><th>Email</th><td>$email<td></tr>
            <tr><th>Amount </th><td>RM $amount<td></tr>
            <tr><th>Payment Status</th><td>$paidstatus<td></tr>
            </table>
        <hr>
        <div class='w3-container w3-round w3-block w3-green'>$message</div>
        </div>
        </body>
        </html> 
        ";
    }
?>