<!doctype html>
<html lang="en">
<head>
  <!--  Meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/login.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/standard.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
  <title></title>
  <style>
    .admin-login-page {
      background-color: #800000;
      background-repeat: no-repeat;
      background-size: 100%;
      height: 100vh;
      width: 100%;*/
    }

  </style>
</head>
<body>

  <section class="admin-login-page">
    <div class="container admin-container">
      <div class="row admin-card-container">
        <div class="card admin-card">
          <div class="card-body">
            <div class="text-center">

            </div>
            <div class="login-form-title">University of Santo Tomas</div>
            <div class="welcome-form-title text-center mt-3">
              <h5>Welcome to</h5>
              <h5>Institute of Information and Computing Sciences</h5>
              <h3 class="system-form-title">Attendance Monitoring System</h3>
            </div>
            <div class="login-form-container">
              <div class="alert-container-content hidden"></div>
              <form id="login-form" method="POST">
              <div class="form-group mt-3">
                <input type="email" class="form-control standard-form-field email login-input" id="email" name="email" placeholder="EMAIL">
              </div>
              <div class="form-group">
                <input type="password" class="form-control standard-form-field password login-input" id="password" name="password" placeholder="PASSWORD">
              </div>
              <!-- <div class="text-center">
                <label class="checkbox-inline"><input type="checkbox" class="remember_me" value="1" name="remember_me">Remember me</label>
              </div> -->
              <div class="text-center">
               <a class="forgot-password">Forgot your password or email?</a>
             </div>
            <div class="alert alert-danger error-message d-none text-center mt-2 mb-0"></div>
             <div class="form-group text-center mt-3">
              <button type="button" id="btn-login" class="btn btn-primary btn-login">Login</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <div class="modal fade modal-fade-in-scale-up" id="forgot-password-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
   role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
      <div class="modal-content">
        <div class="modal-header bgc-primary">
          <h5 class="modal-title">Please contact your system administrator. <br/> Thank you.</h5>
        </div>
        <div class="modal-body">
      </div>
      </div>
    </div>
  </div>

</body>
</html>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script>
 $(document).ready(function() {

  $(document).on('click', '.forgot-password', function() {
      $('#forgot-password-modal').modal('show');
  });
  
  $(document).on('click', '.btn-login', function () {
        var check = validateInput();
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        if(check) {
            loginUser();
            // $('#login-form').submit();
        } else {
            $(this).prop('disabled', false).html('Login');
        }
    });

    $('.login-input').on('keyup', function (e) {
        if (e.keyCode == 13) {
            $('#btn-login').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            var check = validateInput();
            if(check) {
                loginUser();
            } else {
                $('#btn-login').prop('disabled', false).html('Login');
            }
        }
    });

    function validateInput() {
        $('.validate_error_message').remove();
        $('.required_input').removeClass('err_inputs');
        var check_user_name = $("#email");
        var check_password = $("#password");
        var error_message = "<span class='validate_error_message'>This field is required</span>";

        if (check_user_name.val() == "" ||  check_password.val() == "") {
            if (check_user_name.has("span") && $("span").hasClass("warning-note")) {
                
            } else {
                if(check_user_name.val() == '') {
                    $(check_user_name).addClass("err_inputs");
                    $(error_message).addClass("d-block warning-note").insertAfter($(check_user_name));
                }
                    
                if(check_password.val() == '') {
                    $(check_password).addClass("err_inputs");
                    $(error_message).addClass("d-block warning-note").insertAfter($(check_password));
                }          
            }
            return false;
        } else {
            $('.validate_error_message').remove();
            $(check_password).removeClass('err_inputs');
            $(check_user_name).removeClass('err_inputs');
            return true;    
        }
    }

    function loginUser() {
        $('.error-text-login').addClass('d-none').removeClass('d-block');
        var form = $('#login-form').serialize();
        var email = $('#email').val();
        var password = $('#password').val();
        console.log(email);
        console.log(password);
        $.ajax({
                url: '<?=base_url()?>ajax/login',
                type: 'POST',
                data: form,
            }).done(function (data) {
              console.log(data);
              var result = JSON.parse(data);
                if(result.success === true) {
                    window.location.replace(result.message);
                } else {
                    $('#password').val('');
                    $('.error-message').removeClass('d-none').addClass('d-block').html(result.message);
                    $('#btn-login').html('Login').prop('disabled', false);
                }
            });
    }
 });
  
</script>