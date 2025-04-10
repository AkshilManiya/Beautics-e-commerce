<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['search'])) {
    $conditions = [];

    // Check if category ID is set
    if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $conditions[] = "tblcategory.Category_id = $category_id";
    }

    // Check if product name is set
    if (isset($_POST['product_name']) && !empty($_POST['product_name'])) {
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $conditions[] = "tblproduct.product_name LIKE '%$product_name%'";
    }

    // Check if ingredients are set
    if (isset($_POST['ingredients']) && !empty($_POST['ingredients'])) {
        $ingredients = $conn->real_escape_string($_POST['ingredients']);
        $conditions[] = "tblproduct.ingredients LIKE '%$ingredients%'";
    }

    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "tblproduct.active = $status";
    }

    $sql = "SELECT tblproduct.*, tblcategory.category_name, tblcategory.Category_id FROM tblproduct join tblcategory on tblcategory.Category_id=tblproduct.category_id where tblproduct.is_disabled=0";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Product_id'] . "</td>";
            echo "<td>" . $row['category_name'] . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['ingredients'] . "</td>";
    
            // Active/Deactive button
            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['Product_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['Product_id'] . ")'>Active</button>") . "</td>";
    
            // Update button
            echo "<td><button class='update-click' onclick='show_update(" 
                . $row['Product_id'] . ", \"" 
                . $row['category_id'] . "\", \"" 
                . $row['product_name'] . "\", \"" 
                . $row['description'] . "\", \""
                . $row['ingredients'] . "\")'>Update</button></td>";
    
            // Delete button
            echo "<td><button  class='delete-click' onclick='delete_product(" . $row['Product_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No records found</td></tr>";
    }
    
    $conn->close();
}
else if (isset($_POST['insert'])) {
    $productName = $_POST['prodname'];
    $description = $_POST['desc'];
    $ingredients = $_POST['ingredients'];
    $category = $_POST['category'];

    $sql = "SELECT tblproduct.*, tblcategory.category_name, tblcategory.Category_id FROM tblproduct join tblcategory on tblcategory.Category_id=tblproduct.category_id where tblproduct.is_disabled=0 And tblproduct.product_name='$productName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "prodname";
        exit;
    }

    $sql = "INSERT INTO tblProduct VALUES (NULL, '$productName', '$description', '$ingredients', '$category', 1, 0)";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo mysqli_error($conn);
    }
} 
else if (isset($_POST['update'])) {    
    $id = $_POST['id'];
    $productName = $_POST['prodname'];
    $description = $_POST['desc'];
    $ingredients = $_POST['ingredients'];
    $category = $_POST['category'];

    $sql = "SELECT tblproduct.*, tblcategory.category_name, tblcategory.Category_id FROM tblproduct join tblcategory on tblcategory.Category_id=tblproduct.category_id where tblproduct.is_disabled=0 And tblproduct.product_name='$productName' And tblproduct.Product_id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "prodname";
        exit;
    }

    $sql = "UPDATE tblProduct 
            SET product_name = '$productName', 
                description = '$description', 
                ingredients = '$ingredients', 
                category_id = '$category' 
            WHERE Product_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo mysqli_error($conn);
    }
}

else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblproduct WHERE Product_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblproduct SET active=0 WHERE Product_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblproduct SET active=1 WHERE Product_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
