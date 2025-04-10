<?php
$conn = mysqli_connect("localhost", "root", "", "beautics");

if (isset($_POST['state'])) {
    $sql = "SELECT State_id, state_name from tblstate;";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value=" . $row['State_id'] . ">" . $row['state_name'] . "</option>";
        }
    }
    $conn->close();
    echo $options;
} else if (isset($_POST['city'])) {
    $s = $_POST['S'];
    $sql = "SELECT City_id, city_name from tblcity where state_id='$s';";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value=" . $row['City_id'] . ">" . $row['city_name'] . "</option>";
        }
    }
    $conn->close();
    echo $options;
} else if (isset($_POST['category'])) {

    $sql = "SELECT Category_id, category_name from tblcategory;";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value=" . $row['Category_id'] . ">" . $row['category_name'] . "</option>";
        }
    }
    $conn->close();
    echo $options;
} else if (isset($_POST['product'])) {
    $C = $_POST['C'];
    $sql = "SELECT Product_id, product_name from tblproduct where category_id='$C';";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value=" . $row['Product_id'] . ">" . $row['product_name'] . "</option>";
        }
    }
    $conn->close();
    echo $options;
} else if (isset($_POST['color'])) {
    $sql = "SELECT Color_id, color_name, code FROM tblcolor;";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['Color_id'] . "' style='background-color:" . htmlspecialchars($row['code']) . ";'>" . $row['color_name'] . "</option>";
        }
    }
    $conn->close();
    echo $options;
}

?>
