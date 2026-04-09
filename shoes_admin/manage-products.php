<?php 
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']) == 0) {
  header('location:logout.php');
} else {

    if (isset($_GET['delid'])) {  
        $did = intval($_GET['delid']);
        $query = mysqli_query($con, "DELETE FROM product WHERE pid='$did'");
        echo '<script>alert("Product deleted")</script>';
        echo "<script>window.location.href='manage-products.php'</script>";
    }

    // Search Logic
    $search_query = "";
    $sql_products = "SELECT * FROM product";
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_query = mysqli_real_escape_string($con, $_GET['search']);
        $sql_products .= " WHERE pname LIKE '%$search_query%' OR pgname LIKE '%$search_query%'";
    }
    $query = mysqli_query($con, $sql_products);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - SoleStyle</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        
        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include('leftbar.php'); ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm z-0">
                <h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Products Management</h1>
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

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 animate-fade-in-up delay-200">
                    
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 md:mb-0">All Products</h2>
                        
                        <div class="flex gap-4 w-full md:w-auto">
                            <form action="" method="GET" class="flex flex-1 md:w-64">
                                <div class="relative flex-1">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                                </div>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-r-lg hover:bg-red-700 transition-colors text-sm font-medium">Search</button>
                            </form>
                            <a href="add-product.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center whitespace-nowrap">
                                <i class="fas fa-plus mr-2"></i> Add New
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">S No</th>
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <th scope="col" class="px-6 py-3">Brand Name</th>
                                    <th scope="col" class="px-6 py-3">Group Name</th>
                                    <th scope="col" class="px-6 py-3">Cost</th>
                                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (mysqli_num_rows($query) > 0) {
                                    $sn = 1;
                                    while ($res = mysqli_fetch_array($query)) { ?>	
                                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-gray-900"><?php echo $sn; ?></td>
                                            <td class="px-6 py-4">
                                                <div class="h-12 w-12 rounded-lg overflow-hidden border border-gray-200 bg-white">
                                                    <img src="../images/<?php echo htmlentities($res['pimage']); ?>" alt="Product" class="h-full w-full object-contain">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-gray-800"><?php echo htmlentities(strtoupper($res['pname'])); ?></td>
                                            <td class="px-6 py-4 text-gray-500"><?php echo htmlentities(strtoupper($res['pgname'])); ?></td>
                                            <td class="px-6 py-4 font-medium text-green-600">Rs. <?php echo htmlentities($res['cost']); ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="edit-product.php?pid=<?php echo htmlentities($res['pid']); ?>" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="manage-products.php?delid=<?php echo htmlentities($res['pid']); ?>" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $sn++; } 
                                } else { ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                                <p>No products found matching your criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-xs text-gray-400 text-right">
                        Showing <?php echo mysqli_num_rows($query); ?> records
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
<?php } ?>
