<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order</title>
    <?php include "../static/libs.php"; ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        #product_details {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #order-summary {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
            width: 60%;
        }

        #product_image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-right: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .product-info {
            flex-grow: 1;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        #description,
        #ingredients,
        #size,
        #color,
        #price {
            margin-bottom: 8px;
            font-size: 1em;
        }

        #color {
            display: inline-block;
            margin: 5px 10px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        #color_name {
            margin-left: 10px;
            font-size: 16px;
            vertical-align: middle;
        }

        #quantity {
            margin-top: 10px;
            padding: 5px;
            width: 100px;
            border-radius: 5px;
        }

        .pricing-info {
            width: 35%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
        }

        .pricing-info div {
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        #quantity_price,
        #total_item_price,
        #delivery_charge,
        #gst,
        #total_amount {
            font-weight: bold;
        }

        button {
            display: block;
            width: 100%;
            padding: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button {
            padding: 7px 25px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }




        #user_details {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .input-section div {
            width: 48%;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            display: inline-block;
            width: 48%;
            padding: 10px;
            font-size: 1.2em;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }

        button:hover {
            background-color: #0056b3;
        }

        #user_details button:last-child {
            background-color: #28a745;
        }

        #user_details button:last-child:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php include "customer_header.php"; ?>
    <div id="product_details">
        <div id="order-summary">
            <img id="product_image" src="" alt="Product Image">
            <div class="product-info">
                <div class="section-title" id="product_name">Product Name</div>
                <div id="description">Description</div>
                <div id="ingredients">Ingredients</div>
                <div id="size">Size</div>
                <div><span id="color"></span><span id="color_name"></span></div>
                <div id="price">Price</div>
                <input type="number" id="quantity" value="1" min="1" onchange="updateSummary()">
            </div>
        </div>
        <div class="pricing-info">
            <div id="quantity_price">Quantity X Price: $0.00</div>
            <div id="total_item_price">Total Item Price: $0.00</div>
            <div id="delivery_charge">Delivery Charge: $5.00</div>
            <div id="gst">GST: $0.00</div>
            <div id="total_amount">Total Payable Amount: $0.00</div>
        </div>
        <button onclick="confirm_order()">Confirm Order</button>
    </div>

    <div id="user_details" class="user-details">
        <div class="section-title">User Details</div>
        <div class="input-section">
            <input type="hidden" id="id">
            <input type="hidden" id="gender">
            <div>
                <label>Name</label>
                <input type="text" id="user_name">
            </div>
            <div>
                <label>Contact No</label>
                <input type="text" id="contact">
            </div>
            <div>
                <label>Flat Number</label>
                <input type="text" id="flat">
            </div>
            <div>
                <label>Floor Number</label>
                <input type="number" id="floor">
            </div>
            <div>
                <label>Building Name</label>
                <input type="text" id="building">
            </div>
            <div>
                <label>Road/Street</label>
                <input type="text" id="road">
            </div>
            <div>
                <label>Pincode</label>
                <input type="number" id="pincode">
            </div>
            <div>
                <label>State</label>
                <select id="state" onchange="fetch_city()"></select>
            </div>
            <div>
                <label>City</label>
                <select id="city"></select>
            </div>
        </div>
        <button onclick="show_product_detail()">back to order</button>
        <button onclick="make_payment()">Make Payment</button>
    </div>

    <script>
        var productId = 0;
        var product_quantity = 0;
        var totalPayable = 0;

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        $(document).ready(function() {
            productId = getQueryParam('product');
            console.log(productId);
            show_product_detail();
        });

        function show_product_detail() {
            $("#product_details").show();
            $("#user_details").hide();
            fetch_product_details();
        }

        function fetch_product_details() {
            $.ajax({
                url: 'php/Order_php.php',
                type: 'POST',
                data: {
                    variant: productId
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    console.log(data);
                    $('#product_image').attr('src', '/Beautics/static/system_img/variants/' + data[0].img_path);
                    $('#product_name').html(data[0].product_name);
                    $('#description').html(data[0].description);
                    $('#ingredients').html(data[0].ingredients);
                    $('#size').html(data[0].amount_value + ' ' + data[0].amount_type);

                    $('#color').css('background-color', `${data[0].code}`);
                    $('#color_name').html(data[0].color_name);

                    $('#price').html('$' + data[0].price);
                    updateSummary();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function updateSummary() {
            const quantity = parseInt($('#quantity').val());
            product_quantity = quantity;
            const price = parseFloat($('#price').text().replace('$', ''));
            const deliveryCharge = 5.00; // Example static delivery charge
            const gstRate = 0.05; // 5% GST rate

            const totalItemPrice = quantity * price;
            const gst = totalItemPrice * gstRate;
            totalPayable = totalItemPrice + deliveryCharge + gst;

            // Update pricing summary
            $('#quantity_price').html(`Quantity X Price: $${totalItemPrice.toFixed(2)}`);
            $('#total_item_price').html(`Total Item Price: $${totalItemPrice.toFixed(2)}`);
            $('#gst').html(`GST: $${gst.toFixed(2)}`);
            $('#total_amount').html(`Total Payable Amount: $${totalPayable.toFixed(2)}`);
        }

        function confirm_order() {
            show_user_detail();
        }


        function fetch_state() {
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {
                    state: "done"
                },
                success: function(response) {
                    $('#state').html(response);
                }
            });
        }

        function fetch_city() {
            var S = $("#state").val();
            $.ajax({
                url: '../php/select.php',
                method: 'POST',
                async: false,
                data: {
                    S: S,
                    city: "done"
                },
                success: function(response) {
                    $('#city').html(response);
                }
            });
        }


        function show_user_detail() {
            $("#user_details").show();
            $("#product_details").hide();
            fetch_user_details();
        }

        function fetch_user_details() {
            $.ajax({
                url: 'php/Order_php.php',
                type: 'POST',
                data: {
                    user: true
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    console.log(data);
                    $('#id').val(data[0].User_id);
                    $('#user_name').val(data[0].name);
                    $('#contact').val(data[0].contact);
                    $('#gender').val(data[0].gender);
                    $('#flat').val(data[0].flat_number);
                    $('#floor').val(data[0].floor_number);
                    $('#building').val(data[0].building_name);
                    $('#road').val(data[0].road_street);
                    $('#pincode').val(data[0].pincode);
                    fetch_state();
                    select_tag("state", data[0].state_id);
                    fetch_city();
                    select_tag("city", data[0].city_id);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function select_tag(id, value) {
            var selectElement = document.getElementById(id);
            var searchText = value;
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].text === searchText) {
                    selectElement.options[i].selected = true;
                    break;
                }
            }
        }

        function make_payment() {
            const id = $("#id").val();
            const newName = $('#user_name').val();
            const newContact = $('#contact').val();
            const newGender = $('#gender').val();
            const newFlat = $('#flat').val();
            const newFloor = $('#floor').val();
            const newBuilding = $('#building').val();
            const newRoad = $('#road').val();
            const newPincode = $('#pincode').val();
            const newCity = $('#city').val();
            $.ajax({
                type: 'POST',
                url: '../php/Profile_php.php',
                data: {
                    update_profile: "done",
                    name: newName,
                    contact: newContact,
                    gender: newGender,
                    flat: newFlat,
                    floor: newFloor,
                    building: newBuilding,
                    road: newRoad,
                    pincode: newPincode,
                    city: newCity,
                    id: id
                },
                success: function(response) {
                    if (response === "success") {
                        Payment(totalPayable);
                    } else {
                        alert("Error updating profile: " + response);
                    }
                }
            });
        }

        function Payment(amount) {
            var amount = parseInt(amount) * 100;
            var options = {
                "key": "rzp_test_IX1Koi8LULfW3g",
                "amount": amount,
                "currency": "INR",
                "name": "Acme Corp",
                "description": "Test Transaction",
                "image": "https://example.com/your_logo",
                "handler": function(response) {
                    $.ajax({
                        type: 'POST',
                        url: 'php/Order_php.php',
                        data: {
                            order_confirm: true,
                            variant: productId,
                            toalamount: totalPayable,
                            quantity: product_quantity,
                            user: $("#id").val()
                        },
                        success: function(response) {
                            if (response === "success") {
                                window.location.href = 'Myorders.php';
                            } else {
                                alert("Error placing order: " + response);
                            }
                        }
                    });
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function(response) {
                alert("Payment failed. Please try again later.");
            });
            rzp1.open();
        }
    </script>

</body>

</html>