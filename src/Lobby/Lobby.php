<?php
session_start();
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
  <script src="../../public/js/chat.js"></script>

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



  <?php

  $sql = $connection->prepare("SELECT id, player1, player2  FROM games");
  $sql->execute();
  $sql_result = $sql->get_result();



  // a game card is shown for every game wich is in the DB
  while ($results = $sql_result->fetch_assoc()) {

  ?>
<!--<div class="container">
  <div class="row">
  <div class="col-8">-->
    <div class="Karte">
      <div class="card" style="width: 18rem;">
        <img src="../../public/img/Schachbrett.jpeg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo $results['id'] ?></h5>
          <p class="card-text">Spieler1:
            <?php
            //checking if there is a player 1
            if (empty($results['player1'])) {
              echo "Kein Spieler 1";
            } else {
              echo $results['player1'];
            }
            ?>
          </p>
          <p class="card-text">Spieler2:
            <?php
            //checking if there is a player 2
            if (empty($results['player2'])) {
              echo "Kein Spieler 2";
            } else {
              echo $results['player2'];
            }
            ?>
          </p>
          <a href="#" class="btn btn-outline-success">Beitreten</a>
          <a href="#" class="btn btn-outline-success">Beitreten</a>

        </div>
      </div>
    </div>
  <!--</div>-->






  <?php
  }
  ?>

    <div class="row">

<div class="col-12"
<div class ="chat_include">
  <?php
  include '../chat/index.php'
   ?>
</div>
</div>




  <?php

  include '../footer.html'

  ?>
