<?php
  require 'DBConnection.php';

//check if submit button was clicked
if(isset($_POST['SignUpSubmit'])){
  $nickname = $_POST['inputName'];
  $email = $_POST['inputEmail'];
  $password = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);

  $error_nickname=false;
  $error_email=false;

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

  }else{
    if($sql_email_results->num_rows == 1 ){

      echo '<html><div>
            Die gewünschte Email ist bereits registriert!
            </div></html>';
      $error_email=true;
    }
    else if ($sql_nickname_results->num_rows ==1) {

      echo '<html><div>
            Der gewünschte Nickname ist bereits registriert!
            </div></html>';
      $error_nickname=true;
    }
  }

  $connection->close();
  $sql_email->close();
  $sql_nickname->close();


}
 ?>

 <script>

   var error_email ="<?php echo $error_email ?>";
   var error_nickname ="<?php echo $error_nickname ?>";

   if(error_email == true){
     $("#inputEmail").addClass("is-invalid");
   }else if(error_nickname == true){
     $("#inputName").addClass("is-invalid");
   }else{
      window.location.replace("http://localhost/chess/src/Lobby/lobby.php");
   }

 </script>
