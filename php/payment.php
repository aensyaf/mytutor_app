<?php
    $email = $_GET['email'];
    $mobile = $_GET['phoneno'];
    $name = $_GET['user_name'];
    $amount = $_GET['amount'];

    $api_key = '';
    $collection_id ='';

    $host = '';

    $data = array(
        'collection_id' => $collection_id,
        'email' => $email,
        'mobile' => $mobile,
        'name' => $name,
        'amount' => ($amount+1) *100,
        'description' => 'Payment for order by '.$name,
        'callback_url' => "",
        'redirect_url' => "",
    );

    $process = curl_init($host);
    curl_setopt($process, CURLOPT_HEADER, 0);
    curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($process, CURLOPT_POSTFIELDS, ($data));

    $return = curl_excel($process);
    curl_close($process);

    $bill = json_decode($return, true);
    header("Location: {$bill['url']}");
?>