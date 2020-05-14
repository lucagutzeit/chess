<?php
  session_start();
  if(isset($_SESSION['userid'])){
    include "NavAngemeldet.php";
  }else{
    include "NavAbgemeldet.php";
  }
?>

<div class="main">
  <img src="img/test.jpg" alt="testbild">
</div>
<div class="main">
  <img src="img/test.jpg" alt="testbild">
</div>
<h1>Hallo</h1>
<div class="main">
  <img src="img/test.jpg" alt="testbild">
</div>

<?php
  include 'footer.html';
?>
