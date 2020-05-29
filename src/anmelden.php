<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="Stylesheet" href="../public/css/Stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>
      Anmeldung
    </title>
  </head>
<body>
  
<form class="container" action= "anmelden_logic.php" method="post">

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputName">Nickname</label>
          <input type="text" class="form-control" name="inputName" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-7">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>

          <div class="invalid-feedback">
            Diese Email ist bereits registriert!
          </div>
          <div class="valid-feedback">
            Diese Email wurde noch nicht registriert.
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
            Ich akzeptiere die AGB
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-outline-success">Registrieren</button>
    </form>


    <?php

    $Url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (strpos($Url, "email=exist")==true){
      echo '<script>$("#inputEmail").addClass("is-invalid")</script>';
    }

    include 'footer.html'
     ?>
