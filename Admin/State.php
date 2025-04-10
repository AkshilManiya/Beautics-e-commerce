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
        tbody td:nth-child(2) {
            width: 100%;
        }

        thead th:nth-child(3), 
        tbody td:nth-child(3),
        thead th:nth-child(4),
        tbody td:nth-child(4),
        thead th:nth-child(5),
        tbody td:nth-child(5) {
            width: 100px; 
        }

    </style>

</head>

<body>
    <?php include "admin_sider.php"; ?>

    <div class="title"> State</div>
    <div class="top-frame">
        <button onclick="fetch_State()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Search</button>
        <button onclick="show_insert()" class="new-button">make New State</button>
    </div>
    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="state_name_checkbox" class="search-item-check">
            <div class="search-item-label">State name</div>
            <input type="text" placeholder="Search by city name" id="search_state" class="search-item-input"><br>
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
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class="insert frame-title">Add New State</span>
        <div>
            <div class="label">State Name <span id="error_name" style="color:red;">*</span></div>
            <input type="text" placeholder="state" id="statename" class="input">
        </div>
        <button onclick="insert_data()" class="add-button">Add State</button>
    </div>

    <div id="show_update" >
        <span class="update frame-title">Update State</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">State Name <span id="error_statename" style="color:red;">*</span></div>
            <input type="text" placeholder="state" id="new_statename" class="input">
        </div>
        <button onclick="update()" class="update-button">Update State</button>
    </div>


    <script>
        $(document).ready(function() {
            show();
            fetch_State();
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

        function show_insert() {
            $("#show_insert").show();
            $("#show").hide();
            $("#show_update").hide();
        }

        function insert_data() {
            var statename = $("#statename").val();

            $("#error_name").text("");

            if (statename === "" || !/^[a-zA-Z\s]+$/.test(statename)) {
                $("#error_name").text("State name should only contain letters and spaces");
                return;
            }

            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                data: {
                    statename: statename,
                    insert: true
                },
                success: function(response) {
                    if (response.includes("success")) {
                        show();
                        fetch_State();
                    } else if (response.includes("statename")){
                        $("#error_name").text("state already exist");
                    }
                    else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        function show_update(id, statename) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();

            $("#id").val(id);
            $("#new_statename").val(statename);
        }

        function update() {
            var id = $("#id").val();
            var statename = $("#new_statename").val();

            $("#error_statename").text("");

            if (statename === "" || !/^[a-zA-Z\s]+$/.test(statename)) {
                $("#error_statename").text("State name should only contain letters and spaces");
                return;
            }

            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                data: {
                    statename: statename,
                    update: true,
                    id: id
                },
                success: function(response) {
                    if (response.includes("success")) {
                        show();
                        fetch_State();
                    } else if (response.includes("statename")){
                        $("#error_statename").text("state already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }


        function delete_sat(id) {
            console.log(id);
            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                async: false,
                data: {
                    delete: "done",
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        function Active(id) {
            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                async: false,
                data: {
                    active: "done",
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        function Deactive(id) {
            console.log(id);
            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                async: false,
                data: {
                    deactive: "done",
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    show_search();
                    search();
                }
            });
        }

        
        function fetch_State() {
            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                async: false,
                data: {
                    search: "done"
                },
                success: function(response) {
                    $('#data').html(response);
                    clearSearch();
                    show();
                }
            });
        }

        function search() {            
            var cityNameChecked = $('#state_name_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');
            
            if (!cityNameChecked && !activeChecked) {
                fetch_State();
                return;
            }

            var searchData = {
                search: true
            };
            
            if (cityNameChecked) {
                var stateName = $('#search_state').val();
                searchData.state_name = stateName;
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }

            $.ajax({
                url: 'php/State_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#state_name_checkbox').prop('checked', false);
            $('#search_state').val('');
        }
    </script>
</body>

</html>