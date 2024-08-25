<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
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
    <title>Dashboard | Quiztie</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/welcome.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #343a40;
            border-radius: 0;
            margin-bottom: 20px;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }
        .navbar-nav > li > a {
            color: #fff !important;
        }
        .navbar-nav > li.active > a {
            background-color: #007bff !important;
            color: #fff !important;
        }
        .navbar-nav > li > a:hover {
            background-color: #007bff !important;
            color: #fff !important;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title1 {
            color: #343a40;
        }
        .table {
            background-color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default title1">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php?q=0"><b>Quiztie</b></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dashboard.php?q=0">Home<span class="sr-only">(current)</span></a></li>
                    <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dashboard.php?q=1">User</a></li>
                    <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dashboard.php?q=2">Ranking</a></li>
                    <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
                    <li><a href="dashboard.php?q=4">Add Quiz</a></li>
                    <li><a href="dashboard.php?q=5">Remove Quiz</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout1.php?q=dashboard.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(@$_GET['q']==0): ?>
                    <div class="jumbotron text-center">
                        <h1>Welcome to the Admin Page!</h1>
                        <p>Manage your quizzes and users efficiently. Explore the features using the navigation bar above.</p>
                        <p><a href="dashboard.php?q=4" class="btn btn-primary btn-lg">Add a New Quiz</a></p>
                    </div>
                <?php endif; ?>

                <?php if(@$_GET['q']==2): ?>
                    <div class="panel title">
                        <div class="table-responsive">
                            <table class="table table-striped title1">
                                <tr style="color:red">
                                    <td><center><b>Rank</b></center></td>
                                    <td><center><b>Email</b></center></td>
                                    <td><center><b>Score</b></center></td>
                                </tr>
                                <?php
                                    $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                                    $c = 0;
                                    while($row = mysqli_fetch_array($q)):
                                        $e = $row['email'];
                                        $s = $row['score'];
                                        $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                                        while($row = mysqli_fetch_array($q12)):
                                            $name = $row['name'];
                                            $college = $row['college'];
                                        endwhile;
                                        $c++;
                                ?>
                                    <tr>
                                        <td style="color:#99cc32"><center><b><?php echo $c; ?></b></center></td>
                                        <td><center><?php echo $e; ?></center></td>
                                        <td><center><?php echo $s; ?></center></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(@$_GET['q']==1): ?>
                    <div class="panel">
                        <div class="table-responsive">
                            <table class="table table-striped title1">
                                <tr>
                                    <td><center><b>S.N.</b></center></td>
                                    <td><center><b>Name</b></center></td>
                                    <td><center><b>College</b></center></td>
                                    <td><center><b>Email</b></center></td>
                                    <td><center><b>Action</b></center></td>
                                </tr>
                                <?php
                                    $result = mysqli_query($con, "SELECT * FROM user") or die('Error');
                                    $c = 1;
                                    while($row = mysqli_fetch_array($result)):
                                        $name = $row['name'];
                                        $email = $row['email'];
                                        $college = $row['college'];
                                ?>
                                    <tr>
                                        <td><center><?php echo $c++; ?></center></td>
                                        <td><center><?php echo $name; ?></center></td>
                                        <td><center><?php echo $college; ?></center></td>
                                        <td><center><?php echo $email; ?></center></td>
                                        <td><center><a title="Delete User" href="update.php?demail=<?php echo $email; ?>"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></center></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(@$_GET['q']==4 && !(@$_GET['step'])): ?>
                    <div class="row">
                        <span class="title1" style="margin-left:40%;font-size:30px;color:#343a40;"><b>Enter Quiz Details</b></span><br /><br />
                        <div class="col-md-3"></div>
                        <div class="col-md-6">   
                            <form class="form-horizontal title1" name="form" action="update.php?q=addquiz" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="name"></label>  
                                        <div class="col-md-12">
                                            <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="total"></label>  
                                        <div class="col-md-12">
                                            <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="right"></label>  
                                        <div class="col-md-12">
                                            <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" type="number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="wrong"></label>  
                                        <div class="col-md-12">
                                            <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" type="number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="time"></label>  
                                        <div class="col-md-12">
                                            <input id="time" name="time" placeholder="Enter time limit for test in minutes" class="form-control input-md" type="number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="tag"></label>  
                                        <div class="col-md-12">
                                            <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for="desc"></label>  
                                        <div class="col-md-12">
                                            <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label" for=""></label>
                                        <div class="col-md-12"> 
                                            <input type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
