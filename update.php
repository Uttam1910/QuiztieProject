<?php
include_once 'database.php';
session_start();

$email = $_SESSION['email'];

if (isset($_SESSION['key'])) {
    if (@$_GET['demail']) {
        $demail = @$_GET['demail'];
        mysqli_query($con, "DELETE FROM rank WHERE email='$demail'") or die('Error');
        mysqli_query($con, "DELETE FROM history WHERE email='$demail'") or die('Error');
        mysqli_query($con, "DELETE FROM user WHERE email='$demail'") or die('Error');
        header("location:dashboard.php?q=1");
    }
}

if (isset($_SESSION['key'])) {
    if (@$_GET['q'] == 'rmquiz') {
        $eid = @$_GET['eid'];
        $result = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid'") or die('Error');
        while ($row = mysqli_fetch_array($result)) {
            $qid = $row['qid'];
            mysqli_query($con, "DELETE FROM options WHERE qid='$qid'") or die('Error');
            mysqli_query($con, "DELETE FROM answer WHERE qid='$qid'") or die('Error');
        }
        mysqli_query($con, "DELETE FROM questions WHERE eid='$eid'") or die('Error');
        mysqli_query($con, "DELETE FROM quiz WHERE eid='$eid'") or die('Error');
        mysqli_query($con, "DELETE FROM history WHERE eid='$eid'") or die('Error');
        header("location:dashboard.php?q=5");
    }
}

if (isset($_SESSION['key'])) {
    if (@$_GET['q'] == 'addquiz') {
        $name = ucwords(strtolower($_POST['name']));
        $total = $_POST['total'];
        $right = $_POST['right'];
        $wrong = $_POST['wrong'];
        $id = uniqid();
        mysqli_query($con, "INSERT INTO quiz VALUES ('$id', '$name', '$right', '$wrong', '$total', NOW())");
        header("location:dashboard.php?q=4&step=2&eid=$id&n=$total");
    }
}

if (isset($_SESSION['key'])) {
    if (@$_GET['q'] == 'addqns') {
        $n = @$_GET['n'];
        $eid = @$_GET['eid'];
        $ch = @$_GET['ch'];
        for ($i = 1; $i <= $n; $i++) {
            $qid = uniqid();
            $qns = $_POST['qns' . $i];
            mysqli_query($con, "INSERT INTO questions VALUES ('$eid', '$qid', '$qns', '$ch', '$i')");
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a = $_POST[$i . '1'];
            $b = $_POST[$i . '2'];
            $c = $_POST[$i . '3'];
            $d = $_POST[$i . '4'];
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$a', '$oaid')") or die('Error61');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$b', '$obid')") or die('Error62');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$c', '$ocid')") or die('Error63');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$d', '$odid')") or die('Error64');
            $e = $_POST['ans' . $i];
            switch ($e) {
                case 'a':
                    $ansid = $oaid;
                    break;
                case 'b':
                    $ansid = $obid;
                    break;
                case 'c':
                    $ansid = $ocid;
                    break;
                case 'd':
                    $ansid = $odid;
                    break;
                default:
                    $ansid = $oaid;
            }
            mysqli_query($con, "INSERT INTO answer VALUES ('$qid', '$ansid')");
        }
        header("location:dashboard.php?q=0");
    }
}

if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
    $eid = @$_GET['eid'];
    $optionid = @$_GET['n'];
    $total = @$_GET['t'];
    $ans = $_POST['ans'];
    $qid = @$_GET['qid'];
    $q = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid'");
    while ($row = mysqli_fetch_array($q)) {
        $ansid = $row['ansid'];
    }
    if ($ans == $ansid) {
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'");
        while ($row = mysqli_fetch_array($q)) {
            $right = $row['right'];
        }
        if ($optionid == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW())") or die('Error');
        }
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error115');
        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
            $r = $row['right'];
        }
        $r++;
        $s = $s + $right;
        mysqli_query($con, "UPDATE `history` SET `score`=$s, `level`=$optionid, `right`=$r, date= NOW() WHERE  email = '$email' AND eid = '$eid'") or die('Error124');
    } else {
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'") or die('Error129');
        while ($row = mysqli_fetch_array($q)) {
            $wrong = $row['wrong'];
        }
        if ($optionid == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW() )") or die('Error137');
        }
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error139');
        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
            $w = $row['wrong'];
        }
        $w++;
        $s = $s - $wrong;
        mysqli_query($con, "UPDATE `history` SET `score`=$s, `level`=$optionid, `wrong`=$w, date=NOW() WHERE  email = '$email' AND eid = '$eid'") or die('Error147');
    }
    if ($optionid != $total) {
        $optionid++;
        header("location:welcome.php?q=quiz&step=2&eid=$eid&n=$optionid&t=$total") or die('Error152');
    } else if ($_SESSION['key'] != 'suryapinky') {
        $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error156');
        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
        }
        $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
        $rowcount = mysqli_num_rows($q);
        if ($rowcount == 0) {
            mysqli_query($con, "INSERT INTO rank VALUES('$email','$s',NOW())") or die('Error165');
        } else {
            while ($row = mysqli_fetch_array($q)) {
                $sun = $row['score'];
            }
            $sun = $s + $sun;
            mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
        }
        header("location:welcome.php?q=result&eid=$eid");
    } else {
        header("location:welcome.php?q=result&eid=$eid");
    }
}

if (@$_GET['q'] == 'quizre' && @$_GET['step'] == 25) {
    $eid = @$_GET['eid'];
    $n = @$_GET['n'];
    $t = @$_GET['t'];
    $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error156');
    while ($row = mysqli_fetch_array($q)) {
        $s = $row['score'];
    }
    mysqli_query($con, "DELETE FROM `history` WHERE eid='$eid' AND email='$email'") or die('Error184');
    $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
    while ($row = mysqli_fetch_array($q)) {
        $sun = $row['score'];
    }
    $sun = $sun - $s;
    mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
    header("location:welcome.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .container {
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center">Quiz Dashboard</h2>
    <div class="row">
      <div class="col-md-12">
        <form action="update_script.php?q=addquiz" method="POST">
          <div class="form-group">
            <label for="name">Quiz Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="total">Total Questions:</label>
            <input type="number" class="form-control" id="total" name="total" required>
          </div>
          <div class="form-group">
            <label for="right">Marks for Correct Answer:</label>
            <input type="number" class="form-control" id="right" name="right" required>
          </div>
          <div class="form-group">
            <label for="wrong">Marks for Wrong Answer:</label>
            <input type="number" class="form-control" id="wrong" name="wrong" required>
          </div>
          <button type="submit" class="btn btn-primary">Create Quiz</button>
        </form>
      </div>
    </div>

    <!-- Add Questions Section -->
    <div class="row mt-5">
      <div class="col-md-12">
        <form action="update_script.php?q=addqns&n=<?php echo $n; ?>&eid=<?php echo $eid; ?>&ch=<?php echo $ch; ?>" method="POST">
          <?php
          for ($i = 1; $i <= $n; $i++) {
            echo '
              <div class="form-group">
                <label for="qns' . $i . '">Question ' . $i . ':</label>
                <input type="text" class="form-control" id="qns' . $i . '" name="qns' . $i . '" required>
              </div>
              <div class="form-group">
                <label for="' . $i . '1">Option A:</label>
                <input type="text" class="form-control" id="' . $i . '1" name="' . $i . '1" required>
              </div>
              <div class="form-group">
                <label for="' . $i . '2">Option B:</label>
                <input type="text" class="form-control" id="' . $i . '2" name="' . $i . '2" required>
              </div>
              <div class="form-group">
                <label for="' . $i . '3">Option C:</label>
                <input type="text" class="form-control" id="' . $i . '3" name="' . $i . '3" required>
              </div>
              <div class="form-group">
                <label for="' . $i . '4">Option D:</label>
                <input type="text" class="form-control" id="' . $i . '4" name="' . $i . '4" required>
              </div>
              <div class="form-group">
                <label for="ans' . $i . '">Correct Answer:</label>
                <select class="form-control" id="ans' . $i . '" name="ans' . $i . '" required>
                  <option value="a">Option A</option>
                  <option value="b">Option B</option>
                  <option value="c">Option C</option>
                  <option value="d">Option D</option>
                </select>
              </div>
              <hr>
            ';
          }
          ?>
          <button type="submit" class="btn btn-success">Add Questions</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
