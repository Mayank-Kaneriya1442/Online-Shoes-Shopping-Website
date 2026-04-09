<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webshoes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<p class='text-center text-red-500 mt-10'>Connection failed: " . $conn->connect_error . "</p>");
}

$order = null;
$error_message = "";
$success_message = "";

// --- Handle Order Cancellation Form Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order_id'])) {
    $cancel_order_id = $conn->real_escape_string($_POST['cancel_order_id']);

    // First, check the current status to ensure it's cancellable
    $stmt_check = $conn->prepare("SELECT order_status FROM orders WHERE id = ?");
    $stmt_check->bind_param("i", $cancel_order_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        $current_order = $result_check->fetch_assoc();
        
        // Only allow cancellation if the status is 'Pending' or 'Processing'
        if (in_array($current_order['order_status'], ['Pending', 'Processing'])) {
            $stmt_cancel = $conn->prepare("UPDATE orders SET order_status = 'Cancelled' WHERE id = ?");
            $stmt_cancel->bind_param("i", $cancel_order_id);
            if ($stmt_cancel->execute()) {
                $success_message = "Order #" . $cancel_order_id . " has been successfully cancelled.";
            } else {
                $error_message = "Failed to cancel the order. Please try again.";
            }
            $stmt_cancel->close();
        } else {
            $error_message = "This order cannot be cancelled as it has already been shipped or delivered.";
        }
    } else {
        $error_message = "Invalid Order ID for cancellation.";
    }
    $stmt_check->close();
}


// --- Handle Order Lookup Form Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_order_id']) && !empty($_GET['search_order_id'])) {
    $search_order_id = $conn->real_escape_string($_GET['search_order_id']);

    // Fetch the single order for the given ID
    $stmt_order = $conn->prepare("SELECT id, customer_name, customer_phone, customer_email, customer_address, payment_mode, order_status, total_amount, order_date FROM orders WHERE id = ? LIMIT 1");
    $stmt_order->bind_param("i", $search_order_id);
    $stmt_order->execute();
    $result_order = $stmt_order->get_result();

    if ($result_order->num_rows > 0) {
        $order = $result_order->fetch_assoc();
        $order_id = $order['id'];

        // Fetch order items
        $stmt_items = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();
        $order_items = $result_items->fetch_all(MYSQLI_ASSOC);
        $order['items'] = $order_items;

        $stmt_items->close();
    } else {
        $error_message = "No order found with that ID. Please try again.";
    }
    $stmt_order->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($order && !in_array($order['order_status'], ['Delivered', 'Cancelled'])): ?>
        <!-- Live Tracking: Auto-refresh the page every 30 seconds to get status updates -->
        <meta http-equiv="refresh" content="30;url=<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?search_order_id=' . urlencode($order['id'])); ?>">
    <?php endif; ?>
    <title>Track Your Order - WebShoes</title>
    
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

        /* --- Tracking Page Specific --- */
        .tracking-container {
            margin-top: 120px;
            margin-bottom: 80px;
        }
        
        .search-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .order-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
        }

        .status-badge {
            display: inline-block; 
            padding: 0.5em 1em; 
            border-radius: 50px;
            font-weight: 600; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #cce5ff; color: #004085; }
        .status-shipped { background-color: #d1ecf1; color: #0c5460; }
        .status-out-for-delivery { background-color: #ffeeba; color: #856404; }
        .status-delivered { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        
        /* --- Live Tracking Timeline CSS --- */
        .timeline { 
            list-style-type: none; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 0; 
            margin: 40px 0; 
            position: relative;
        }
        .timeline-step { 
            text-align: center; 
            flex: 1; 
            position: relative; 
            z-index: 1;
        }
        .timeline-step:before {
            content: '';
            position: absolute;
            top: 25px;
            left: -50%;
            height: 3px;
            width: 100%;
            background-color: #e2e8f0;
            z-index: -1;
            transition: background-color 0.4s ease;
        }
        .timeline-step:first-child:before { content: none; }
        .timeline-icon {
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff;
            color: #adb5bd;
            border: 2px solid #e2e8f0;
            font-size: 1.2rem;
            transition: all 0.4s ease;
            margin-bottom: 10px;
        }
        .timeline-label {
            font-size: 0.85rem;
            color: var(--text-gray);
            font-weight: 500;
        }
        /* Completed/Active State Styles */
        .timeline-step.completed .timeline-icon { 
            background-color: #fff; 
            color: var(--accent-red); 
            border-color: var(--accent-red);
        }
        .timeline-step.completed:before { 
            background-color: var(--accent-red); 
        }
        .timeline-step.active .timeline-icon {
            background-color: var(--accent-red);
            color: white;
            border-color: var(--accent-red);
            box-shadow: 0 0 0 5px rgba(192, 57, 43, 0.2);
            animation: pulse 2s infinite;
        }
        .timeline-step.active:before {
            background-color: var(--accent-red);
        }
        .timeline-step.active .timeline-label { 
            font-weight: 700; 
            color: var(--primary-dark); 
        }
        
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(192, 57, 43, 0.5); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(192, 57, 43, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(192, 57, 43, 0); }
        }

        .btn-track {
            background: var(--accent-red);
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
        .btn-track:hover {
            background: #a93226;
            color: #fff;
            transform: translateY(-2px);
        }
        
        .form-control:focus {
            border-color: var(--accent-red);
            box-shadow: 0 0 0 0.2rem rgba(192, 57, 43, 0.1);
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

    <div class="container tracking-container">
        <!-- Search Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-card">
                    <h2 class="mb-3">Track Your Order</h2>
                    <p class="text-muted mb-4">Enter your Order ID to see its status and details.</p>
                    
                    <form action="" method="GET" class="d-flex gap-2">
                        <input type="text" name="search_order_id" class="form-control form-control-lg" placeholder="Enter Order ID (e.g. 123)" value="<?php echo htmlspecialchars($_GET['search_order_id'] ?? $_POST['cancel_order_id'] ?? '', ENT_QUOTES); ?>" required>
                        <button type="submit" class="btn-track">Track</button>
                    </form>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success mt-4 mb-0" role="alert">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger mt-4 mb-0" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if ($order): ?>
        <div class="order-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 border-bottom pb-3">
                <div>
                    <h3 class="mb-1">Order #<?php echo htmlspecialchars($order['id']); ?></h3>
                    <p class="text-muted mb-0">Placed on <?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
                </div>
                <?php if (!in_array($order['order_status'], ['Delivered', 'Cancelled'])): ?>
                <div class="badge bg-light text-dark border mt-3 mt-md-0">
                    <i class="fas fa-sync-alt fa-spin me-2"></i> Live Status
                </div>
                <?php endif; ?>
            </div>

            <!-- --- Order Status Specific Display --- -->
            <?php if ($order['order_status'] == 'Cancelled'): ?>
                <div class="alert alert-danger text-center py-5">
                    <i class="fas fa-times-circle fa-3x mb-3"></i>
                    <h4>Order Cancelled</h4>
                    <p class="mb-0">This order has been cancelled and will not be processed.</p>
                </div>
            <?php else: ?>
                <!-- --- Live Tracking System Timeline --- -->
                <div class="mb-5">
                    <?php
                    $status_levels = ['Pending', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered'];
                    $current_status_index = array_search($order['order_status'], $status_levels);
                    $icons = ['fa-file-invoice-dollar', 'fa-box-open', 'fa-truck-fast', 'fa-people-carry-box', 'fa-house-chimney-user'];
                    ?>
                    <ol class="timeline">
                        <?php foreach ($status_levels as $index => $status): ?>
                            <?php
                                $step_class = '';
                                if ($current_status_index !== false) {
                                    if ($index < $current_status_index) {
                                        $step_class = 'completed';
                                    } elseif ($index == $current_status_index) {
                                        $step_class = 'completed active';
                                    }
                                }
                            ?>
                            <li class="timeline-step <?php echo $step_class; ?>">
                                <div class="timeline-icon"><i class="fas <?php echo $icons[$index]; ?>"></i></div>
                                <div class="timeline-label"><?php echo $status; ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            <?php endif; ?>
            <!-- --- End Status Specific Display --- -->

            <!-- --- Cancel Order Button --- -->
            <?php if (in_array($order['order_status'], ['Pending', 'Processing'])): ?>
                <div class="alert alert-light border text-center mb-5">
                    <p class="mb-3">Changed your mind? You can cancel your order before it ships.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.');">
                        <input type="hidden" name="cancel_order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-ban me-2"></i>Cancel Order
                        </button>
                    </form>
                </div>
            <?php endif; ?>
            
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded h-100">
                        <h5 class="mb-3"><i class="fas fa-user-circle me-2 text-muted"></i>Customer Details</h5>
                        <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                        <p class="mb-0"><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded h-100">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2 text-muted"></i>Shipping Address</h5>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded h-100">
                        <h5 class="mb-3"><i class="fas fa-credit-card me-2 text-muted"></i>Payment Method</h5>
                        <p class="mb-0"><strong>Method:</strong> <?php echo htmlspecialchars($order['payment_mode']); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded h-100">
                        <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-muted"></i>Order Status</h5>
                        <p class="mb-0"><strong>Current Status:</strong> 
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['order_status'])); ?>">
                                <?php echo htmlspecialchars($order['order_status']); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            
            <h4 class="mb-3"><i class="fas fa-list-alt me-2 text-muted"></i>Order Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td class="text-end">Rs. <?php echo number_format($item['price'], 2); ?></td>
                                    <td class="text-end fw-bold">Rs. <?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end">Delivery Fee:</td>
                                <td class="text-end">Rs. <?php echo number_format(50, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Amount:</td>
                                <td class="text-end fw-bold">Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
   <?php
        include 'shoes_admin\footer.php';
    ?>
    <?php $conn->close(); ?>
</html>
