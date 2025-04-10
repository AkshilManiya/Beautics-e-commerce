<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

$uploadDir = 'C:/xampp/htdocs/Beautics/static/system_img/variants/';
function uploadImageAndInsert($imageFile, $uploadDir) {    
    $tmpName = $imageFile['tmp_name'];
    $fileName = basename($imageFile['name']);
    $destPath = $uploadDir . $fileName;
    if (move_uploaded_file($tmpName, $destPath)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['search'])) {
    $conditions = [];

    // Check if category ID is set
    if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $conditions[] = "tblcategory.Category_id = $category_id";
    }

    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $conditions[] = "tblproduct.Product_id = $product_id";
    }

    // Check if product name is set
    if (isset($_POST['color_name']) && !empty($_POST['color_name'])) {
        $color_name = $conn->real_escape_string($_POST['color_name']);
        $conditions[] = "tblcolor.color_name LIKE '%$color_name%'";
    }

    // Check if ingredients are set
    if (isset($_POST['amount_type']) && !empty($_POST['amount_type'])) {
        $amount_type = $conn->real_escape_string($_POST['amount_type']);
        $conditions[] = "tblvariants.amount_type LIKE '%$amount_type%'";
    }
    
    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "tblvariants.active = $status";
    }

    $sql = "SELECT tblcategory.Category_id, tblcategory.category_name, tblproduct.Product_id, tblproduct.product_name, tblcolor.code, tblcolor.color_name, tblvariants.* FROM tblVariants JOIN tblProduct ON tblvariants.product_id = tblproduct.Product_id JOIN tblCategory ON tblproduct.category_id = tblcategory.Category_id JOIN tblColor ON tblvariants.color_id = tblcolor.Color_id WHERE tblvariants.is_disabled = 0";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }
    // echo $sql;
    // return ;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Variant_id'] . "</td>";
            echo "<td>" . $row['category_name'] . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td><div style='display:flex; gap:10;'><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div><div>" . $row['color_name'] . "</div></div></td>";

            echo "<td>" . $row['amount_type'] . "</td>";
            echo "<td>" . $row['amount_value'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td><img class='tbl-img' src='/Beautics/static/system_img/variants/" . $row['img_path']. "' alt='image'></td>";

            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['Variant_id'] . ")'>Deactivate</button>" 
                : "<button class='active' onclick='Deactive(" . $row['Variant_id'] . ")'>Activate</button>") . "</td>";

            echo "<td><button class='update-click' onclick='show_update(" 
                . $row['Variant_id'] . ", \"" 
                . $row['category_id'] . "\", \"" 
                . $row['product_id'] . "\", \"" 
                . $row['color_id'] . "\", \"" 
                . $row['amount_type'] . "\", \"" 
                . $row['amount_value'] . "\", \"" 
                . $row['price'] . "\", \"" 
                . $row['quantity'] . "\", \"" 
                . $row['img_path'] . "\")'>Update</button></td>";

            echo "<td><button class='delete-click' onclick='delete_variant(" . $row['Variant_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No records found</td></tr>";
    }
    $conn->close();
}
else if (isset($_POST['insert'])) {
    if (uploadImageAndInsert($_FILES['image'], $uploadDir)) {
        $product_id = $_POST['product'];
        $color_id = $_POST['color'];
        $amount_type = $_POST['type'];
        $amount_value = $_POST['amount'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $imageName = basename($_FILES['image']['name']);

        $sql = "INSERT INTO tblvariants 
                (product_id, color_id, amount_type, amount_value, price, quantity, img_path, active, is_disabled) 
                VALUES 
                ('$product_id', '$color_id', '$amount_type', '$amount_value', '$price', '$quantity', '$imageName', 1, 0)";

        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Operation failed.";
    }
}
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_id = $_POST['product'];
    $color_id = $_POST['color'];
    $amount_type = $_POST['type'];
    $amount_value = $_POST['amount'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $imageName = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        if (uploadImageAndInsert($_FILES['image'], $uploadDir)) {
            $imageName = basename($_FILES['image']['name']); 
        } else {
            echo "Error: Image upload failed.";
            exit;
        }
    }

    if ($imageName) {
        $sql = "UPDATE tblvariants 
                SET product_id = '$product_id', color_id = '$color_id', amount_type = '$amount_type', amount_value = '$amount_value', 
                    price = '$price', quantity = '$quantity', img_path = '$imageName' 
                WHERE Variant_id = '$id'";
    } else {
        $sql = "UPDATE tblvariants 
                SET product_id = '$product_id', color_id = '$color_id', amount_type = '$amount_type', amount_value = '$amount_value', 
                    price = '$price', quantity = '$quantity' 
                WHERE Variant_id = '$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "update tblvariants set is_disabled=1 WHERE Variant_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblvariants SET active=0 WHERE Variant_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblvariants SET active=1 WHERE Variant_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
