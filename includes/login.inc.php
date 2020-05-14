<?php
  $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
  if(empty($referer)){
    $referer = '../index.php';
  }else{
    $realdReferer = explode('?', $referer);
    $referer = reset($realdReferer);
  }

  require 'connection.inc.php';

  $email = $_POST['loginEmail'];
  $password = $_POST['loginPassword'];

  $sql = $connection->prepare("SELECT id, password FROM user WHERE email=?");
  $sql->bind_param('ss', $email);
  $sql->execute();
  $sql_result = $sql->get_result();
  //naechsten beiden Zeilen nochmal genauer angucken
  if($sql_result->num_rows() === 1){
    $userid = $sql_result->fetch_assoc();
    if(/*password richtig?*/){
      session_start();
      $_SESSION['userid'] = $userid['id'];
      header('location ../index.php');
    }
  }else{
    header('location: '.$referer.'?error=loginfailed');
    exit();
  }
?>
