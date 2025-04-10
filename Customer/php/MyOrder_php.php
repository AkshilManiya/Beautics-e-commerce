<?php
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['fetch_orders'])) {
    $sql = "select tblorder.*, tblvariants.*, tblproduct.*, tblorder.quantity as quan from tblorder join tbluser on tbluser.User_id= tblorder.user_id join tblvariants on tblvariants.Variant_id=tblorder.variant_id join tblproduct on tblproduct.Product_id=tblvariants.product_id where tbluser.email='$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product' onclick=\"window.location.href='Myorder.php?order=".$row['Order_id']."'\">";
            echo "<div><img src='/Beautics/static/system_img/variants/" . $row['img_path'] . "' alt='Product img' style='width:150px;height:150px;'></div>"; // Image
            echo "<div class='desc'><div>Product Name: " . $row['product_name'] . "</div>"; // Product Name
            echo "<div>Order Date: " . $row['order_date'] . "</div>"; // Product Description
            echo "<div>Quantity: " . $row['quan'] . "</div>"; // Product Ingredients
            echo "<div>Total Amount: $" . $row['total_price'] . "</div>"; // Product Price
            echo "</div></div>";
        }
    } else {
        echo "<div>No products found.</div>";
    }
    $conn->close();
}
else if (isset($_POST['order'])) {
    $orderId = $_POST['order'];
    $sql = "select tblorder.*, tblvariants.*, tblproduct.*,tbluser.*,tblstate.state_name,tblcity.city_name,tblorder.quantity as quan, tblcolor.color_name from tblorder join tbluser on tbluser.User_id= tblorder.user_id join tblcity on tblcity.City_id =  tbluser.city_id join tblstate on tblstate.State_id=tblcity.state_id join tblvariants on tblvariants.Variant_id=tblorder.variant_id join tblcolor on tblcolor.color_id=tblvariants.Color_id join tblproduct on tblproduct.Product_id=tblvariants.product_id where tblorder.Order_id='$orderId';";
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
