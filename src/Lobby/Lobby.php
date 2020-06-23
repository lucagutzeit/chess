<?php
if (!isset($_SESSION)) {
  session_start();
}
require '../DBConnection.php';

include '../nav.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">

  <link rel="Stylesheet" href="../../public/css/Stylesheet.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />

  <!-- JavaScript -->
  <script src="../../public/js/lobby.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="../../public/css/chat.css" />

  <!--Bootstrap JS-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <title>Lobby</title>
</head>

<body>

  <?php

    $Url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (strpos($Url, "name=exists") == true) {
      echo '<html> <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Ungültige Eingabe!</strong> Der Name der Lobby existiert bereits
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div> </html>';
    }


    if (strpos($Url, "error=empty") == true) {
      echo '<html> <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Achtung!</strong> Sie müssen angemeldet sein um eine Lobby zu erstellen
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div> </html>';
    }

   ?>


    <div class="button">
    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
      new game
    </button>
  </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create new game</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form class="container" action= "newGame_logic.php" method="post">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control" id= "game_name" name="game_name" required>
                  </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-outline-success">create</button>
                </div>
              </form>

          </div>
        </div>
      </div>
    </div>


  <div id="lobby_container">

  </div>
  <div class="row">

    <div class="col-12" <div class="chat_include">
      <?php
      include '../chat/index.php'
      ?>
    </div>
  </div>


  <?php

  include '../footer.html'

  ?>
