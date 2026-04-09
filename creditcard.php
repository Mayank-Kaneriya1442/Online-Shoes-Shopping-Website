<?php
session_start();

// Redirect if checkout info or cart is not in session
if (!isset($_SESSION['checkout_info']) || empty($_SESSION['cart'])) {
    header('Location: place_order.php');
    exit();
}

// --- Mock Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webshoes";
$con = new mysqli($servername, $username, $password, $dbname);
// --- End Mock ---

$checkoutInfo = $_SESSION['checkout_info'];
$cartItems = [];
$message = '';

// Populate cart items from session for display
foreach ($_SESSION['cart'] as $id => $item) {
    $cartItems[$id] = $item;
}

// --- Handle Card Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Here you would typically integrate a real payment gateway API
    // For this example, we will simulate a successful payment and proceed to save the order.

    if ($con && !$con->connect_error) {
        $con->begin_transaction();
        try {
            // Retrieve customer data from session
            $customerName = $checkoutInfo['customer_name'];
            $customerPhone = $checkoutInfo['customer_phone'];
            $customerEmail = $checkoutInfo['customer_email'];
            $customerAddress = $checkoutInfo['customer_address'];
            $paymentMode = $checkoutInfo['payment_mode'];
            $totalAmount = $checkoutInfo['total_amount'];

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
            
            // Clear session data
            unset($_SESSION['cart']);
            unset($_SESSION['checkout_info']);
            
            // Redirect to the success page
            header('Location: place_order.php?order_success=true&order_id=' . $orderId);
            exit();

        } catch (mysqli_sql_exception $exception) {
            $con->rollback();
            $message = "<div class='text-red-600 bg-red-100 p-3 rounded-lg text-center mb-4'>Error: Payment failed. Please try again.</div>";
            // For debugging: error_log($exception->getMessage());
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($stmt_items)) $stmt_items->close();
            $con->close();
        }
    } else {
        $message = "<div class='text-red-600 bg-red-100 p-3 rounded-lg text-center mb-4'>Database connection failed.</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - SoleStyle</title>
    
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

        /* --- Payment Specific --- */
        .payment-container {
            margin-top: 120px;
            margin-bottom: 80px;
        }

        .payment-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
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

        .input-group-text {
            background: #fff;
            border-left: none;
            border-color: #e0e0e0;
            color: var(--text-gray);
        }
        .form-control + .input-group-text {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        .input-group .form-control {
            border-right: none;
        }

        .btn-pay {
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
        .btn-pay:hover {
            background: #a93226;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(192, 57, 43, 0.3);
            color: #fff;
        }

        .summary-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f5f5f5;
        }
        .summary-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }
        .summary-info h6 {
            font-size: 0.9rem;
            margin: 0;
            font-weight: 600;
        }
        .summary-info p {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin: 0;
        }
        .summary-price {
            margin-left: auto;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-align: right;
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
        </div>
    </nav>

    <div class="container payment-container">
        <div class="row g-5 justify-content-center">
            <!-- Credit Card Form Section -->
            <div class="col-lg-7">
                <div class="payment-card">
                    <h4 class="section-title"><i class="fas fa-lock me-2 text-muted"></i>Secure Card Payment</h4>
                    
                    <?php if (!empty($message)) echo $message; ?>
                    
                    <form action="creditcard.php" method="post" id="payment-form">
                        <div class="mb-4">
                            <label for="cardholder_name" class="form-label">Cardholder Name</label>
                            <input type="text" id="cardholder_name" name="cardholder_name" placeholder="Enter Your Name" class="form-control" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="card_number" class="form-label">Card Number</label>
                            <div class="input-group">
                                <input type="text" id="card_number" name="card_number" placeholder="0000 0000 0000 0000" class="form-control" required>
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM / YY" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="password" id="cvv" name="cvv" placeholder="123" class="form-control" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-pay">
                            Pay Rs. <?php echo number_format($checkoutInfo['total_amount'], 2); ?>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary Section -->
            <div class="col-lg-5">
                <div class="summary-card">
                    <h4 class="mb-4">Order Summary</h4>
                    <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
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
                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Amount</span>
                            <span class="total-amount">Rs. <?php echo number_format($checkoutInfo['total_amount'], 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Simple input formatting for user experience
    document.getElementById('card_number').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^\d]/g, '').replace(/(.{4})/g, '$1 ').trim();
    });
    document.getElementById('expiry_date').addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
        }
        e.target.value = value;
    });
    </script>
</body>
</html>
