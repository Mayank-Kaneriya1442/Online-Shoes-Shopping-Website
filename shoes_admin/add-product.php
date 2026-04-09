<?php session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid'] == 0)) {
	header('location:logout.php');
} else {

	if (isset($_POST['submit'])) {
		$pgname = $_POST['pgname'];
		$pname = $_POST['pname'];
		$pimage = $_POST['pimage'];
		$cost = $_POST['cost'];
		
		$query = mysqli_query($con, "insert into product(pgname,pname,pimage,cost) value('$pgname','$pname','$pimage','$cost')");
		if ($query) {
			echo '<script>alert("Product Added successfully")</script>';
			echo "<script>window.location.href='manage-products.php'</script>";	
		} else {
			echo '<script>alert("Something went wrong. Please try again")</script>';
			echo '<script>window.location.href=add-product.php</script>';
		}
	}
	?>


	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Add Product - SoleStyle</title>
		
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
					<h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Add New Product</h1>
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
						<form method="post">
							<div class="space-y-6">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-2">Product Group Name <span class="text-red-500">*</span></label>
									<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors bg-white" 
										name="pgname" id="pgname" onchange="groupAvailability()" required="required">
										<option value="">Select Group</option>
										<?php $query = mysqli_query($con, "select * from tbl_group");
										while ($res = mysqli_fetch_array($query)) { ?>
											<option value="<?php echo htmlentities($res['pgname']) ?>">
												<?php echo htmlentities($res['pgname']) ?>
											</option>
										<?php } ?>
									</select>
									<span id="group-availability-status" class="text-xs mt-1 block"></span>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-2">Brand Name</label>
									<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" name="pname" required>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
									<input type="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors" name="pimage" required>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-2">Cost</label>
									<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" name="cost" required>
								</div>

								<div class="pt-4">
									<input type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" 
										name="submit" value="Add Product">
								</div>
							</div>
						</form>
					</div>
				</main>
			</div>
		</div>

			<!-- jQuery -->
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			
			<script>
				function groupfullAvail() {
					$("#loaderIcon").show();
					jQuery.ajax({
						url: "group_availability.php",
						data: 'pgname1=' + $("#pgname").val(),
						type: "POST",
						success: function (data) {
							$("#group-status").html(data);
							$("#loaderIcon").hide();
						},
						error: function () { }
					});
				}

				function groupAvailability() {
					$("#loaderIcon").show();
					jQuery.ajax({
						url: "group_availability.php",
						data: 'pgname1=' + $("#pgname").val(),
						type: "POST",
						success: function (data) {
							$("#group-availability-status").html(data);
							$("#loaderIcon").hide();
						},
						error: function () { }
					});
				}

			</script>
	</body>

	</html>
<?php } ?>