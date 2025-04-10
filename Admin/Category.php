<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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

    <div class="title">Category</div>
    <div class="top-frame">
        <button onclick="fetch_Category()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Search</button>
        <button onclick="show_insert()" class="new-button">make New State</button>
    </div>
    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="category_name_checkbox" class="search-item-check">
            <div class="search-item-label">Category name</div>
            <input type="text" placeholder="Search by city name" id="search_category" class="search-item-input"><br>
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
                <th>Image</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class=" frame-title">Add New Category</span>
        <div>
            <div class="label">Category Name <span id="error_catname" style="color:red;">*</span></div>
            <input type="text" placeholder="category" id="catname" class="input">
        </div>
        <div class="image">
            <img id="preview" src="" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
            <input type="file" id="catimage" accept="image/*" onchange="previewImage(event, 1)">
        </div>
        <button onclick="insert_data()" class="add-button">Add Category</button>
    </div>

    <div id="show_update">
    <span class=" frame-title">Update Category</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">Category Name <span id="error_new_catname" style="color:red;">*</span></div>
            <input type="text" placeholder="category" id="new_catname" class="input">
        </div>
        <div class="image">
            <img id="preview_update" src="" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
            <input type="file" id="new_catimage" accept="image/*" onchange="previewImage(event, 2)">
        </div>
        <button onclick="update()" class="update-button">Update Category</button>
    </div>


    <script>
        $(document).ready(function () {
            show();
            fetch_Category();
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
            var categoryName = $("#catname").val();
            var categoryImage = $("#catimage")[0].files[0];
            
            $("#error_catname").text("");
            var hasError = false;
            if (!categoryName) {
                $("#error_catname").text("Category name cannot be empty.");
                hasError = true;
            }
            if (!categoryImage) {
                alert("Category image cannot be empty.");
                hasError = true;
            }
            if (hasError) { return; }

            var formData = new FormData();
            formData.append('category_name', categoryName);
            formData.append('image', categoryImage);
            formData.append('insert', 'done');

            $.ajax({
                url: 'php/Category_php.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_Category();
                    } else if (response.includes("catname")){
                        $("#error_catname").text("category already exist");
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error: ", textStatus, errorThrown);
                    alert("An error occurred while uploading.");
                }
            });
        }

        function show_update(id, name, img) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();

            $("#id").val(id);
            $("#new_catname").val(name);
            $("#preview_update").attr("src", "/Beautics/static/system_img/category/" + img);
        }

        function update() {
            var id = $("#id").val();
            var categoryName = $("#new_catname").val();
            var categoryImage = $("#new_catimage")[0].files[0];

            $("#error_new_catname").text("");
            var hasError = false;
            if (!categoryName) {
                $("#error_new_catname").text("Category name cannot be empty.");
                hasError = true;
            }
            if (hasError) { return; }

            var formData = new FormData();
            formData.append('id', id);
            formData.append('category_name', categoryName);

            if (categoryImage) {
                formData.append('image', categoryImage);
            }
            formData.append('update', 'done');

            $.ajax({
                url: 'php/Category_php.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_Category();
                    } else if (response.includes("catname")){
                        $("#error_new_catname").text("category already exist");
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error: ", textStatus, errorThrown);
                    alert("An error occurred while updating.");
                }
            });
        }

        

        function delete_cat(id){
            $.ajax({
                url: 'php/Category_php.php',
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
                url: 'php/Category_php.php',
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
                url: 'php/Category_php.php',
                method: 'POST',
                async: false,
                data: {deactive: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }

        function previewImage(event, id) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (id == 1){
                        document.getElementById('preview').src = e.target.result;
                    }
                    else {
                        document.getElementById('preview_update').src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function fetch_Category(){
            $.ajax({
                url: 'php/Category_php.php',
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
            var CategoryNameChecked = $('#category_name_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');

            if (!CategoryNameChecked && !activeChecked) {
                fetch_Category();
                return;
            }

            var searchData = {
                search: true
            };
            
            if (CategoryNameChecked) {
                searchData.category_name = $('#search_category').val();
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }


            $.ajax({
                url: 'php/Category_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    console.log(response);
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#category_name_checkbox').prop('checked', false);
            $('#search_category').val('');
        }

    </script>
</body>
</html>