<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include "../static/libs.php"; ?>
        <link rel="stylesheet" href="../static/css/Profile.css">
        <style>
        </style>
    </head>
    <body>
        <?php
            include "staff_header.php";
        ?>
        
        <div class="outer_frame">
            <div id="profile_show">
                <div id="image_frame">
                    <img src="" alt="profile" id="img">
                    <p id="uploadStatus"></p>
                    <button onclick="Update_img()">Update image</button>
                </div>
                <div class="form">
                    <div>
                        <input type="hidden" id="id">
                        <div class="show-data"><label>User Name : </label><div id="name"></div></div>
                        <div class="show-data"><label>User email : </label><div id="email"></div></div>
                        <div class="show-data"><label>Contact : </label><div id="conno"></div></div>
                        <div class="show-data"><label>Gender : </label><div id="gender"></div></div>
                        <div class="show-data"><label>Address : </label><div id="address"></div></div>
                        <div class="show-data"><label>City : </label><div id="city"></div></div>
                        <div class="show-data"><label>State : </label><div id="state"></div></div>
                    </div>
                    <div>
                        <button onclick="Update_profile()">Update Profile</button>
                        <button onclick="Update_password()">Update Password</button>
                    </div>
                </div>
            </div>
            <div id="profile_update">
                <div>
                <div class="input-data">
                    <label>User Name* <span id="name_error" style="color:red;"></span></label>
                    <input type="text" id="new_name">
                </div>
                <div class="input-data">
                    <label>User email <span id="email_error" style="color:red;"></span></label>
                    <input type="email" id="new_email" disabled=False>
                </div>
                <div class="input-data">
                    <label>Contact* <span id="contact_error" style="color:red;"></span></label>
                    <input type="number" id="new_conno">
                </div>
                <div class="input-data">
                    <label>Gender* <span id="gender_error" style="color:red;"></span></label>
                    <select id="new_gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-data">
                    <label>Flat number <span id="flat_error" style="color:red;"></span></label>
                    <input type="text" id="new_flat">
                </div>
                <div class="input-data">
                    <label>Floor number <span id="floor_error" style="color:red;"></span></label>
                    <input type="number" id="new_floor">
                </div>
                <div class="input-data">
                    <label>Building name <span id="building_error" style="color:red;"></span></label>
                    <input type="text" id="new_building">
                </div>
                <div class="input-data">
                    <label>Road street <span id="road_error" style="color:red;"></span></label>
                    <input type="text" id="new_road">
                </div>
                <div class="input-data">
                    <label>Pincode <span id="pincode_error" style="color:red;"></span></label>
                    <input type="number" id="new_pincode">
                </div>
                <div class="input-data">
                    <label>State* <span id="state_error" style="color:red;"></span></label>
                    <select id="new_state" onchange="fetch_city()"></select>
                </div>
                <div class="input-data">
                    <label>City* <span id="city_error" style="color:red;"></span></label>
                    <select id="new_city"></select>
                </div>

                </div>
                <div>
                    <button onclick="Save_profile()">Save Profile</button>
                    <button onclick="Show_profile()">Show Profile</button>
                </div>
            </div>
            <div id="password_update">
                <label>Enter old password :  <span style="color: red;" id="valid_oldpassword"></span></label><input type="text" placeholder="old password" id="old" /><br>
                <label>Enter new password :  <span style="color: red;" id="valid_password"></span></label><input type="text" placeholder="new password" id="new" /><br>
                <label>Enter confirm password :  <span style="color: red;" id="valid_compass"></span></label><input type="password" placeholder="confirm password" id="com" /><br>
                <button onclick="Save_password()">Save Password</button>
                <button onclick="Show_profile()">Show Profile</button>
            </div>
        </div>

        <script>

            $(document).ready(function () {
                Show_profile();
            });

            function Show_profile() {
                $("#profile_show").show();
                $("#profile_update").hide();
                $("#password_update").hide();
                fetchUserProfile(1);
            }

            function Update_profile() {
                $("#profile_show").hide();
                $("#profile_update").show();
                $("#password_update").hide();
                fetchUserProfile(2);
            }

            function Update_password() {
                $("#profile_show").hide();
                $("#profile_update").hide();
                $("#password_update").show();
            }

            
            function fetch_state() {
                $.ajax({
                    url: '../php/select.php',
                    method: 'POST',
                    async: false,
                    data: {state: "done"},
                    success: function (response) {
                        $('#new_state').html(response);
                        fetch_city();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }

            function fetch_city() {
                var S = $("#new_state").val();
                $.ajax({
                    url: '../php/select.php',
                    method: 'POST',
                    async: false,
                    data: {S: S, city: "done"},
                    success: function (response) {
                        $('#new_city').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }

            function fetchUserProfile(mode) {
                $.ajax({
                    type: 'POST',
                    url: '../php/profile_php.php',
                    data: { fetch_profile: "done"},
                    success: function (response) {
                        console.log(response);
                        var userData = JSON.parse(response);
                        if (mode == 1) {
                            document.getElementById('img').src = `/Beautics/static/system_img/profile/${userData['image']}`;
                            console.log(document.getElementById('img').src);
                            $('#id').val(userData['id']);
                            $('#name').text(userData['name']);
                            $('#email').text(userData['email']);
                            $('#conno').text(userData['conno']);
                            $('#gender').text(userData['gender']);
                            $('#address').text(`${userData['flat_number']} -${userData['floor_number']} ,${userData['building_name']} , ${userData['road_street']} ,${userData['pincode']}`);
                            $('#city').text(userData['city']);
                            $('#state').text(userData['state']);
                        } else if (mode == 2) {
                            $('#new_name').val(userData['name']);
                            $('#new_email').val(userData['email']);
                            $('#new_conno').val(userData['conno']);
                            $('#new_gender').val(userData['gender']);

                            $('#new_flat').val(userData['flat_number']);
                            $('#new_floor').val(userData['floor_number']);
                            $('#new_building').val(userData['building_name']);
                            $('#new_road').val(userData['road_street']);
                            $('#new_pincode').val(userData['pincode']);
                            
                            fetch_state();
                            select_tag("new_state", userData['state_id']);

                            fetch_city();
                            select_tag("new_city", userData['city_id']);

                        }
                    }
                });
            }
            
            function select_tag(id, value){
                var selectElement = document.getElementById(id);
                var searchText = value;
                for (var i = 0; i < selectElement.options.length; i++) {
                    if (selectElement.options[i].text === searchText) {
                        selectElement.options[i].selected = true;
                        break;
                    }
                }
            }
            
            function uploadImage(selectedFile, userId) {
                const formData = new FormData();
                formData.append('image', selectedFile);
                formData.append('id', userId);

                $.ajax({
                    url: '../php/uploader.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function (response) {
                        if (response === "success") {
                            fetchUserProfile(1);
                        } else {
                            $("#uploadStatus").text(response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#uploadStatus").text("Upload error: " + errorThrown);
                    }
                });
            }

            function Update_img() {
                const fileInput = document.createElement('input');
                const userId = $("#id").val();  // Get user ID from input field
                fileInput.type = 'file';
                fileInput.accept = '.jpg, .jpeg, .png, .webp';
                fileInput.style.display = 'none';
                fileInput.click();
                
                fileInput.addEventListener('change', function () {
                    const selectedFile = fileInput.files[0];
                    if (selectedFile) {
                        const fileName = selectedFile.name;
                        if (isAllowedFileType(fileName)) {
                            uploadImage(selectedFile, userId);  // Pass user ID
                        } else {
                            alert('Invalid file type. Please select a jpg, jpeg, png, or webp image.');
                        }
                    }
                });
            }

            function isAllowedFileType(fileName) {
                const allowedExtensions = [".jpg", ".jpeg", ".png", ".webp"];
                const extension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
                return allowedExtensions.includes(extension);
            }

            function Save_profile() {
                const id = $("#id").val();
                const newName = $('#new_name').val();
                const newContact = $('#new_conno').val();
                const newGender = $('#new_gender').val();
                const newFlat = $('#new_flat').val();
                const newFloor = $('#new_floor').val();
                const newBuilding = $('#new_building').val();
                const newRoad = $('#new_road').val();
                const newPincode = $('#new_pincode').val();
                const newState = $('#new_state').val();
                const newCity = $('#new_city').val();

                $("#name_error").text("");
                $("#contact_error").text("");
                $("#gender_error").text("");
                $("#state_error").text("");
                $("#city_error").text("");
                $("#pincode_error").text("");

                let hasError = false;

                // Validation conditions
                if (newName === "") {
                    $("#name_error").text("Name is required");
                    hasError = true;
                }

                if (newContact === "" || !/^\d{10}$/.test(newContact)) {
                    $("#contact_error").text("Valid 10-digit contact number is required");
                    hasError = true;
                }

                if (newGender === "") {
                    $("#gender_error").text("Gender is required");
                    hasError = true;
                }

                if (!/^\d{6}$/.test(newPincode)) {
                    $("#pincode_error").text("Valid 6-digit pincode number is required");
                    hasError = true;
                }

                if (newState === "") {
                    $("#state_error").text("State is required");
                    hasError = true;
                }

                if (newCity === "") {
                    $("#city_error").text("City is required");
                    hasError = true;
                }

                if (hasError) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '../php/Profile_php.php',
                    data: { update_profile: "done", name: newName, contact: newContact, gender: newGender, flat:newFlat, floor:newFloor, building:newBuilding, road:newRoad, pincode:newPincode, state: newState, city: newCity, id:id},
                    success: function (response) {
                        if (response === "success") {
                            alert("Profile updated successfully!");
                            Show_profile();
                        } else {
                            alert("Error updating profile: " + response);
                        }
                    }
                });
            }

            
            function cleaner(){
                $("#valid_name").text("");
                $("#valid_number").text("");
                $("#valid_password").text("");
                $("#valid_oldpassword").text("");
                $("#valid_compass").text("");
            }

            function Save_password() {
                var id = $("#id").val();
                var oldPass = $("#old").val();
                var pass = $("#new").val();
                var compass = $("#com").val();

                cleaner();
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

                cleaner();

                $.ajax({
                    url: '../php/Profile_php.php',
                    method: 'POST',
                    data: {old: oldPass, id: id, new: pass },
                    success: function (response) {
                        console.log(response);
                        if (response == "old") {
                            $("#valid_oldpassword").text("old password is wrong");
                        }
                        else if (response == "success") {
                            alert("password changed");
                            Show_profile();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching options: ' + status + ' - ' + error);
                    }
                });
            }
        </script>
    </body>
</html>