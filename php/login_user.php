<?php
    if(!isset($_POST)){
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
        die();
    }

    include_once("dbconnect.php");
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $sqllogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_pass = '$password'";
    $result = $conn->query($sqllogin);
    $numrow = $result->num_rows;

    if($numrow > 0){
        while($row = $result->fetch_assoc()) {
            $user['id'] = $row['user_id'];
            $user['email'] = $row['user_email'];
            $user['name'] = $row['user_name'];
            $user['phoneno'] = $row['user_phoneno'];
            $user['address'] = $row['user_address'];
        }
        $sqlgetquan = "SELECT * FROM tbl_carts WHERE user_email = '$email' AND cart_status IS NULL";
        $result = $conn->query($sqlgetquan);
        $number_of_result = $result->num_rows;
        $carttotal = 0;
        while($row = $result->fetch_assoc()){
            $carttotal=$row['cart_quan'] + $carttotal;
        }
        $mycart = array();
        $mycart['carttotal'] = $carttotal;
        $response = array('status' => 'success', 'data'=>$user);
        sendJsonResponse($response);
        //$response = array('status' => 'success', 'data' => $user);
        //sendJsonResponse($response);
    }else{
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }

    function sendJsonResponse($sentArray){
        header('Content-Type: application/json');
        echo json_encode($sentArray);
    }
?>