<?php

  require 'DBConnection.php';

  $nickname = $_POST['nickname'];
  $password = $_POST['password'];


    $sql = $connection->prepare("SELECT Passwort FROM Nutzer WHERE Nickname=?");
    $sql->bind_param('s', $nickname);
    $sql->execute();
    $sql_result = $sql->get_result();

    if ($sql_result->num_rows==1){
      $result = $sql_result->fetch_assoc();
      if (isset($result['Passwort'])){
        if(password_verify ( $password, $result['Passwort'] ) == true){
          echo "Congrats";
        }else {
          header ('location: landing.php?error=passwort');
          exit();
        }
      }else{
        echo "array Fehler";
      }
    }
    else{
      header ('location: landing.php?error=nickname');
      exit();
    }


 ?>
