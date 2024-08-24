<?php
include_once 'database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
} else {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    include_once 'database.php';
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
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        body {
            background: #f4f4f9;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #1c1c1c;
            border: none;
            border-radius: 0;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: #ffffff !important;
            font-size: 24px;
            font-weight: bold;
        }
        .navbar-nav li a {
            color: #d1d1d1 !important;
            font-weight: bold;
        }
        .navbar-nav li a:hover, .navbar-nav li.active a {
            color: #ffffff !important;
            background-color: #333333 !important;
        }
        .navbar-toggle {
            border-color: #ffffff;
        }
        .navbar-toggle .icon-bar {
            background-color: #ffffff;
        }
        .panel {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            color: #2C3E50;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #2C3E50;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn {
            background-color: #1de9b6;
            color: white;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #17c2a7;
        }
        .btn-danger {
            background-color: red;
            color: white;
            font-weight: bold;
        }
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        .fa {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Online Quiz System</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?>>
                        <a href="welcome.php?q=1"><span class="fa fa-home"></span> Home</a>
                    </li>
                    <li <?php if (@$_GET['q'] == 2) echo 'class="active"'; ?>>
                        <a href="welcome.php?q=2"><span class="fa fa-history"></span> History</a>
                    </li>
                    <li <?php if (@$_GET['q'] == 3) echo 'class="active"'; ?>>
                        <a href="welcome.php?q=3"><span class="fa fa-trophy"></span> Ranking</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="logout.php?q=welcome.php"><span class="fa fa-sign-out"></span> Log out</a>
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
                    echo '<div class="panel"><div class="table-responsive"><table class="table table-striped">
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
                            echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$right * $total.'</td><td><a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn">Start</a></td></tr>';
                        } else {
                            echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.' <span title="This quiz is already solved by you" class="fa fa-check-circle"></span></td><td>'.$total.'</td><td>'.$right * $total.'</td><td><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-danger">Reattempt</a></td></tr>';
                        }
                    }
                    echo '</table></div></div>';
                } ?>

                <?php
                if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                    $eid = @$_GET['eid'];
                    $sn = @$_GET['n'];
                    $total = @$_GET['t'];
                    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'");
                    echo '<div class="panel">';
                    while ($row = mysqli_fetch_array($q)) {
                        $qns = $row['qns'];
                        $qid = $row['qid'];
                        echo '<b>Question '.$sn.':</b><br />'.$qns.'<br /><br />';
                    }
                    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'");
                    echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST" class="form-horizontal">';
                    while ($row = mysqli_fetch_array($q)) {
                        $option = $row['option'];
                        $optionid = $row['optionid'];
                        echo '<div class="radio"><label><input type="radio" name="ans" value="'.$optionid.'"> '.$option.'</label></div>';
                    }
                    echo '<br /><button type="submit" class="btn btn-primary"><span class="fa fa-lock"></span> Submit</button></form></div>';
                }

                if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                    $eid = @$_GET['eid'];
                    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
                    echo '<div class="panel"><center><h1 class="title">Result</h1></center><br /><table class="table table-striped">';
                    while ($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['right'];
                        $qa = $row['level'];
                        echo '<tr><td>Total Questions</td><td>'.$qa.'</td></tr>
                              <tr style="color:#99cc32"><td>Correct Answers <span class="fa fa-check-circle"></span></td><td>'.$r.'</td></tr>
                              <tr style="color:red"><td>Wrong Answers <span class="fa fa-times-circle"></span></td><td>'.$w.'</td></tr>
                              <tr><td>Total Score</td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div>';
                }

                if (@$_GET['q'] == 2) {
                    $result = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC") or die('Error');
                    echo '<div class="panel"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>S.N.</th><th>Quiz</th><th>Correct Answers</th><th>Wrong Answers</th><th>Date</th></tr>';
                    $c = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $eid = $row['eid'];
                        $score = $row['score'];
                        $wrong = $row['wrong'];
                        $right = $row['right'];
                        $date = $row['date'];
                        $quiz_result = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'");
                        $quiz = mysqli_fetch_array($quiz_result)['title'];
                        echo '<tr><td>'.$c++.'</td><td>'.$quiz.'</td><td>'.$right.'</td><td>'.$wrong.'</td><td>'.$date.'</td></tr>';
                    }
                    echo '</table></div></div>';
                }

                if (@$_GET['q'] == 3) {
                    $result = mysqli_query($con, "SELECT * FROM history ORDER BY score DESC") or die('Error');
                    echo '<div class="panel"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>S.N.</th><th>Email</th><th>Score</th></tr>';
                    $c = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $email = $row['email'];
                        $score = $row['score'];
                        echo '<tr><td>'.$c++.'</td><td>'.$email.'</td><td>'.$score.'</td></tr>';
                    }
                    echo '</table></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
