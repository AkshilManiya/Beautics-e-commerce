<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['search'])) {
    $conditions = [];

    if (isset($_POST['state_name']) && !empty($_POST['state_name'])) {
        $city_name = $conn->real_escape_string($_POST['state_name']);
        $conditions[] = "state_name LIKE '%$city_name%'";
    }

    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "active = $status";
    }

    $sql = "SELECT * from tblState where is_disabled='0'";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['State_id'] . "</td>";
            echo "<td>" . $row['state_name'] . "</td>";
            
            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['State_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['State_id'] . ")'>Active</button>") . "</td>";
            
            echo "<td><button class='update-click' onclick='show_update(" . $row['State_id'] . ", \"" . $row['state_name'] . "\", \"" . $row['img_path'] . "\")'>Update</button></td>";
            echo "<td><button class='delete-click' onclick='delete_sat(" . $row['State_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    $conn->close();
}
else if (isset($_POST['insert']))
{
    $stateName = $_POST['statename'];
    $sql = "SELECT * from tblState where state_name='$stateName'";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "INSERT INTO tblstate VALUES (NULL,'$stateName', 1, 0)";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
    }
    else{
        echo "statename";
    }
}
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $stateName = $_POST['statename'];
    
    $sql = "SELECT * from tblState where state_name='$stateName' and State_id!=$id";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "UPDATE tblstate SET state_name = '$stateName' WHERE State_id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    }
    else{
        echo "statename";
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "update tblstate set is_disabled=1 WHERE State_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblstate SET active=0 WHERE State_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblstate SET active=1 WHERE State_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
