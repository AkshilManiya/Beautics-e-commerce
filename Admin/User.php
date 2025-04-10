<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <?php include "../static/libs.php"; ?>
    <link rel="stylesheet" href="../static/css/Admin/Admin.css">
    <style>
        /* Adjust specific column widths */
        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 5%;
        }

        thead th:nth-child(2), 
        tbody td:nth-child(2),
        thead th:nth-child(3), 
        tbody td:nth-child(3),
        thead th:nth-child(4), 
        tbody td:nth-child(4) {
            width: 30%;
        } 

        thead th:nth-child(9), 
        tbody td:nth-child(9),
        thead th:nth-child(10),
        tbody td:nth-child(10),
        thead th:nth-child(11),
        tbody td:nth-child(11) {
            width: 100px; 
        }
        .error{
            color:red;
        }

    </style>
</head>
<body>
    <?php include "admin_sider.php"; ?>

    <div class="title">Users</div>
    <div class="top-frame">
        <button onclick="fetch_User()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Advance Search</button>
        <button onclick="show_insert()" class="new-button">Add New Variant</button>
    </div>

    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="username_checkbox" class="search-item-check">
            <div class="search-item-label">Username</div>
            <input type="text" placeholder="Search by username" id="search_username" class="search-item-input">
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="email_checkbox" class="search-item-check">
            <div class="search-item-label">Email</div>
            <input type="text" placeholder="Search by email" id="search_email" class="search-item-input">
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="state_checkbox" class="search-item-check">
            <div class="search-item-label">State</div>
            <select id="search_state" class="search-item-input"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="city_checkbox" class="search-item-check">
            <div class="search-item-label">City</div>
            <select id="search_city" class="search-item-input"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="gender_checkbox" class="search-item-check">
            <div class="search-item-label">Gender</div>
            <select id="search_gender" class="search-item-input">
                <option value="Male" selected>Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="role_checkbox" class="search-item-check">
            <div class="search-item-label">Role</div>
            <select id="search_role" class="search-item-input">
                <option value="Customer" selected>Customer</option>
                <option value="Staff">Staff</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="status_checkbox" class="search-item-check">
            <div class="search-item-label">Status</div>
            <select id="search_active" class="search-item-input">
                <option value=1 selected>Active</option>
                <option value=0>Deactive</option>
            </select>
        </div>
        <button onclick="search()" class="search-button">Search</button>
        <button onclick="clearSearch()" class="clear-button">Clear</button>
    </div>

    <div id="show">
        <table>
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Gender</th>
                <th>State</th>
                <th>City</th>
                <th>Role</th>
                <th>Status</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class="frame-title">Add New User</span>
        <div>
            <div class="label">Name <span id="error_name"></span> </div><input class="input" type="text" placeholder="name" id="name">
            <div class="label">email <span id="error_email"></span> </div><input class="input" type="text" id="email" placeholder="email">
            <div class="label">Contact <span id="error_contact"></span> </div><input class="input" type="number" id="contact" maxlength="10" minlength="10" placeholder="contact">
            <div class="label">gender <span></span> </div>
            <select class="input" id="gender">
                <option id="Male">Male</option>
                <option id="Female">Female</option>
            </select>
            <div class="label">state <span></span> </div><select class="input" id="state" onchange="fetch_city(1)"></select>
            <div class="label">city <span></span> </div><select class="input" id="city"></select>
            <div class="label">Role <span></span> </div>
            <select class="input" id="role">
                <option value="Customer">Customer</option>
                <option value="Staff">Staff</option>
            </select>
        </div>
        <button onclick="insert_data()" class="add-button">Add User</button>
    </div>

    <div id="show_update">
        <span class="frame-title">Update User</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">Name <span id="error_new_name"></span> </div><input class="input" type="text" placeholder="name" id="new_name">
            <div class="label">Contact <span id="error_new_contact"></span> </div><input class="input" type="number" id="new_contact" maxlength="10" minlength="10" placeholder="contact">
            <div class="label">email <span id="error_new_email"></span> </div><input class="input" type="text" id="new_email" placeholder="email" disabled=true>
            <div class="label">gender <span></span> </div>
            <select class="input" id="new_gender">
                <option id="Male">Male</option>
                <option id="Female">Female</option>
            </select>
            <div class="label">state <span></span> </div><select class="input" id="new_state" onchange="fetch_city(2)"></select>
            <div class="label">city <span></span> </div><select class="input" id="new_city"></select>
            <div class="label">Role <span></span> </div>
            <select class="input" id="new_role">
                <option id="Customer">Customer</option>
                <option id="Staff">Staff</option>
                <option id="Admin">Admin</option>
            </select>
        </div>
        <button onclick="update()" class="update-button">Update State</button>
    </div>


    <script>
        $(document).ready(function () {
            show();
            fetch_User();
        });

        function show(){
            $("#show").show();
            $("#show_insert").hide();
            $("#show_update").hide();
            $("#show_search").hide();
        }

        function show_search(){
            $("#show").show();
            $("#show_search").show();
            $("#show_insert").hide();
            $("#show_update").hide();
        }

        function show_insert(){
            $("#show_insert").show();
            $("#show").hide();
            $("#show_update").hide();
            fetch_state(1);
        }

        function fetch_state(num) {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {state: "done"},
                success: function (response) {
                    console.log(response);
                    if (num == 1){
                        $('#state').html(response);
                        fetch_city(1);
                    }
                    else if(num == 2){
                        $('#new_state').html(response);
                    }
                    else if(num == 3){
                        $('#search_state').html(response);
                        fetch_city(3);
                    }
                }
            });
        }

        function fetch_city(num) {
            if (num == 1){
                var S = $("#state").val();
            }else if (num == 2){
                var S = $("#new_state").val();
            }else if (num == 3){
                var S = $("#search_state").val();
            }
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {city: "done", S:S},
                success: function (response) {
                    console.log(response);
                    if (num == 1){
                        $('#city').html(response);
                    }
                    else if(num == 2){
                        $('#new_city').html(response);
                    }
                    else if(num == 3){
                        $('#search_city').html(response);
                    }
                }
            });
        }

        function insert_data() {
            var name = $("#name").val();
            var contact = $("#contact").val();
            var email = $("#email").val();
            var gender = $("#gender").val();
            var city_id = $("#city").val();
            var role = $("#role").val();

            hasError = false;
            // Regular Expressions for validation
            var nameRegex = /^[A-Za-z ]+$/; // Only allows alphabets and spaces
            var contactRegex = /^[0-9]{10}$/; // Validates a 10-digit number
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation

            // Validate Name (should not contain numbers or special characters)
            if (name === "") {
                $("#error_name").text("Product is required").addClass("error");
                hasError = true;
            } else if (!nameRegex.test(name)) {
                $("#error_name").text("Username should not contain numbers or special characters").addClass("error");
                hasError = true;
            } else {
                $("#error_name").text(""); // Clear error if valid
            }

            // Validate Contact (valid 10-digit number)
            if (contact === "") {
                $("#error_contact").text("Contact number is required").addClass("error");
                hasError = true;
            } else if (!contactRegex.test(contact)) {
                $("#error_contact").text("Please enter a valid 10-digit contact number").addClass("error");
                hasError = true;
            } else {
                $("#error_contact").text(""); // Clear error if valid
            }

            // Validate Email (valid email format)
            if (email === "") {
                $("#error_email").text("Email is required").addClass("error");
                hasError = true;
            } else if (!emailRegex.test(email)) {
                $("#error_email").text("Please enter a valid email address").addClass("error");
                hasError = true;
            } else {
                $("#error_email").text(""); // Clear error if valid
            }

            // Stop form submission if there are validation errors
            if (hasError) {
                return;
            }

            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                data: { name: name,contact: contact,email: email,gender: gender,city_id: city_id, role: role,insert: true},
                success: function (response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_User();
                    } else if(response.includes("email")){
                        $("#error_email").text("Email is exist").addClass("error");
                    } else if(response.includes("contact")){
                        $("#error_contact").text("contact is exist").addClass("error");
                    } else{
                        alert("error", response);
                    }
                }
            });
        }

        function show_update(id, name, contact, email, gender, state_id, city_id, role) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();
            
            $("#id").val(id);
            $("#new_name").val(name);
            $("#new_contact").val(contact);
            $("#new_email").val(email);
            select_tag("new_gender",gender, false);
            select_tag("new_role",role, false);
            
            fetch_state(2);
            select_tag("new_state",state_id);
            fetch_city(2);
            select_tag("new_city",city_id);
            console.log(id, name, contact, email, gender, state_id, city_id, address, role);
        }

        function select_tag(id, value, check_value = true) {
            var selectElement = document.getElementById(id);
            console.log(id, value);
            for (var i = 0; i < selectElement.options.length; i++) {
                if (check_value) {
                    if (selectElement.options[i].value == value) {  // Compare with value (for state_id, city_id)
                        selectElement.options[i].selected = true;
                        break;
                    }
                } else {
                    if (selectElement.options[i].text == value) {  // Compare with text (for name)
                        selectElement.options[i].selected = true;
                        break;
                    }
                }
            }
        }

        function update() {
            var id = $("#id").val();
            var name = $("#new_name").val();
            var contact = $("#new_contact").val();
            var email = $("#new_email").val();
            var gender = $("#new_gender").val();
            var city_id = $("#new_city").val();
            var role = $("#new_role").val();

            hasError = false;
            var nameRegex = /^[A-Za-z ]+$/;
            var contactRegex = /^[0-9]{10}$/;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (name === "") {
                $("#error_new_name").text("Product is required").addClass("error");
                hasError = true;
            } else if (!nameRegex.test(name)) {
                $("#error_new_name").text("Username should not contain numbers or special characters").addClass("error");
                hasError = true;
            } else {
                $("#error_new_name").text("");
            }

            if (contact === "") {
                $("#error_new_contact").text("Contact number is required").addClass("error");
                hasError = true;
            } else if (!contactRegex.test(contact)) {
                $("#error_new_contact").text("Please enter a valid 10-digit contact number").addClass("error");
                hasError = true;
            } else {
                $("#error_new_contact").text("");
            }

            if (hasError) {
                return ;
            }

            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                data: { id: id,name: name,contact: contact,email: email, gender: gender,city_id: city_id, role: role,update: true },
                success: function(response) {
                    if (response.includes("success")) {
                        show();
                        fetch_User();
                    } else if(response.includes("email")){
                        $("#error_new_email").text("Email is exist").addClass("error");
                    } else if(response.includes("contact")){
                        $("#error_new_contact").text("contact is exist").addClass("error");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        function delete_user(id){
            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                async: false,
                data: {delete: "done", id: id},
                success: function (response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        function Active(id){
            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                async: false,
                data: {active: "done", id: id},
                success: function (response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        function Deactive(id){
            console.log(id);
            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                async: false,
                data: {deactive: "done", id: id},
                success: function (response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        
        function fetch_User(){
            $.ajax({
                url: 'php/User_php.php',
                method: 'POST',
                async: false,
                data: {search: "done"},
                success: function (response) {
                    console.log(response);
                    $('#data').html(response);
                    show();
                    clearSearch();
                }
            });
        }

        function search() {
            // Check which checkboxes are selected
            var usernameChecked = $('#username_checkbox').is(':checked');
            var emailChecked = $('#email_checkbox').is(':checked');
            var stateChecked = $('#state_checkbox').is(':checked');
            var cityChecked = $('#city_checkbox').is(':checked');
            var genderChecked = $('#gender_checkbox').is(':checked');
            var roleChecked = $('#role_checkbox').is(':checked');
            var statusChecked = $('#status_checkbox').is(':checked');

            // If no checkboxes are selected, fetch all results
            if (!usernameChecked && !emailChecked && !stateChecked && !cityChecked && !genderChecked && !roleChecked && !statusChecked) {
                fetch_User(); // Assuming this fetches all data
                return;
            }

            // Collect search data based on selected checkboxes
            var searchData = { search: true };

            if (usernameChecked) {
                searchData.username = $('#search_username').val();
            }
            
            if (emailChecked) {
                searchData.email = $('#search_email').val();
            }

            if (stateChecked) {
                searchData.state_id = $('#search_state').val();
            }

            if (cityChecked) {
                searchData.city_id = $('#search_city').val();
            }

            if (genderChecked) {
                searchData.gender = $('#search_gender').val();
            }

            if (roleChecked) {
                searchData.role = $('#search_role').val();
            }

            if (statusChecked) {
                searchData.status = $('#search_active').val();
            }
            
            // Make an AJAX request to the server
            $.ajax({
                url: 'php/User_php.php', // Modify the URL if needed
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response); // Display the response in the appropriate div
                    show_search();
                }
            });
        }

        function clearSearch() {

            $('#username_checkbox').prop('checked', false);
            $('#email_checkbox').prop('checked', false);
            $('#state_checkbox').prop('checked', false);
            $('#city_checkbox').prop('checked', false);
            $('#gender_checkbox').prop('checked', false);
            $('#role_checkbox').prop('checked', false);
            $('#status_checkbox').prop('checked', false);

            $('#search_username').val('');
            $('#search_email').val('');
            fetch_state(3);
            $('#search_gender').val('Male');
            $('#search_role').val('Customer');
            $('#search_active').val('1');
        }

    </script>
</body>
</html>