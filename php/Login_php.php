<?php
$conn = mysqli_connect("localhost", "root", "", "beautics");
session_start();


function return_page($usertype){
    if ($usertype == "Customer") {
        return "/Beautics/Customer/customer_home.php";
    } else if ($usertype == "Staff") {
        return "/Beautics/Staff/staff_home.php";
    } else if($usertype == "Admin"){
        return "/Beautics/Admin/admin_home.php";
    }
}

if (isset($_POST['Login'])) {
    $user = $_POST['email'];
    $pass = $_POST['password'];
    $rem = $_POST['rem'];

    $sqlview = "SELECT * FROM tbluser WHERE email = '$user'";
    $result = mysqli_query($conn, $sqlview);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $username = $row[3];
            $hash = $row[4];
            $usertype = $row[13];
            $verify = password_verify($pass, $hash);
            if ($verify) {
                $_SESSION['email'] = $username;
                $_SESSION['usertype'] = $usertype;
                if ($rem) {
                    setcookie("username", "$username", time() + 3600, "/", "", 0);
                    setcookie("password", "$pass", time() + 3600, "/", "", 0);
                }
                echo return_page($usertype);
                exit;
            } else {
                echo 'error password';
            }
        }
    } else {
        echo 'error account';
    }
} else if (isset($_POST['cookie'])) {
    $user = $_COOKIE['username'];
    $pass = $_COOKIE['password'];
    $sqlview = "SELECT * FROM tbluser WHERE email = '$user'";
    $result = mysqli_query($conn, $sqlview);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $username = $row[3];
            $hash = $row[4];
            $usertype = $row[13];
            $verify = password_verify($pass, $hash);
            if ($verify) {
                $_SESSION['email'] = $username;
                $_SESSION['usertype'] = $usertype;
                echo return_page($usertype);
            } else {
                echo 'error';
            }
        }
    } else {
        echo 'error';
    }
}
if (isset($_GET['hash'])){
    $password = $_GET['hash'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo $hash;
}
?>