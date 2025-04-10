<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">WebSiteName</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="/Beautics/Customer/customer_home.php">Home</a></li>
            <li><a href="/Beautics/Customer/Product.php">Product</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="Login">
            <li><a href="/Beautics/customer/Register.php"> Register </a></li>
            <li><a href="/Beautics/Login.php"> Login </a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="Profile" style="display:none;">
            <li><a href="/Beautics/Customer/Cart.php">Cart</a></li>
            <li><a href="/Beautics/Customer/Wishlist.php">Wishlist</a></li>
            <li><a href="/Beautics/Customer/Myorders.php"> MyOrder </a></li>
            <li><a href="/Beautics/Customer/Profile.php"> <span id="user"> Profile </span></a></li>
            <li><a href="#" onclick="Logout()"> Logout </a></li>
        </ul>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '../php/Login_php.php',
            method: 'POST',
            data: {
                cookie: "done"
            },
            async: false,
            success: function(response) {
                // console.log(response);
                if (response === 'error') {
                    alert('auto login faild');
                } else {
                    console.log(response);
                }
            }
        });
        $.ajax({
            url: '../php/Check_login_php.php',
            type: 'POST',
            async: false,
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
            url: '../php/Check_login_php.php',
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