<?php
session_start();

require 'DBConnection.php';

$nickname = $_POST['nickname'];
$password = $_POST['password'];


$sql = $connection->prepare("SELECT Passwort FROM Nutzer WHERE Nickname=?");
$sql->bind_param('s', $nickname);
$sql->execute();
$sql_result = $sql->get_result();

//check if nickname exists
if ($sql_result->num_rows == 1) {
  //results gets written in an array
  $result = $sql_result->fetch_assoc();

  // Checks if passwort exists in $result
  if (isset($result['Passwort'])) {

    // Validates password
    if (password_verify($password, $result['Passwort']) == true) {
      $_SESSION['nickname'] = $nickname;
      header('location: http://localhost/chess/src/Lobby/lobby.php');
    } else {
      //if password is wrong
      header('location: landing.php?error=FalscheEingabe');
    }
  } else {
    //if there is a Problem with the array
    header('location: landing.php?Fehler');
  }
} else {
  //if nickname does not exist
  header('location: landing.php?error=FalscheEingabe');
}

$connection->close();
$sql->close();
