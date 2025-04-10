<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
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

        .wishlists {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .wishlist {
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

        .wishlist:hover {
            transform: translateY(-5px);
            /* Subtle lift effect on hover */
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            /* Deeper shadow on hover */
        }

        .wishlist img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 50px;
        }

        .wishlist div {
            flex: 1;
        }

        .wishlist div:first-child {
            flex-basis: 120px;
        }

        .wishlist div:nth-child(2) {
            font-weight: bold;
            font-size: 18px;
            /* Slightly larger font size */
        }

        .wishlist div:nth-child(3),
        .wishlist div:nth-child(4),
        .wishlist div:nth-child(5),
        .wishlist div:nth-child(6) {
            color: #555;
            margin-bottom: 5px;
            font-size: 16px;
            /* Improved readability */
        }

        @media (max-width: 768px) {
            .wishlist {
                flex-direction: column;
                align-items: center;
            }

            .wishlist img {
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
    <div class="title">Wishlist</div>
    <div class="wishlists">
    </div>
    <script>
        $(document).ready(function() {
            fetch_wishlist();
        });

        function fetch_wishlist() {
            $.ajax({
                url: 'php/Wishlist_php.php',
                type: 'POST',
                data: {
                    wishlist: true
                },
                success: function(response) {
                    $('.wishlists').html(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function delete_Wishlist(id) {
            $.ajax({
                url: 'php/Wishlist_php.php',
                type: 'POST',
                data: { delete: true, id:id},
                success: function(response) {
                    fetch_wishlist();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>