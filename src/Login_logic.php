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
      //results gets written in an array
      $result = $sql_result->fetch_assoc();

      // Checks if passwort exists in $result
      if (isset($result['Passwort'])){

        // Validates password
        if(password_verify( $password, $result['Passwort'] ) == true){
          echo "Congrats";
        }else {
          //if password is wrong
          header ('location: landing.php?error=FalscheEingabe');
        }
      }else{
        //if there is a Problem with the array
        //echo "array Fehler";
        header ('location: landing.php?Fehler');
      }
    }
    else{
      //if nickname does not exist
      header ('location: landing.php?error=FalscheEingabe');
    }

    $connection->close();
    $sql->close();
 ?>
