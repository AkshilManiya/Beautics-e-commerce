<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyOrders</title>
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

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Product Section */
        .product-section {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .product-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-info {
            flex: 1;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-description,
        .product-ingredients,
        .product-size,
        .product-color,
        .product-price,
        .product-quantity,
        .product-quantity-price,
        .product-total-price,
        .delivery-charge,
        .gst,
        .total-amount {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #e63946;
        }

        .product-price,
        .product-quantity-price,
        .product-total-price,
        .delivery-charge,
        .gst {
            color: #0077cc;
        }

        /* User Section */
        .user-section {
            margin-top: 20px;
        }

        .user-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .user-name,
        .user-contact,
        .user-flat,
        .user-floor,
        .user-building,
        .user-road,
        .user-pincode,
        .user-state,
        .user-city {
            width: calc(33% - 20px);
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .user-name {
            font-size: 18px;
            font-weight: bold;
        }

        @media (max-width: 768px) {

            .user-name,
            .user-contact,
            .user-flat,
            .user-floor,
            .user-building,
            .user-road,
            .user-pincode,
            .user-state,
            .user-city {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .product-section {
                flex-direction: column;
            }

            .user-name,
            .user-contact,
            .user-flat,
            .user-floor,
            .user-building,
            .user-road,
            .user-pincode,
            .user-state,
            .user-city {
                width: 100%;
            }
        }





        .order-status {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Center items */
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            align-items: center;
            /* Align items vertically */
        }

        .status-item {
            text-align: center;
            position: relative;
            margin: 0 10px;
            /* Add horizontal spacing */
        }

        .status-item::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 20px;
            /* Adjusted width for better spacing */
            height: 2px;
            background-color: #ddd;
            z-index: -1;
        }

        .status-item:last-child::after {
            display: none;
            /* No line after the last item */
        }

        .status-item.completed {
            color: #28a745;
            /* Green for completed stages */
        }

        .status-item.active {
            color: #007bff;
            /* Blue for the current active stage */
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
    <h2 class="title">Order</h2>
    <div class="container">
        <div id="product_details" class="product-section">
            <div>
                <img id="product_image" class="product-image" src="" alt="Product Image">
                <div id="order-status" class="order-status">
                    <div class="status-item" id="paid">Paid</div>
                    <div class="status-item">|</div>
                    <div class="status-item" id="confirmed">Confirmed</div>
                    <div class="status-item">|</div>
                    <div class="status-item" id="dispatched">Dispatched</div>
                    <div class="status-item">|</div>
                    <div class="status-item" id="delivered">Delivered</div>
                </div>

            </div>
            <div class="product-info">
                <div class="section-title" id="product_name">Product Name</div>
                <div id="description" class="product-description">Description</div>
                <div id="ingredients" class="product-ingredients">Ingredients</div>
                <div id="size" class="product-size">Size</div>
                <div id="color" class="product-color">Color</div>
                <div id="price" class="product-price">Price</div>
                <div id="quantity" class="product-quantity">Quantity</div>
                <div id="quantity_price" class="product-quantity-price">Quantity X Price: $0.00</div>
                <div id="total_item_price" class="product-total-price">Total Item Price: $0.00</div>
                <div id="delivery_charge" class="delivery-charge">Delivery Charge: $5.00</div>
                <div id="gst" class="gst">GST: $0.00</div>
                <div id="total_amount" class="total-amount">Total Payable Amount: $0.00</div>
            </div>
        </div>
        <div id="user_details" class="user-section">
            <div class="user-info">
                <div id="user_name" class="user-name">User Name</div>
                <div id="contact" class="user-contact">Contact</div>
                <div id="flat" class="user-flat">Flat Number</div>
                <div id="floor" class="user-floor">Floor Number</div>
                <div id="building" class="user-building">Building</div>
                <div id="road" class="user-road">Road/Street</div>
                <div id="pincode" class="user-pincode">Pincode</div>
                <div id="state" class="user-state">State</div>
                <div id="city" class="user-city">City</div>
            </div>
        </div>
    </div>
    <script>
        var orderId = 0;
        $(document).ready(function() {
            orderId = getQueryParam('order');
            fetch_order();
        });

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }


        function updateOrderStatus(currentStatus) {
            const statusItems = document.querySelectorAll('.status-item');

            statusItems.forEach((item, index) => {
                item.classList.remove('completed', 'active');

                if (index < getStatusIndex(currentStatus)) {
                    item.classList.add('completed'); // Mark previous statuses as completed
                } else if (index === getStatusIndex(currentStatus)) {
                    item.classList.add('active'); // Mark the current status as active
                }
            });
        }

        function getStatusIndex(status) {
            const statusMap = {
                "Paid": 0,
                "Confirmed": 2,
                "Dispatched": 4,
                "Delivered": 6
            };
            return statusMap[status] !== undefined ? statusMap[status] : -1; // Return the index or -1 if status not found
        }

        function fetch_order() {
            $.ajax({
                url: 'php/MyOrder_php.php',
                type: 'POST',
                data: {
                    order: orderId
                },
                success: function(response) {
                    const data = JSON.parse(response);

                    updateOrderStatus(data[0].status);
                    $('#product_image').attr('src', `/Beautics/static/system_img/variants/${data[0].img_path}`);
                    $('#product_name').text(data[0].product_name);
                    $('#description').text(data[0].description);
                    $('#ingredients').text(data[0].ingredients);
                    $('#size').text(data[0].amount_value + ' ' + data[0].amount_type);
                    $('#color').text(data[0].color_id ? `Color name: ${data[0].color_name}` : 'No color specified');
                    $('#price').text('$' + data[0].price);
                    $('#quantity').text(data[0].quan);

                    let Amount = (data[0].quan * data[0].price).toFixed(2);
                    $('#quantity_price').text(`Quantity X Price: $${data[0].quan} X $${data[0].price}`);
                    $('#total_item_price').text(`Total Item Price: $${(data[0].quan * data[0].price).toFixed(2)}`);

                    // Assuming a fixed delivery charge of $5.00
                    let deliveryCharge = 5.00;

                    // Assuming a 5% GST for calculation
                    let gst = (data[0].total_price * 0.05).toFixed(2);
                    $('#gst').text(`GST: $${gst}`);

                    let totalAmount = (parseFloat(Amount) + parseFloat(deliveryCharge) + parseFloat(gst)).toFixed(2);
                    $('#total_amount').text(`Total Payable Amount: $${totalAmount}`);

                    // Populate user details
                    $('#user_name').text(data[0].name);
                    $('#contact').text(data[0].contact);
                    $('#flat').text(data[0].flat_number);
                    $('#floor').text(data[0].floor_number);
                    $('#building').text(data[0].building_name);
                    $('#road').text(data[0].road_street);
                    $('#pincode').text(data[0].pincode);
                    $('#state').text(data[0].state_name || 'Not specified');
                    $('#city').text(data[0].city_name || 'Not specified');
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>