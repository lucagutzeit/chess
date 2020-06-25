 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
   <meta charset="utf-8">


   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
   <link rel="Stylesheet" href="./../public/css/Stylesheet.css">

   <!-- jQuery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <!--Bootstrap JS-->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

   <!-- Game JS -->
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
     <div class="row">
       <div class="col-sm"></div>
       <div class="col-sm" id="board">
         <?php include 'chessboard.php' ?>
		<div class = "color" id="color">
			Color:
		</div>
		<div class = "secondRow" id="secondRow">
			
		</div>
		<div class = "turncount" id="turncount">
		
		</div>
       </div>
       <div class="col-sm"></div>
     </div>
   </div>
   <!--      <div class="Figuren col-3 row ">
       Figuren
     </div> -->
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