<?php
require_once "pdo.php";
session_start();


if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}

if ( isset($_SESSION['success']) ) {
  echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
  unset($_SESSION['success']);
}

if ( isset($_SESSION['user_id'])) {
  // echo ($_SESSION['user_id']);
  echo "<a href='add.php'>Add New Resume</a> <br /> <br />";
  echo "<a href='logout.php'>Logout</a>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brian Riendeau</title>
</head>
<body>
<?php

if (!isset($_SESSION['user_id'])) {
  echo('<a href="login.php">Login</a>');
}

echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT profile_id, first_name, last_name, email, headline, summary FROM profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  if ($row === false) {
    echo "No rows";
    break;
  } else {
        // echo "looping";bad value
        echo "<tr><td>";
        $profile_link = "view.php?profile_id=" . $row['profile_id'];

        echo "<a href='$profile_link'>" . htmlspecialchars($row['first_name']) . "</a> ";
        // echo("<a href='view.php?profile_id=" . htmlentities($row['profile_id']) . "'>" .$row['first_name'] ."</a>");
        echo("</td><td>");
        echo(htmlentities($row['last_name']));
        echo("</td><td>");
        echo(htmlentities($row['email']));
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        echo("</td></tr>\n");
        // echo $row['autos_id'];
  }


}

?>

</body>
</html>
</table> 
</html> 




