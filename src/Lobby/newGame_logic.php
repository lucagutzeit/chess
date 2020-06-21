<?php
session_start();
  require __DIR__ . '/../Include/DBConnection.php';

  $nickname = $_SESSION["nickname"];
  $ID = random_int ( 1 , 1000 ) ;


  $sql_insert = $connection->prepare('INSERT INTO lobby(Nickname1, ID) VALUES(?,?)');
  $sql_insert->bind_param('si', $nickname, $ID);
  $sql_insert->execute();

  header('location: Lobby.php');
