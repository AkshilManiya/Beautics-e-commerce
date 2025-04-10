<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City</title>
    <?php include "../static/libs.php"; ?>
    <link rel="stylesheet" href="../static/css/Admin/Admin.css">
    <style>
        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 5%;
        }

        thead th:nth-child(2), 
        tbody td:nth-child(2),
        thead th:nth-child(3), 
        tbody td:nth-child(3) {
            width: 50%;
        }

        thead th:nth-child(4), 
        tbody td:nth-child(4),
        thead th:nth-child(5),
        tbody td:nth-child(5),
        thead th:nth-child(6),
        tbody td:nth-child(6) {
            width: 100px; 
        }

    </style>
</head>
<body>

    <?php include "admin_sider.php"; ?>

    <div class="title">City</div>
    <div class="top-frame">
        <button onclick="fetch_City()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Advance Search</button>
        <button onclick="show_insert()" class="new-button">make New City</button>
    </div>
    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="city_name_checkbox" class="search-item-check">
            <div class="search-item-label">City name</div>
            <input type="text" placeholder="Search by city name" id="search_city" class="search-item-input"><br>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="state_checkbox" class="search-item-check">
            <div class="search-item-label">State</div>
            <select id="search_state" class="search-item-input"></select>
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
                <th>state name</th>
                <th>City </th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class="insert frame-title">Add New City</span>
        <div>
            <div class="label">State : <span id="error_state" style="color:red;"></span></div>
            <select id="state" class="input"></select>
            <div class="label">City Name : <span id="error_cityname" style="color:red;"></span></div>
            <input type="text" placeholder="City" id="cityname" class="input">
        </div>
        <button onclick="insert_data()" class="add-button">Add City</button>
    </div>

    <div id="show_update">
        <span class="insert frame-title">Update City</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">State : <span id="error_new_state" style="color:red;"></span></div>
            <select id="new_state" class="input"></select>
            <div class="label">City Name : <span id="error_new_cityname" style="color:red;"></span></div>
            <input type="text" placeholder="City" id="new_cityname" class="input">
        </div>
        <button onclick="update()" class="update-button">Update City</button>
    </div>


    <script>
        $(document).ready(function () {
            show();
            fetch_City();
            fetch_state(3);
        });

        function fetch_state(num) {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {state: "done"},
                success: function (response) {
                    if (num == 1){
                        $('#state').html(response);
                    }
                    else if(num == 2){
                        $('#new_state').html(response);
                    }
                    else if(num == 3){
                        $('#search_state').html(response);
                    }
                }
            });
        }

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

        function insert_data() {
            var cityname = $("#cityname").val();
            var state = $("#state").val();

            $("#error_cityname").text("");

            if (cityname === "" || !/^[a-zA-Z\s]+$/.test(cityname)) {
                $("#error_cityname").text("City name should only contain letters and spaces");
                return;
            }

            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                data: { state:state, cityname:cityname, insert:true},
                success: function (response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_City();
                    } else if (response.includes("cityname")){
                        $("#error_cityname").text("city already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        function select_tag(value){
            var selectElement = document.getElementById("new_state");
            var searchText = value;
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value === searchText) {
                    selectElement.options[i].selected = true;
                    break;
                }
            }
        }

        function show_update(id, state, cityname) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();
            
            $("#id").val(id);
            $("#new_cityname").val(cityname);
            fetch_state(2);
            select_tag(state);
        }

        function update() {
            var id = $("#id").val();
            var cityname = $("#new_cityname").val();
            var state = $("#new_state").val();

            $("#error_new_cityname").text("");

            if (cityname === "" || !/^[a-zA-Z\s]+$/.test(cityname)) {
                $("#error_new_cityname").text("City name should only contain letters and spaces");
                return;
            }

            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                data: { state:state, cityname:cityname, update:true, id:id},
                success: function(response) {
                    if (response.includes("success")) {
                        show();
                        fetch_City();
                    } else if (response.includes("cityname")){
                        $("#error_new_cityname").text("city already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        
        function delete_City(id){
            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                async: false,
                data: {delete: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }

        function Active(id){
            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                async: false,
                data: {active: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }
        
        function Deactive(id){
            console.log(id);
            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                async: false,
                data: {deactive: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }
        
        function fetch_City(){
            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                async: false,
                data: {search: "done"},
                success: function (response) {
                    $('#data').html(response);
                    clearSearch();
                    show();
                }
            });
        }

        function search() {            
            var cityNameChecked = $('#city_name_checkbox').is(':checked');
            var stateChecked = $('#state_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');

            if (!cityNameChecked && !stateChecked && !activeChecked) {
                fetch_City();
                return;
            }

            var searchData = {
                search: true
            };
            
            if (cityNameChecked) {
                var cityName = $('#search_city').val();
                searchData.city_name = cityName;
            }
            
            if (stateChecked) {
                var state = $('#search_state').val();
                searchData.state = state;
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }

            $.ajax({
                url: 'php/City_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#city_name_checkbox').prop('checked', false);
            $('#state_checkbox').prop('checked', false);
            
            $('#search_city').val('');
            fetch_state(3);
        }



    </script>
</body>
</html>