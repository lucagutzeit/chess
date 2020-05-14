<?php

  require 'connection.inc.php';

  $email = $_POST['emailaddress'];

  if(empty($email)){
    echo -1;
    exit();
  }

  $sql_email = $connection->prepare('SELECT * FROM user WHERE email=?');
  $sql_email->bind_param('s', $email);
  $sql_email->execute();
  $sql_email_results = $sql_email->get_result();
  if($sql_email_results->num_row == 0){
    echo 1;
    exit();
  }else{
    echo -1;
    exit();
  }

  echo 2;
  $sql_egal->close();
  $connection->close();
?>
