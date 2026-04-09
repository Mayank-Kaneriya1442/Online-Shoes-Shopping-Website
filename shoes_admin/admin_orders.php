<?php
session_start();
// --- Database Connection ---
include('includes/dbconnection.php');
// Map $con to $conn to maintain compatibility with existing code in this file
$conn = $con;

if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit();
}

// --- Handle Status Update Form Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $orderId = (int)$_POST['order_id'];
    $newStatus = $conn->real_escape_string($_POST['new_status']);

    // IMPORTANT: Ensure your 'orders' table `order_status` ENUM includes 'Cancelled'
    $allowed_statuses = ['Pending', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered', 'Cancelled'];

    if (in_array($newStatus, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
}

// --- Dashboard Metrics ---
$total_orders = $conn->query("SELECT COUNT(id) as count FROM orders")->fetch_assoc()['count'];
$total_customers = $conn->query("SELECT COUNT(DISTINCT customer_email) as count FROM orders")->fetch_assoc()['count'];
$total_revenue_result = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE order_status != 'Cancelled'")->fetch_assoc()['total'];
$total_revenue = $total_revenue_result ?? 0;

// --- Search and Fetch Logic ---
$search_query = "";
$sql_orders = "SELECT id, customer_name, customer_phone, customer_email, customer_address, payment_mode, order_status, total_amount, order_date FROM orders";
if (!empty($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    $sql_orders .= " WHERE customer_name LIKE '%$search_query%' OR customer_email LIKE '%$search_query%' OR id LIKE '%$search_query%'";
}
$sql_orders .= " ORDER BY order_date DESC";
$result_orders = $conn->query($sql_orders);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - All Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif; 
        }
        .modal { transition: opacity 0.25s ease; }
        .modal-content { transition: transform 0.25s ease, opacity 0.25s ease; }
        
        /* Custom Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0; /* Start hidden */
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        .status-badge {
            display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px;
            font-weight: 500; font-size: 0.75rem; text-transform: uppercase;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; } /* Amber */
        .status-processing { background-color: #dbeafe; color: #1e40af; } /* Blue */
        .status-shipped { background-color: #e0e7ff; color: #3730a3; } /* Indigo */
        .status-out-for-delivery { background-color: #fed7aa; color: #9a3412; } /* Orange */
        .status-delivered { background-color: #d1fae5; color: #065f46; } /* Green */
        .status-cancelled { background-color: #fee2e2; color: #991b1b; } /* Red */

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-slate-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include('leftbar.php'); ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm z-0">
                <h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Orders Management</h1>
                <div class="flex items-center space-x-4 animate-fade-in-up delay-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm text-gray-500">Welcome back,</p>
                        <p class="font-semibold text-gray-800"><?php echo strtoupper(htmlentities($_SESSION['login'])); ?></p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-bold shadow-inner">
                        <?php echo substr(strtoupper($_SESSION['login']), 0, 1); ?>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between animate-fade-in-up delay-100 hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $total_orders; ?></p>
                    </div>
                    <div class="bg-blue-50 text-blue-600 rounded-full p-4"><i class="fas fa-shopping-bag fa-lg"></i></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between animate-fade-in-up delay-200 hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Customers</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo $total_customers; ?></p>
                    </div>
                    <div class="bg-yellow-50 text-yellow-600 rounded-full p-4"><i class="fas fa-users fa-lg"></i></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between animate-fade-in-up delay-300 hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800">Rs. <?php echo number_format($total_revenue, 2); ?></p>
                    </div>
                    <div class="bg-green-50 text-green-600 rounded-full p-4"><i class="fas fa-dollar-sign fa-lg"></i></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in-up delay-300">
                <form action="" method="GET" class="mb-6 flex items-center space-x-4">
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" placeholder="Search by Order ID, Name, or Email..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES); ?>" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-3 rounded-lg hover:from-red-700 hover:to-red-900 transition-all duration-300 font-semibold">Search</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left">Order ID</th>
                                <th scope="col" class="px-6 py-4 text-left">Customer</th>
                                <th scope="col" class="px-6 py-4 ">Date</th>
                                <th scope="col" class="px-6 py-4 text-left">Total</th>
                                <th scope="col" class="px-6 py-4 text-center">Status</th>
                                <th scope="col" class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result_orders->num_rows > 0): ?>
                                <?php while($order = $result_orders->fetch_assoc()): ?>
                                    <tr class="<?php echo ($order['order_status'] == 'Cancelled') ? 'bg-red-50 hover:bg-red-100' : 'bg-white hover:bg-gray-50'; ?> border-b transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">#<?php echo htmlspecialchars($order['id']); ?></td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                                            <p class="text-xs text-gray-400"><?php echo htmlspecialchars($order['customer_email']); ?></p>
                                        </td>
                                        <td class="px-6 py-4"><?php echo date("M j, Y", strtotime($order['order_date'])); ?></td>
                                        <td class="px-6 py-4  font-bold text-gray-800">Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($order['order_status'] == 'Cancelled'): ?>
                                                <span class="status-badge status-cancelled">
                                                   <i class="fas fa-ban mr-1"></i> Cancelled by User
                                                </span>
                                            <?php else: ?>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                                    <select name="new_status" onchange="this.form.submit()" class="form-select border rounded-lg p-2 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-red-500 transition-colors">
                                                        <option value="Pending" <?php echo ($order['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Processing" <?php echo ($order['order_status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="Shipped" <?php echo ($order['order_status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                                        <option value="Out for Delivery" <?php echo ($order['order_status'] == 'Out for Delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                                                        <option value="Delivered" <?php echo ($order['order_status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                        <option value="Cancelled">Cancel</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="openModal('order-modal-<?php echo $order['id']; ?>')" class="font-medium text-red-600 hover:text-red-800 hover:underline transition-colors">View Details</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-16 text-gray-500">
                                        <i class="fas fa-box-open fa-3x mb-3 text-gray-400"></i>
                                        <p class="font-semibold text-lg">No orders found.</p>
                                        <?php if(!empty($search_query)): ?>
                                            <p>Try adjusting your search criteria.</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </main>
        </div>
    </div>


    <!-- Modals -->
    <?php
    if ($result_orders->num_rows > 0) {
        mysqli_data_seek($result_orders, 0); // Reset result pointer to loop again
        while($order = $result_orders->fetch_assoc()) {
    ?>
    <div id="order-modal-<?php echo $order['id']; ?>" class="modal fixed inset-0 bg-black bg-opacity-50 h-full w-full flex items-center justify-center hidden opacity-0 z-50">
        <div class="modal-content relative p-8 border w-full max-w-4xl shadow-2xl rounded-2xl bg-white transform scale-95 overflow-y-auto max-h-[90vh]">
            <button onclick="closeModal('order-modal-<?php echo $order['id']; ?>')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times fa-lg"></i>
            </button>
            <div class="text-left">
                <h3 class="text-3xl leading-6 font-bold text-gray-900 mb-2">Order Details: #<?php echo htmlspecialchars($order['id']); ?></h3>
                <p class="text-sm text-gray-500 mb-6 border-b pb-4">Date: <?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-3 text-lg"><i class="fas fa-user-circle mr-2 text-gray-500"></i>Customer Details</h4>
                        <p class="text-sm text-gray-700"><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p class="text-sm text-gray-700"><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                        <p class="text-sm text-gray-700"><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-3 text-lg"><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>Shipping Address</h4>
                        <p class="text-sm text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($order['customer_address'])); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-3 text-lg"><i class="fas fa-credit-card mr-2 text-gray-500"></i>Payment Method</h4>
                        <p class="text-sm text-gray-700"><strong>Method:</strong> <?php echo htmlspecialchars($order['payment_mode']); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-3 text-lg"><i class="fas fa-info-circle mr-2 text-gray-500"></i>Order Status</h4>
                        <p class="text-sm text-gray-700"><strong>Status:</strong> <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['order_status'])); ?>"><?php echo htmlspecialchars($order['order_status']); ?></span></p>
                    </div>
                </div>
                
                <h4 class="font-semibold text-gray-800 mb-3 text-xl border-t pt-6"><i class="fas fa-list-alt mr-2 text-gray-500"></i>Order Items</h4>
                <div class="overflow-hidden border rounded-2xl">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 font-semibold text-left">Product</th>
                                <th class="p-4 font-semibold text-center">Quantity</th>
                                <th class="p-4 font-semibold text-right">Price</th>
                                <th class="p-4 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order_id = $order['id'];
                            $stmt_items = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
                            $stmt_items->bind_param("i", $order_id);
                            $stmt_items->execute();
                            $result_items = $stmt_items->get_result();
                            while($item = $result_items->fetch_assoc()):
                            ?>
                            <tr class="border-t hover:bg-gray-50 transition-colors">
                                <td class="p-3"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td class="p-4 text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td class="p-4 text-right">Rs. <?php echo number_format($item['price'], 2); ?></td>
                                <td class="p-4 text-right font-medium">Rs. <?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                            </tr>
                            <?php endwhile; $stmt_items->close(); ?>
                        </tbody>
                        <tfoot class="font-bold bg-gray-100">
                            <tr>
                                <td colspan="3" class="p-4 text-right text-md text-gray-700">Delivery Fee:</td>
                                <td class="p-4 text-right text-md text-gray-900">Rs. <?php echo number_format(50, 2); ?></td>
                            </tr>
                            
                            <tr class="border-t-2">
                                <td colspan="3" class="p-4 text-right text-lg text-gray-800">Total Amount:</td>
                                <td class="p-4 text-right text-lg text-red-600">Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    }
    ?>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.modal-content').classList.remove('scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html>
