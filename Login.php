<!--  login page Html -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="static/css/Login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
    <body>

    <div class="login-container">
        <p id="error" class="error-message"></p>
        <div class="login-box">
            <h1>Log In</h1>
            <form>
                <div class="form-group">
                    <label for="email">Enter Email:</label>
                    <input type="text" id="email" class="input-field" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="password">Enter Password:</label>
                    <input type="password" id="password" class="input-field" placeholder="Enter password">
                </div>

                <div class="form-group remember-me">
                    <input type="checkbox" id="rem">
                    <label for="rem">Remember Me</label>
                </div>

                <div class="form-group">
                    <button type="button" class="btn" onclick="Login()">Login</button>
                </div>
            </form>

            <div class="links">
                <a href='customer/Register.php'>Register</a>
                <a href='forgot.php'>Forgot Password?</a>
            </div>
        </div>
    </div>


        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'php/Login_php.php',
                    method: 'POST',
                    data: {cookie: "done"},
                    success: function (response) {
                        console.log(response);
                        if (response === 'error') {
                            alert('auto login faild');
                        } else {
                            window.location.href = response;
                        }
                    }
                });
            });

            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function Login(){
                var email = $("#email").val();
                var password = $("#password").val();

                if (email == "" || password == ""){
                    $("#error").text("please fill email or password");
                    return;
                }
                else if (!validateEmail(email)){
                    $("#error").text("please enter valid email.");
                    return;
                }

                const rem = $('#rem').prop('checked');
                console.log(rem);
                $.ajax({
                    type: "POST",
                    url: "php/Login_php.php",
                    data: {
                           email: email,
                           password: password,
                           rem:rem,
                           Login: "done"},
                    success: function (response) {
                        console.log(response);
                        if (response === 'error password') {
                            $("#error").text('invalid password');
                        } else if (response === 'error account') {
                            $("#error").text('invalid account');
                        } else {
                            window.location.href = response;
                        }
                    },error: function (xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }
        </script>
    </body>
</html>