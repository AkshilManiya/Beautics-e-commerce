<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendOTP($to, $msg) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;
        $mail->Username = 'ABC@gmail.com'; // sender
        $mail->Password = ''; // password of sender
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ABC@gmail.com', 'Beautics');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Beautics - otp';
        $mail->Body = $msg;

        $mail->send();
    } catch (Exception $e) {
        echo "error";
    }
}

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;
        $otp = rand(100000, 999999);
        sendOTP($email, OTP_Html($otp));
        $_SESSION['otp'] = $otp;
    }
}

if(isset($_GET['email'])){
    $email = $_GET['email'];
    $data = $_GET['data'];
    sendOTP($email, OTP_Html($data));
    echo "success";
}

function OTP_html($otp){
    $OTP_Html = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px 50px;
                    background-color: #fff;
                    background-image: linear-gradient(to bottom right, #7a8ee4c9, #d3208bc5, #fda000c0);
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header h1 {
                    color: #1900ff;
                    margin: 10px 0;
                }
                .content {
                    margin-bottom: 20px;
                }
                .content p {
                    font-size: 16px;
                    line-height: 1.5;
                    color: #333;
                }
                .otp {
                    font-size: 35px;
                    font-weight: bold;
                    color: #0400ff;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .footer {
                    text-align: center;
                }
                .footer p {
                    font-size: 14px;
                    color: #666;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Email Verification</h1>
                </div>
                <div class="content">
                    <p>Dear User,</p>
                    <p>Your One-Time Password (OTP) is:</p>
                    <p class="otp">' . $otp . '</p>
                    <p>Please use this OTP to proceed with your action.</p>
                </div>
                <div class="footer">
                    <p>Regards,<br>Beacutics Team</p>
                </div>
            </div>
        </body>
        </html>
    ';
    return $OTP_Html;
}

?>