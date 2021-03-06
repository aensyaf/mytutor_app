<?php
    if(!isset($_POST)){
        $response = array('status'=> 'failed', 'data' => null);
        sendJsonResponse($response);
        die();
    }

    include_once("dbconnect.php");
    $subid = $_POST['subjectid'];
    $email = $_POST['email'];
    $cartqty = "1";
    $carttotal = 0;
    $sqlinsert = "SELECT * FROM tbl_carts WHERE user_email = '$email' AND subj_id = '$subid'";
    $result = $conn->query($sqlinsert);
    $number_of_result = $result->num_rows;

    if($number_of_result>0){
        while($row = $result->fetch_assoc()) {
            $cartqty = $row['cart_quan'];
        }
        $cartqty = $cartqty+1;
        
        $updatecart = "UPDATE `tbl_carts` SET `cart_quan`='$cartqty' WHERE user_email='$email' AND subj_id='$subid' AND cart_status IS NULL";
        $conn->query($updatecart);
    }
    else{
        $addcart = "INSERT INTO `tbl_carts`(`subj_id`, `user_email`, `cart_quan`) VALUES ('$subid','$email','$cartqty')";
        if($conn->query($addcart)===TRUE){

        }else{
            $response = array('status' => 'failed', 'data'=>null);
            sendJsonResponse($response);
            return;
        }
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
    $response = array('status' => 'success', 'data'=>$mycart);
    sendJsonResponse($response);

    function sendJsonResponse($sentArray){
        header('Content-Type: application/json');
        echo json_encode($sentArray);
    }
?>