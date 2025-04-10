<?php
$conn = mysqli_connect("localhost", "root", "", "beautics");

session_start();
$email = $_SESSION['email'];

if (isset($_POST['fetch_profile'])) {
    $sql = "SELECT tbluser.*, tblcity.city_name, tblstate.state_name FROM tbluser JOIN tblcity ON tbluser.city_id = tblcity.City_id JOIN tblstate ON tblcity.State_id = tblstate.State_id WHERE tbluser.email = '$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userData = [
            'id' => $row['User_id'],
            'image' => $row['profile_img'],
            'name' => $row['name'],
            'conno' => $row['contact'],
            'email' => $row['email'],
            'flat_number' => $row['flat_number'],
            'floor_number' => $row['floor_number'],
            'building_name' => $row['building_name'],
            'road_street' => $row['road_street'],
            'pincode' => $row['pincode'],
            'gender' => $row['gender'],
            'city' => $row['city_name'],
            'state' => $row['state_name'],
        ];
        echo json_encode($userData);
    } else {
        echo "User not found.";
    }
    $conn->close();
} else if (isset($_POST['update_profile'])) {
    $newName = $_POST['name'];
    $newContact = $_POST['contact'];
    $newGender = $_POST['gender'];
    $flat_number = $_POST['flat'];
    $floor_number = $_POST['floor'];
    $building_name = $_POST['building'];
    $road_street = $_POST['road'];
    $pincode = $_POST['pincode'];
    $newCity = $_POST['city'];
    $id = $_POST['id'];

    $sql = "UPDATE tbluser SET 
                    name='$newName',
                    contact='$newContact',
                    gender='$newGender',
                    flat_number = '$flat_number',
                    floor_number = '$floor_number',
                    building_name = '$building_name',
                    road_street = '$road_street',
                    pincode = '$pincode',
                    city_id='$newCity' WHERE User_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    $conn->close();
} else if (isset($_POST['new'])){
    $old = $_POST['old'];
    $new = $_POST['new'];
    $id = $_POST['id'];

    $sql = "SELECT password FROM tbluser WHERE User_id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPassword = $row['password'];
        if (password_verify($old, $currentPassword)) {
            $updateSql = "UPDATE tbluser SET password='$new' WHERE User_id='$id'";
            if (mysqli_query($conn, $updateSql)) {
                echo "success";  // Password updated successfully
            } else {
                echo "error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "old";  // Old password is incorrect
        }
    } else {
        echo "error fetching user data: " . mysqli_error($conn);
    }
}
?>
