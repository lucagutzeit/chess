
    <script>
      $(document).ready(function(){
        $("form").submit(function(e){
          //disable the action in the form tag
          e.preventDefault();
          var nickname = $("#nickname").val();
          var password = $("#password").val();
          var SignInSubmit = $("#SignInSubmit").val();

          $(".error-message").load("Login_logic.php", {
            //first name is the post name, second is the value
            nickname: nickname,
            password: password,
            SignInSubmit: SignInSubmit
          });

        });
      });

    </script>
