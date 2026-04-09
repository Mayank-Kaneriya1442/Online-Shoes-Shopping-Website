<?php
session_start();
include('shoes_admin/includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoleStyle - Premium Footwear</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #1a1a1a;
            --accent-red: #c0392b;
            --text-gray: #666;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--primary-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        /* --- Navbar --- */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            padding: 15px 0;
        }
        .nav-link {
            font-weight: 500;
            color: var(--primary-dark) !important;
            margin: 0 12px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: var(--accent-red) !important;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 0;
            margin-top: 15px;
        }
        .dropdown-item {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .dropdown-item:hover {
            background-color: var(--bg-light);
            color: var(--accent-red);
        }

        /* --- Hero Carousel --- */
        .carousel-item {
            height: 85vh;
            min-height: 500px;
            background-color: #000;
        }
        .carousel-item img {
            height: 100%;
            object-fit: cover;
            opacity: 0.6; /* Darken image for text readability */
        }
        .carousel-caption {
            bottom: 35%;
            left: 10%;
            right: 10%;
            text-align: center;
        }
        .carousel-caption h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            animation: fadeInUp 1s ease-out;
        }
        .carousel-caption p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.3s backwards;
        }
        .btn-hero {
            padding: 15px 40px;
            background: var(--accent-red);
            color: #fff;
            border: none;
            border-radius: 50px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
            animation: fadeInUp 1s ease-out 0.6s backwards;
            text-decoration: none;
        }
        .btn-hero:hover {
            background: #a93226;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(192, 57, 43, 0.4);
            color: #fff;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Features Section --- */
        .features-section {
            padding: 80px 0;
            background: #fff;
        }
        .feature-box {
            text-align: center;
            padding: 30px;
            transition: transform 0.3s;
        }
        .feature-box:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-red);
            margin-bottom: 20px;
        }
        .feature-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        .feature-text {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        /* --- Products Section --- */
        .products-section {
            padding: 80px 0;
            background: var(--bg-light);
        }
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        .section-header h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--accent-red);
            margin: 15px auto 0;
        }
        
        .product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .product-img-container {
            position: relative;
            overflow: hidden;
            height: 300px;
        }
        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-img-container img {
            transform: scale(1.1);
        }
        .product-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-card:hover .product-overlay {
            opacity: 1;
        }
        .btn-quick-view {
            background: #fff;
            color: var(--primary-dark);
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transform: translateY(20px);
            transition: all 0.3s;
        }
        .product-card:hover .btn-quick-view {
            transform: translateY(0);
        }
        .product-details {
            padding: 20px;
            text-align: center;
        }
        .product-brand {
            font-size: 0.8rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-dark);
        }
        .product-price {
            color: var(--accent-red);
            font-weight: 700;
            font-size: 1.1rem;
        }
        .btn-add-cart {
            width: 100%;
            padding: 12px;
            background: var(--primary-dark);
            color: #fff;
            border: none;
            font-weight: 500;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add-cart:hover {
            background: var(--accent-red);
            color: #fff;
        }

        /* --- Newsletter --- */
        .newsletter-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            padding: 80px 0;
            color: #fff;
            text-align: center;
        }
        .newsletter-input {
            height: 55px;
            border-radius: 30px 0 0 30px;
            border: none;
            padding-left: 30px;
        }
        .newsletter-btn {
            height: 55px;
            border-radius: 0 30px 30px 0;
            background: var(--accent-red);
            color: #fff;
            border: none;
            padding: 0 40px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .newsletter-btn:hover {
            background: #a93226;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="12" fill="#c0392b"/>
                    <path d="M11 22.5C11 22.5 13 27.5 19 27.5C25 27.5 29 20 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 17.5C13 17.5 17 12.5 23 12.5C29 12.5 29 15 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 22.5L29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ms-2 fw-bold text-dark">SoleStyle</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Men</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="men_sneaker.php">Sneakers</a></li>
                            <li><a class="dropdown-item" href="men_walking_shoes.php">Walking Shoes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Women</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="women_sneaker.php">Sneakers</a></li>
                            <li><a class="dropdown-item" href="women_sandal.php">Sandals</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Children</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="children_clog.php">Clogs</a></li>
                            <li><a class="dropdown-item" href="children_walking_shoes.php">Walking Shoes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Sport</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="cricket_shoes.php">Cricket Shoes</a></li>
                            <li><a class="dropdown-item" href="football_shoes.php">Football Shoes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">School</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Boy_school_shoes.php">Boys School Shoes</a></li>
                            <li><a class="dropdown-item" href="Girl_school_shoes.php">Girls School Shoes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="cart.php" class="text-dark me-3 position-relative">
                    <i class="fas fa-shopping-bag fa-lg"></i>
                </a>
                <a href="clientsideorder.php" class="text-dark me-3">
                    <i class="fas fa-truck-fast fa-lg"></i>
                </a>
                <a href="sign_in.php" class="text-dark">
                    <i class="fas fa-user-circle fa-lg"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slider1.jpg" class="d-block w-100" alt="New Collection">
                <div class="carousel-caption">
                    <h1>Step Into Style</h1>
                    <p>Discover the latest trends in footwear fashion. Comfort meets elegance.</p>
                    <a href="men_walking_shoes.php" class="btn-hero">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/slider3.jpg" class="d-block w-100" alt="Sport Shoes">
                <div class="carousel-caption">
                    <h1>Unleash Your Potential</h1>
                    <p>High-performance sports shoes for every athlete.</p>
                    <a href="cricket_shoes.php" class="btn-hero">Explore Sports</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/slide5.jpg" class="d-block w-100" alt="Casual Wear">
                <div class="carousel-caption">
                    <h1>Everyday Comfort</h1>
                    <p>Casual styles perfect for your daily adventures.</p>
                    <a href="men_sneaker.php" class="btn-hero">View Collection</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <i class="fas fa-shipping-fast feature-icon"></i>
                        <h4 class="feature-title">Free Shipping</h4>
                        <p class="feature-text">On all orders over Rs. 2000. Fast and reliable delivery to your doorstep.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <i class="fas fa-headset feature-icon"></i>
                        <h4 class="feature-title">24/7 Support</h4>
                        <p class="feature-text">Our dedicated support team is here to help you with any questions.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4 class="feature-title">Secure Payment</h4>
                        <p class="feature-text">100% secure payment processing. We accept all major cards and UPI.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="products-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Trending Now</h2>
                <p class="text-muted">Our most popular picks for the season</p>
            </div>

            <div class="row g-4">
                <?php
                // Fetch 6 random products for the trending section
                $query = mysqli_query($con, "SELECT * FROM product ORDER BY RAND() LIMIT 6");
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                ?>
                <div class="col-md-4 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="images/<?php echo htmlentities($row['pimage']); ?>" alt="<?php echo htmlentities($row['pname']); ?>">
                            <div class="product-overlay">
                                <a href="cart.php?add_to_cart=<?php echo htmlentities($row['pid']); ?>" class="btn-quick-view">Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-details">
                            <div class="product-brand"><?php echo htmlentities($row['pname']); ?></div>
                            <h5 class="product-title"><?php echo htmlentities($row['pgname']); ?></h5>
                            <div class="product-price mb-3">Rs. <?php echo htmlentities($row['cost']); ?></div>
                            <a href="cart.php?add_to_cart=<?php echo htmlentities($row['pid']); ?>" class="btn-add-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    // Fallback static content if database is empty or connection fails
                ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">No products found in the database. Please add products via the admin panel.</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" data-aos="zoom-in">
                    <h2 class="mb-3">Subscribe to our Newsletter</h2>
                    <p class="mb-4 text-white-50">Get the latest updates on new products and upcoming sales.</p>
                    <form class="d-flex justify-content-center">
                        <input type="email" class="form-control newsletter-input" placeholder="Your Email Address">
                        <button type="submit" class="newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    
    <!-- Footer -->
    <?php include 'shoes_admin/footer.php'; ?>
</body>
</html>
