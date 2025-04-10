<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <?php include "../static/libs.php"; ?>
    <link rel="stylesheet" href="../static/css/Admin/Admin.css">
    <style>
        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 5%;
        }
        thead th:nth-child(11),
        tbody td:nth-child(11),
        thead th:nth-child(12),
        tbody td:nth-child(12),
        thead th:nth-child(13), 
        tbody td:nth-child(13) {
            width: 100px; 
        }
    </style>
</head>
<body>
    <?php include "staff_header.php"; ?>

    <div class="title">Orders</div>
    <div class="top-frame">
        <button onclick="fetch_Order()" class="new-button">Show all</button>
        <button onclick="show_search()" class="new-button">Advance Search</button>
    </div>

    <div class="search-frame" id="show_search">
    <div class="search-item-box">
            <input type="checkbox" id="category_checkbox" class="search-item-check">
            <div class="search-item-label">Category</div>
            <select id="search_category" class="search-item-input" onchange="fetch_product()"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="product_checkbox" class="search-item-check">
            <div class="search-item-label">Product</div>
            <select id="search_product" class="search-item-input"></select>
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="date_checkbox" class="search-item-check">
            <div class="search-item-label">Date</div>
            <input type="date" placeholder="Select date" id="search_date" class="search-item-input">
        </div>
        <div class="search-item-box">
            <input type="checkbox" id="status_checkbox" class="search-item-check">
            <div class="search-item-label">Status</div>
            <select id="search_active" class="search-item-input">
                <option value="Paid" selected>Paid</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Dispatched">Dispatched</option>
                <option value="Delivered">Delivered</option>
            </select>
        </div>
        <button onclick="search()" class="search-button">Search</button>
        <button onclick="clearSearch()" class="clear-button">Clear</button>
    </div>
    <div id="show">
        <table>
            <thead>
                <th>Order Id</th>
                <th>Order Date</th>
                <th>Product img</th>
                <th>Product Name</th>
                <th>Product Color</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Username</th>
                <th>Contact Number</th>
                <th>remove</th>
                <th>Status</th>
                <th>updte</th>
            </thead>
            <tbody id="data">

            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            show();
            fetch_Order();
            fetch_category();
        });

        function show(){
            $("#show").show();
            $("#show_search").hide();
        }

        function show_search(){
            $("#show").show();
            $("#show_search").show();
        }

        function fetch_category() {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {category: "done"},
                success: function (response) {
                    $('#search_category').html(response);
                    fetch_product();
                }
            });
        }

        function fetch_product() {
            var C = $("#search_category").val();
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {product: "done", C:C},
                success: function (response) {
                    $('#search_product').html(response);
                }
            });
        }


        function fetch_Order() {
            $.ajax({
                url: 'php/Order_php.php',
                method: 'POST',
                async: false,
                data: { search: "done" },
                success: function (response) {
                    $('#data').html(response);
                    show();
                    clearSearch();
                }
            });
        }
        
        function remove_status(id, status) {
            let newStatus = status == "Delivered" ? "Dispatched" : status == "Dispatched" ? "Confirmed" : "Paid";
            if (newStatus) {
                $.ajax({
                    url: 'php/Order_php.php',
                    method: 'POST',
                    data: { opration: "remove", id: id, status: newStatus },
                    success: function () { 
                        fetch_Order(); 
                    }
                });
            }
        }

        function update_status(id, status) {
            let newStatus = status == "Paid" ? "Confirmed" : status == "Confirmed" ? "Dispatched" : "Delivered";
            if (newStatus) {
                $.ajax({
                    url: 'php/Order_php.php',
                    method: 'POST',
                    data: { opration: "update", id: id, status: newStatus },
                    success: function () { 
                        fetch_Order(); 
                    }
                });
            }
        }

        function search() {
            var categoryChecked = $('#category_checkbox').is(':checked');
            var productChecked = $('#product_checkbox').is(':checked');
            var dateChecked = $('#date_checkbox').is(':checked');
            var statusChecked = $('#status_checkbox').is(':checked');

            // If no checkboxes are selected, fetch all orders
            if (!categoryChecked && !productChecked && !dateChecked && !statusChecked) {
                fetch_Order();
                return;
            }

            var searchData = { search: true };
            if (categoryChecked) {
                searchData.category_id = $('#search_category').val();
            }

            if (productChecked) {
                searchData.product_id = $('#search_product').val();
            }

            if (dateChecked) {
                searchData.order_date = $('#search_date').val();
            }

            if (statusChecked) {
                searchData.status = $('#search_active').val();
            }

            // Log search data for debugging
            console.log(searchData);

            // Perform AJAX request to fetch filtered data
            $.ajax({
                url: 'php/Order_php.php',
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
            $('#date_checkbox').prop('checked', false);
            $('#status_checkbox').prop('checked', false);

            fetch_category();
            $('#search_date').val('');
            $('#search_active').val('Paid');
        }



    </script>
</body>
</html>
 