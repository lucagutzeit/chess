<?php
  require 'DBConnection.php';

  $nickname = $_POST['inputName'];
  $email = $_POST['inputEmail'];
  $password = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);

  //looking if email exist
  $sql_email = $connection->prepare('SELECT * FROM Nutzer WHERE Email=?');
  $sql_email->bind_param('s', $email );
  $sql_email->execute();
  $sql_email_results = $sql_email->get_result();

  //looking if nickname exist
  $sql_nickname = $connection->prepare('SELECT * FROM Nutzer WHERE Nickname=?');
  $sql_nickname->bind_param('s', $nickname );
  $sql_nickname->execute();
  $sql_nickname_results = $sql_nickname->get_result();

  //if email or nickname does not exist everything gets written in the DB
if($sql_email_results->num_rows == 0 && $sql_nickname_results->num_rows ==0 ){
    $sql_insert = $connection->prepare('INSERT INTO Nutzer(Nickname, Email, Passwort) VALUES(?,?,?)');
    $sql_insert->bind_param('sss', $nickname, $email, $password);
    $sql_insert->execute();
    header('location: landing.php');
  }else{
    if($sql_email_results->num_rows == 1 ){
      header('location: anmelden.php?email=exist');
      //echo"Email existiert bereits";

    }
    else if ($sql_nickname_results->num_rows ==1) {
      echo"Nickname existiert bereits";
    }

    exit();
  }

  $connection->close();
  $sql_email->close();
  $sql_nickname->close();
  $sql_insert->close();
 ?>
