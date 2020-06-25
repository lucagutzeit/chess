<?php
session_start();

if (!(isset($_SESSION['nickname']) && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
  header("Location: http://localhost/chess/src/landing.php");
} else {
  require './DBConnection.php';
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">

    <!-- JavaScript -->
    <script src="../public/js/chat.js"></script>

    <link rel="stylesheet" href="./../public/css/Stylesheet.css">
    <link rel="stylesheet" href="./../public/css/chat.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Score Board</title>
  </head>

  <body>

    <?php
    include 'nav.php'

    ?>

    <?php

    $sql = $connection->prepare("SELECT * FROM Nutzer");
    $sql->execute();
    $sql_result = $sql->get_result();

    ?>
    <div class="row">
    <div class="col-6" >
    <div class="ScoreBoard">
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">User</th>
            <th scope="col">Win/Lose</th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($results = $sql_result->fetch_assoc()) {

          ?>

            <tr>
              <td><?php echo $results['Nickname'] ?></td>
              <td><?php echo $results['win'] . '/' . $results['lose'] ?></td>
            </tr>

          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    </div>



      <div class="col-6" >
      <div class="chat_include2">
        <?php
        include './chat/index.php'
        ?>
      </div>
    </div>
    </div>





  <?php
  include 'footer.html';
}
  ?>
