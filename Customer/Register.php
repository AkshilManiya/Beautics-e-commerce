<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/Beautics/static/css/Customer/Register.css">
    <?php include "../static/libs.php"; ?>
    <style>
        h1 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="alt-register-container">
        <div class="alt-register-box">
            <h1>Create Account</h1>
            <p id="error" class="alt-error-message"></p>
            <form>
                <div class="alt-form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="alt-input-field" placeholder="Enter your username">
                </div>

                <div class="alt-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="alt-input-field" placeholder="Enter your email">
                </div>

                <div class="alt-form-group">
                    <label for="conno">Contact Number</label>
                    <input type="number" id="conno" class="alt-input-field" placeholder="Enter your contact number">
                </div>

                <div class="alt-form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" class="alt-select-field">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="alt-form-group">
                    <label for="selectState">State</label>
                    <select id="selectState" class="alt-select-field" onchange="fetch_city()">
                        <!-- Dynamic state options -->
                    </select>
                </div>

                <div class="alt-form-group">
                    <label for="selectCity">City</label>
                    <select id="selectCity" class="alt-select-field">
                        <!-- Dynamic city options -->
                    </select>
                </div>

                <div class="alt-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="alt-input-field" placeholder="Create a password">
                </div>

                <button type="button" class="alt-btn" onclick="Register()">Register</button>
            </form>

            <p class="alt-link">Already have an account? <a href="../Login.php">Login here</a></p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetch_state();
        });

        function fetch_state() {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                data: {
                    state: "done"
                },
                success: function(response) {
                    console.log(response);
                    $('#selectState').html(response);
                    fetch_city();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching options: ' + status + ' - ' + error);
                }
            });
        }

        function fetch_city() {
            var S = $("#selectState").val();
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                data: {
                    S: S,
                    city: "done"
                },
                success: function(response) {
                    $('#selectCity').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching options: ' + status + ' - ' + error);
                }
            });
        }

        function Register() {
            var username = $("#username").val();
            var email = $("#email").val();
            var conno = $("#conno").val();
            var city = $("#selectCity").val();
            var gender = $("#gender").val();
            var password = $("#password").val();
            var error = $("#error");

            error.text("");

            // Username validation
            if (username === "") {
                error.text("Username is required.");
                return;
            } else if (username.length < 3) {
                error.text("Username must be at least 3 characters long.");
                return;
            }

            // Email validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "") {
                error.text("Email is required.");
                return;
            } else if (!emailPattern.test(email)) {
                error.text("Please enter a valid email address.");
                return;
            }

            // Contact number validation (assuming it's a 10-digit number)
            if (conno === "") {
                error.text("Contact number is required.");
                return;
            } else if (conno.length != 10) {
                error.text("Contact number must be 10 digits.");
                return;
            }

            // Gender validation
            if (gender === null || gender === "") {
                error.text("Please select a gender.");
                return;
            }

            // City validation
            if (city === null || city === "") {
                error.text("Please select a city.");
                return;
            }

            // Password validation
            if (password === "") {
                error.text("Password is required.");
                return;
            } else if (password.length < 6) {
                error.text("Password must be at least 6 characters long.");
                return;
            }


            $.ajax({
                type: "POST",
                url: "php/Register_php.php",
                data: {
                    username: username,
                    email: email,
                    password: password,
                    conno: conno,
                    gender: gender,
                    city: city,
                    Register: "done"
                },
                success: function(response) {
                    console.log(response);
                    if (response == "success") {
                        window.location.href = "../login.php";
                    } else if (response == "exist") {
                        $("#error").text("Email already exists");
                    } else {
                        $("#error").text("Registration unsuccessful");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error during registration: ' + status + ' - ' + error);
                }
            });
        }
    </script>

</body>

</html>