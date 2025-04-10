<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variants</title>
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
        tbody td:nth-child(3) {
            width: 20%;
        } 

        thead th:nth-child(10), 
        tbody td:nth-child(10),
        thead th:nth-child(11),
        tbody td:nth-child(11),
        thead th:nth-child(12),
        tbody td:nth-child(12) {
            width: 100px; 
        }

        .error{
            color:red;
        }

    </style>
</head>
<body>


    <?php include "admin_sider.php"; ?>

    <div class="title">Variant</div>
    <div class="top-frame">
        <button onclick="fetch_Variants()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Advance Search</button>
        <button onclick="show_insert()" class="new-button">Add New Variant</button>
    </div>

    <div class="search-frame" id="show_search">
        <div class="search-item-box">
            <input type="checkbox" id="category_checkbox" class="search-item-check">
            <div class="search-item-label">Category</div>
            <select id="search_category" class="search-item-input" onchange="fetch_product(3)"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="product_checkbox" class="search-item-check">
            <div class="search-item-label">Product</div>
            <select id="search_product" class="search-item-input"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="color_checkbox" class="search-item-check">
            <div class="search-item-label">Color</div>
            <input type="text" placeholder="Search by color name" id="search_color" class="search-item-input">
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="amount_checkbox" class="search-item-check">
            <div class="search-item-label">Amount</div>
            <input type="text" placeholder="Search by amount" id="search_amount" class="search-item-input">
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
                <th>Category</th>   
                <th>Product</th>
                <th>Color</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody id="data">
                <!-- Data will be inserted here via AJAX -->
            </tbody>
        </table>
    </div>

    <div id="show_insert">
    <span class="frame-title">Add New Variant</span>
        <div>
            <div class="label">Category <span id="error_cat"></span></div><select class="input" id="category" onchange="fetch_product(1)"></select>
            <div class="label">product <span id="error_prod"></span></div><select class="input" id="product"></select>
            <div class="label">Color <span id="error_color"></span></div><select class="input" id="color"></select>
            <div class="label">Type <span id="error_type"></span></div><input class="input" type="text" placeholder="Type" id="type">
            <div class="label">Amount <span id="error_amount"></span></div><input class="input" type="number" placeholder="Amount" id="amount">
            <div class="label">Price <span id="error_price"></span></div><input class="input" type="number" placeholder="Price" id="price">
            <div class="label">Quantity <span id="error_quan"></span></div><input class="input" type="number" placeholder="Quantity" id="quantity">
        </div>
        <div class="image">
            <img id="preview" src="" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
            <input type="file" id="varimage" accept="image/*" onchange="previewImage(event, 1)">
        </div>
        <button onclick="insert_data()" class="add-button">Add variants</button>
    </div>

    <div id="show_update">
    <span class="frame-title">Update Variant</span>
        <div>
            <input type="hidden" id="id">
            <div class="label">Category <span id="error_new_cat"></span></div><select class="input" id="new_category" onchange="fetch_product(2)"></select>
            <div class="label">Product  <span id="error_new_prod"></span></div><select class="input" id="new_product"></select>
            <div class="label">Color    <span id="error_new_color"></span></div><select class="input" id="new_color"></select>
            <div class="label">Type     <span id="error_new_type"></span></div><input class="input" type="text" placeholder="Type" id="new_type">
            <div class="label">Amount   <span id="error_new_amount"></span></div><input class="input" type="number" placeholder="Amount" id="new_amount">
            <div class="label">Price    <span id="error_new_price"></span></div><input class="input" type="number" placeholder="Price" id="new_price">
            <div class="label">Quantity <span id="error_new_quan"></span></div><input class="input" type="number" placeholder="Quantity" id="new_quantity">
        </div>
        <div class="image">
            <img id="preview_update" src="" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
            <input type="file" id="new_varimage" accept="image/*" onchange="previewImage(event, 2)">
        </div>
        <button onclick="update()" class="update-button">Update variants</button>
    </div>

    <script>
        $(document).ready(function () {
            show();
            fetch_Variants();
        });

        function fetch_category(num) {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {category: "done"},
                success: function (response) {
                    console.log(response);
                    if (num == 1){
                        $('#category').html(response);
                        fetch_product(1);
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

        function fetch_product(num) {
            if (num == 1){
                var C = $("#category").val();
            } else if (num == 2){
                var C = $("#new_category").val();
            } else if(num == 3){
                var C = $("#search_category").val();
            }
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {product: "done", C:C},
                success: function (response) {
                    console.log(response);
                    if (num == 1){
                        $('#product').html(response);
                    }
                    else if(num == 2){
                        $('#new_product').html(response);
                    }
                    else if(num == 3){
                        $('#search_product').html(response);
                    }
                }
            });
        }

        function fetch_color(num) {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {color: "done"},
                success: function (response) {
                    console.log(response);
                    if (num == 1){
                        $('#color').html(response);
                    }
                    else if(num == 2){
                        $('#new_color').html(response);
                    }
                    else if(num == 3){
                        $('#search_color').html(response);
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

        function show_insert() {
            $("#show_insert").show();
            $("#show").hide();
            $("#show_update").hide();
            fetch_category(1);
            fetch_color(1);
        }

        function insert_data() {
            var product = $("#product").val();
            var color = $("#color").val();
            var type = $("#type").val();
            var amount = $("#amount").val();
            var price = $("#price").val();
            var quantity = $("#quantity").val();
            var variantsImage = $("#varimage")[0].files[0];


             // Clear previous error messages
            $(".error").text("");

            let hasError = false;
            
            if (product === "") {
                $("#error_prod").text("Product is required").addClass("error");
                hasError = true;
            }

            // Validate Color
            if (color === "") {
                $("#error_color").text("Color is required").addClass("error");
                hasError = true;
            }

            // Validate Type
            if (type === "") {
                $("#error_type").text("Type is required").addClass("error");
                hasError = true;
            }

            // Validate Amount
            if (amount === "" || amount <= 0) {
                $("#error_amount").text("Amount must be a positive number").addClass("error");
                hasError = true;
            }

            // Validate Price
            if (price === "" || price <= 0) {
                $("#error_price").text("Price must be a positive number").addClass("error");
                hasError = true;
            }

            // Validate Quantity
            if (quantity === "" || quantity <= 0) {
                $("#error_quan").text("Quantity must be a positive number").addClass("error");
                hasError = true;
            }

            // Validate Image
            if (!variantsImage) {
                alert("variant image cannot be empty.");
                hasError = true;
            }

            if (hasError) { return; }

            var formData = new FormData();
            formData.append('product', product);
            formData.append('color', color);
            formData.append('type', type);
            formData.append('amount', amount);
            formData.append('price', price);
            formData.append('quantity', quantity);
            formData.append('image', variantsImage);
            formData.append('insert', 'done');

            $.ajax({
                url: 'php/Variants_php.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.includes("success")) {
                        show();
                        fetch_Variants();
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

        function select_tag(id, value){
            var selectElement = document.getElementById(id);
            var searchText = value;
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value === searchText) {
                    selectElement.options[i].selected = true;
                    break;
                }
            }
        }

        function show_update(id, cat_id, prod_id, color_id, type, amount, price, quantity, img) {
            $("#show").hide();
            $("#insert").hide();
            $("#show_update").show();

            $("#id").val(id);
            $("#new_type").val(type);
            $("#new_amount").val(amount);
            $("#new_price").val(price);
            $("#new_quantity").val(quantity);
            $("#preview_update").attr("src", "/Beautics/static/system_img/variants/" + img);

            fetch_category(2);
            select_tag("new_category", cat_id);
            fetch_product(2);
            console.log(cat_id);
            select_tag("new_product", prod_id);
            fetch_color(2);
            select_tag("new_color", color_id);

        }

        function update() {
            var id = $("#id").val();
            var product = $("#new_product").val();
            var color = $("#new_color").val();
            var type = $("#new_type").val();
            var amount = $("#new_amount").val();
            var price = $("#new_price").val();
            var quantity = $("#new_quantity").val();
            var variantsImage = $("#new_varimage")[0].files[0];

            $(".error").text("");

            let hasError = false;

            // Validate Product
            if (product === "") {
                $("#error_new_prod").text("Product is required").addClass("error");
                hasError = true;
            }

            // Validate Color
            if (color === "") {
                $("#error_new_color").text("Color is required").addClass("error");
                hasError = true;
            }

            // Validate Type
            if (type === "") {
                $("#error_new_type").text("Type is required").addClass("error");
                hasError = true;
            }

            // Validate Amount
            if (amount === "" || amount <= 0) {
                $("#error_new_amount").text("Amount must be a positive number").addClass("error");
                hasError = true;
            }

            // Validate Price
            if (price === "" || price <= 0) {
                $("#error_new_price").text("Price must be a positive number").addClass("error");
                hasError = true;
            }

            // Validate Quantity
            if (quantity === "" || quantity <= 0) {
                $("#error_new_quan").text("Quantity must be a positive number").addClass("error");
                hasError = true;
            }

            if (hasError) { return; }

            var formData = new FormData();
            formData.append('id', id);
            formData.append('product', product);
            formData.append('color', color);
            formData.append('type', type);
            formData.append('amount', amount);
            formData.append('price', price);
            formData.append('quantity', quantity);

            if (variantsImage) {
                formData.append('image', variantsImage);
            }
            formData.append('update', 'done');

            $.ajax({
                url: 'php/Variants_php.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.includes("success")) {
                        show();
                        fetch_Variants();
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


        function delete_variant(id){
            $.ajax({
                url: 'php/Variants_php.php',
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
            console.log("Active",id);
            $.ajax({
                url: 'php/Variants_php.php',
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
            console.log("Deactive",id);
            $.ajax({
                url: 'php/Variants_php.php',
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

        function previewImage(event, id) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (id == 1){
                        document.getElementById("preview").src = e.target.result;
                    } else {
                        document.getElementById("preview_update").src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        }
        
        function fetch_Variants(){
            $.ajax({
                url: 'php/Variants_php.php',
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
            var categoryChecked = $('#category_checkbox').is(':checked');
            var productChecked = $('#product_checkbox').is(':checked');
            var colorChecked = $('#color_checkbox').is(':checked');
            var amountChecked = $('#amount_checkbox').is(':checked');
            var activeChecked = $('#status_checkbox').is(':checked');

            
            if (!categoryChecked && !productChecked && !colorChecked && !amountChecked && !activeChecked) {
                fetch_Variants();
                return;
            }

            var searchData = { search: true };

            if (categoryChecked) {
                searchData.category_id = $('#search_category').val();
            }
            
            if (productChecked) {
                searchData.product_id = $('#search_product').val();
            }

            if (colorChecked) {
                searchData.color_name = $('#search_color').val();
            }

            if (amountChecked) {
                searchData.amount_type = $('#search_amount').val();
            }

            if (activeChecked) {
                searchData.status = $('#search_active').val();
            }

            console.log(searchData);
            $.ajax({
                url: 'php/Variants_php.php',
                method: 'POST',
                data: searchData,
                success: function (response) {
                    $('#data').html(response);
                    show_search();
                }
            });
        }

        function clearSearch() {
            $('#category_checkbox').prop('checked', false);
            $('#product_checkbox').prop('checked', false);
            $('#color_checkbox').prop('checked', false);
            $('#amount_checkbox').prop('checked', false);
            $('#active_checkbox').prop('checked', false);
            
            fetch_category(3);
            fetch_product(3);
            fetch_color(3);
            $('#search_amount').val('');
            $('#search_active').val('1');
        }

    </script>
</body>
</html>
