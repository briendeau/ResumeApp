<?php
require_once "pdo.php";

session_start();

if  (!isset($_SESSION['name']) && !isset($_SESSION['user_id']) ) {
  die("ACCESS DENIED");
}

  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}



if (isset($_POST['add'])) {
  if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 ||
      strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1
  || strlen($_POST['summary']) < 1) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ./add.php");
    return;
  } elseif (strpos($_POST['email'], '@') === false ) {
    $_SESSION['error'] = "Email must have an at-sign (@)";
    header("Location: ./add.php");
    return;
  } else  {
 

    $stmt = $pdo->prepare('INSERT INTO Profile
    (user_id, first_name, last_name, email, headline, summary)
    VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
    ':uid' => $_SESSION['user_id'],
    ':fn' => $_POST['first_name'],
    ':ln' => $_POST['last_name'],
    ':em' => $_POST['email'],
    ':he' => $_POST['headline'],
    ':su' => $_POST['summary'])
    );

  $_SESSION['success'] = 'Record added';
  header('Location: index.php');
  return;
  }

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
<p>Add A New Resume</p>
<form method="post">
<p>First Name:
<input type="text" name="first_name"></p>
<p>Last Name:
<input type="text" name="last_name"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Headline:
<input type="text" name="headline"></p>
<p>Summary:
<input type="text" name="summary"></p>
<p><input type="submit" name="add" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>

</body>
</html>