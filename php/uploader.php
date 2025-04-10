<?php
$conn = mysqli_connect("localhost", "root", "", "beautics");


if (isset($_FILES['image']) && isset($_POST['id'])) {
    $userId = $_POST['id'];  // Get user ID
    $imageName = basename($_FILES['image']['name']); // Get just the image name
    $imageTmpName = $_FILES['image']['tmp_name'];
    
    $uploadDir = 'C:/xampp/htdocs/Beautics/static/system_img/profile/';
    $uploadFile = $uploadDir . $imageName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($imageTmpName, $uploadFile)) {
        $sql = "UPDATE tbluser SET profile_img='$imageName' WHERE User_id='$userId'";
        
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "error updating database: " . mysqli_error($conn);
        }
    } else {
        echo "error uploading file";
    }
}
?>
