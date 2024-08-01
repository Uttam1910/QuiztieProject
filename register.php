<?php
	include("database.php");
	session_start();
	
	if(isset($_POST['submit']))
	{	
		$name = $_POST['name'];
		$name = stripslashes($name);
		$name = addslashes($name);

		$email = $_POST['email'];
		$email = stripslashes($email);
		$email = addslashes($email);

		$password = $_POST['password'];
		$password = stripslashes($password);
		$password = addslashes($password);

		$college = $_POST['college'];
		$college = stripslashes($college);
		$college = addslashes($college);

		$str = "SELECT email FROM user WHERE email='$email'";
		$result = mysqli_query($con, $str);
		
		if(mysqli_num_rows($result) > 0)	
		{
            echo "<center><h3><script>alert('Sorry.. This email is already registered !!');</script></h3></center>";
            header("refresh:0;url=login.php");
        }
		else
		{
            $str = "INSERT INTO user (name, email, password, college) VALUES ('$name', '$email', '$password', '$college')";
			if(mysqli_query($con, $str))	
			{
				echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
				header('location: welcome.php?q=1');
			}
		}
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Register | Quiztie</title>
	<link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="scripts/ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="css/form.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');
        body {
            background: url(image/book.png) center center no-repeat fixed;
            background-size: cover;
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
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-muted {
            color: #777;
        }
    </style>
</head>
<body>
	<div class="container">
		<h5>Register to</h5>
		<h4>Quiztie</h4>
		<form method="post" action="register.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Enter Your Username:</label>
                <input type="text" id="name" name="name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="email">Enter Your Email Id:</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="password">Enter Your Password:</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="college">Enter Your College Name:</label>
                <input type="text" id="college" name="college" class="form-control" required />
            </div>
            <div class="form-group text-right">
                <button class="btn" name="submit">Register</button>
            </div>
            <div class="form-group text-center">
                <span class="text-muted">Already have an account? </span> <a href="login.php">Login Here</a>
            </div>
        </form>
	</div>
	<script src="js/jquery.js"></script>
	<script src="scripts/bootstrap/bootstrap.min.js"></script>
</body>
</html>
