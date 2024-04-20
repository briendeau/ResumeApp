<?php
require_once "pdo.php";
session_start();


if  (!isset($_SESSION['name']) ) {
  die("ACCESS DENIED");
}

if (!isset($_SESSION['user_id'])) {
  die("Invalid User_ID");
}

if (!isset($_GET['profile_id']) || $_SESSION['user_id'] !== $_GET['profile_id']) {
  die("Permission not granted for this user.");
}
if ($_SESSION['user_id'] !== $_GET['profile_id']) {
  die("Permission not granted for this user.");
}

// skip this code when first coming to the page on a GET request.
if ( isset($_POST['first_name']) && isset($_POST['last_name'])
  && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['profile_id']) ) {

  // Data validation
  if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || 
       strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
    $_SESSION['error'] = 'All fields are required';
    header("Location: edit.php?profile_id=".$_POST['profile_id']);
    return;
  } elseif ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Invalid email missing @';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    } else {
 
                    // make sure your commas are not missing or at the end of vars or this will BLOW UP
    $sql = "UPDATE profile SET  first_name = :fn, last_name = :ln, email = :em, headline = :hdl, summary = :sum WHERE profile_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hdl' => $_POST['headline'],
        ':sum' => $_POST['summary'],
        ':pid' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
  }
}




// start GET request check here.
// Guardian: Make sure that autos_id is present from the index page.
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}


$stmt = $pdo->prepare("SELECT profile_id, first_name, last_name, email, headline, summary FROM profile WHERE profile_id = :xyz");

$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}


$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$hl = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matrix Analysis</title>
</head>
<body>
    <p>Edit Resume Profile</p>
    <form method="post">
    <p>First Name:
    <input type="text" name="first_name" value="<?= $fn  ?>"></p>
    <p>Last Name:
    <input type="text" name="last_name" value="<?= $ln ?>"></p>
    <p>Email:
    <input type="text" name="email" value="<?= $e ?>"></p>
    <p>Headline:
    <input type="text" name="headline" value="<?= $hl ?>"></p>
    <p>Summary:
    <input type="text" name="summary" value="<?= $su ?>"></p>
    <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
    <p><input type="submit" value="Save"/>
    <a href="index.php">Cancel</a></p>
    </form>

</body>
</html>

