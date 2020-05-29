<?php

  require 'DBConnection.php';

  $nickname = $_POST['nickname'];
  $password = $_POST['password'];


    $sql = $connection->prepare("SELECT Passwort FROM Nutzer WHERE Nickname=?");
    $sql->bind_param('s', $nickname);
    $sql->execute();
    $sql_result = $sql->get_result();

    //If nickname does exist 
    if ($sql_result->num_rows==1){
      $result = $sql_result->fetch_assoc();

      // Checks if passwort exists in $result
      if (isset($result['Passwort'])){

        // Validates password
        if(password_verify( $password, $result['Passwort'] ) == true){
          echo "Congrats";
        }else {
          header ('location: landing.php?error=passwort');
        }
      }else{
        echo "array Fehler";
      }
    }
    else{
      header ('location: landing.php?error=nickname');
    }

    $connection->close();
    $sql->close();
 ?>
