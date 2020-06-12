<?php
require 'DBConnection.php'
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="Stylesheet" href="../public/css/Stylesheet.css">
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

    $results = $sql_result->fetch_assoc();
?>
        <table>
               <thead>
                   <tr>
                       <td>Nickname</td>
                   </tr>
               </thead>
               <tbody>
               <?php
                   while($row = mysql_fetch_array($results)) {
                   ?>
                       <tr>
                           <td><?php echo $row['Nickname']?></td>
                       </tr>

                   <?php
                   }
                   ?>
                   </tbody>
                   </table>

      }

    ?>




<?php
  include 'footer.html'
 ?>
