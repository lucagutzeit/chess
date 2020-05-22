<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<form class="container" method="post">

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputName">Nickname</label>
          <input type="text" class="form-control" name="inputName" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-7">
          <label for="inputEmail4">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
        </div>
          <div class="form-group col-md-5">
            <label for="inputPassword">Passwort</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck" required>
          <label class="form-check-label" for="gridCheck">
            Ich akzeptiere die AGB
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-outline-success">Registrieren</button>
    </form>


    <?php
    include 'footer.html'
     ?>
