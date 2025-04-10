<?php 
session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['search'])) {
    $conditions = [];

    if (isset($_POST['city_name']) && !empty($_POST['city_name'])) {
        $city_name = $conn->real_escape_string($_POST['city_name']);
        $conditions[] = "tblCity.city_name LIKE '%$city_name%'";
    }

    if (isset($_POST['state']) && !empty($_POST['state'])) {
        $state_id = $conn->real_escape_string($_POST['state']);
        $conditions[] = "tblCity.state_id = '$state_id'";
    }

    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "tblcity.active = $status";
    }

    $sql = "SELECT tblCity.*, tblstate.state_name FROM tblCity JOIN tblstate ON tblstate.State_id = tblCity.state_id where is_disabled=0";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['City_id'] . "</td>";
            echo "<td>" . $row['state_name'] . "</td>";
            echo "<td>" . $row['city_name'] . "</td>";
            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['City_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['City_id'] . ")'>Active</button>") . "</td>";
            echo "<td><button class='update-click' onclick='show_update(" . $row['City_id'] . ", \"" . $row['state_id'] . "\", \"" . $row['city_name'] . "\")'>Update</button></td>";
            echo "<td><button class='delete-click' onclick='delete_City(" . $row['City_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
    $conn->close();
}

else if (isset($_POST['insert'])) {
    $CityName = $_POST['cityname'];
    $state = $_POST['state'];

    $sql = "SELECT tblCity.*, tblstate.state_name FROM tblCity JOIN tblstate ON tblstate.State_id = tblCity.state_id where city_name='$CityName'";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "INSERT INTO tblCity VALUES (NULL, '$CityName','$state', 1, 0)";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
    }
    else{
        echo "cityname";
    }
} 
else if (isset($_POST['update'])) {    
    $id = $_POST['id'];
    $CityName = $_POST['cityname'];
    $state = $_POST['state'];

    $sql = "SELECT tblCity.*, tblstate.state_name FROM tblCity JOIN tblstate ON tblstate.State_id = tblCity.state_id where city_name='$CityName' And City_id!=$id";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "UPDATE tblCity SET city_name = '$CityName', state_id = '$state' WHERE City_id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo mysqli_error($conn);
        }
    }
    else{
        echo "cityname";
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblcity WHERE City_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcity SET active=0 WHERE City_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tblcity SET active=1 WHERE City_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
