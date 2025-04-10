<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <?php include "../static/libs.php"; ?>
    <link rel="stylesheet" href="../static/css/Admin/Admin.css">
    <style>
        /* Adjust specific column widths */
        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 5%;
        }

        thead th:nth-child(3),
        tbody td:nth-child(3)
        thead th:nth-child(5),
        tbody td:nth-child(5) {
            width: 15%;
        }

        thead th:nth-child(7), 
        tbody td:nth-child(7),
        thead th:nth-child(8),
        tbody td:nth-child(8),
        thead th:nth-child(9),
        tbody td:nth-child(9) {
            width: 100px; 
        }


    </style>
</head>
<body>
    <?php include "staff_header.php"; ?>

    <div class="title">Product</div>
    <div class="top-frame">
        <button onclick="fetch_Product()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Advance Search</button>
        <button onclick="show_insert()" class="new-button">make New City</button>
    </div>
    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="category_checkbox" class="search-item-check">
            <div class="search-item-label">Category</div>
            <select id="search_category" class="search-item-input"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="product_name_checkbox" class="search-item-check">
            <div class="search-item-label">Product name</div>
            <input type="text" placeholder="Search by product name" id="search_product" class="search-item-input"><br>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="ingredients_name_checkbox" class="search-item-check">
            <div class="search-item-label">Ingredients name</div>
            <input type="text" placeholder="Search by ingredients name" id="search_ingredients" class="search-item-input"><br>
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
                <th>Category name</th>
                <th>Prodcut </th>
                <th>Description</th>
                <th>ingredients</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <div id="show_insert">
        <span class="frame-title">Add New Product</span>
        <div>
            <div class="label">Category <span id="error_category" style="color:red;"></span></div>
            <select id="category" class="input"></select>
            <div class="label">Name <span id="error_prodname" style="color:red;"></span></div>
            <input type="text" placeholder="product" id="prodname" class="input">
            <div class="label">Description <span id="error_desc" style="color:red;"></span></div>
            <input type="text" id="desc" class="input">
            <div class="label">ingredients <span id="error_ingredients" style="color:red;"></span></div>
            <input type="text" id="ingredients" class="input">
            <button onclick="insert_data()" class="add-button">Add Product</button>
        </div>
    </div>

    <div id="show_update">
        <span class="frame-title">Update Product</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">Category <span id="error_new_category" style="color:red;"></span></div>
            <select id="new_category" class="input"></select>  
            <div class="label">Name <span id="error_new_product" style="color:red;"></span></div>
            <input type="text" placeholder="product" id="new_prodname" class="input">
            <div class="label">Description <span id="error_new_desc" style="color:red;"></span></div>
            <input type="text" id="new_desc" class="input">
            <div class="label">ingredients <span id="error_new_ingredients" style="color:red;"></span></div>
            <input type="text" id="new_ingredients" class="input">
            <button onclick="update()" class="update-button">Update Product</button>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            show();
            fetch_Product();
            fetch_category(3);
        });

        function fetch_category(num) {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {category: "done"},
                success: function (response) {
                    if (num == 1){
                        $('#category').html(response);
                    }
                    else if(num == 2){
                        $('#new_category').html(response);
                    }
                    else if(num == 3){
                        $('#search_category').html(response);
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
            fetch_category(1);
        }

        function insert_data() {
            var prodname = $("#prodname").val();
            var desc = $("#desc").val();
            var ingredients = $("#ingredients").val();
            var category = $("#category").val();

            $("#error_category").text("");
            $("#error_prodname").text("");
            $("#error_desc").text("");
            $("#error_ingredients").text("");

            let hasError = false;

            // Validation conditions for "Add New Product"
            if (category === "") {
                $("#error_category").text("Category is required");
                hasError = true;
            }

            if (prodname === "") {
                $("#error_prodname").text("Product name is required");
                hasError = true;
            }

            if (desc === "") {
                $("#error_desc").text("Description is required");
                hasError = true;
            }

            if (ingredients === "") {
                $("#error_ingredients").text("Ingredients are required");
                hasError = true;
            }

            if (hasError) { return; }

            $.ajax({
                url: 'php/Product_php.php',
                method: 'POST',
                data: { category:category,prodname: prodname, desc:desc ,ingredients:ingredients, insert:true},
                success: function (response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_Product();
                    }else if (response.includes("prodname")){
                        $("#error_prodname").text("product already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

        function select_tag(value){
            var selectElement = document.getElementById("new_category");
            var searchText = value;
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value === searchText) {
                    selectElement.options[i].selected = true;
                    break;
                }
            }
        }

        function show_update(id, cat_id, prodname, desc, ingredients) {
            $("#show").hide();
            $("#show_insert").hide();
            $("#show_update").show();
            
            $("#id").val(id);
            $("#new_prodname").val(prodname);
            $("#new_desc").val(desc);
            $("#new_ingredients").val(ingredients);

            fetch_category(2);
            select_tag(cat_id);
        }

        function update() {
            var id = $("#id").val();
            var prodname = $("#new_prodname").val();
            var desc = $("#new_desc").val();
            var ingredients = $("#new_ingredients").val();
            var category = $("#new_category").val();

            $("#error_new_category").text("");
            $("#error_new_product").text("");
            $("#error_new_desc").text("");
            $("#error_new_ingredients").text("");

            let hasError = false;

            // Validation conditions for "Update Product"
            if (category === "") {
                $("#error_new_category").text("Category is required");
                hasError = true;
            }

            if (prodname === "") {
                $("#error_new_product").text("Product name is required");
                hasError = true;
            }

            if (desc === "") {
                $("#error_new_desc").text("Description is required");
                hasError = true;
            }

            if (ingredients === "") {
                $("#error_new_ingredients").text("Ingredients are required");
                hasError = true;
            }

            if (hasError) { return; }

            $.ajax({
                url: 'php/Product_php.php',
                method: 'POST',
                data: { category:category, prodname:prodname, desc:desc, ingredients:ingredients, update:true, id:id},
                success: function(response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_Product();
                    } else if (response.includes("prodname")){
                        $("#error_new_product").text("prodname already exist");
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        }

       

        function delete_product(id){
            $.ajax({
                url: 'php/Product_php.php',
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
                url: 'php/Product_php.php',
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
                url: 'php/Product_php.php',
                method: 'POST',
                async: false,
                data: {deactive: "done", id: id},
                success: function (response) {
                    show_search();
                    search();
                }
            });
        }

        function fetch_Product(){
            $.ajax({
                url: 'php/Product_php.php',
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
            var categoryChecked = $('#category_checkbox').is(':checked');
            var productNameChecked = $('#product_name_checkbox').is(':checked');
            var ingredientsNameChecked = $('#ingredients_name_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');
            
            if (!ingredientsNameChecked && !productNameChecked && !categoryChecked && !activeChecked) {
                fetch_Product();
                return;
            }

            var searchData = {
                search: true
            };

            if (categoryChecked) {
                searchData.category_id = $('#search_category').val();
            }
            
            if (productNameChecked) {
                searchData.product_name = $('#search_product').val();
            }

            if (ingredientsNameChecked) {
                searchData.ingredients = $('#search_ingredients').val();
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }

            $.ajax({
                url: 'php/Product_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#state_checkbox').prop('checked', false);
            $('#product_name_checkbox').prop('checked', false);
            $('#ingredients_name_checkbox').prop('checked', false);
            
            fetch_category(3);
            $('#search_product').val('');
            $('#search_ingredients').val('');
        }

    </script>
</body>
</html>