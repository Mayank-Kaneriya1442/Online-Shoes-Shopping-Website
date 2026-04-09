<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webshoes";
$con = new mysqli($servername, $username, $password, $dbname);

$order = null;
$orderItems = [];
$message = '';
$orderId = null;

if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $orderId = htmlspecialchars($_GET['order_id']);

    if ($con && !$con->connect_error) {
        $con->begin_transaction();
        try {
            // 1. Fetch order details from the 'orders' table
            $stmt = $con->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $order = $result->fetch_assoc();
            }
            $stmt->close();

            // 2. Fetch all items related to this order from the 'order_items' table
            if ($order) {
                $stmt_items = $con->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $stmt_items->bind_param("i", $orderId);
                $stmt_items->execute();
                $result_items = $stmt_items->get_result();
                while ($row = $result_items->fetch_assoc()) {
                    $orderItems[] = $row;
                }
                $stmt_items->close();
            } else {
                $message = "Order not found. Please check the order ID.";
            }

            $con->commit();

        } catch (mysqli_sql_exception $exception) {
            $con->rollback();
            $message = "Error fetching order details. Please try again later.";
            // For debugging: error_log($exception->getMessage());
        }
        $con->close();
    } else {
        $message = "Database connection failed.";
    }
} else {
    $message = "Invalid or missing order ID.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Order #<?php echo htmlspecialchars($orderId); ?></title>
    
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

        /* --- Invoice Specific --- */
        .invoice-container {
            margin-top: 120px;
            margin-bottom: 80px;
        }
        .invoice-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 50px;
        }
        .invoice-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }
        .invoice-meta {
            color: var(--text-gray);
            font-size: 0.95rem;
        }
        .invoice-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .invoice-info p {
            margin-bottom: 5px;
            color: var(--text-gray);
            font-size: 0.95rem;
        }
        .invoice-info strong {
            color: var(--primary-dark);
            font-weight: 600;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: var(--primary-dark);
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: var(--text-gray);
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .invoice-total {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
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
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            margin-bottom: 0;
        }
        
        .btn-print {
            background: var(--primary-dark);
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print:hover {
            background: var(--accent-red);
            color: #fff;
            transform: translateY(-2px);
        }

        @media print {
            .navbar, .btn-print, footer {
                display: none !important;
            }
            .invoice-container {
                margin-top: 0;
                margin-bottom: 0;
            }
            .invoice-card {
                box-shadow: none;
                padding: 0;
            }
            body {
                background-color: #fff;
            }
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
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="user_profile.php" class="text-dark">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                <?php } else { ?>
                    <a href="sign_in.php" class="btn btn-outline-dark btn-sm me-2">Login</a>
                    <a href="register.php" class="btn btn-dark btn-sm">Register</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container invoice-container">
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $message; ?>
            </div>
        <?php elseif ($order): ?>
            <div class="invoice-card">
                <div class="invoice-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1 class="invoice-title">Invoice</h1>
                        <p class="invoice-meta mb-0">Order ID: <strong>#<?php echo htmlspecialchars($order['id']); ?></strong></p>
                    </div>
                    <div class="text-md-end mt-3 mt-md-0">
                        <p class="invoice-meta mb-1">Date: <strong><?php echo date("F j, Y", strtotime($order['order_date'])); ?></strong></p>
                        <p class="invoice-meta mb-0">Payment: <strong><?php echo htmlspecialchars($order['payment_mode']); ?></strong></p>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <h4 class="invoice-section-title">Billed To</h4>
                        <div class="invoice-info">
                            <p><strong><?php echo htmlspecialchars($order['customer_name']); ?></strong></p>
                            <p><?php echo htmlspecialchars($order['customer_email']); ?></p>
                            <p><?php echo htmlspecialchars($order['customer_phone']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></p>
                        </div>
                    </div>
                    
                </div>

                <div class="table-responsive mb-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td class="text-end">Rs. <?php echo number_format($item['price'], 2); ?></td>
                                    <td class="text-end">Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-5 col-lg-4">
                        <div class="invoice-total">
                            <div class="total-row">
                                <span>Subtotal</span>
                                <span>Rs. <?php echo number_format($order['total_amount'] - 50.00, 2); ?></span>
                            </div>
                            <div class="total-row">
                                <span>Delivery Fee</span>
                                <span>Rs. 50.00</span>
                            </div>
                            <div class="total-row final">
                                <span>Total:</span>
                                <span>Rs. <?php echo number_format($order['total_amount'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5 d-print-none">
                    <button onclick="window.print()" class="btn-print">
                        <i class="fas fa-print me-2"></i> Print Invoice
                    </button>
                    <a href="home.php" class="btn btn-outline-dark rounded-pill px-4 ms-2">Back to Home</a>
                </div>
                
                <div class="text-center mt-5 text-muted small d-none d-print-block">
                    <p>Thank you for shopping with SoleStyle!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'shoes_admin/footer.php'; ?>
</html>
