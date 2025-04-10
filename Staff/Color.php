<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>color</title>
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
    <?php include "staff_header.php"; ?>

    <div class="title">Color</div>
    <div class="top-frame">
        <button onclick="fetch_Color()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Search</button>
        <button onclick="show_insert()" class="new-button">make New Color</button>
    </div>
    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="color_name_checkbox" class="search-item-check">
            <div class="search-item-label">Color name</div>
            <input type="text" placeholder="Search by color name" id="search_color" class="search-item-input"><br>
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
                <th>Color</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class="frame-title">Add New Color</span>
        <div>
            <div class="label">Name : <span id="error_colorname" style="color:red;"></span></div>
            <input type="text" placeholder="color" id="colorname" class="input">
            <div class="label">select color : <span id="error_code" style="color:red;"></span></div>
            <input type="color" id="code">
        </div>
        <button onclick="insert_data()" class="add-button">Add color</button>
    </div>

    <div id="show_update">
        <span class="update frame-title">Update Color</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">Name:<span id="error_new_colorname" style="color:red;"></span> </div>
            <input type="text" placeholder="color" id="new_colorname" class="input">
            <div class="label">select color : <span id="error_new_code" style="color:red;"></span></div>
            <input type="color" id="new_code">
        </div>
        <button onclick="update()" class="update-button">Update color</button>
    </div>


    <script>
        $(document).ready(function () {
            show();
            fetch_Color();
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
        }

        function insert_data() {
            var colorname = $("#colorname").val();
            var code = $("#code").val();
            
            $("#error_colorname").text("");
            $("#error_code").text("");

            let hasError = false;

            if (colorname === "" ) {
                $("#error_colorname").text("Please enter color name");
                hasError = true;
            }
            if (code === "" ) {
                $("#error_code").text("select color code");
                hasError = true;
            }

            if (hasError) { return; }

            $.ajax({
                url: 'php/Color_php.php',
                method: 'POST',
                data: { colorname: colorname, code:code, insert:true},
                success: function (response) {
                    if (response.includes("success")) {
                        show();
                        fetch_Color();
                    } else if (response.includes("color_name")){
                        $("#error_colorname").text("color name already exist");
                    } else if (response.includes("code")){
                        $("#error_code").text("color already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        function show_update(id, colorname, code) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();
            
            $("#id").val(id);
            $("#new_colorname").val(colorname);
            $("#new_code").val(code);

        }

        function update() {
            var id = $("#id").val();
            var colorname = $("#new_colorname").val();
            var code = $("#new_code").val();
            
            $("#error_new_colorname").text("");
            $("#error_new_code").text("");

            let hasError = false;

            if (colorname === "" ) {
                $("#error_new_colorname").text("Please enter color name");
                hasError = true;
            }
            if (code === "" ) {
                $("#error_new_code").text("select color code");
                hasError = true;
            }

            if (hasError) { return; }

            $.ajax({
                url: 'php/Color_php.php',
                method: 'POST',
                data: { colorname:colorname, code:code, update:true, id:id},
                success: function(response) {
                    if (response.includes("success")) {
                        show();
                        fetch_Color();
                    } else if (response.includes("color_name")){
                        $("#error_new_colorname").text("color name already exist");
                    } else if (response.includes("code")){
                        $("#error_new_code").text("color already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        

        function delete_cat(id){
            $.ajax({
                url: 'php/Color_php.php',
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
                url: 'php/Color_php.php',
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
                url: 'php/Color_php.php',
                method: 'POST',
                async: false,
                data: {deactive: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }

        function fetch_Color(){
            $.ajax({
                url: 'php/Color_php.php',
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
            var colorNameChecked = $('#color_name_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');

            if (!colorNameChecked && !activeChecked) {
                fetch_Color();
                return;
            }

            var searchData = {
                search: true
            };
            
            if (colorNameChecked) {
                var colorName = $('#search_color').val();
                searchData.color_name = colorName;
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }

            $.ajax({
                url: 'php/Color_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#color_name_checkbox').prop('checked', false);
            $('#search_color').val('');
        }

    </script>
</body>
</html>