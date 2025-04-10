<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "beautics");


if (isset($_POST['order_confirm'])){
    $variantId = $_POST['variant'];
    $totalAmount = $_POST['toalamount'];
    $quantity = $_POST['quantity'];
    $userId = $_POST['user']; 
    $paymentMethod = 'Online'; 
    $orderDate = date("Y-m-d");
    $paymentDate = date("Y-m-d H:i:s");

    $sqlOrder = "INSERT INTO tblOrder (variant_id, user_id, quantity, total_price, order_date, status) VALUES ($variantId, $userId, $quantity, $totalAmount, '$orderDate', 'Paid')";
    if ($conn->query($sqlOrder) === TRUE) {
        $orderId = $conn->insert_id;
        $sql = "INSERT INTO tblPayment (order_id, payment_method, payment_amount, payment_date) VALUES ($orderId, '$paymentMethod', $totalAmount, '$paymentDate')";
        if (mysqli_query($conn, $sql)) {
            $sql = "update tblvariants set quantity=quantity-$quantity WHERE Variant_id='$variantId'";
            if (mysqli_query($conn, $sql)) {
                echo "success";
            } else {
                echo mysqli_error($conn);
            }
        } else {
            echo mysqli_error($conn);
        }
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
} else if (isset($_POST['variant'])) {
    $variantId = $_POST['variant'];
    $sql = "SELECT tblvariants.*,tblcolor.*, tblproduct.* from tblvariants join tblcolor on tblcolor.Color_id=tblvariants.color_id join tblproduct on tblproduct.Product_id=tblvariants.product_id where Variant_id=$variantId";
    $result = $conn->query($sql);
    $options = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row;
        }
    }
    $conn->close();
    echo json_encode($options);
} else if (isset($_POST['user'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT tbluser.*, tblcity.*, tblstate.* from tbluser join tblcity on tblcity.City_id =  tbluser.city_id join tblstate on tblstate.State_id=tblcity.state_id where tbluser.email='$email';";
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
?>
