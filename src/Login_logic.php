<?php

  require 'DBConnection.php';

  $nickname = $_POST['nickname'];
  $password = $_POST['password'];

  if(empty($nickname)||empty($password)){
    header('location: landng.php');
    exit();
  }else{
    $sql = $connection->prepare("SELECT * FROM Nutzer WHERE Nickname=?");
    $sql->bind_param('s', $nickname);
    $sql->execute();
    $sql_result = $sql->get_result();



  }

 ?>
