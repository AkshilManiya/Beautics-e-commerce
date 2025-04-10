<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['search'])) {

    $conditions = [];
    if (isset($_POST['color_name']) && !empty($_POST['color_name'])) {
        $city_name = $conn->real_escape_string($_POST['color_name']);
        $conditions[] = "color_name LIKE '%$city_name%'";
    }

    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "active = $status";
    }

    $sql = "SELECT * FROM tblcolor where is_disabled=0";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Color_id'] . "</td>";
            echo "<td>" . $row['color_name'] . "</td>";
            echo "<td><div style='background-color:" . htmlspecialchars($row['code']) . "; width: 20px; height: 20px; border-radius: 50%; border:1px solid black;'></div></td>";
            
            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['Color_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['Color_id'] . ")'>Active</button>") . "</td>";
            
            echo "<td><button class='update-click' onclick='show_update(" . $row['Color_id'] . ", \"" . $row['color_name'] . "\", \"" . $row['code'] . "\")'>Update</button></td>";
            echo "<td><button class='delete-click' onclick='delete_cat(" . $row['Color_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    $conn->close();
}
else if (isset($_POST['insert']))
{
    $colorName = $_POST['colorname'];
    $code = $_POST['code'];
    $sql = "SELECT * FROM tblcolor where code='$code'";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "SELECT * FROM tblcolor where code='$code' And color_name='$colorName'";
        $result = $conn->query($sql);
        if ($result->num_rows <= 0) {
            $sql = "INSERT INTO tblcolor VALUES (NULL, '$code', '$colorName', 1, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "success";
            } else {
                echo "Database Error: " . mysqli_error($conn);
            }
        }
        else{
            echo "colorname";
        }
    }
    else{
        echo "code";
    }
}
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $colorName = $_POST['colorname'];
    $code = $_POST['code'];
    $sql = "SELECT * FROM tblcolor where code='$code' And Color_id!=$id";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "SELECT * FROM tblcolor where code='$code' And color_name='$colorName' And Color_id!=$id";
        $result = $conn->query($sql);
        if ($result->num_rows <= 0) {
            $sql = "UPDATE tblcolor SET color_name = '$colorName',code='$code' WHERE Color_id = '$id'";
            if (mysqli_query($conn, $sql)) {
                echo "success";
            } else {
                echo "Database Error: " . mysqli_error($conn);
            }
        }
        else{
            echo "colorname";
        }
    }
    else{
        echo "code";
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "update tblcolor set is_disabled=1 WHERE Color_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcolor SET active=0 WHERE Color_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcolor SET active=1 WHERE Color_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
