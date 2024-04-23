<?php
session_start();

if (!(isset($_SESSION['nickname']) && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)) {
  header("Location: landing.php");
} else {
  require '../DBConnection.php';

  $nickname = $_SESSION['nickname'];
  $game_name = $_POST['game_name'];


  $sql_game_name = $connection->prepare('SELECT * FROM games WHERE name=? AND state=0');
  $sql_game_name->bind_param('s', $game_name);
  $sql_game_name->execute();
  $sql_game_name_results = $sql_game_name->get_result();
  $sql_game_name->close();

  if ($sql_game_name_results->num_rows == 0) {

    $sql_insert = $connection->prepare('INSERT INTO games(player1, name) VALUES(?,?)');
    $sql_insert->bind_param('ss', $nickname, $game_name);
    $sql_insert->execute();
    $sql_insert->close();

    $sql = $connection->prepare('SELECT id FROM games WHERE name = ? AND state=0');
    $sql->bind_param('s', $game_name);
    $sql->execute();
    $result = $sql->get_result()->fetch_assoc();
    $id = $result['id'];

    $_SESSION['gameId'] = $id;
    header("location: ../game.php?id=$id");
  } else {
    header('location: ../lobby.php?name=exists');
  }
}
