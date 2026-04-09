<?php session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid'] == 0)) {
	header('location:logout.php');
} else {


	if (isset($_POST['submit'])) {
		$aid = $_SESSION['aid'];
		$aname = $_POST['adminname'];
		$aemail = $_POST['aemailid'];


		$query = mysqli_query($con, "update tbl_login set FullName='$aname',AdminEmail='$aemail' where id='$aid'");
		if ($query) {
			echo '<script>alert("Admin Profile updated successfully")</script>';
			echo "<script>window.location.href='admin-profile.php'</script>";
		}

	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin Profile - SoleStyle</title>
		
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
					<h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Edit Admin Profile</h1>
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
								$adminid = intval($_SESSION['aid']);
								$query = mysqli_query($con, "SELECT * FROM tbl_login where id='$adminid'");
								$sn = 1;
								while ($res = mysqli_fetch_array($query)) { ?>
									<form method="post">
										<div class="space-y-6">
											<div>
												<label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
												<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" 
													name="adminname" id="adminname" value="<?php echo $res['FullName']; ?>" required="required">
											</div>

											<div>
												<label class="block text-sm font-medium text-gray-700 mb-2">Email ID</label>
												<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" 
													name="aemailid" id="aemailid" value="<?php echo $res['AdminEmail']; ?>" required="required">
											</div>

											<div>
												<label class="block text-sm font-medium text-gray-700 mb-2">Login ID / Username</label>
												<input class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed" 
													name="loginid" id="loginid" value="<?php echo $res['loginid']; ?>" disabled required="required">
												<p class="text-xs text-red-500 mt-1">Login ID / Username cannot be edited</p>
											</div>

											<div class="pt-4">
												<input type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" 
													name="submit" value="Update Profile">
											</div>
										</div>
									</form>
											<?php } ?>
					</div>
				</main>
			</div>
		</div>
	</body>

	</html>
<?php } ?>