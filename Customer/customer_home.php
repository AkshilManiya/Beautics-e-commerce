<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Image Carousel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .item{
            height: 500px;
            width: auto;
        }

        .container {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include "customer_header.php"; ?>

    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/Beautics/static/system_img/variants/1.jpg" alt="Los Angeles" style="width:100%;">
                </div>

                <div class="item">
                    <img src="/Beautics/static/system_img/variants/1.jpg" alt="Chicago" style="width:100%;">
                </div>

                <div class="item">
                    <img src="/Beautics/static/system_img/variants/1.jpg" alt="New york" style="width:100%;">
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <h1>Customer Home</h1>
</body>

</html>