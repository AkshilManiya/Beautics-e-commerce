<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Description</title>
    <?php include "../static/libs.php"; ?>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        /* General Container Styling */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 20px auto;
            gap: 30px;
        }

        /* Image Section */
        .image-section {
            flex: 1;
            max-width: 40%;
            display: flex;
            flex-direction: column;
        }

        .image-section img {
            width: 300px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .image-section div {
            height: 100px;
            margin-top: 10px;

            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: center;
        }

        .user-btn {
            margin: 10px;
        }




        /* Product Details Section */
        .details-section {
            flex: 2;
            padding: 10px;
        }

        .details-section h1 {
            font-size: 28px;
            color: #333;
        }

        .details-section p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .details-section strong {
            color: #333;
        }

        .details-section .colors,
        .details-section .amounts {
            margin-top: 15px;
        }

        /* Available Colors */
        #colors .color {
            display: inline-block;
            cursor: pointer;
            margin-right: 10px;
        }

        #colors .color div {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #333;
        }

        /* Available Amounts */
        #amounts .amount {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            background-color: white;
            transition: background-color 0.2s ease;
        }

        #amounts .amount:hover {
            background-color: #f0f0f0;
        }

        /* Buttons Styling */
        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                gap: 20px;
            }

            .image-section,
            .details-section {
                max-width: 100%;
            }
        }

        .check_true {
            background-color: gray;
            cursor: not-allowed;
            /* Show disabled cursor */
        }

        .check_false {
            background-color: green;
            cursor: pointer;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            color: #4CAF50;
            margin: auto;
            width: 80%;
        }
    </style>
</head>

<body>
    <?php include "customer_header.php"; ?>
    <div class="title">Description</div>
    <div class="container">
        <!-- Product Image -->
        <div class="image-section">
            <img id="productImage" src="" alt="Product Image">
            <div>
                <button class='user-btn cart' onclick="Add_to_cart()">Add to cart</button>
                <button class='user-btn wishlist' onclick="Add_to_wishlist()">Add to wishlist</button>
            </div>
        </div>

        <!-- Product Details -->
        <div class="details-section">
            <h1 id="name">Product Name</h1>
            <p id="desc">Product description goes here...</p>
            <p><strong>Ingredients:</strong> <span id="ingredients"></span></p>

            <div>
                <div>Avilable colors</div>
                <div id="colors">
                </div>
            </div>
            <div>
                <div>Avilable amount</div>
                <div id="amounts">
                </div>
            </div>
            <button onclick="window.location.href=`Order.php?product=${varId}`">buy now</button>
        </div>
    </div>

    <script>
        var productId = 0;
        var varId = 0;
        $(document).ready(function() {
            productId = getQueryParam('product');
            fetch_product();
        });

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        function fetch_product() {
            console.log(productId);
            $.ajax({
                url: 'php/Description_php.php',
                type: 'POST',
                data: {
                    product: productId
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    console.log(data);
                    $("#name").html(data[0].product_name);
                    $("#desc").html(data[0].description);
                    $("#ingredients").html(data[0].ingredients);
                    fetch_colors();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function fetch_colors() {
            $.ajax({
                url: 'php/Description_php.php',
                type: 'POST',
                data: {
                    colors: productId
                },
                success: function(response) {
                    console.log(response);
                    $('#colors').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function fetch_amounts(color_id) {
            $.ajax({
                url: 'php/Description_php.php',
                type: 'POST',
                data: {
                    amounts: productId,
                    color: color_id
                },
                success: function(response) {
                    // console.log(color_id, response);
                    $('#amounts').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function fetch_other_details(color_id) {
            $.ajax({
                url: 'php/Description_php.php',
                type: 'POST',
                data: {
                    amounts: productId,
                    color: color_id
                },
                success: function(response) {
                    // console.log(color_id, response);
                    $('#amounts').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function updateProductImage(id, imagePath) {
            varId = id;
            $("#productImage").attr('src', `/Beautics/static/system_img/variants/${imagePath}`);
            check_user_activity();
        }

        function check_user_activity() {
            $.ajax({
                url: 'php/Description_php.php',
                type: 'POST',
                data: {
                    check_varid: varId
                },
                success: function(response) {
                    const result = JSON.parse(response);

                    // Handle "Add to Cart" button
                    if (result.in_cart) {
                        $(".cart").prop('disabled', true).removeClass('check_false').addClass('check_true');
                    } else {
                        $(".cart").prop('disabled', false).removeClass('check_true').addClass('check_false');
                    }

                    // Handle "Add to Wishlist" button
                    if (result.in_wishlist) {
                        $(".wishlist").prop('disabled', true).removeClass('check_false').addClass('check_true');
                    } else {
                        $(".wishlist").prop('disabled', false).removeClass('check_true').addClass('check_false');
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }


        function Add_to_cart() {
            console.log(varId);
            $.ajax({
                url: 'php/Cart_php.php',
                type: 'POST',
                data: {
                    add_to_cart: varId
                },
                success: function(response) {
                    check_user_activity();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function Add_to_wishlist() {
            console.log("hello");
            console.log(varId);
            $.ajax({
                url: 'php/Wishlist_php.php',
                type: 'POST',
                data: {
                    add_to_wishlist: varId
                },
                success: function(response) {
                    check_user_activity();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>