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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login | Quiztie</title>
    <link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="scripts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="css/form.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

        body {
            background: #f8f9fa;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #343a40;
            text-align: center;
            overflow: hidden;
        }
        .container {
            background: #fff;
            padding: 50px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        h5, h4 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #343a40;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 12px;
            font-size: 16px;
            color: #343a40;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            box-shadow: none;
            color: #343a40;
            border-color: #80bdff;
        }
        .btn {
            display: inline-block;
            margin: 10px 0;
            padding: 12px 25px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .forgot-password:hover {
            color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5>Login to</h5>
        <h4>Admin Page</h4>
        <form method="post" action="admin.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Enter Your Email Id:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password" class="fw">Enter Your Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group text-right">
                <button class="btn" name="submit">Login</button>
            </div>
            <a href="javascript:void(0)" class="forgot-password">Forgot Password?</a>
        </form>
        <div class="footer">
            <p>&copy; 2024 Quiztie. All rights reserved.</p>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="scripts/bootstrap/bootstrap.min.js"></script>
</body>
</html>
