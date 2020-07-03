<?php
session_start();

if (isset($_SESSION['nickname']) && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
  header('location: lobby.php');
} else {
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">



    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <link rel="Stylesheet" href="./../public/css/Stylesheet.css">
    <link rel="Stylesheet" href="./../public/css/StylesheetLanding.css">


    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- JS -->
    <script src="./../public/js/landing.js"></script>

    <title>
      Chess
    </title>

    <script>
      $(document).ready(function() {
        $("#form").submit(function(e) {
          //disable the action in the form tag
          e.preventDefault();
          var nickname = $("#nickname").val();
          var password = $("#password").val();
          var SignInSubmit = $("#SignInSubmit").val();

          var error_message = $("#error_message").val();

          $("#error_message").load("Login_logic.php", {
            //first name is the post name, second is the value
            nickname: nickname,
            password: password,
            SignInSubmit: SignInSubmit
          });

        });
      });
    </script>

  </head>


  <body>
    <nav id="nav" class="navbar navbar-light bg-light">
      <a class="navbar-brand">Chess</a>
      <form class="form-inline">
        <a href="./anmelden.php">
          <button type="button" class="btn btn-outline-danger">Anmelden</button>
        </a>
      </form>
    </nav>
    <div class="background">



      <?php


      $Url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      //Error Message if there is a Error wich is not caused by the user
      if (strpos($Url, "error=Fehler") == true) {
        echo '<html> <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Etwas ist schief gelaufen!</strong> Bitte versuchen sie es später noch einmal.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div> </html>';
      }
      ?>


      <form id="form" action="Login_logic.php" method="post">

        <p id="error_message" class="error-message"></p>

        <div class=register>

          <div class=rectangle>
            <div class=login>

              <div class="form-group">
                <label for="nickname">Nickname</label>
                <input type="nickname" class="form-control" id="nickname" name="nickname" required>
              </div>
              <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button id="SignInSubmit" type="submit" class="btn btn-outline-success">Login</button>
      </form>
    </div>
    </div>
    </div>
    </div>
  </body>


<?php
  include 'footer.html';
} ?>