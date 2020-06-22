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

  <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />

  <!-- JavaScript -->
  <script src="../../public/js/lobby.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="../../public/css/chat.css" />

  <title>Lobby</title>
</head>

<body>

  <form action="newGame_logic.php" method="post">
    <div class="button">
      <!--<button type="button" class="btn btn-outline-secondary">Neues Spiel</button>-->
      <input type="submit" class="button" name="insert" value="insert" />
    </div>
  </form>

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