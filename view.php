<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Matrix Analysis View Page</title>
<!-- bootstrap.php - this is HTML -->

</head>
<body>
<?php

$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline, summary FROM profile");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<div class="container">
<h1>Profile information</h1>
<p>First Name:
<?= $row['first_name'] ?></p>
<p>Last Name:
<?= $row['last_name'] ?></p></p>
<p>Email:
<?= $row['email'] ?></p></p>
<p>Headline:<br/>
<?= $row['headline'] ?></p></p>
<p>Summary:<br/>
<?= $row['summary'] ?></p><p>
</p>
<a href="index.php">Done</a>
</div>
</body>
</html>
