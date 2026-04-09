<?php session_start();
include('C:\xampp\htdocs\shoeswebsite\shoes_admin\includes\dbconnection.php');

$msg = "";
if(isset($_POST['submit']))
  {
    $uname=$_POST['id'];
    $Password=$_POST['password'];
    $query=mysqli_query($con,"select ID,loginid from tbl_login where  loginid='$uname' && password='$Password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
      $_SESSION['aid']=$ret['ID'];
      $_SESSION['login']=$ret['loginid'];
     header('location:dashboard.php');
    }
    else{
      $msg = "Invalid Details";
    }
  }
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - SoleStyle</title>

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
            background: linear-gradient(135deg, #1a1a1a 0%, #c0392b 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
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
            <div class="mb-4">
                <svg width="60" height="60" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-inline-block">
                    <rect width="40" height="40" rx="12" fill="#c0392b"/>
                    <path d="M11 22.5C11 22.5 13 27.5 19 27.5C25 27.5 29 20 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 17.5C13 17.5 17 12.5 23 12.5C29 12.5 29 15 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 22.5L29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2>Admin Login</h2>
            <p class="text-muted mb-4">Welcome back! Please login to your account.</p>
            
            <?php if($msg != ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group text-start">
                    <input class="form-control" placeholder="Login ID" id="id" name="id" type="text" required autofocus autocomplete="off">
                </div>
                <div class="form-group text-start">
                    <input class="form-control" placeholder="Password" id="password" name="password" type="password" value="" required>
                </div>
                
                <button type="submit" name="submit" class="btn btn-login">Sign In</button>
                
                <a href="password-recovery.php" class="forgot-link">Forgot Password?</a>
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
