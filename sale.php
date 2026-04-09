<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sale </title>

    <!-- Include Bootstrap CSS for basic styling (optional) -->
    <link rel="stylesheet" href="bootstrap.min.css">

    
    <!-- Include Bootstrap CSS for Girl_School_shoes page -->
    <link rel="stylesheet" href="css/product.css">

    <!-- Include jQuery -->
    <script src="jquery.min.js"></script>

    <!-- Include jQuery for Girl_School_shoes page -->
    <script src="jquery/product.js"></script>

</head>

<body class="p-0 m-0">
  
<nav class="navbar">
        <div class="logo">
            <a><img src="images/logo.PNG" width="40" height="40" alt="logo"></a>
        </div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li class="dropdown">
                <a href="#">Men</a>
                <ul class="dropdown-menu">
                    <li><a href="men_sneaker.php">Sneaker</a></li>
                    <li><a href="men_walking_shoes.php">Walking Shoes</a></li>
                    <li><a href="men_formal_shoes.php">Formal Shoes</a></li>
                    <li><a href="men_clogs.php">Clogs</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Women</a>
                <ul class="dropdown-menu">
                    <li><a href="women_clog.php">Clogs</a></li>
                    <li><a href="women_sneaker.php">Sneakers</a></li>
                    <li><a href="women_sandal.php">Sandals</a></li>
                    <li><a href="women_slider.php">Slider</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Children</a>
                <ul class="dropdown-menu">
                    <li><a href="children_clog.php">Clogs</a></li>
                    <li><a href="children_sandal.php">Sandals</a></li>
                    <li><a href="children_walking_shoes.php">Walking Shoes</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Sport</a>
                <ul class="dropdown-menu">
                    <li><a href="cricket_shoes.php">Cricket Shoes</a></li>
                    <li><a href="football_shoes.php">FootBall Shoes</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">School</a>
                <ul class="dropdown-menu">
                    <li><a href="Boy_school_shoes.php">Boys School Shoes</a></li>
                    <li><a href="Girl_school_shoes.php">Girls School Shoes</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Brand</a>
                <ul class="dropdown-menu">
                    <li><a href="puma_shoes.php">puma</a></li>
                    <li><a href="nike.php">nike</a></li>
                </ul>
            </li>
            <li><a href="sale.php">Sale</a></li>

            <li><a href="contact_us.php">Contact</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="sign_in.php"><img src="images/adminprofile.png"alt="" width="30px" height="30px"></a></li>
         
        </ul>
    </nav>

    <br>
    <div>
        <center>
            <h3> SALE </h3>
        </center>
    </div>

    <div class="container my-5">
        <div class="row">
            <!--product1-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\product1.jpg" class="img-fluid h-100 w-100"
                        alt="The Dependables: Black-Blue">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Painted Shoes</h5>
                        <p class="product-price"> <span class="new-price">Rs. 1,599</span> <span
                                class="old-price text-muted text-decoration-line-through">Rs. 3,799</span>
                        </p>
                        <p class="product-discount">57% OFF</p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
            <!--product2 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\Nike_football_shoes_men.jpg"
                            class="img-fluid h-100 w-100" alt="The Dependables: Black-Blue" id="img2">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Nike Men Football Shoes</h5>
                        <p class="product-price"> <span class="new-price">Rs. 1,800</span> <span
                                class="old-price text-muted text-decoration-line-through">Rs. 2000</span>
                        </p>
                        <p class="product-discount">10% OFF</p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>
            <!--product3-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\product3.jpg" class="img-fluid h-100 w-100"
                            alt="The Dependables: Black-Blue" id="img2">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Women Sliper's</h5>
                        <p class="product-price"> <span class="new-price">Rs. 588</span> <span
                                class="old-price text-muted text-decoration-line-through">Rs. 600</span>
                        </p>
                        <p class="product-discount">2% OFF</p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!--product4-->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images\product4.jpg" class="img-fluid h-100 w-100"
                        alt="The Dependables: Black-Blue" id="img2">
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">Baby-Boy Walking Shoes</h5>
                        <p class="product-price"> <span class="new-price">Rs. 430</span> <span
                                class="old-price text-muted text-decoration-line-through">Rs. 500</span>
                        </p>
                        <p class="product-discount">2% OFF</p>
                        <button class="btn btn-dark w-100">ADD TO CART</button>
                    </div>
                            </div>
            </div>
        </div>
    </div>

</body>

</html>
