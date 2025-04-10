<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

$uploadDir = 'C:/xampp/htdocs/Beautics/static/system_img/category/';
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

    if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
        $city_name = $conn->real_escape_string($_POST['category_name']);
        $conditions[] = "category_name LIKE '%$city_name%'";
    }

    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "active = $status";
    }

    $sql = "SELECT * FROM tblcategory where is_disabled=0";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Category_id'] . "</td>";
            echo "<td>" . $row['category_name'] . "</td>";
            echo "<td><img class='tbl-img' src='/Beautics/static/system_img/category/" . $row['img_path']. "' alt='image'></td>";
            
            echo "<td>" . (!$row['active']
                ? "<button class='deactive' onclick='Active(" . $row['Category_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['Category_id'] . ")'>Active</button>") . "</td>";
            
            echo "<td><button class='update-click' onclick='show_update(" . $row['Category_id'] . ", \"" . $row['category_name'] . "\", \"" . $row['img_path'] . "\")'>Update</button></td>";
            echo "<td><button class='delete-click' onclick='delete_cat(" . $row['Category_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
    $conn->close();
}
else if (isset($_POST['insert']))
{
    if (uploadImageAndInsert($_FILES['image'], $uploadDir)) {
        $categoryName = $_POST['category_name'];
        $imageName = basename($_FILES['image']['name']);

        $sql = "SELECT * FROM tblcategory where category_name='$categoryName'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "catname";
            exit;
        }

        $sql = "INSERT INTO tblcategory VALUES (NULL,'$categoryName', '$imageName', 1, 0)";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
        echo "Success: Image uploaded and data inserted.";
    } else {
        echo "Error: Operation failed.";
    }
}
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $categoryName = $_POST['category_name'];

    $sql = "SELECT * FROM tblcategory where category_name='$categoryName' And Category_id!=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "catname";
        exit;
    }

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
        $sql = "UPDATE tblcategory SET category_name = '$categoryName', img_path = '$imageName' WHERE Category_id = '$id'";
    } else {
        $sql = "UPDATE tblcategory SET category_name = '$categoryName' WHERE Category_id = '$id'";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblcategory WHERE Category_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcategory SET active=0 WHERE Category_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcategory SET active=1 WHERE Category_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
