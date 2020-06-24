 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
   <meta charset="utf-8">

   <link rel="Stylesheet" href="./../public/css/Stylesheet.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="../public/js/chesspieces.js"></script>
   <script src="../public/js/movelogic.js"></script>
   <script src="../public/js/canvas.js"></script>
   <script src="../public/js/canvas_interaction.js"></script>

   <title>game</title>
 </head>

 <body>
   <?php
    include 'nav.php'
    ?>

   <div class="container">
     <!--      <div class="Figuren col-3 row ">
       Figuren
     </div> -->

     <div id="board">
       <?php include 'chessboard.php' ?>
     </div>
   </div>

   <!-- <div class="row">
       <div class="col-12">
         <div class="game_chat">
           chat
         </div>
       </div>
     </div> -->


 </body>

 </html>