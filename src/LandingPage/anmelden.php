<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="Stylesheet" href="../../public/css/Stylesheet.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>
    Anmeldung
  </title>
</head>

<body>

  <div class="anmelden">

    <form class="container" action="anmelden_logic.php" method="post">

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputName">Nickname</label>
          <input type="text" class="form-control" id="inputName" name="inputName" required>

          <div class="invalid-feedback">
            Der gewünschte Nickname ist bereits registriert!
          </div>

        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-7">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>

          <div class="invalid-feedback">
            Die gewünschte Email ist bereits registriert!
          </div>

        </div>
        <div class="form-group col-md-5">
          <label for="inputPassword">Passwort</label>
          <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck" required>
          <label class="form-check-label" for="gridCheck">
            Ich akzeptiere die <a href="AGB.php" target="_blank">AGB</a>
            <!--opens in new tab-->
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-outline-success">Registrieren</button>
    </form>

  </div>


  <?php

  $Url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //check if there is a String after the URL. If so the user gets an error message
  if (strpos($Url, "email=exist") == true) {
    echo '<script>$("#inputEmail").addClass("is-invalid")</script>';
  }
  if (strpos($Url, "nickname=exist") == true) {
    echo '<script>$("#inputName").addClass("is-invalid")</script>';
  }

  include __DIR__ . '/../Include/footer.html'
  ?>