<?php
session_start();
require __DIR__ . '/../DBConnection.php';

$nickname = $_SESSION['nickname'];
$game_name = $_POST['game_name'];


$sql_game_name = $connection->prepare('SELECT * FROM games WHERE name=?');
$sql_game_name->bind_param('s', $game_name);
$sql_game_name->execute();
$sql_game_name_results = $sql_game_name->get_result();



if(empty($nickname)){
  header('location: Lobby.php?error=empty');
}
if ($sql_email_results->num_rows == 0){

  $sql_insert = $connection->prepare('INSERT INTO games(player1, name) VALUES(?,?)');
  $sql_insert->bind_param('ss', $nickname, $game_name);
  $sql_insert->execute();
  header('location: Lobby.php');

}else{
  header ('location: Lobby.php?name=exists');
}
?>
