<?php
    include_once 'database.php';
    session_start();
    if(isset($_SESSION["email"])) {
        session_destroy();
    }

    $ref = @$_GET['q'];
    if(isset($_POST['submit'])) {    
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email = stripslashes($email);
        $email = addslashes($email);
        $password = stripslashes($password); 
        $password = addslashes($password);

        $email = mysqli_real_escape_string($con, $email);
        $password = mysqli_real_escape_string($con, $password);

        $result = mysqli_query($con, "SELECT email FROM admin WHERE email = '$email' and password = '$password'") or die('Error');
        $count = mysqli_num_rows($result);
        if($count == 1) {
            session_start();
            if(isset($_SESSION['email'])) {
                session_unset();
            }
            $_SESSION["name"] = 'Admin';
            $_SESSION["key"] = 'admin';
            $_SESSION["email"] = $email;
            header("location:dashboard.php?q=0");
        } else {
            echo "<center><h3><script>alert('Sorry.. Wrong Username (or) Password');</script></h3></center>";
            header("refresh:0;url=admin.php");
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login | Quiztie</title>
    <link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="scripts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="css/form.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        .login-box h4 {
            font-family: 'Noto Sans', sans-serif;
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #0095f6;
        }
        .btn-primary {
            background-color: #0095f6;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #007bb5;
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: #0095f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .forgot-password:hover {
            color: #007bb5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #0095f6;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h4>Login to Admin Page</h4>
            <form method="post" action="admin.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="submit">Login</button>
                </div>
                <a href="javascript:void(0)" class="forgot-password">Forgot Password?</a>
            </form>
        </div>
        <div class="footer">
            <p>&copy; 2024 Quiztie. All rights reserved.</p>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="scripts/bootstrap/bootstrap.min.js"></script>
</body>
</html>
