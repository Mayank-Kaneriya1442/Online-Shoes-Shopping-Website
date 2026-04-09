<?php
session_start();

// --- Mock Database Connection for Standalone Testing ---
// In a real environment, you would use: include('shoes_admin/includes/dbconnection.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webshoes";
$con = new mysqli($servername, $username, $password, $dbname);
// End Mock Database Connection

$cartItems = [];
$orderPlacedSuccessfully = false; // Flag to control view
$message = '';

// Redirect if cart is empty and an order hasn't just been placed
if (empty($_SESSION['cart']) && !isset($_GET['order_success'])) {
    header('Location: cart.php');
    exit();
}

// Populate cart items from session for display
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $cartItems[$id] = [
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'image' => $item['image']
        ];
    }
}

// --- Define Delivery Fee ---
$deliveryFee = 50.00;

// Calculate subtotal and total amount
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$totalAmount = !empty($cartItems) ? $subtotal + $deliveryFee : 0;

// --- Handle Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $customerName = htmlspecialchars(strip_tags($_POST['customer_name']));
    $customerEmail = htmlspecialchars(strip_tags($_POST['customer_email']));
    $customerPhone = htmlspecialchars(strip_tags($_POST['customer_phone']));
    $customerAddress = htmlspecialchars(strip_tags($_POST['customer_address']));
    $paymentMode = htmlspecialchars(strip_tags($_POST['payment_mode']));

    // --- MODIFICATION START ---
    // If payment mode is Card or UPI, save info to session and redirect
    if ($paymentMode === 'Credit/Debit Card' || $paymentMode === 'UPI') {
        $_SESSION['checkout_info'] = [
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'payment_mode' => $paymentMode,
            'total_amount' => $totalAmount
        ];
        if ($paymentMode === 'Credit/Debit Card') {
            header('Location: creditcard.php');
        } else { // UPI
            header('Location: upi.php');
        }
        exit();
    }
    // --- MODIFICATION END ---


    // --- Process other payment methods (like Cash on Delivery) directly ---
    if ($con && !$con->connect_error) {
        $con->begin_transaction();
        try {
            // 1. Insert into 'orders' table
            $stmt = $con->prepare("INSERT INTO orders (customer_name, customer_phone, customer_email, customer_address, payment_mode, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", $customerName, $customerPhone, $customerEmail, $customerAddress, $paymentMode, $totalAmount);
            $stmt->execute();
            
            $orderId = $con->insert_id;

            // 2. Insert each cart item into 'order_items' table
            $stmt_items = $con->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $stmt_items->bind_param("isid", $orderId, $item['name'], $item['quantity'], $item['price']);
                $stmt_items->execute();
            }

            $con->commit();
            
            // Set success state and clear the cart
            $_SESSION['cart'] = [];
            
            // Redirect to the same page with a success flag to show the confirmation
            header('Location: place_order.php?order_success=true&order_id=' . $orderId);
            exit();

        } catch (mysqli_sql_exception $exception) {
            $con->rollback();
            $message = "<div class='text-red-600 bg-red-100 p-3 rounded-lg text-center mb-4'>Error: Could not place your order. Please try again.</div>";
            // For debugging: error_log($exception->getMessage());
        }
        if (isset($stmt)) $stmt->close();
        if (isset($stmt_items)) $stmt_items->close();
        $con->close();
    } else {
        $message = "<div class='text-red-600 bg-red-100 p-3 rounded-lg text-center mb-4'>Database connection failed.</div>";
    }
}

// Check if the page is being loaded after a successful order
if (isset($_GET['order_success']) && $_GET['order_success'] == 'true') {
    $orderPlacedSuccessfully = true;
    $orderId = htmlspecialchars($_GET['order_id']);
    $message = "Your Order ID is #" . $orderId;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SoleStyle</title>
    
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

        /* --- Checkout Specific --- */
        .checkout-container {
            margin-top: 120px;
            margin-bottom: 80px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent-red);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-gray);
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: var(--accent-red);
            box-shadow: 0 0 0 0.2rem rgba(192, 57, 43, 0.1);
        }

        .order-summary-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f5f5f5;
        }
        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .summary-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        .summary-info h6 {
            font-size: 0.95rem;
            margin-bottom: 2px;
            font-weight: 600;
        }
        .summary-info p {
            font-size: 0.85rem;
            color: var(--text-gray);
            margin: 0;
        }
        .summary-price {
            margin-left: auto;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
            color: var(--text-gray);
        }
        .total-row.final {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .payment-option {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        .payment-option:hover {
            background-color: #f9f9f9;
        }
        .payment-option input[type="radio"] {
            margin-right: 15px;
            accent-color: var(--accent-red);
            transform: scale(1.2);
        }
        .payment-icon {
            margin-left: auto;
            color: var(--text-gray);
        }

        .btn-place-order {
            width: 100%;
            background: var(--accent-red);
            color: #fff;
            padding: 15px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        .btn-place-order:hover {
            background: #a93226;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(192, 57, 43, 0.3);
            color: #fff;
        }

        .success-card {
            text-align: center;
            padding: 50px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }
        .success-icon {
            font-size: 4rem;
            color: #27ae60;
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

    <div class="container checkout-container">
        <?php if ($orderPlacedSuccessfully): ?>
            <div class="success-card">
                <i class="fas fa-check-circle success-icon"></i>
                <h2 class="mb-3">Order Placed Successfully!</h2>
                <p class="text-muted mb-4">Thank you for your purchase. We've received your order and will begin processing it shortly.</p>
                <div class="alert alert-light border mb-4">
                    <i class="fas fa-receipt me-2"></i> <?php echo $message; ?>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <a href="bill.php?order_id=<?php echo htmlspecialchars($orderId); ?>" class="btn btn-outline-dark rounded-pill px-4">View Invoice</a>
                    <a href="home.php" class="btn btn-place-order w-auto px-5 m-0">Continue Shopping</a>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-5">
                <!-- Left Column: Form -->
                <div class="col-lg-8">
                    <form action="place_order.php" method="post" id="checkoutForm">
                        <!-- Shipping Info -->
                        <div class="mb-5">
                            <h4 class="section-title">Shipping Information</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                </div>
                                <div class="col-12">
                                    <label for="customer_phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                                </div>
                                <div class="col-12">
                                    <label for="customer_address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h4 class="section-title">Payment Method</h4>
                            <label class="payment-option">
                                <input type="radio" name="payment_mode" value="Cash on Delivery" checked>
                                <span>Cash on Delivery</span>
                                <i class="fas fa-money-bill-wave payment-icon"></i>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_mode" value="Credit/Debit Card">
                                <span>Credit / Debit Card</span>
                                <i class="fas fa-credit-card payment-icon"></i>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_mode" value="UPI">
                                <span>UPI</span>
                                <i class="fas fa-mobile-alt payment-icon"></i>
                            </label>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Summary -->
                <div class="col-lg-4">
                    <div class="order-summary-card">
                        <h4 class="mb-4">Order Summary</h4>
                        
                        <div class="mb-4">
                            <?php foreach ($cartItems as $item): ?>
                            <div class="summary-item">
                                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="summary-img">
                                <div class="summary-info">
                                    <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                                    <p>Qty: <?php echo $item['quantity']; ?></p>
                                </div>
                                <div class="summary-price">
                                    Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rs. <?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Delivery Fee</span>
                            <span>Rs. <?php echo number_format($deliveryFee, 2); ?></span>
                        </div>
                        <div class="total-row final">
                            <span>Total</span>
                            <span>Rs. <?php echo number_format($totalAmount, 2); ?></span>
                        </div>

                        <button type="submit" form="checkoutForm" class="btn-place-order">
                            Place Order <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'shoes_admin/footer.php'; ?>
</html>
