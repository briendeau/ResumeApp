<?php
require_once "pdo.php";
session_start();

if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Brian Riendeau Analysis View Page</title>
<!-- bootstrap.php - this is HTML -->

</head>
<body>  
<?php


$stmt = $pdo->prepare("SELECT profile_id, first_name, last_name, email, headline, summary FROM profile WHERE profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  $_SESSION['error'] = 'Bad value for profile_id';
  header( 'Location: index.php' ) ;
  return;
}
?>
<div class="container">
<h1>Profile information</h1>
<p>First Name:
<?= htmlentities($row['first_name']) ?></p>
<p>Last Name:
<?= htmlentities($row['last_name']) ?></p></p>
<p>Email:
<?= htmlentities($row['email']) ?></p></p>
<p>Headline:<br/>
<?= htmlentities($row['headline']) ?></p></p>
<p>Summary:<br/>
<?= htmlentities($row['summary']) ?></p><p>
</p>
<a href="index.php">Done</a>
</div>
</body>
</html>
