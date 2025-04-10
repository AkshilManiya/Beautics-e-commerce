<?php
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['product'])) {
    $productId = $_POST['product'];
    $sql = "SELECT * from tblproduct WHERE Product_id = $productId";
    $result = $conn->query($sql);
    $options = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row;
        }
    }
    $conn->close();
    echo json_encode($options);
}else if (isset($_POST['colors'])) {
    $productId = $_POST['colors'];
    $sql = "SELECT DISTINCT c.* FROM tblVariants v JOIN tblColor c ON v.color_id = c.Color_id WHERE v.product_id = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            if ($i == 1){
                echo "<script> fetch_amounts(" . $row['Color_id'] . "); </script>";
            }
            echo "<div class='color' onclick='fetch_amounts(" . $row['Color_id'] . ")'><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div></div>";
            $i++;
        }
    } else {
        echo "<div>No products found.</div>";
    }
    $conn->close();
}
else if (isset($_POST['amounts'])) {
    $productId = $_POST['amounts'];
    $color = $_POST['color'];
    $sql = "SELECT v.* FROM tblVariants v JOIN tblColor c ON v.color_id = c.Color_id WHERE v.product_id = $productId AND c.Color_id=$color";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            if ($i == 1){
                echo "<script> updateProductImage(".$row['Variant_id'].",\"" . htmlspecialchars($row['img_path']) . "\"); </script>";
            }
            echo "  
                <div class='amount' onclick='updateProductImage(".$row['Variant_id'].",\"" . htmlspecialchars($row['img_path']) . "\")'>
                    <div>" . $row['amount_value'] . "  " . $row['amount_type'] . "</div>
                    <div><b>₹" . $row['price'] . "</b></div>
                </div>
            ";
            $i++;
        }
    } else {
        echo "<div>No amounts found for this color.</div>";
    }
    $conn->close();
}
else if (isset($_POST['check_varid'])){
    $variantId = $_POST['check_varid'];

    $cartQuery = "SELECT COUNT(*) AS in_cart FROM tblCart join tbluser on tbluser.User_id=tblcart.user_id WHERE tblcart.variant_id = $variantId AND tbluser.email = '$email';";
    $cartResult = $conn->query($cartQuery);
    $inCart = $cartResult->fetch_assoc()['in_cart'];

    // Query to check if the variant ID is in the user's wishlist
    $wishlistQuery = "SELECT COUNT(*) AS in_wishlist FROM tblwishlist join tbluser on tbluser.User_id=tblwishlist.user_id WHERE tblwishlist.variant_id = $variantId AND tbluser.email = '$email';";
    $wishlistResult = $conn->query($wishlistQuery);
    $inWishlist = $wishlistResult->fetch_assoc()['in_wishlist'];

    // Return JSON response
    echo json_encode([
        'in_cart' => $inCart > 0,
        'in_wishlist' => $inWishlist > 0
    ]);
}
?>
