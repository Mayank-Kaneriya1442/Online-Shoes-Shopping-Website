<?php session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
{
$adminid=$_SESSION['aid'];
$cpassword=$_POST['currentpassword'];
$newpassword=$_POST['newpassword'];
$query=mysqli_query($con,"select id from tbl_login where id='$adminid' and   password='$cpassword'");
$row=mysqli_fetch_array($query);
if($row>0){
$ret=mysqli_query($con,"update tbl_login set password='$newpassword' where id='$adminid'");
echo '<script>alert("Your password successully changed.")</script>';
} else {

echo '<script>alert("Your current password is wrong.")</script>';
}



}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password - SoleStyle</title>

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
<script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
} 

</script>
<body class="bg-slate-100">
	<div class="flex h-screen overflow-hidden">
		<!-- Sidebar -->
		<?php include('leftbar.php'); ?>

		<!-- Main Content -->
		<div class="flex-1 flex flex-col overflow-hidden">
			<!-- Header -->
			<header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm z-0">
				<h1 class="text-2xl font-bold text-gray-800 animate-fade-in-up">Change Password</h1>
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
					<form method="post" name="changepassword" onsubmit="return checkpass();">
						<div class="space-y-6">
							<div>
								<label class="block text-sm font-medium text-gray-700 mb-2">Current Password <span class="text-red-500">*</span></label>
								<input type="password" name="currentpassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" required="true" value="">
							</div>

							<div>
								<label class="block text-sm font-medium text-gray-700 mb-2">New Password <span class="text-red-500">*</span></label>
								<input type="password" name="newpassword" id="newpassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" value="" required>
							</div>

							<div>
								<label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
								<input type="password" name="confirmpassword" id="confirmpassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors" value="" required>
							</div>

							<div class="pt-4">
								<input type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" 
									name="submit" value="Change Password">
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
