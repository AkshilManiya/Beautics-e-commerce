<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyOrder</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
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

        #myorders {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
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

        .product .desc {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: nowrap;
            margin-left: 20px;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .product div {
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #333;
        }

        .product div:first-child {
            font-weight: bold;
            font-size: 1.2em;
            color: #000;
        }

        .product div:nth-child(3) {
            font-style: italic;
        }

        .product div:last-child {
            font-weight: bold;
            font-size: 1.2em;
            color: #28a745;
        }

        #myorders div {
            text-align: left;
        }

        @media (max-width: 768px) {
            #myorders {
                padding: 10px;
            }

            .product {
                width: 100%;
            }

            .product img {
                width: 100%;
                height: auto;
            }
        }

        .title {
            font-size: 35px;
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
    <h2 class="title">My Orders</h2>
    <div id="myorders">

    </div>
    <script>
        var orderId = 0;
        $(document).ready(function() {
            fetch_order_details();
        });

        function fetch_order_details() {
            $.ajax({
                url: 'php/MyOrder_php.php',
                type: 'POST',
                data: {
                    fetch_orders: true
                },
                success: function(response) {
                    console.log(response)
                    $('#myorders').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>