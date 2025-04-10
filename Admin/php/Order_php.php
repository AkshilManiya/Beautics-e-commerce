<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['search'])) {

    $conditions = [];

    // Check if category ID is set
    if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $conditions[] = "tblcategory.Category_id = $category_id";
    }

    // Check if product ID is set
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $conditions[] = "tblproduct.Product_id = $product_id";
    }

    // Check if order date is set
    if (isset($_POST['order_date']) && !empty($_POST['order_date'])) {
        $order_date = $conn->real_escape_string($_POST['order_date']);
        $conditions[] = "DATE(tblorder.Order_date) = '$order_date'";
    }

    // Check if status is set
    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "tblorder.Status = '$status'";
    }

    $sql = "SELECT tblorder.*, tblvariants.*, tblproduct.*, tbluser.*, tblstate.state_name, tblcity.city_name ,tblcolor.code
            FROM tblorder 
            JOIN tbluser ON tbluser.User_id = tblorder.user_id 
            JOIN tblcity ON tblcity.City_id = tbluser.city_id 
            JOIN tblstate ON tblstate.State_id = tblcity.state_id 
            JOIN tblvariants ON tblvariants.Variant_id = tblorder.variant_id 
            JOIN tblColor ON tblvariants.color_id = tblcolor.Color_id
            JOIN tblproduct ON tblproduct.Product_id = tblvariants.product_id
            JOIN tblcategory ON tblcategory.Category_id = tblproduct.category_id";
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Order_id'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td><img class='tbl-img' src='/Beautics/static/system_img/variants/" . $row['img_path']. "' alt='image'></td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div></td>";
            echo "<td>" . $row['amount_value'] . $row['amount_type'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['total_price'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['contact'] . "</td>";

            echo "<td>" . ($row['status'] == "Paid" 
                ? "<button class='deactive' disabled>remove</button>" 
                : "<button class='active' onclick='remove_status(" . $row['Order_id'] . ", \"" . $row['status'] . "\")'>remove</button>") . "</td>";

            echo "<td>" . $row['status'] . "</td>";            

            echo "<td>" . ($row['status'] == "Delivered" 
                ? "<button class='deactive' disabled>update</button>" 
                : "<button class='active' onclick='update_status(" . $row['Order_id'] . ", \"" . $row['status'] . "\")'>update</button>") . "</td>";

        }
    } else {
        echo "<tr><td colspan='11'>No records found</td></tr>";
    }
} 
else if (isset($_POST['opration']) && $_POST['opration'] == "remove") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE tblorder SET status='$status' WHERE Order_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
else if (isset($_POST['opration']) && $_POST['opration'] == "update") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE tblorder SET status='$status' WHERE Order_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$conn->close();
?>
