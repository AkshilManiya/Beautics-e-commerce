<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Product</title>
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

        #data {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            padding: 20px;
            gap: 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: auto;
            width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product div {
            margin-top: 10px;
        }

        .product .desc {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: nowrap;
            margin-left: 20px;
        }

        #search {
            padding: 10px;
            width: 300px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .product {
                width: 180px;
            }

            #search {
                width: 200px;
            }
        }

        .product_search,
        .lable {
            margin: auto;
            width: 85%;
            height: auto;
        }

        .upper_frame {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8fafc;
            /* Light background for the frame */
            border-radius: 12px;
            /* Rounded corners */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            margin-bottom: 20px;
            /* Space below the frame */
        }

        .title {
            font-size: 28px;
            /* Adjusted for better balance */
            font-weight: bold;
            color: #2563eb;
            /* Vibrant blue color */
            margin: 0;
            padding-right: 10px;
            /* Spacing between title and dropdown */
        }

        select#category {
            font-size: 16px;
            /* Increased font size */
            padding: 10px;
            /* More padding for better clickability */
            border-radius: 8px;
            /* Rounded corners for the dropdown */
            border: 1px solid #ccc;
            /* Light border */
            background-color: #fff;
            /* White background */
            color: #333;
            /* Dark text color */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: border-color 0.3s ease;
            /* Smooth transition for border color */
        }

        select#category:hover {
            border-color: #2563eb;
            /* Border color change on hover */
        }
    </style>
</head>

<body>
    <?php include "customer_header.php"; ?>
    <div class="upper_frame">
        <div class='title'>Product</div>
        <div><select id="category" onchange="show_product()">
                <option value=0>All</option>
            </select></div>
    </div>
    <div id="data"></div>

    <script>
        $(document).ready(function() {
            fetch_category();
            show_product();
        });

        function fetch_category() {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {
                    category: "done"
                },
                success: function(response) {
                    $('#category').html(`<option value=0>All</option>${response}`);
                }
            });
        }

        function show_product() {
            var cat_id = $("#category").val();
            $.ajax({
                url: 'php/Product_php.php',
                method: 'POST',
                data: {
                    product: "done",
                    cat_id: cat_id
                },
                async: false,
                success: function(response) {
                    console.log(response);
                    $('#data').html(response);
                }
            });
        }
    </script>
</body>

</html>