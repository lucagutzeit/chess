<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>WebShop</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <a class="navbar-brand" href="#">Titel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Bereich 1<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Bereich 2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Bereich 3</a>
          </li>
        </ul>
        <span class="navbar-text">
          <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#loginModal">Login</button>
          <a href="registration.php"><button type="button" class="btn btn-outline-warning">Registrierung </button></a>
        </span>
      </div>
    </nav>

    <?php
      if(isset($_GET['error'])) {
        if($_GET['error'] == 'loginfailed'){
          echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Holy guacamole!</strong> Falsches Passwort oder Email.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          ';
        }
      }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="includes/login.inc.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="loginEmail">Email address</label>
                <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" class="form-control" id="loginPassword" name="loginPassword">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
              <button type="submit" class="btn btn-outline-success">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
