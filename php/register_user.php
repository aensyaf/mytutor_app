<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}


include_once("dbconnect.php");
      $name = $_POST["name"];
      $email = $_POST["email"];
      $phoneno = $_POST["phoneno"];
      $address = $_POST["address"];
      $password = sha1($_POST["password"]);
      $sqlinsert = "INSERT INTO `tbl_users`(`user_name`, `user_email`, `user_phoneno`, `user_address`, `user_pass`) VALUES ('$name','$email','$phoneno','$address','$password')";


if ($conn->query($sqlinsert)===TRUE) {
    $response = array('status' => 'success', 'data' => null);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>