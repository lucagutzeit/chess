
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
</head>

<body>



  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Chess</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="./ScoreBoard.php">ScoreBoard <span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./lobby.php">Lobby</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./game.php">Games</a>
        </li>

      </ul>



      <form class="form-inline my-2 my-lg-0">
        <form class="form-inline">
          <a href='./logout.php'> <button type="button" class="btn btn-outline-danger">Abmelden</button>
          </a>
        </form>
      </form>
    </div>

          <div id="username" class="nickname" >
            <div class="rectangle_2">
            <?php echo $_SESSION['nickname'];?>
            </div>
          </div>
  </nav>
