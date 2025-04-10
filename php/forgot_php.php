<?php
include '../Customer/php/Register_php.php';
include '../send_otp.php';


// session_start();
$conn = mysqli_connect("localhost", "root", "", "beautics");



if (isset($_POST['email_check'])) {
    $email = $_POST['email'];
    echo check_email($email, $conn);
} 
else if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $otp = rand(100000, 999999);
    $msg = "Your OTP : $otp";
    sendOTP($email, $msg);
    $_SESSION['otp'] = $otp;
    echo $otp;
} 
else if (isset($_POST['check_otp'])) {
    $enteredOTP = $_POST['enteredOTP'];
    $expectedOTP = $_SESSION['otp'];
    if ($enteredOTP == $expectedOTP) {
        echo "true";
    } else {
        echo "false";
    }
} 
else if (isset($_POST['forgot_set'])){
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $update = "update tbluser set password='$hash' where email='$email';";
    if (mysqli_query($conn, $update)) {
        echo "success";
    } else {
        echo "error";
    }

}


?>