<?php
session_start();
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit;
} else {
    // Handle form submission
    if (isset($_POST['submit'])) {
        // Retrieve the product ID from the URL (or fallback to 0)
        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

        // Check if the form fields are set and not empty
        if (!empty($pid) && !empty($_POST['pname']) && !empty($_POST['pimage']) && !empty($_POST['cost'])) {
            $pname = $_POST['pname'];
            $pimage = $_POST['pimage'];
            $cost = $_POST['cost'];

            // Run the query and check for errors
            $query = mysqli_query($con, "UPDATE product SET pname='$pname', pimage='$pimage', cost='$cost' WHERE pid='$pid'");

            if ($query) {
                echo '<script>alert("Product updated successfully")</script>';
                echo "<script>window.location.href='manage-products.php'</script>";
                exit;
            } else {
                echo '<div class="alert alert-danger">Error updating product: ' . mysqli_error($con) . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Please fill in all fields before submitting!</div>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - SoleStyle</title>
    
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
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .delay-100 { animation-delay: 0.1s; }
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
                <h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Edit Product</h1>
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
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100 animate-fade-in-up delay-100">
                                    <?php
                                    // Retrieve product details based on the passed pid
                                    $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
                                    if ($pid > 0) {
                                        $query = mysqli_query($con, "SELECT * FROM `product` WHERE pid='$pid'");
                                        if ($res = mysqli_fetch_array($query)) {
                                    ?>
                                            <form method="post">
                                                <div class="space-y-6">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Brand Name</label>
                                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" 
                                                            name="pname" id="pname" value="<?php echo $res['pname']; ?>" required="required">
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                                                        <input type="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors" 
                                                            name="pimage" id="pimage" value="<?php echo $res['pimage']; ?>" required="required">
                                                        <p class="text-xs text-gray-500 mt-1">Current: <?php echo $res['pimage']; ?></p>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Cost</label>
                                                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" 
                                                            name="cost" id="cost" value="<?php echo $res['cost']; ?>" required="required">
                                                    </div>

                                                    <div class="pt-4">
                                                        <input type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" 
                                                            name="submit" value="Update Product">
                                                    </div>
                                                </div>
                                            </form>
                                    <?php
                                        } else {
                                            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">Invalid product ID or product not found.</div>';
                                        }
                                    } else {
                                        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">Product ID not provided.</div>';
                                    }
                                    ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
<?php } ?>
