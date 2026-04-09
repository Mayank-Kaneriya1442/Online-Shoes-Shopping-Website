<?php session_start();
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $uname=$_POST['id'];
    $emailid=$_POST['emailid'];
    $Password=$_POST['password'];
    $query=mysqli_query($con,"select ID,loginid from tbl_login where  loginid='$uname' && AdminEmail='$emailid' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
$ret=mysqli_query($con,"update tbl_login set password='$Password' where loginid='$uname' && AdminEmail='$emailid' ");
echo '<script>alert("Your password successully changed.")</script>';
echo "<script>window.location.href='login.php'</script>";
    }
    else{
 echo '<script>alert("invalid details")</script>';
    }
  }
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Recovery - SoleStyle</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #1a1a1a;
            --accent-red: #c0392b;
            --text-gray: #666;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 5px solid var(--accent-red);
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: var(--accent-red);
            box-shadow: 0 0 0 0.2rem rgba(192, 57, 43, 0.1);
        }

        .btn-login {
            background: var(--accent-red);
            color: #fff;
            border-radius: 50px;
            padding: 12px 20px;
            width: 100%;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #a93226;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.3);
            color: white;
        }

        .forgot-link {
            display: block;
            margin-top: 15px;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--accent-red);
        }
    </style>
</head>
<body>
    
    <div class="container d-flex justify-content-center">
        <div class="login-card" data-aos="fade-up" data-aos-duration="1000">
            <img src="../images/logo.PNG" class="brand-logo" alt="logo">
            <h2>Password Recovery</h2>
            <p class="text-muted mb-4">Enter your details to reset password.</p>
            
            <form method="post">
                <div class="form-group text-start">
                    <input class="form-control" placeholder="Login ID" id="id" name="id" type="text" required autofocus autocomplete="off">
                </div>
                <div class="form-group text-start">
                    <input class="form-control" placeholder="Admin Email ID" id="emailid" name="emailid" type="text" required autocomplete="off">
                </div>
                <div class="form-group text-start">
                    <input class="form-control" placeholder="New Password" id="password" name="password" type="password" value="" required>
                </div>
                
                <button type="submit" value="Change Password" name="submit" class="btn btn-login">Change Password</button>
                
                <a href="login.php" class="forgot-link">Back to Login</a>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
