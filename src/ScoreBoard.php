<?php
session_start();

if (!(isset($_SESSION['nickname']) && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
  header("Location: http://localhost/chess/src/landing.php");
} else {
  require '../DBConnection.php';
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./../public/css/Stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Score Board</title>
  </head>

  <body>

    <?php
    include 'nav.php'

    ?>

    <?php

    $sql = $connection->prepare("SELECT Nickname FROM Nutzer");
    $sql->execute();
    $sql_result = $sql->get_result();

    ?>

    <div class="ScoreBoard">
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">Nickname</th>
            <th scope="col">Score</th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($results = $sql_result->fetch_assoc()) {

          ?>

            <tr>
              <td><?php echo $results['Nickname'] ?></td>
              <td><?php echo $results['Nickname'] ?></td>
            </tr>

          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  <?php
  include 'footer.html';
}
  ?>