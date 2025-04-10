<?php

$conn = mysqli_connect("localhost", "root", "", "beautics");

function check_email($email, $conn) {
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM tbluser WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;  // Email exists
    } else {
        return false;  // Email doesn't exist
    }
}


if (isset($_POST['Register'])){
    $username =  $_POST['username'];
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $city =  $_POST['city'];
    $gender = $_POST['gender'];
    $conno =  $_POST['conno'];
    
    if (!check_email($email, $conn)){
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $insert = "INSERT INTO tblUser (name, contact, email, password, gender, city_id, role, active, is_disabled) 
                   VALUES ('$username', '$conno', '$email', '$hash', '$gender', $city, 'Customer', TRUE, FALSE);";
        // echo $insert;
        if (mysqli_query($conn, $insert)) {
            echo "success";
        } else {
            echo "error";
        }
    }
    else{
        echo "exist";
    }
}

?>