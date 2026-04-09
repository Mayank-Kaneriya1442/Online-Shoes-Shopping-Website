<?php
session_start();
// Assuming you have a user logged in and their ID is stored in the session.
// For testing, I'm setting a default user ID. Replace this with your actual session logic.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Default user for testing.
}
$loggedInUserId = $_SESSION['user_id'];

// =================================================================
// 1. DATABASE CONNECTION
// =================================================================
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'webshoes'; // Using your 'webshoes' database

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// =================================================================
// 2. HANDLE CANCEL ORDER REQUEST
// =================================================================
if (isset($_POST['action']) && $_POST['action'] == 'cancel_order' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Security check: Ensure the order belongs to the logged-in user
    $check_stmt = $conn->prepare("SELECT status FROM orders WHERE id = ? AND userId = ?");
    $check_stmt->bind_param("ii", $orderId, $loggedInUserId);
    $check_stmt->execute();
    $status_result = $check_stmt->get_result()->fetch_assoc();
    $check_stmt->close();

    if ($status_result && !in_array($status_result['status'], ['Out for delivery', 'Delivered', 'Cancelled'])) {
        // Update the order status to "Cancelled"
        $update_stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
        $update_stmt->bind_param("i", $orderId);
        $update_stmt->execute();
        $update_stmt->close();
    }
    
    header("Location: myorder.php");
    exit();
}


// =================================================================
// 3. FETCH ORDERS FOR THE LOGGED-IN USER
// =================================================================
$orders_data = [];
try {
    // Fetch all orders for the logged-in user, including address details
    $sql_orders = "
        SELECT 
            id, amount, status, payment, paymentMethod, date, 
            address_firstname, address_lastname, address_street, 
            address_city, address_state, address_zipcode, 
            address_country, address_phone
        FROM orders 
        WHERE userId = ?
        ORDER BY date DESC
    ";
    $stmt_orders = $conn->prepare($sql_orders);
    $stmt_orders->bind_param("i", $loggedInUserId);
    $stmt_orders->execute();
    $orders_result = $stmt_orders->get_result();


    while ($order = $orders_result->fetch_assoc()) {
        // For each order, fetch its items
        $stmt_items = $conn->prepare("SELECT name, JSON_UNQUOTE(JSON_EXTRACT(image, '$[0]')) as image, price, quantity, size FROM order_items WHERE orderId = ?");
        $stmt_items->bind_param("i", $order['id']);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();

        $items_data = [];
        while ($item = $items_result->fetch_assoc()) {
            $items_data[] = $item;
        }
        $stmt_items->close();

        $order['items'] = $items_data;
        $orders_data[] = $order;
    }
     $stmt_orders->close();
} catch (Exception $e) {
    die("Error fetching orders: " . $e->getMessage());
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <!-- In-built CSS for styling -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .title-container {
            margin-bottom: 2rem;
        }
        .title-text {
            font-size: 2rem;
            font-weight: bold;
            color: #1a202c;
        }
        .title-text .text-orange {
            color: #f56565;
        }
        .order-card {
            display: grid;
            grid-template-columns: 0.5fr 2fr 1fr 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
            border: 2px solid #e2e8f0;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: #fff;
            border-radius: 8px;
            font-size: 14px;
        }
        .order-images img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        .order-details .item-list p {
            margin: 4px 0;
        }
        .order-details .customer-name {
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .order-details .total-amount {
            font-weight: bold;
            font-size: 16px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .order-details .address p {
            margin: 2px 0;
            line-height: 1.5;
            color: #555;
        }
        .order-details .contact {
            margin-top: 1rem;
        }

        .order-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .order-status .tracking-icon {
             width: 48px;
             height: 48px;
        }
        .order-actions {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            height: 100%;
        }
        .btn {
            border: 1px solid #ccc;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            width: 140px;
            text-align: center;
        }
        .btn-cancel {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        .btn:hover {
            background-color: #f1f1f1;
        }
        .btn-cancel:hover {
            background-color: #dc2626;
        }
        .no-orders {
            text-align: center;
            font-size: 1.25rem;
            color: #718096;
            margin-top: 2rem;
        }
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .order-card {
                grid-template-columns: 0.5fr 2fr 1fr;
                grid-template-areas: 
                    "images details status"
                    "images details actions";
            }
            .order-actions {
                 grid-area: actions;
                 margin-top: 1rem;
            }
        }
        @media (max-width: 768px) {
            .order-card {
                grid-template-columns: 1fr;
                grid-template-areas: 
                    "images"
                    "details"
                    "status"
                    "actions";
                text-align: center;
            }
            .order-images, .order-status, .order-actions {
                justify-content: center;
                flex-direction: row;
                flex-wrap: wrap;
            }
             .order-actions {
                flex-direction: row;
             }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title-container">
        <h1 class="title-text">MY <span class="text-orange">ORDERS</span></h1>
    </div>

    <div>
        <?php if (empty($orders_data)): ?>
            <p class="no-orders">You have no orders yet.</p>
        <?php else: ?>
            <?php foreach ($orders_data as $order): ?>
                <div class="order-card">
                    <!-- Column 1: Images -->
                    <div class="order-images">
                        <?php foreach ($order['items'] as $item): ?>
                            <img src="<?php echo htmlspecialchars($item['image'] ?: 'path/to/placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <?php endforeach; ?>
                    </div>

                    <!-- Column 2: Order Details -->
                    <div class="order-details">
                        <div class="item-list">
                            <?php foreach ($order['items'] as $index => $item): ?>
                                <p>
                                    <?php echo htmlspecialchars($item['name']); ?> x 
                                    <?php echo htmlspecialchars($item['quantity']); ?> x 
                                    <span><?php echo htmlspecialchars($item['size']); ?></span>
                                    <?php if ($index < count($order['items']) - 1) echo ','; ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <p class="customer-name"><?php echo htmlspecialchars($order['address_firstname'] . ' ' . $order['address_lastname']); ?></p>
                        <div class="address">
                            <p><?php echo htmlspecialchars($order['address_street']); ?></p>
                            <p><?php echo htmlspecialchars($order['address_city'] . ', ' . $order['address_state'] . ' - ' . $order['address_zipcode']); ?></p>
                            <p><?php echo htmlspecialchars($order['address_country']); ?></p>
                        </div>
                        <p class="total-amount">₹<?php echo htmlspecialchars($order['amount']); ?></p>
                        <p class="contact">Phone: <?php echo htmlspecialchars($order['address_phone']); ?></p>
                        <p>Items: <?php echo count($order['items']); ?></p>
                        <p>Method: <?php echo htmlspecialchars($order['paymentMethod']); ?></p>
                        <p>Payment: <?php echo $order['payment'] ? 'Done' : 'Pending'; ?></p>
                        <p>Date: <?php echo date("M d, Y", strtotime($order['date'])); ?></p>
                    </div>

                    <!-- Column 3: Status -->
                    <div class="order-status">
                        <svg class="tracking-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5a3.375 3.375 0 00-3.375-3.375H3.375m15.75 9v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 003.375-3.375h1.125c.621 0 1.125.504 1.125 1.125V6.375" />
                        </svg>
                        <p><?php echo htmlspecialchars($order['status']); ?></p>
                    </div>
                    
                    <!-- Column 4: Spacer (for layout consistency) -->
                    <div></div>

                    <!-- Column 5: Actions -->
                    <div class="order-actions">
                        <?php if ($order['status'] === 'Delivered'): ?>
                            <p>Order Delivered</p>
                        <?php elseif ($order['status'] === 'Cancelled'): ?>
                             <p>Order Cancelled</p>
                        <?php else: ?>
                            <a href="#" class="btn">Track Order</a>
                            <form method="POST" action="myorder.php" style="margin: 0;">
                                <input type="hidden" name="action" value="cancel_order">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" class="btn btn-cancel" 
                                    <?php if ($order['status'] === 'Out for delivery') echo 'onclick="alert(\'Your order is Out for delivery, so you cannot cancel it.\'); return false;"'; ?>>
                                    Cancel Order
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
