<?php

  require 'connection.inc.php';

  $firstname = $_POST['inputName'];
  $lastname = $_POST['inputNachname'];
  $email = $_POST['inputEmail4'];
  $password = $_POST['inputPassword4'];
  $password2 = $_POST['inputPassword2'];
  $adresse = $_POST['inputAddress'];
  $housenumber = $_POST['inputhousenumber'];
  $postleitzahl =$_POST['inputPostleitzahl'];
  $stadt = $_POST['inputCity'];

  if (empty($firstname)||empty($lastname)||empty($email)||empty($password)||empty($adresse)||empty($postleitzahl)||empty($stadt)||empty($housenumber)){
    header('location: ../registration.php');
    exit();
  }

  if($password === $password2){
    $password = password_hash($_POST['inputPassword4'], PASSWORD_DEFAULT);
  }else{
    header('location: ../test.html');
    exit();
  }

  $sql_email = $connection->prepare('SELECT * FROM user WHERE email=?');
  $sql_email->bind_param('s', $email);
  $sql_email->execute();
  $sql_email_results = $sql_email->get_result();
  if($sql_email_results->num_row == 0){
    $sql_insert = $connection->prepare('INSERT INTO user(firstname, lastname, email, password, street, housenumber, zip, city) VALUES(?,?,?,?,?,?,?,?)');
    $sql_insert->bind_param('ssssssis', $firstname, $lastname, $email, $password, $adresse, $housenumber, $postleitzahl, $stadt);
    $sql_insert->execute();
    header('location: ../index.php');
  }else{
    header('location: ../registration.php');
    exit();
  }
  $connection->close();
  $sql_email->close();
  $sql_insert->close();
?>
