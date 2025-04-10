<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="Order.php">Orders</a></li>
      <li><a href="Category.php">Category</a></li>
      <li><a href="Product.php">Product</a></li>
      <li><a href="Variants.php">Varients</a></li>
      <li><a href="Color.php">Color</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" id="Login">
      <li><a href="/Beautics/customer/Register.php"> Register</a></li>
      <li><a href="/Beautics/Login.php"> Login</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" id="Profile" style="display:none;">
      <li><a href="/Beautics/Staff/Profile.php"> <span id="user"> Profile </span></a></li>
      <li><a href="#" onclick="Logout()"> Logout </a></li>
    </ul>
  </div>
</nav>

<script>
    $(document).ready(function () {
        $.ajax({
            url: '../php/Check_login_php.php',
            type: 'POST',
            data: {check_login: "done"},
            success: function (data) {
                console.log(data);
                let response = JSON.parse(data);
                if (response.status === 'not_logged_in') {
                    $('#Login').show();
                    $('#Profile').hide();   
                } else {
                    $('#Profile').show();
                    $('#Login').hide();
                    $('#user').text(response[0]['Username']);
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    function Logout() {
        $.ajax({
            url: '../php/Check_login_php.php',
            type: 'POST',
            data: {logout: "true"},
            success: function (data) {
                let response = JSON.parse(data);
                if (response.status === "logout") {
                    window.location.href = "../Login.php";
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
</script>

</body>
</html>
