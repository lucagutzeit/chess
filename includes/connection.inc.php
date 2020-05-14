<?php
  $dbServername = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $db = "webstoredb";

  $connection = new mysqli($dbServername, $dbUser, $dbPassword, $db);

  if($connection->connect_error){
    die($connection->connect_error);
  }
?>
