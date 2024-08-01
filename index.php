<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiztie</title>
    <link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="image/logo.png" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

        body {
            background: url(image/bg2.jpg) center center no-repeat;
            background-size: cover;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            text-align: center;
            overflow: hidden;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 50px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
            max-width: 600px;
            width: 90%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.8);
        }
        h1 {
            font-size: 56px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #f8f9fa;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #dcdcdc;
        }
        .btn {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 25px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiztie</h1>
        <p>Welcome to Quiztie! Test your knowledge with our exciting quizzes and challenge your friends to see who knows more. Enhance your learning experience with a variety of topics and difficulty levels.</p>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
        <a href="admin.php" class="btn">Admin Login</a>
        <h2>Good Luck!</h2>
        <div class="footer">
            <p>&copy; 2024 Quiztie. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
