<?php
$conn = mysqli_connect("localhost", "root", "", "beautics");
session_start();

if (isset($_SESSION['email']) && isset($_POST['check_login'])) {
    $username = $_SESSION['email'];
    $usertype = $_SESSION['usertype'];

    $sql = "SELECT * FROM tbluser WHERE email = '$username';";
    $result = $conn->query($sql);
    $options = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row;
        }
    }
    $conn->close();
    echo json_encode($options);
}
 else if (isset($_POST['logout'])) {
    unset($_SESSION['email']);
    unset($_SESSION['usertype']);
    session_destroy();
    // Delete cookies
    setcookie("username", "", time() - 3600, "/");
    setcookie("password", "", time() - 3600, "/");
    echo json_encode(["status" => "logout"]);
} else {
    echo json_encode(["status" => "not_logged_in"]);
}
?>
