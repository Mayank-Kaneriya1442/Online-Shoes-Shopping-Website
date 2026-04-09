<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women Sliper </title>

    <!-- Include Bootstrap CSS for basic styling (optional) -->
    <link rel="stylesheet" href="bootstrap.min.css">

    <!-- Include jQuery -->
    <script src="jquery.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        /*product*/
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-image {
            position: relative;
            overflow: hidden;
            height: 350px;
            width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .product-image img {
            width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .price {
            color: #000;
            font-weight: bold;
            margin-right: 10px;
            font-size: 1.2rem;
        }
    </style>

    <script>
        //product card
        $(document).ready(function () {
            $('.product-card').hover(function () {
                $(this).find('img').css('transform', 'scale(1.1)');
            }, function () {
                $(this).find('img').css('transform', 'scale(1)');
            });
        });
    </script>
</head>

<body>

    <br>
    <div>
        <center>
            <h3>Women's Sliper</h3>
        </center>
    </div>

    <div class="container my-5">
        <div class="row">
            <!--product1-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper1.jpg" class="img-fluid h-100 w-100"
                            alt="The Dependables: Black-Blue">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand : Pearls</h5>
                        <h5 class="product-name">Women's Sliper </h5>
                        <p class="price"> Rs. 550 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
            <!--product2 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper2.jpg" class="img-fluid h-100 w-100" alt="">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand : TORRID </h5>
                        <h5 class="product-name"> Women's Sliper </h5>
                        <p class="price"> Rs. 150 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
            <!--product3-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper3.jpg" class="img-fluid h-100 w-100" alt="">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand :  Loly Stone</h5>
                        <h5 class="product-name">Women's Sliper  </h5>
                        <p class="price"> Rs. 500 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!--product4-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper4.jpg" class="img-fluid h-100 w-100" alt="">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand : Leaf</h5>
                        <h5 class="product-name">Women's Sliper </h5>
                        <p class="price"> Rs. 530 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!--product5-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper5.jpg" class="img-fluid h-100 w-100" alt="The Dependables: Black-Blue">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand : CEQUA</h5>
                        <h5 class="product-name">Women's Sliper  </h5>
                        <p class="price"> Rs. 400 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!--product6-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\women_slipper\sliper6.jpg" class="img-fluid h-100 w-100" alt="">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Brand : Mark lorif</h5>
                        <h5 class="product-name">Women's Sliper </h5>
                        <p class="price"> Rs. 580 </p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
