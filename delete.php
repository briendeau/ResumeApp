<?php
require_once "pdo.php";
session_start();


if  (!isset($_SESSION['name']) ) {
  die("ACCESS DENIED");
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}


if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}



$stmt = $pdo->prepare("SELECT profile_id, first_name, last_name FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matrix Analysis</title>
</head>
<body>
  <p>Confirm: Deleting From Database -> <?= htmlentities($row['first_name'])." ".htmlentities($row['last_name']) ?></p>

  <form method="post">
  <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
  <input type="submit" value="Delete" name="delete">
  <a href="index.php">Cancel</a>
  </form>

</body>
</html>
