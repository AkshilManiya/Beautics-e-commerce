<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <?php include "../static/libs.php"; ?>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #e0e7ff;
            /* Soft blue background */
            color: #333;
            padding: 20px;
        }

        .carts {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .cart {
            display: flex;
            flex-direction: row;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
            justify-content: flex-start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            align-items: center;
            flex-wrap: nowrap;
        }

        .cart:hover {
            transform: translateY(-5px);
            /* Subtle lift effect on hover */
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            /* Deeper shadow on hover */
        }

        .cart img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 50px;
        }

        .cart div {
            flex: 1;
        }

        .cart div:first-child {
            flex-basis: 120px;
        }

        .cart div:nth-child(2) {
            font-weight: bold;
            font-size: 18px;
            /* Slightly larger font size */
        }

        .cart div:nth-child(3),
        .cart div:nth-child(4),
        .cart div:nth-child(5),
        .cart div:nth-child(6) {
            color: #555;
            margin-bottom: 5px;
            font-size: 16px;
            /* Improved readability */
        }

        @media (max-width: 768px) {
            .cart {
                flex-direction: column;
                align-items: center;
            }

            .cart img {
                width: 80px;
                height: 80px;
                margin-bottom: 10px;
                /* Space between image and text */
            }

            button {
                width: 100%;
            }
        }

        .title {
            font-size: 24px;
            /* Larger title font */
            font-weight: bold;
            text-align: left;
            padding: 10px;
            color: #2563eb;
            /* Vibrant blue color */
            margin: auto;
            width: 80%;
        }
    </style>
</head>

<body>
    <?php include "customer_header.php"; ?>
    <div class="title">Cart</div>
    <div class="carts">
    </div>
    <script>
        $(document).ready(function() {
            fetch_cart();
        });

        function fetch_cart() {
            $.ajax({
                url: 'php/Cart_php.php',
                type: 'POST',
                data: {
                    cart: true
                },
                success: function(response) {
                    $('.carts').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function delete_Cart(id) {
            $.ajax({
                url: 'php/Cart_php.php',
                type: 'POST',
                data: { delete: true, id:id},
                success: function(response) {
                    fetch_cart();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>