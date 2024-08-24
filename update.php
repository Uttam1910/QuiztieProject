<?php
include_once 'database.php';
session_start();

$email = $_SESSION['email'];

if (isset($_SESSION['key'])) {
    if (isset($_GET['demail'])) {
        $demail = mysqli_real_escape_string($con, $_GET['demail']);
        mysqli_query($con, "DELETE FROM rank WHERE email='$demail'") or die('Error deleting from rank table');
        mysqli_query($con, "DELETE FROM history WHERE email='$demail'") or die('Error deleting from history table');
        mysqli_query($con, "DELETE FROM user WHERE email='$demail'") or die('Error deleting from user table');
        header("location:dashboard.php?q=1");
        exit();
    }
}

if (isset($_SESSION['key'])) {
    if (isset($_GET['q']) && $_GET['q'] == 'rmquiz') {
        $eid = mysqli_real_escape_string($con, $_GET['eid']);
        $result = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid'") or die('Error retrieving questions');
        while ($row = mysqli_fetch_array($result)) {
            $qid = $row['qid'];
            mysqli_query($con, "DELETE FROM options WHERE qid='$qid'") or die('Error deleting from options table');
            mysqli_query($con, "DELETE FROM answer WHERE qid='$qid'") or die('Error deleting from answer table');
        }
        mysqli_query($con, "DELETE FROM questions WHERE eid='$eid'") or die('Error deleting from questions table');
        mysqli_query($con, "DELETE FROM quiz WHERE eid='$eid'") or die('Error deleting from quiz table');
        mysqli_query($con, "DELETE FROM history WHERE eid='$eid'") or die('Error deleting from history table');
        header("location:dashboard.php?q=5");
        exit();
    }
}

if (isset($_SESSION['key'])) {
    if (isset($_GET['q']) && $_GET['q'] == 'addquiz') {
        $name = ucwords(strtolower(mysqli_real_escape_string($con, $_POST['name'])));
        $total = mysqli_real_escape_string($con, $_POST['total']);
        $right = mysqli_real_escape_string($con, $_POST['right']);
        $wrong = mysqli_real_escape_string($con, $_POST['wrong']);
        $id = uniqid();
        mysqli_query($con, "INSERT INTO quiz VALUES ('$id', '$name', '$right', '$wrong', '$total', NOW())") or die('Error inserting into quiz table');
        header("location:dashboard.php?q=4&step=2&eid=$id&n=$total");
        exit();
    }
}

if (isset($_SESSION['key'])) {
    if (isset($_GET['q']) && $_GET['q'] == 'addqns') {
        $n = mysqli_real_escape_string($con, $_GET['n']);
        $eid = mysqli_real_escape_string($con, $_GET['eid']);
        $ch = mysqli_real_escape_string($con, $_GET['ch']);
        for ($i = 1; $i <= $n; $i++) {
            $qid = uniqid();
            $qns = mysqli_real_escape_string($con, $_POST['qns' . $i]);
            mysqli_query($con, "INSERT INTO questions VALUES ('$eid', '$qid', '$qns', '$ch', '$i')") or die('Error inserting into questions table');
            
            // Prepare option IDs and values
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a = mysqli_real_escape_string($con, $_POST[$i . '1']);
            $b = mysqli_real_escape_string($con, $_POST[$i . '2']);
            $c = mysqli_real_escape_string($con, $_POST[$i . '3']);
            $d = mysqli_real_escape_string($con, $_POST[$i . '4']);
            
            // Insert options
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$a', '$oaid')") or die('Error inserting into options table');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$b', '$obid')") or die('Error inserting into options table');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$c', '$ocid')") or die('Error inserting into options table');
            mysqli_query($con, "INSERT INTO options VALUES ('$qid', '$d', '$odid')") or die('Error inserting into options table');
            
            // Determine the correct answer
            $e = mysqli_real_escape_string($con, $_POST['ans' . $i]);
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
                    $ansid = $oaid; // Default to first option
            }
            mysqli_query($con, "INSERT INTO answer VALUES ('$qid', '$ansid')") or die('Error inserting into answer table');
        }
        header("location:dashboard.php?q=0");
        exit();
    }
}

if (isset($_GET['q']) && $_GET['q'] == 'quiz' && isset($_GET['step']) && $_GET['step'] == 2) {
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    $optionid = mysqli_real_escape_string($con, $_GET['n']);
    $total = mysqli_real_escape_string($con, $_GET['t']);
    $ans = mysqli_real_escape_string($con, $_POST['ans']);
    $qid = mysqli_real_escape_string($con, $_GET['qid']);
    
    $q = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid'") or die('Error retrieving answer');
    $row = mysqli_fetch_array($q);
    $ansid = $row['ansid'];
    
    if ($ans == $ansid) {
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'") or die('Error retrieving quiz');
        $row = mysqli_fetch_array($q);
        $right = $row['right'];

        if ($optionid == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW())") or die('Error inserting into history table');
        }

        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error retrieving history');
        $row = mysqli_fetch_array($q);
        $s = $row['score'];
        $r = $row['right'];
        $r++;
        $s += $right;
        mysqli_query($con, "UPDATE history SET score=$s, level=$optionid, right=$r, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error updating history table');
    } else {
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'") or die('Error retrieving quiz');
        $row = mysqli_fetch_array($q);
        $wrong = $row['wrong'];

        if ($optionid == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW())") or die('Error inserting into history table');
        }

        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error retrieving history');
        $row = mysqli_fetch_array($q);
        $s = $row['score'];
        $w = $row['wrong'];
        $w++;
        $s -= $wrong;
        mysqli_query($con, "UPDATE history SET score=$s, level=$optionid, wrong=$w, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error updating history table');
    }

    if ($optionid != $total) {
        $optionid++;
        header("location:welcome.php?q=quiz&step=2&eid=$eid&n=$optionid&t=$total");
    } else if ($_SESSION['key'] != 'suryapinky') {
        $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error retrieving score');
        $row = mysqli_fetch_array($q);
        $s = $row['score'];

        $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error retrieving rank');
        if (mysqli_num_rows($q) == 0) {
            mysqli_query($con, "INSERT INTO rank VALUES('$email','$s',NOW())") or die('Error inserting into rank table');
        } else {
            $row = mysqli_fetch_array($q);
            $sun = $row['score'];
            $sun += $s;
            mysqli_query($con, "UPDATE rank SET score=$sun, time=NOW() WHERE email='$email'") or die('Error updating rank table');
        }
        header("location:welcome.php?q=result&eid=$eid");
    } else {
        header("location:welcome.php?q=result&eid=$eid");
    }
}
?>
