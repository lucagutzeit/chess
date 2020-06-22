/* <?php

      $sql = $connection->prepare("SELECT id, player1, player2  FROM games");
      $sql->execute();
      $sql_result = $sql->get_result();



      // a game card is shown for every game wich is in the DB
      while ($results = $sql_result->fetch_assoc()) {

      ?>

<div class="Karte">
  <div class="card" style="width: 18rem;">
    <img src="../../public/img/Schachbrett.jpeg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title"> ${name ?></h5>
      <p class="card-text">Spieler1:
      </p>
      <a href="#" class="btn btn-outline-success">Beitreten</a>
    </div>
  </div>
</div>

