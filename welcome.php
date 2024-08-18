<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email']))) {
        header("location:login.php");
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
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-default title1">
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
                    <li <?php if(@$_GET['q']==1) echo 'class="active"'; ?> >
                        <a href="welcome.php?q=1"><span class="glyphicon glyphicon-home"></span> Home</a>
                    </li>
                    <li <?php if(@$_GET['q']==2) echo 'class="active"'; ?> >
                        <a href="welcome.php?q=2"><span class="glyphicon glyphicon-list-alt"></span> History</a>
                    </li>
                    <li <?php if(@$_GET['q']==3) echo 'class="active"'; ?> >
                        <a href="welcome.php?q=3"><span class="glyphicon glyphicon-stats"></span> Ranking</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="logout.php?q=welcome.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                if(@$_GET['q']==1) {
                    $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped">
                    <tr><th>S.N.</th><th>Topic</th><th>Total Questions</th><th>Marks</th><th>Action</th></tr>';
                    $c = 1;
                    while($row = mysqli_fetch_array($result)) {
                        $title = $row['title'];
                        $total = $row['total'];
                        $right = $row['right'];
                        $eid = $row['eid'];
                        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
                        $rowcount = mysqli_num_rows($q12);    
                        if($rowcount == 0) {
                            echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$right*$total.'</td><td><a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn">Start</a></td></tr>';
                        } else {
                            echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.' <span title="This quiz is already solved by you" class="glyphicon glyphicon-ok"></span></td><td>'.$total.'</td><td>'.$right*$total.'</td><td><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-danger">Reattempt</a></td></tr>';
                        }
                    }
                    echo '</table></div></div>';
                }?>

                <?php
                if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
                    $eid = @$_GET['eid'];
                    $sn = @$_GET['n'];
                    $total = @$_GET['t'];
                    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'");
                    echo '<div class="panel">';
                    while($row = mysqli_fetch_array($q)) {
                        $qns = $row['qns'];
                        $qid = $row['qid'];
                        echo '<b>Question '.$sn.':</b><br />'.$qns.'<br /><br />';
                    }
                    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'");
                    echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST" class="form-horizontal">';
                    while($row = mysqli_fetch_array($q)) {
                        $option = $row['option'];
                        $optionid = $row['optionid'];
                        echo '<div class="radio"><label><input type="radio" name="ans" value="'.$optionid.'"> '.$option.'</label></div>';
                    }
                    echo '<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span> Submit</button></form></div>';
                }

                if(@$_GET['q']== 'result' && @$_GET['eid']) {
                    $eid = @$_GET['eid'];
                    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error157');
                    echo '<div class="panel"><center><h1 class="title">Result</h1></center><br /><table class="table table-striped">';
                    while($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['right'];
                        $qa = $row['level'];
                        echo '<tr><td>Total Questions</td><td>'.$qa.'</td></tr>
                              <tr style="color:#99cc32"><td>Right Answer <span class="glyphicon glyphicon-ok-circle"></span></td><td>'.$r.'</td></tr>
                              <tr style="color:red"><td>Wrong Answer <span class="glyphicon glyphicon-remove-circle"></span></td><td>'.$w.'</td></tr>
                              <tr><td>Score <span class="glyphicon glyphicon-star"></span></td><td>'.$s.'</td></tr>';
                    }
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error158');
                    while($row = mysqli_fetch_array($q)) {
                        $score = $row['score'];
                        echo '<tr><td>Overall Score <span class="glyphicon glyphicon-stats"></span></td><td>'.$score.'</td></tr>';
                    }
                    echo '</table></div>';
                }

                if(@$_GET['q']== 2) {
                    $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC ") or die('Error197');
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped">
                    <tr style="color:black"><th>S.N.</th><th>Quiz</th><th>Questions</th><th>Right</th><th>Wrong</th><th>Score</th></tr>';
                    $c = 0;
                    while($row = mysqli_fetch_array($q)) {
                        $eid = $row['eid'];
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['right'];
                        $qa = $row['level'];
                        $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE  eid='$eid' ") or die('Error208');
                        while($row = mysqli_fetch_array($q23)) {
                            $title = $row['title'];
                        }
                        $c++;
                        echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div></div>';
                }

                if(@$_GET['q']== 3) {
                    $q = mysqli_query($con, "SELECT * FROM rank  ORDER BY score DESC ") or die('Error223');
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped">
                    <tr style="color:black"><th>Rank</th><th>Name</th><th>Gender</th><th>College</th><th>Score</th></tr>';
                    $c = 0;
                    while($row = mysqli_fetch_array($q)) {
                        $e = $row['email'];
                        $s = $row['score'];
                        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e' ") or die('Error231');
                        while($row = mysqli_fetch_array($q12)) {
                            $name = $row['name'];
                            $gender = $row['gender'];
                            $college = $row['college'];
                        }
                        $c++;
                        echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$college.'</td><td>'.$s.'</td></tr>';
                    }
                    echo '</table></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
