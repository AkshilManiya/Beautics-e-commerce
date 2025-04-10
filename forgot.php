<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    div {
        margin-bottom: 15px;
    }

    #f1,
    #f2 {
        background-color: #fff;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 400px;
    }

    label {
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
    }

    input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    #valid_email,
    #valid_otp,
    #valid_password,
    #valid_compass {
        font-size: 14px;
        color: red;
    }

    #fotp {
        margin-top: 15px;
    }

    a {
        text-decoration: none;
        color: #4CAF50;
        display: block;
        margin-top: 20px;
        text-align: center;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 500px) {

        #f1,
        #f2 {
            width: 90%;
        }
    }
</style>

<body>


    <div>
        <div id="f1">
            <div>
                <label>email : </label>
                <input type="email" id="email" />
                <div style="color: red;" id="valid_email"></div>
                <button id="send_otp" onclick="verify_email()">send OTP</button>
            </div>
            <div id="fotp">
                <label>OTP : </label>
                <input type="number" id="otp" />
                <div style="color: red;" id="valid_otp"></div>
            </div>
            <button onclick="f2()">NEXT</button>
        </div>
        <div id="f2">
            <div>
                <label>password : </label>
                <input type="text" id="pass" />
                <div style="color: red;" id="valid_password"></div>
            </div>
            <div>
                <label>confirm password : </label>
                <input type="password" id="compass" />
                <div style="color: red;" id="valid_compass"></div>
            </div>
            <button onclick="Back_f1()">BACK</button>
            <button onclick="register()">submit</button>
        </div>
        <div>
            <button onclick="window.location.href='/Beautics/Login.php'"> Login </button>
        </div>
    </div>

    <body>
        <script>
            otp = 0;
            $(document).ready(function() {
                $("#f1").show();
                $("#f2").hide();
                $("#fotp").hide();
            });

            function verify_email() {
                const email = $('#email').val();
                console.log(email);
                if (email == "") {
                    $("#valid_email").text("please fill email");
                    return;
                }
                $.ajax({
                    url: 'php/forgot_php.php',
                    method: 'POST',
                    data: {
                        email: email,
                        email_check: true
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 1) {
                            $('#valid_email').html('otp is sending...');
                            sendOTP(email);
                        } else if (response == 0) {
                            $("#valid_email").text('Email not exist in the system.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }

            function sendOTP(email) {
                $.ajax({
                    url: 'php/forgot_php.php',
                    type: 'POST',
                    data: {
                        email: email,
                        send_otp: true
                    },
                    success: function(response) {
                        console.log(response);
                        otp = response.slice(-6);
                        // otp = response;
                        $('#valid_email').html('otp has sended to email');
                        $("#fotp").show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending email:', error);
                    }
                });
            }

            function f2() {
                var email = $("#email").val();
                var enterd_otp = $.trim($("#otp").val());
                console.log(enterd_otp, otp);

                if (email == "" || enterd_otp == "") {
                    $("#report").text("Please fill in all details");
                    return;
                } else if (!/^\d{6}$/.test(enterd_otp)) {
                    $("#valid_otp").text("Please enter a valid 6-digit OTP code");
                    return;
                }
                $("#valid_email").text("");
                $("#valid_otp").text("");

                if (enterd_otp != otp) {
                    $("#report").text("invalid otp");
                    return;
                } else {
                    $("#report").text("");
                    $("#valid_email").text("");
                    $("#valid_otp").text("");
                    $("#f1").hide();
                    $("#f2").show();
                }
            }

            function Back_f1() {
                $("#f1").show();
                $("#f2").hide();
            }

            function register() {
                var pass = $("#pass").val();
                var compass = $("#compass").val();
                var email = $("#email").val();

                if (pass == "") {
                    $("#valid_password").text("please enter password");
                    return;
                } else if (!pass.match(/[a-z]/g)) {
                    $("#valid_password").text("Password must include small character");
                    return;
                } else if (!pass.match(/[A-Z]/g)) {
                    $("#valid_password").text("Password must include Capital character");
                    return;
                } else if (!pass.match(/[0-9]/g)) {
                    $("#valid_password").text("Password must include Number digits");
                    return;
                } else if (pass.length <= 6) {
                    $("#valid_password").text("Password must be more than 6 latters");
                    return;
                } else if (pass != compass) {
                    $("#valid_compass").text("plase, cheack comfirm password");
                    return;
                }

                $("#valid_password").text("");
                $("#valid_compass").text("");
                $.ajax({
                    url: 'php/forgot_php.php',
                    method: 'POST',
                    data: {
                        email: email,
                        password: pass,
                        forgot_set: true
                    },
                    success: function(response) {
                        if (response == "success") {
                            window.location.href = 'Login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }
        </script>

</html>