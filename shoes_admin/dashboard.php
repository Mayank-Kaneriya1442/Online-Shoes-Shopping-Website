<?php session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {

    // Fetch Monthly Sales Data for Chart
    $months = [];
    $salesData = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date("M", mktime(0, 0, 0, $i, 1));
        $salesData[$i] = 0;
    }

    $salesQuery = mysqli_query($con, "SELECT MONTH(order_date) as month, SUM(total_amount) as total FROM orders WHERE YEAR(order_date) = YEAR(CURDATE()) AND order_status != 'Cancelled' GROUP BY MONTH(order_date)");
    while($row = mysqli_fetch_assoc($salesQuery)) {
        $salesData[$row['month']] = $row['total'];
    }
    $salesValues = array_values($salesData);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - SoleStyle</title>
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
            
            /* Custom Animations */
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes zoomIn {
                from { opacity: 0; transform: scale(0.9); }
                to { opacity: 1; transform: scale(1); }
            }

            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-6px); }
                100% { transform: translateY(0px); }
            }
            
            .animate-slide-down {
                animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            .animate-zoom-in {
                animation: zoomIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
            }

            .hover-float:hover .float-icon {
                animation: float 2s ease-in-out infinite;
            }
            
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-400 { animation-delay: 0.4s; }
            .delay-500 { animation-delay: 0.5s; }

            /* Hide scrollbar for Chrome, Safari and Opera */
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            /* Hide scrollbar for IE, Edge and Firefox */
            .no-scrollbar {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
        </style>
    </head>

    <body class="bg-slate-100">
        <div class="flex h-screen overflow-hidden">
            
            <!-- Include Sidebar -->
            <?php include('leftbar.php'); ?>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-8 shadow-sm z-10 sticky top-0 animate-slide-down">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm text-gray-500">Welcome back,</p>
                            <p class="font-semibold text-gray-800"><?php echo strtoupper(htmlentities($_SESSION['login'])); ?></p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-bold shadow-inner">
                            <?php echo substr(strtoupper($_SESSION['login']), 0, 1); ?>
                        </div>
                    </div>
                </header>

                <!-- Scrollable Content -->
                <main class="flex-1 overflow-y-auto p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        
                        <?php 
                        // Database Queries
                        $query = mysqli_query($con, "SELECT gid FROM tbl_group");
                        $listedgroups = mysqli_num_rows($query);

                        $query1 = mysqli_query($con, "SELECT pid FROM product");
                        $totalproducts = mysqli_num_rows($query1);

                        $query_users = mysqli_query($con, "SELECT id FROM register");
                        $totalusers = mysqli_num_rows($query_users);

                        $query_orders = mysqli_query($con, "SELECT id FROM orders"); 
                        $total_orders = mysqli_num_rows($query_orders);
                        ?>

                        <!-- Card 1: Groups -->
                        <a href="manage-groups.php" class="block group animate-zoom-in delay-100 hover-float">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-blue-100 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-gray-500 text-sm font-medium mb-1">Listed Groups</p>
                                    <p class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors"><?php echo htmlentities($listedgroups); ?></p>
                                </div>
                                <div class="relative z-10 bg-blue-50 text-blue-600 rounded-xl p-4 float-icon shadow-sm">
                                    <i class="fas fa-layer-group fa-lg"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Card 2: Products -->
                        <a href="manage-products.php" class="block group animate-zoom-in delay-200 hover-float">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-green-100 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-gray-500 text-sm font-medium mb-1">Total Products</p>
                                    <p class="text-4xl font-bold text-gray-800 group-hover:text-green-600 transition-colors"><?php echo htmlentities($totalproducts); ?></p>
                                </div>
                                <div class="relative z-10 bg-green-50 text-green-600 rounded-xl p-4 float-icon shadow-sm">
                                    <i class="fas fa-shoe-prints fa-lg"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Card 3: Users -->
                        <a href="user-account.php" class="block group animate-zoom-in delay-300 hover-float">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-gray-500 text-sm font-medium mb-1">Registered Users</p>
                                    <p class="text-4xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors"><?php echo htmlentities($totalusers); ?></p>
                                </div>
                                <div class="relative z-10 bg-indigo-50 text-indigo-600 rounded-xl p-4 float-icon shadow-sm">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Card 4: Orders -->
                        <a href="admin_orders.php" class="block group animate-zoom-in delay-400 hover-float">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-yellow-100 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-yellow-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-gray-500 text-sm font-medium mb-1">Total Orders</p>
                                    <p class="text-4xl font-bold text-gray-800 group-hover:text-yellow-600 transition-colors"><?php echo htmlentities($total_orders); ?></p>
                                </div>
                                <div class="relative z-10 bg-yellow-50 text-yellow-600 rounded-xl p-4 float-icon shadow-sm">
                                    <i class="fas fa-shopping-bag fa-lg"></i>
                                </div>
                            </div>
                        </a>

                    </div>

                    <!-- Sales Chart -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 animate-zoom-in delay-400 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800">Monthly Revenue</h3>
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full"><?php echo date('Y'); ?></span>
                        </div>
                        <div class="relative h-80 w-full">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-lg p-8 animate-zoom-in delay-500 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                        
                        <h3 class="text-xl font-bold mb-6 relative z-10">Quick Actions</h3>
                        <div class="flex flex-wrap gap-4 relative z-10">
                            <a href="add-product.php" class="px-6 py-3 bg-white text-red-600 rounded-xl hover:bg-red-50 transition-all shadow-md font-semibold flex items-center transform hover:-translate-y-1">
                                <i class="fas fa-plus mr-2"></i> Add Product
                            </a>
                            <a href="admin_orders.php" class="px-6 py-3 bg-red-800 bg-opacity-50 border border-red-400 text-white rounded-xl hover:bg-opacity-70 transition-all shadow-md font-semibold flex items-center transform hover:-translate-y-1 backdrop-blur-sm">
                                <i class="fas fa-list mr-2"></i> Manage Orders
                            </a>
                        </div>
                    </div>

                </main>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                        label: 'Revenue',
                        data: <?php echo json_encode($salesValues); ?>,
                        borderColor: '#c0392b',
                        backgroundColor: 'rgba(192, 57, 43, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#c0392b',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f3f4f6' },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        </script>
    </body>

    </html>
<?php } ?>
