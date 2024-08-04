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

        .navbar-brand,
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .carousel-item img {
            max-height: 300px;
            object-fit: cover;
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
    session_start();
    include_once 'database.php';

    if (!isset($_SESSION['email'])) {
        header("location:login.php");
        exit();
    }

    $name = htmlspecialchars($_SESSION['name']);
    $email = htmlspecialchars($_SESSION['email']);
    ?>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Online Quiz System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= (isset($_GET['q']) && $_GET['q'] == 1) ? 'active' : '' ?>">
                        <a class="nav-link" href="welcome.php?q=1"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item <?= (isset($_GET['q']) && $_GET['q'] == 2) ? 'active' : '' ?>">
                        <a class="nav-link" href="welcome.php?q=2"><i class="fas fa-history"></i> History</a>
                    </li>
                    <li class="nav-item <?= (isset($_GET['q']) && $_GET['q'] == 3) ? 'active' : '' ?>">
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
        <?php
        $q = isset($_GET['q']) ? intval($_GET['q']) : 1;

        switch ($q) {
            case 1:
                echo '<div class="card">';
                echo '<div class="card-header"><h3>Welcome to the Online Quiz System</h3></div>';
                echo '<div class="card-body">';

                echo '<div class="jumbotron jumbotron-fluid bg-light">';
                echo '<div class="container">';
                echo '<h1 class="display-4">Welcome, ' . $name . '!</h1>';
                echo '<p class="lead">Explore and test your knowledge with our variety of quizzes. Challenge yourself and see how you rank against others!</p>';
                echo '<hr class="my-4">';
                echo '<p>Browse available quizzes below and get started on your learning journey.</p>';
                echo '</div>';
                echo '</div>';

                echo '<div id="featuredQuizzes" class="carousel slide" data-ride="carousel">';
                echo '<ol class="carousel-indicators">';
                echo '<li data-target="#featuredQuizzes" data-slide-to="0" class="active"></li>';
                echo '<li data-target="#featuredQuizzes" data-slide-to="1"></li>';
                echo '<li data-target="#featuredQuizzes" data-slide-to="2"></li>';
                echo '<li data-target="#featuredQuizzes" data-slide-to="3"></li>';
                echo '</ol>';
                echo '<div class="carousel-inner">';

                $quizzes = [
                    ['img' => 'image/geo.jpg', 'title' => 'Geography Quiz', 'desc' => 'Test your knowledge of world geography.'],
                    ['img' => 'image/maths.jpg', 'title' => 'Maths Quiz', 'desc' => 'Challenge your math skills and solve problems.'],
                    ['img' => 'image/php.jpg', 'title' => 'PHP & SQL Quiz', 'desc' => 'Evaluate your knowledge of PHP and SQL.'],
                    ['img' => 'image/apt.jpg', 'title' => 'Aptitude Quiz', 'desc' => 'Sharpen your aptitude and problem-solving skills.']
                ];

                foreach ($quizzes as $index => $quiz) {
                    $active = $index === 0 ? 'active' : '';
                    echo '<div class="carousel-item ' . $active . '">';
                    echo '<img class="d-block w-100" src="' . htmlspecialchars($quiz['img']) . '" alt="' . htmlspecialchars($quiz['title']) . '">';
                    echo '<div class="carousel-caption d-none d-md-block">';
                    echo '<h5>' . htmlspecialchars($quiz['title']) . '</h5>';
                    echo '<p>' . htmlspecialchars($quiz['desc']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
                echo '<a class="carousel-control-prev" href="#featuredQuizzes" role="button" data-slide="prev">';
                echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                echo '<span class="sr-only">Previous</span>';
                echo '</a>';
                echo '<a class="carousel-control-next" href="#featuredQuizzes" role="button" data-slide="next">';
                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                echo '<span class="sr-only">Next</span>';
                echo '</a>';
                echo '</div>';

                $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC");
                if (!$result) {
                    die('Error: ' . mysqli_error($con));
                }

                echo '<div class="card mt-4">';
                echo '<div class="card-header"><h3>Available Quizzes</h3></div>';
                echo '<div class="card-body">';
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead><tr><th>#</th><th>Topic</th><th>Total Questions</th><th>Marks</th><th>Action</th></tr></thead>';
                echo '<tbody>';

                $c = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = isset($row['title']) ? htmlspecialchars($row['title']) : 'No Title';
                    $total = isset($row['total']) ? intval($row['total']) : 0;
                    $right = isset($row['right']) ? intval($row['right']) : 0;
                    $eid = isset($row['eid']) ? intval($row['eid']) : 0;

                    $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'");
                    if (!$q12) {
                        die('Error: ' . mysqli_error($con));
                    }
                    $rowcount = mysqli_num_rows($q12);
$action = $rowcount == 0
    ? '<a href="attempt.php?q=5&eid=' . $eid . '" class="btn btn-success">Attempt Quiz</a>'
    : '<a href="attempt.php?q=5&eid=' . $eid . '" class="btn btn-danger">Reattempt</a>';


                    echo '<tr>';
                    echo '<td>' . $c++ . '</td>';
                    echo '<td>' . $title . '</td>';
                    echo '<td>' . $total . '</td>';
                    echo '<td>' . $right . '</td>';
                    echo '<td>' . $action . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                break;

case 2:
                echo '<div class="card">';
                echo '<div class="card-header"><h3>Quiz History</h3></div>';
                echo '<div class="card-body">';

                // Query to fetch history, ordered by score in descending order
                $history = mysqli_query($con, "SELECT h.*, q.title FROM history h
                                                JOIN quiz q ON h.eid = q.eid
                                                WHERE h.email='$email'
                                                ORDER BY h.score DESC");
                if (!$history) {
                    die('Error: ' . mysqli_error($con));
                }

                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead><tr><th>#</th><th>Quiz</th><th>Questions Solved</th><th>Right</th><th>Wrong</th><th>Score</th></tr></thead>';
                echo '<tbody>';

                $c = 1;
                while ($row = mysqli_fetch_array($history)) {
                    $s = isset($row['score']) ? intval($row['score']) : 0;
                    $w = isset($row['wrong']) ? intval($row['wrong']) : 0;
                    $r = isset($row['right']) ? intval($row['right']) : 0;
                    $qa = isset($row['level']) ? intval($row['level']) : 0;
                    $title = isset($row['title']) ? htmlspecialchars($row['title']) : 'Unknown Title';

                    echo '<tr>';
                    echo '<td>' . $c++ . '</td>';
                    echo '<td>' . $title . '</td>';
                    echo '<td>' . $qa . '</td>';
                    echo '<td>' . $r . '</td>';
                    echo '<td>' . $w . '</td>';
                    echo '<td>' . $s . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                break;



           case 3:
    // Query to get rankings from the rank table, ordered by score in descending order
    $rankingQuery = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error: ' . mysqli_error($con));
    
    echo '<div class="card">';
    echo '<div class="card-header"><h3>Ranking</h3></div>';
    echo '<div class="card-body">';
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead><tr><th>Rank</th><th>Name</th><th>Score</th></tr></thead>';
    echo '<tbody>';

    $rank = 1; // Initialize rank counter
    while ($ranking = mysqli_fetch_array($rankingQuery)) {
        $email = $ranking['email'];
        $score = $ranking['score'];

        // Query to get the user's name based on the email
        $userQuery = mysqli_query($con, "SELECT name FROM user WHERE email='$email'") or die('Error: ' . mysqli_error($con));
        
        $user = mysqli_fetch_array($userQuery);
        $name = $user['name'] ?? 'Unknown'; // Default to 'Unknown' if name is not found

        // Output the ranking row
        echo '<tr>';
        echo '<td>' . $rank++ . '</td>';
        echo '<td>' . htmlspecialchars($name) . '</td>';
        echo '<td>' . htmlspecialchars($score) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    break;

            default:
                echo '<div class="alert alert-warning" role="alert">Invalid page requested!</div>';
                break;
        }
        ?>
    </div>
</body>

</html>
