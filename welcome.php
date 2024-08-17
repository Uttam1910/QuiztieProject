<?php
session_start(); // Start the session at the beginning of your script

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or show an error message
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email']; // Retrieve email from session

// Database connection
$host = 'localhost'; // or your database host
$user = 'root';      // your database username
$password = '';      // your database password
$database = 'new_quiz'; // your database name

$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Online Quiz System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/welcome.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <style>
        body {
            padding-top: 70px; /* Adjust for fixed navbar */
        }
        .navbar {
            background-color: #343a40; /* Dark background color */
            border-bottom: 1px solid #ddd;
        }
        .navbar-brand {
            font-size: 1.8em;
            color: #fff; /* Navbar brand color */
        }
        .navbar-brand:hover {
            color: #f8f9fa; /* Hover color for navbar brand */
        }
        .navbar-nav .nav-item {
            margin-left: 15px;
        }
        .navbar-nav .nav-link {
            color: #fff; /* Navbar link color */
            font-size: 1.2em;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3; /* Navbar link hover color */
        }
        .panel {
            margin-bottom: 20px;
        }
        .panel-heading {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .panel-body {
            background-color: #f5f5f5;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-primary {
            background-color: #343a40;
            border-color: #343a40;
        }
        .btn-primary:hover {
            background-color: #23272b;
            border-color: #1d2124;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="welcome.php">Quiztie</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item <?php echo @$_GET['q'] == 1 ? 'active' : ''; ?>">
                        <a class="nav-link" href="welcome.php?q=1">Quizzes</a>
                    </li>
                    <li class="nav-item <?php echo @$_GET['q'] == 'quiz' && @$_GET['step'] == 2 ? 'active' : ''; ?>">
                        <a class="nav-link" href="#">Start Quiz</a>
                    </li>
                    <li class="nav-item <?php echo @$_GET['q'] == 'result' ? 'active' : ''; ?>">
                        <a class="nav-link" href="welcome.php?q=result&eid=1">Results</a>
                    </li>
                    <li class="nav-item <?php echo @$_GET['q'] == 2 ? 'active' : ''; ?>">
                        <a class="nav-link" href="welcome.php?q=2">History</a>
                    </li>
                    <li class="nav-item <?php echo @$_GET['q'] == 3 ? 'active' : ''; ?>">
                        <a class="nav-link" href="welcome.php?q=3">Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                if (@$_GET['q'] == 1) {
                    $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Available Quizzes</h3></div><div class="panel-body"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>S.N.</th><th>Topic</th><th>Total Questions</th><th>Marks</th><th>Action</th></tr>';
                    $c = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $title = $row['title'];
                        $total = $row['total'];
                        $right = $row['right'];
                        $eid = $row['eid'];
                        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
                        $rowcount = mysqli_num_rows($q12);    
                        if ($rowcount == 0) {
                            echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$right*$total.'</td><td><a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-primary">Start</a></td></tr>';
                        } else {
                            echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.' <span title="This quiz is already solved by you" class="glyphicon glyphicon-ok"></span></td><td>'.$total.'</td><td>'.$right*$total.'</td><td><a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-primary">Reattempt</a></td></tr>';
                        }
                    }
                    echo '</table></div></div></div>';
                }

                if (@$_GET['q'] == 'result' && isset($_GET['eid'])) {
                    $eid = $_GET['eid'];
                    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Quiz Result</h3></div><div class="panel-body"><table class="table table-striped">';
                    while ($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['right'];
                        $qa = $row['level'];
                        echo '<tr><td>Total Questions</td><td>'.$qa.'</td></tr>
                              <tr style="color:#99cc32"><td>Right Answer <span class="glyphicon glyphicon-ok-circle"></span></td><td>'.$r.'</td></tr>
                              <tr style="color:red"><td>Wrong Answer <span class="glyphicon glyphicon-remove-circle"></span></td><td>'.$w.'</td></tr>
                              <tr><td>Score <span class="glyphicon glyphicon-star"></span></td><td>'.$s.'</td></tr>';
                    }
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error');
                    while ($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        echo '<tr><td>Overall Score <span class="glyphicon glyphicon-stats"></span></td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div></div>';
                }

                if (@$_GET['q'] == 2) {
                    $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC") or die('Error');
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Quiz History</h3></div><div class="panel-body"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>S.N.</th><th>Quiz</th><th>Questions</th><th>Right</th><th>Wrong</th><th>Score</th></tr>';
                    $c = 0;
                    while ($row = mysqli_fetch_array($q)) {
                        $eid = $row['eid'];
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['right'];
                        $qa = $row['level'];
                        $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'") or die('Error');
                        while ($row = mysqli_fetch_array($q23)) {
                            $title = $row['title'];
                        }
                        $c++;
                        echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div></div></div>';
                }

                if (@$_GET['q'] == 3) {
                    $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error');
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Ranking</h3></div><div class="panel-body"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>Rank</th><th>Name</th><th>Gender</th><th>College</th><th>Score</th></tr>';
                    $c = 0;
                    while ($row = mysqli_fetch_array($q)) {
                        $e = $row['email'];
                        $s = $row['score'];
                        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error');
                        while ($row = mysqli_fetch_array($q12)) {
                            $name = $row['name'];
                            $gender = $row['gender'];
                            $college = $row['college'];
                        }
                        $c++;
                        echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$college.'</td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
