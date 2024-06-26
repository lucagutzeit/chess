<?php
session_start();

require 'DBConnection.php';

//check if submit button was clicked
if (isset($_POST['SignInSubmit'])) {
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];

  $error = false;

//Select the passwort from DB where the nickname is equal to what the user has entered
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
        $_SESSION['loggedIn'] = true;
        $_SESSION['nickname'] = $nickname;
      } else { //if password is wrong

        echo '<html> <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Falsche Eingabe!</strong> Passwort/Nickname ist Falsch.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div> </html>';
        $error = true;
        session_destroy();
      }

  } else { //if there is a Problem with the array
    header('location: landing.php?Fehler');
    session_destroy();
  }
} else { //if nickname does not exist

  echo  '<html> <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Falsche Eingabe!</strong> Passwort/Nickname ist Falsch.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div> </html>';
  $error = true;
  session_destroy();
}

$connection->close();
$sql->close();
}
?>


<script>
  //value is equal to $error from php
  var error = "<?php echo $error ?>";

  if (error == false) {
    window.location.replace("lobby.php");

}
</script>
