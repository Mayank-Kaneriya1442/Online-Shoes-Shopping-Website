<?php 
session_start();
include('shoes_admin/includes/dbconnection.php');

// Function to add product to cart
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    $quantity = 1;

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];

        if (array_key_exists($product_id, $cart)) {
            $cart[$product_id]['quantity'] += 1;
        } else {
            $query = mysqli_query($con, "SELECT * FROM product WHERE pid = '$product_id'");
            $product = mysqli_fetch_assoc($query);

            $cart[$product_id] = [
                'name' => $product['pname'],
                'price' => $product['cost'],
                'image' => $product['pimage'],
                'quantity' => $quantity
            ];
        }
    } else {
        $cart = [];
        $query = mysqli_query($con, "SELECT * FROM product WHERE pid = '$product_id'");
        $product = mysqli_fetch_assoc($query);

        $cart[$product_id] = [
            'name' => $product['pname'],
            'price' => $product['cost'],
            'image' => $product['pimage'],
            'quantity' => $quantity
        ];
    }

    $_SESSION['cart'] = $cart;
    header('location: cart.php');
}

// Function to remove product from cart
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    header('location: cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - SoleStyle</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            background-color: var(--bg-light);
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

        /* --- Cart Specific Styles --- */
        .cart-container {
            margin-top: 120px; /* Space for fixed navbar */
            margin-bottom: 80px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid #eee;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: var(--text-gray);
            padding-bottom: 20px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-name {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .btn-remove {
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.1);
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
        }
        .btn-remove:hover {
            background: #e74c3c;
            color: #fff;
        }

        .btn-checkout {
            background: var(--accent-red);
            color: #fff;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-checkout:hover {
            background: #a93226;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(192, 57, 43, 0.3);
        }

        .cart-total {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px;
        }
        .empty-cart i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
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
                    <i class="fas fa-shopping-bag fa-lg" style="color: var(--accent-red);"></i>
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

    <div class="container cart-container">
        <div class="text-center mb-5">
            <h2>Your Shopping Cart</h2>
            <p class="text-muted">Review your selected items before checkout</p>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Product</th>
                            <th style="width: 35%;">Details</th>
                            <th style="width: 15%;">Price</th>
                            <th style="width: 15%;">Quantity</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $id => $product): 
                            $subtotal = $product['price'] * $product['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <img src="images/<?php echo htmlentities($product['image']); ?>" class="product-image" alt="<?php echo htmlentities($product['name']); ?>">
                            </td>
                            <td>
                                <div class="product-name"><?php echo htmlentities($product['name']); ?></div>
                            </td>
                            <td>Rs. <?php echo htmlentities($product['price']); ?></td>
                            <td>
                                <span class="badge bg-light text-dark border"><?php echo htmlentities($product['quantity']); ?></span>
                            </td>
                            <td class="fw-bold">Rs. <?php echo htmlentities($subtotal); ?></td>
                            <td>
                                <a href="cart.php?remove=<?php echo $id; ?>" class="btn-remove" title="Remove Item">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <a href="home.php" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end align-items-center mb-4">
                        <span class="text-muted me-3">Grand Total:</span>
                        <span class="cart-total">Rs. <?php echo $total; ?></span>
                    </div>
                    <a href="place_order.php" class="btn-checkout">
                        Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-basket"></i>
                <h3>Your cart is currently empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                <a href="home.php" class="btn-checkout">Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'shoes_admin/footer.php'; ?>
</html>
