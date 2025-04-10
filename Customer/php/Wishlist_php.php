<?php
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['add_to_wishlist'])) {
    $varId = $_POST['add_to_wishlist'];
    $sql = "SELECT * from tblwishlist WHERE variant_id = $varId and user_id = (SELECT User_id FROM tbluser WHERE email = '$email')";
    $result = $conn->query($sql);
    $options = array();
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO tblwishlist VALUES (NULL, $varId, (SELECT User_id FROM tbluser WHERE email = '$email'))";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
    }
    $conn->close();
}
else if (isset($_POST['wishlist'])) {    
    $sql = "SELECT tblvariants.*, tblwishlist.*,tblcolor.code, tblproduct.product_name from tblwishlist join tblvariants on tblvariants.Variant_id=tblwishlist.variant_id join tblcolor on tblcolor.Color_id=tblvariants.color_id join tblproduct on tblproduct.Product_id=tblvariants.product_id WHERE user_id = (SELECT User_id FROM tbluser WHERE email = '$email')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='wishlist'>";
                echo "<div><img src='/Beautics/static/system_img/variants/" . htmlspecialchars($row['img_path']) . "' alt='Product Image'></div>";
                echo "<div>";
                    echo "<div>" . $row['product_name'] . "</div>";
                    echo "<div><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div></div>";
                    echo "<div>" . $row['amount_value'] . " " . $row['amount_type'] . "</div>";
                    echo "<div>$" . $row['price'] . "</div>";
                    echo "<div><button class='delete-click' onclick='delete_Wishlist(" . $row['Wishlist_id'] . ")'>Delete</button></div>";
                echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div>No wishlist found.</div>";
    }
    $conn->close();
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblwishlist WHERE Wishlist_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>