<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="Stylesheet" href="../public/css/Stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>

    </title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand">Chess</a>
        <form class="form-inline" >
          <a href="anmelden.php"><button type="button" class="btn btn-outline-danger">Anmelden</button></a>
        </form>
      </nav>

    <div class = register>
      <form action= "Login_logic.php" method="post">
          <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="nickname" class="form-control" id="nickname" name="nickname" required>
          </div>
          <div class="form-group">
            <label for="password">Passwort</label>
            <input type="password" class="form-control" id="password" name="password" required>

            <div class="invalid-feedback">
              Das Passwort ist Falsch
            </div>
          </div>
          <button type="submit" class="btn btn-outline-success">Login</button>
      </form>
    </div>
  </body>

<?php
  $Url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if (strpos($Url, "error=passwort")==true){
    echo '<script>$("#password").addClass("is-invalid")</script>';
  }

  include 'footer.html';
 ?>
