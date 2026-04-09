<?php session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{ 
    if(isset($_POST['submit'])){    
$status=1;
$session=$_POST['session'];

$sql="update session set status='$status' where session='$session';";
$sql.="update session set status='0' where session!='$session';";
$query = mysqli_multi_query($con, $sql);
if($query){
echo '<script>alert("session updated successfully")</script>';
echo "<script>window.location.href='session.php'</script>";
}
    
 }?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Session - SoleStyle</title>
	
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
				<h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Manage Session</h1>
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
					<div class="mb-6">
						<?php $query=mysqli_query($con,"SELECT * FROM `session` where status=1");
						while($res=mysqli_fetch_array($query)){?> 
							<div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-blue-800">
								<span class="font-bold">Current Active Session:</span> <?php echo $res['session']?>
							</div>
						<?php } ?>
					</div>

					<form method="post">
						<div class="space-y-4">
							<label class="block text-sm font-medium text-gray-700 mb-2">Select Session to Activate <span class="text-red-500">*</span></label>
							<div class="space-y-2">
								<?php $query=mysqli_query($con,"SELECT * FROM `session`");
								while($res=mysqli_fetch_array($query)){?>   
									<div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
										<input type="radio" name="session" id="session_<?php echo $res['session']?>" value="<?php echo $res['session']?>" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300" required="required">
										<label for="session_<?php echo $res['session']?>" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer w-full">
											<?php echo $res['session']?>
										</label>
									</div>
								<?php  } ?>
							</div>

							<div class="pt-4">
								<input type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" 
									name="submit" value="Update Session">
							</div>
						</div>
					</form>
				</div>
			</main>
		</div>
	</div>
</body>
</html>
<?php } ?>
