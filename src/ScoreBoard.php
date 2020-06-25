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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="./../public/css/Stylesheet.css">
    <link rel="stylesheet" href="./../public/css/chat.css">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />

    <!-- JavaScript -->
    <script src="../public/js/chat.js"></script>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>





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
      <div class="col-6">
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



      <div class="col-6">
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