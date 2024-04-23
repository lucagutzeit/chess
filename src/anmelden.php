<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <script src="./../public/js/anmelden.js"></script>

    <link rel="Stylesheet" href="./../public/css/Stylesheet.css">

    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">



    <title>
      Anmeldung
    </title>

    <script>
      $(document).ready(function(){
        $("#form").submit(function(e){
          //disable the action in the form tag
          e.preventDefault();
          var inputName = $("#inputName").val();
          var inputEmail = $("#inputEmail").val();
          var inputPassword = $("#inputPassword").val();
          var SignUpSubmit = $("#SignUpSubmit").val();

          var error_message = $("#error_message").val();

          $("#error_message").load("anmelden_logic.php", {
            //first name is the post name, second is the value
            inputName: inputName,
            inputEmail: inputEmail,
            inputPassword: inputPassword,
            SignUpSubmit: SignUpSubmit
          });

        });
      });

    </script>

  </head>
<body>

<div class="anmelden">

  <form id="form" class="container" action= "anmelden_logic.php" method="post">



      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputName">Nickname</label>
          <input type="text" class="form-control" id= "inputName" name="inputName" required>
        </div>
        </div>


      <div class="form-row">
        <div class="form-group col-md-7">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>


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
            Ich akzeptiere die <a href="AGB.php" target="_blank">AGB</a> <!--opens in new tab-->
          </label>
        </div>
      </div>
      <button id="SignUpSubmit" type="submit" class="btn btn-outline-success">Registrieren</button>


        <div id="error_message" class="form-error">

        </div>
    </form>

</div>


    <?php

    include 'footer.html'
     ?>
