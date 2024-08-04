<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Online Quiz System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/welcome.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            color: #ffffff !important;
        }
        .navbar-nav .nav-link {
            color: #ffffff !important;
        }
        .navbar-nav .nav-link.active {
            background-color: #495057;
            border-radius: 5px;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: none;
        }
        .card-body {
            background-color: #ffffff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .table thead th {
            border-bottom: none;
        }
        .table tbody td {
            border-top: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    include_once 'database.php';
    session_start();
    if (!(isset($_SESSION['email']))) {
        header("location:login.php");
    } else {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
    ?>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Online Quiz System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if(@$_GET['q']==1) echo 'active'; ?>">
                        <a class="nav-link" href="welcome.php?q=1"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item <?php if(@$_GET['q']==2) echo 'active'; ?>">
                        <a class="nav-link" href="welcome.php?q=2"><i class="fas fa-history"></i> History</a>
                    </li>
                    <li class="nav-item <?php if(@$_GET['q']==3) echo 'active'; ?>">
                        <a class="nav-link" href="welcome.php?q=3"><i class="fas fa-chart-bar"></i> Ranking</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php?q=welcome.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
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
                    echo '<div class="card">';
                    echo '<div class="card-header"><h3>Available Quizzes</h3></div>';
                    echo '<div class="card-body">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table">';
                    echo '<thead><tr><th>#</th><th>Topic</th><th>Total Questions</th><th>Marks</th><th>Action</th></tr></thead>';
                    echo '<tbody>';
                    $c = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $title = $row['title'];
                        $total = $row['total'];
                        $right = $row['right'];
                        $eid = $row['eid'];
                        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
                        $rowcount = mysqli_num_rows($q12);
                        if ($rowcount == 0) {
                            echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . ($right * $total) . '</td><td><a href="welcome.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="btn btn-primary">Start</a></td></tr>';
                        } else {
                            echo '<tr><td>' . $c++ . '</td><td>' . $title . ' <i class="fas fa-check-circle" title="This quiz is already solved by you"></i></td><td>' . $total . '</td><td>' . ($right * $total) . '</td><td><a href="update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '" class="btn btn-danger">Restart</a></td></tr>';
                        }
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                    $eid = @$_GET['eid'];
                    $sn = @$_GET['n'];
                    $total = @$_GET['t'];
                    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'");
                    echo '<div class="card">';
                    echo '<div class="card-header"><h3>Quiz</h3></div>';
                    echo '<div class="card-body">';
                    while ($row = mysqli_fetch_array($q)) {
                        $qns = $row['qns'];
                        $qid = $row['qid'];
                        echo '<b>Question ' . $sn . ': ' . $qns . '</b><br /><br />';
                    }
                    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'");
                    echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST">';
                    echo '<div class="form-group">';
                    while ($row = mysqli_fetch_array($q)) {
                        $option = $row['option'];
                        $optionid = $row['optionid'];
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="ans" value="' . $optionid . '" id="option' . $optionid . '">';
                        echo '<label class="form-check-label" for="option' . $optionid . '">' . $option . '</label>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<button type="submit" class="btn btn-primary">Submit</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }

                if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                    $eid = @$_GET['eid'];
                    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error157');
                    echo '<div class="card">';
                    echo '<div class="card-header"><h3>Result</h3></div>';
                    echo '<div class="card-body">';
                    echo '<table class="table">';
                    while ($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['sahi'];
                        $qa = $row['level'];
                        echo '<tr><td>Total Questions</td><td>' . $qa . '</td></tr>';
                        echo '<tr><td>Right Answer</td><td>' . $r . '</td></tr>';
                        echo '<tr><td>Wrong Answer</td><td>' . $w . '</td></tr>';
                        echo '<tr><td>Score</td><td>' . $s . '</td></tr>';
                    }
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error157');
                    while ($row = mysqli_fetch_array($q)) {
                        $s = $row['score'];
                        echo '<tr><td>Overall Score</td><td>' . $s . '</td></tr>';
                    }
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                }

                if (@$_GET['q'] == 2) {
                    $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC") or die('Error197');
                    echo '<div class="card">';
                    echo '<div class="card-header"><h3>Quiz History</h3></div>';
                    echo '<div class="card-body">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table">';
                    echo '<thead><tr><th>#</th><th>Quiz</th><th>Question Solved</th><th>Right</th><th>Wrong</th><th>Score</th></tr></thead>';
                    echo '<tbody>';
                    $c = 0;
                    while ($row = mysqli_fetch_array($q)) {
                        $eid = $row['eid'];
                        $s = $row['score'];
                        $w = $row['wrong'];
                        $r = $row['sahi'];
                        $qa = $row['level'];
                        $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'") or die('Error208');
                        while ($row = mysqli_fetch_array($q23)) {
                            $title = $row['title'];
                        }
                        $c++;
                        echo '<tr><td>' . $c . '</td><td>' . $title . '</td><td>' . $qa . '</td><td>' . $r . '</td><td>' . $w . '</td><td>' . $s . '</td></tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                if (@$_GET['q'] == 3) {
                    $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                    echo '<div class="card">';
                    echo '<div class="card-header"><h3>Ranking</h3></div>';
                    echo '<div class="card-body">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table">';
                    echo '<thead><tr><th>Rank</th><th>Name</th><th>Score</th></tr></thead>';
                    echo '<tbody>';
                    $c = 0;
                    while ($row = mysqli_fetch_array($q)) {
                        $e = $row['email'];
                        $s = $row['score'];
                        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                        while ($row = mysqli_fetch_array($q12)) {
                            $name = $row['name'];
                        }
                        $c++;
                        echo '<tr><td>' . $c . '</td><td>' . $name . '</td><td>' . $s . '</td></tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
