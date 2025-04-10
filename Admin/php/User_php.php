<?php 
include '../../Customer/php/Register_php.php';

session_start();
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['search'])) {
    $conditions = [];

    $conditions = [];

    // Check if username is set
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $conditions[] = "tbluser.name LIKE '%$username%'";
    }

    // Check if email is set
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $conditions[] = "tbluser.email LIKE '%$email%'";
    }

    // Check if state ID is set
    if (isset($_POST['state_id']) && !empty($_POST['state_id'])) {
        $state_id = $conn->real_escape_string($_POST['state_id']);
        $conditions[] = "tblstate.State_id = $state_id";
    }

    // Check if city ID is set
    if (isset($_POST['city_id']) && !empty($_POST['city_id'])) {
        $city_id = $conn->real_escape_string($_POST['city_id']);
        $conditions[] = "tblcity.City_id = $city_id";
    }

    // Check if gender is set
    if (isset($_POST['gender']) && !empty($_POST['gender'])) {
        $gender = $conn->real_escape_string($_POST['gender']);
        $conditions[] = "tbluser.gender = '$gender'";
    }

    // Check if role is set
    if (isset($_POST['role']) && !empty($_POST['role'])) {
        $role = $conn->real_escape_string($_POST['role']);
        $conditions[] = "tbluser.role = '$role'";
    }

    // Check if status is set
    if (isset($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "tbluser.active = $status";
    }


    $sql = "SELECT tbluser.*, tblstate.state_name, tblstate.State_id, tblcity.city_name FROM tbluser JOIN tblcity ON tblcity.City_id = tbluser.city_id JOIN tblstate ON tblstate.State_id = tblcity.state_id where tblUser.is_disabled=0";
    if (count($conditions) > 0) {
        $sql .= " And " . implode(' AND ', $conditions);
    }

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['User_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['contact'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['city_name'] . "</td>";
            echo "<td>" . $row['state_name'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";

            echo "<td>" . (!$row['active'] 
                ? "<button class='deactive' onclick='Active(" . $row['User_id'] . ")'>Deactive</button>" 
                : "<button class='active' onclick='Deactive(" . $row['User_id'] . ")'>Active</button>") . "</td>";
        
            
            // Update button
            echo "<td><button class='update-click' onclick='show_update(" 
                . $row['User_id'] . ", \"" 
                . $row['name'] . "\", \"" 
                . $row['contact'] . "\", \"" 
                . $row['email'] . "\", \"" 
                . $row['gender'] . "\", \"" 
                . $row['State_id'] . "\", \"" 
                . $row['city_id'] . "\", \"" 
                . $row['role'] . "\")'>Update</button></td>";
    
            // Delete button
            echo "<td><button  class='delete-click' onclick='delete_user(" . $row['User_id'] . ")'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No records found</td></tr>";
    }
    
    $conn->close();
}
else if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $city_id = $_POST['city_id'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM tbluser where email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "email";
        exit;
    }

    $sql = "SELECT * FROM tbluser where contact='$contact'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "contact";
        exit;
    }

    $sql = "INSERT INTO tblUser (name, contact, email, password, gender, city_id, role, active, is_disabled) 
        VALUES ('$name', '$contact', '$email', 'password', '$gender', '$city_id', '$role',1 , 0)";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Update an existing user
else if (isset($_POST['update'])) {    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $city_id = $_POST['city_id'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM tbluser where email='$email' And User_id!='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "email";
        exit;
    }

    $sql = "SELECT * FROM tblcategory where contact='$contact' And User_id!='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "contact";
        exit;
    }
    
    $sql = "UPDATE tblUser 
            SET name = '$name', 
                contact = '$contact', 
                email = '$email', 
                gender = '$gender', 
                city_id = '$city_id', 
                role = '$role' 
            WHERE User_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "User updated successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
else if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tbluser WHERE User_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['deactive'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tbluser SET active=0 WHERE User_id='$id'";    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
else if (isset($_POST['active'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tbluser SET active=1 WHERE User_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $conn->close();
}
?>
