<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Online Quiz System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <style>
        body {
            padding-top: 70px; /* Adjust for fixed navbar */
        }
        .navbar-brand {
            font-size: 1.8em;
        }
        .carousel-inner img {
            width: 100%;
            height: 500px; /* Adjust height as needed */
        }
        .panel {
            margin-bottom: 20px;
        }
        .panel-heading {
            background-color: #337ab7;
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
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary:hover {
            background-color: #286090;
            border-color: #204d74;
        }
        .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
    </style>
</head>
<body>
    <?php
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

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Online Quiz System</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="welcome.php?q=1">Home</a></li>
                <li><a href="welcome.php?q=2">Quiz History</a></li>
                <li><a href="welcome.php?q=3">Ranking</a></li>
            </ul>
        </div>
    </nav>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <img src="images/slide1.jpg" alt="Slide 1">
                <div class="carousel-caption">
                    <h3>Welcome to Online Quiz System</h3>
                    <p>Test your knowledge with our quizzes!</p>
                </div>
            </div>
            <div class="item">
                <img src="images/slide2.jpg" alt="Slide 2">
                <div class="carousel-caption">
                    <h3>Explore Different Quizzes</h3>
                    <p>Choose from a variety of topics and challenge yourself.</p>
                </div>
            </div>
            <div class="item">
                <img src="images/slide3.jpg" alt="Slide 3">
                <div class="carousel-caption">
                    <h3>Track Your Progress</h3>
                    <p>View your quiz history and rankings.</p>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

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
                            echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.' <span title="This quiz is already solved by you" class="glyphicon glyphicon-ok"></span></td><td>'.$total.'</td><td>'.$right*$total.'</td><td><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-danger">Reattempt</a></td></tr>';
                        }
                    }
                    echo '</table></div></div></div>';
                } ?>

                <?php
                if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                    $eid = @$_GET['eid'];
                    $sn = @$_GET['n'];
                    $total = @$_GET['t'];
                    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'");
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Question '.$sn.'</h3></div><div class="panel-body">';
                    while ($row = mysqli_fetch_array($q)) {
                        $qns = $row['qns'];
                        $qid = $row['qid'];
                        echo '<b>Question:</b><br />'.$qns.'<br /><br />';
                    }
                    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'");
                    echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST" class="form-horizontal">';
                    while ($row = mysqli_fetch_array($q)) {
                        $option = $row['option'];
                        $optionid = $row['optionid'];
                        echo '<div class="radio"><label><input type="radio" name="ans" value="'.$optionid.'"> '.$option.'</label></div>';
                    }
                    echo '<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span> Submit</button></form></div></div>';
                }

                if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                    $eid = @$_GET['eid'];
                    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
                    echo '<div class="panel"><div class="panel-heading"><h3 class="panel-title">Result</h3></div><div class="panel-body"><table class="table table-striped">';
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
