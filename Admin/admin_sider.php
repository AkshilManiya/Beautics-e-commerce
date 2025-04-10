<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="Dashboard.php">Dashboard</a></li>
      <li><a href="Order.php">Orders</a></li>
      <li><a href="Category.php">Category</a></li>
      <li><a href="Product.php">Product</a></li>
      <li><a href="Variants.php">Varients</a></li>
      <li><a href="State.php">State</a></li>
      <li><a href="City.php">City</a></li>
      <li><a href="Color.php">Color</a></li>
      <li><a href="User.php">User</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" id="Login">
      <li><a href="/Beautics/customer/Register.php"> Register</a></li>
      <li><a href="/Beautics/Login.php"> Login</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" id="Profile" style="display:none;">
      <li><a href="/Beautics/Admin/Profile.php"> <span id="user"> Profile </span></a></li>
      <li><a href="#" onclick="Logout()"> Logout </a></li>
    </ul>
  </div>
</nav>

<script>
  $(document).ready(function() {
    $.ajax({
        url: '/Beautics/php/Login_php.php',
        method: 'POST',
        data: {cookie: "done"},
        async: false,
        success: function (response) {
            // console.log(response);
            if (response === 'error') {
                alert('auto login faild');
            } else {
                console.log(response);
            }
        }
    });
    $.ajax({
      url: '/Beautics/php/Check_login_php.php',
      type: 'POST',
      data: {
        check_login: "done"
      },
      success: function(data) {
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
      error: function(error) {
        console.error('Error:', error);
      }
    });
  });

  function Logout() {
    $.ajax({
      url: '/Beautics/php/Check_login_php.php',
      type: 'POST',
      data: {
        logout: "true"
      },
      success: function(data) {
        let response = JSON.parse(data);
        if (response.status === "logout") {
          window.location.href = "../Login.php";
        }
      },
      error: function(error) {
        console.error('Error:', error);
      }
    });
  }
</script>