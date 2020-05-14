<?php
  session_start();
  if(isset($_SESSION['userid'])){
    include "NavAngemeldet.php";
  }else{
    include "NavAbgemeldet.php";
  }
?>
    <form class="container" action="includes/registration.inc.php" method="post">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputName">Name</label>
          <input type="text" class="form-control" name="inputName" required>
        </div>
        <div class="form-group col-md-6">
          <label for="inputNachname">Nachname</label>
            <input type="text" class="form-control" name="inputNachname" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputEmail4">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail4" onfocusout="emailCheck()" required>
          <div class="invalid-feedback">
            Diese Email ist bereits registriert!
          </div>
          <div class="valid-feedback">
            Diese Email wurde noch nicht registriert.
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputPassword4">Passwort</label>
          <input type="password" class="form-control" id="inputPassword" name="inputPassword4" required>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Passwort wiederholen</label>
          <input type="password" class="form-control" id="inputPassword2" name="inputPassword2" onfocusout="passwordCheck()" required>
          <div class="invalid-feedback">
            Passwort stimmt nicht überein!
          </div>
          <div class="valid-feedback">
            Passwort stimmt überein.
          </div>
        </div>
      </div>
    <div  class="form-row">
      <div class="form-group col-md-10">
        <label for="inputAddress">Addresse</label>
        <input type="text" class="form-control" name="inputAddress" required>
      </div>
      <div class="form-group col-md-2">
        <label for="inputhousenumber">Hausnummer</label>
        <input type="text" class="form-control" name="inputhousenumber" required>
      </div>
    </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputPostleitzahl">Postleitzahl</label>
          <input type="text" class="form-control" name="inputPostleitzahl" required>
        </div>
        <div class="form-group col-md-8">
          <label for="inputCity">Stadt</label>
          <input type="text" class="form-control" name="inputCity" required>
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

  <script type="text/javascript">

    // function emailCheck(){
    //   var email = document.getElementById('inputEmail').value;
    //   $.post("includes/emailcheck.inc.php", {emailaddress: email},  function(data, status){
    //     if(data == -1){
    //       $('#inputEmail').removeClass("is-valid");
    //       $('#inputEmail').addClass("is-invalid");
    //     }else if (data = 1){
    //       $('#inputEmail').removeClass("is-invalid");
    //       $('#inputEmail').addClass("is-valid");
    //     }else if(data == 2){
    //       $('#inputEmail').addClass("is-valid");
    //       $('#inputEmail').addClass("is-invalid");
    //     } else {
    //       $('#inputEmail').value = 'test';
    //     }
    //   });
    // }

    function passwordCheck(){
      var password1 = document.getElementById('inputPassword').value;
      var password2 = document.getElementById('inputPassword2').value;

      if(password1 != password2){
        $('#inputPassword2').removeClass("is-valid");
         $('#inputPassword2').addClass("is-invalid");
      }
      else{
        $('#inputPassword2').removeClass("is-invalid");
        $('#inputPassword2').addClass("is-valid");
      }
    }
  </script>
<?php
  include 'footer.html';
?>
