<?php
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");


if (isset($_POST['add_to_cart'])) {
    $varId = $_POST['add_to_cart'];
    $sql = "SELECT * from tblcart WHERE variant_id = $varId and user_id = (SELECT User_id FROM tbluser WHERE email = '$email')";
    $result = $conn->query($sql);
    $options = array();
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO tblCart VALUES (NULL, $varId, (SELECT User_id FROM tbluser WHERE email = '$email'))";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
    }
    $conn->close();
}
else if (isset($_POST['cart'])) {    
    $sql = "SELECT tblvariants.*, tblcart.*,tblcolor.code, tblproduct.product_name from tblcart join tblvariants on tblvariants.Variant_id=tblcart.variant_id join tblcolor on tblcolor.Color_id=tblvariants.color_id join tblproduct on tblproduct.Product_id=tblvariants.product_id WHERE user_id = (SELECT User_id FROM tbluser WHERE email = '$email')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='cart'>";
                echo "<img src='/Beautics/static/system_img/variants/" . htmlspecialchars($row['img_path']) . "' alt='Product Image'>";
                echo "<div>";
                    echo "<div>" . $row['product_name'] . "</div>";
                    echo "<div><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div></div>";
                    echo "<div>" . $row['amount_value'] . " " . $row['amount_type'] . "</div>";
                    echo "<div>$" . $row['price'] . "</div>";
                    echo "<div><button class='delete-click' onclick='delete_Cart(" . $row['Cart_id'] . ")'>Delete</button></div>";
                echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div>No cart found.</div>";
    }
    $conn->close();
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblcart WHERE Cart_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>