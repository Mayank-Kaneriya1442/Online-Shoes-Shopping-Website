<?php
include('C:\xampp\htdocs\shoeswebsite\shoes\includes\dbconnection.php');

// Define your query
$query = "SELECT * FROM product WHERE pgname='Men Clogs'";

// Execute the query
$result = mysqli_query($con, $query);

// Check if the query executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
if (mysqli_num_rows($result) == 0) {
    die("No products found for the specified category.");
}
?>

<html>
<head>
    <!-- Include Bootstrap CSS for basic styling (optional) -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- Include CSS for the product page -->
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <a><img src="images/logo.PNG" width="40" height="40" alt="logo"></a>
    </div>
    <ul class="nav-links">
        <li><a href="home.html">Home</a></li>
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
    <div>
        <center>
            <h3>Men's Clogs</h3>
        </center>
    </div>
    <div class="container my-5">
        <div class="row">
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="shoes/shoes_admin/admin/images/<?php echo htmlentities($row['pimage']); ?>" class="img-fluid h-100 w-100" alt="">
                        </div>
                        <div class="product-info">
                            <h5 class="product-name">Brand: <?php echo htmlentities($row['pname']); ?></h5>
                            <h5 class="product-name">Men's Clog</h5>
                            <p class="price">Rs. <?php echo htmlentities($row['cost']); ?></p>
                            <button class="btn btn-dark w-100">ADD TO CART</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="jquery.min.js"></script>
    <!-- Include jQuery for children_clog page -->
    <script src="jquery/product.js"></script>
</body>
</html>
