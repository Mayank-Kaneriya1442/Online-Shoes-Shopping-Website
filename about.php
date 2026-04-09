<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - SoleStyle</title>
    
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
            background-color: #fff;
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

        /* --- Hero Section --- */
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/slider2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            margin-top: 76px;
        }
        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .about-hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
        }

        /* --- Content Sections --- */
        .section-padding {
            padding: 80px 0;
        }
        
        .about-img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 400px;
        }

        .feature-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
            text-align: center;
            border-bottom: 3px solid transparent;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            border-bottom-color: var(--accent-red);
        }
        .feature-icon {
            font-size: 3rem;
            color: var(--accent-red);
            margin-bottom: 25px;
        }

        /* --- Stats Section --- */
        .stats-section {
            background-color: var(--primary-dark);
            color: #fff;
            padding: 60px 0;
        }
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--accent-red);
            font-family: 'Playfair Display', serif;
        }
        .stat-label {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* --- Team Section --- */
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        .member-img-container {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .member-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .team-member:hover .member-img {
            transform: scale(1.1);
        }
        .member-role {
            color: var(--accent-red);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 10px;
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

    <!-- Hero Section -->
    <header class="about-hero">
        <div class="container" data-aos="fade-up">
            <h1>Our Story</h1>
            <p>Crafting comfort and style for every step of your journey. Discover the passion behind SoleStyle.</p>
        </div>
    </header>

    <!-- Who We Are -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="images/slide5.jpg" alt="About SoleStyle" class="about-img">
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <h4 class="text-danger text-uppercase mb-2">Who We Are</h4>
                    <h2 class="mb-4">Redefining Footwear Fashion Since 2020</h2>
                    <p class="text-muted mb-4">SoleStyle isn't just a shoe store; it's a destination for those who value quality, comfort, and trendsetting designs. We started with a simple vision: to make premium footwear accessible to everyone.</p>
                    <p class="text-muted mb-4">Our collection is curated from the finest brands and crafted to ensure that you don't just walk, but you stride with confidence. From casual sneakers to formal elegance, we have something for every occasion.</p>
                    <div class="row g-4 mt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-danger me-3 fs-4"></i>
                                <span class="fw-bold">Authentic Products</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-danger me-3 fs-4"></i>
                                <span class="fw-bold">Best Price Guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">5+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">10k+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Values -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h4 class="text-danger text-uppercase">Our Core Values</h4>
                <h2>What Drives Us</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <i class="fas fa-bullseye feature-icon"></i>
                        <h3>Our Mission</h3>
                        <p class="text-muted">To offer high-quality, stylish, and comfortable footwear for everyone. We believe in combining fashion and function to make every step you take enjoyable and confident.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="fas fa-heart feature-icon"></i>
                        <h3>Our Values</h3>
                        <p class="text-muted">We are committed to sustainability, quality, and customer satisfaction. Our shoes are crafted with care, ensuring both style and durability for the modern lifestyle.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <i class="fas fa-hand-holding-heart feature-icon"></i>
                        <h3>Our Promise</h3>
                        <p class="text-muted">We promise transparent pricing, authentic products, and a seamless shopping experience. Your satisfaction is our top priority, today and always.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
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
</body>
<?php include 'shoes_admin/footer.php'; ?>
</html>
