<?php
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['product'])) {
    $cat_id = $_POST['cat_id'];
    if ($cat_id == 0){
        $sql = "SELECT p.*, v.price, v.img_path FROM tblProduct p LEFT JOIN (SELECT Variant_id, product_id, price, img_path FROM tblVariants WHERE active = 1 AND is_disabled = 0 GROUP BY product_id ORDER BY Variant_id ASC ) v ON p.Product_id = v.product_id WHERE p.active = 1 AND p.is_disabled = 0 GROUP BY p.Product_id;";
    }
    else{
        $sql = "SELECT p.*, v.price, v.img_path FROM tblProduct p LEFT JOIN (SELECT Variant_id, product_id, price, img_path FROM tblVariants WHERE active = 1 AND is_disabled = 0 GROUP BY product_id ORDER BY Variant_id ASC ) v ON p.Product_id = v.product_id WHERE p.active = 1 AND p.category_id=$cat_id AND p.is_disabled = 0 GROUP BY p.Product_id;";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product' onclick=\"window.location.href='Description.php?product=".$row['Product_id']."'\">";
            echo "<div><img src='/Beautics/static/system_img/variants/" . $row['img_path'] . "' alt='Product img' style='width:150px;height:150px;'></div>"; // Image
            echo "<div class='desc'><div><b>Product Name: </b>" . $row['product_name'] . "</div>"; // Product Name
            echo "<div><b>Description:</b> " . $row['description'] . "</div>"; // Product Description
            echo "<div><b>Ingredients:</b> " . $row['ingredients'] . "</div>"; // Product Ingredients
            echo "<div><b>Price:</b> $" . $row['price'] . "</div>"; // Product Price
            echo "</div></div>";
        }
    } else {
        echo "<div>No products found.</div>";
    }
    $conn->close();
}
?>
