<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Haber Holding</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="/haberholding/">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php" style="color:white"><b>Haber</b>Holding</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <h4 class="login-box-msg">Inicia Sesión</h4>

      <form  id="formularioLogin">
        <div class="input-group mb-3">
          <input type="number" class="form-control" placeholder="Numero de Empleado" id="noempleado" name="noempleado">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" id="contrasena" name="contrasena">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <button type="submit"  class="btn btn-primary btn-block">Inciar Sesión</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/sweetalert.min.js"></script>
<script type="text/javascript">
  <?php if(isset($_GET['out'])){ ?>
    swal({
      title: "Error",
      text: "Se ha terminado la sesión",
      icon: "error",
      button: "Iniciar Sesión",
    });
    setTimeout(function(){
      $(".swal-button").trigger("click");
    },1500);
  <?php } ?>
  $("#formularioLogin").submit(function(event){
    var valorempleado    = $("#noempleado").val().trim();
    var valorcontrasena  = $("#contrasena").val().trim();
    if(valorempleado ==''){
      swal({
        title: "Error",
        text: "Debes Capturar tu Número de Empleado",
        icon: "error",
        button: "Regresar",
      });
      setTimeout(function(){
        $(".swal-button").trigger("click");
      },1500);
      $("#noempleado").focus();
      return false;
    }
    if(valorcontrasena ==''){
       swal({
          title: "Error",
          text: "Debes Capturar tu Contraseña",
          icon: "error",
          button: "Regresar",
        });
       setTimeout(function(){
        $(".swal-button").trigger("click");
        },1500)
      $("#contrasena").focus();
      return false;
    }
    $.ajax({
      url:'paginas/controladores/login.php',
      data:{empleado:valorempleado,contrasena:valorcontrasena},
      type:'POST',
      success:function(respuesta){
          if(respuesta=='Error'){
           swal({
              title: respuesta,
              text: "No existe el usuario",
              icon: "error",
              button: "Regresar",
            });
            setTimeout(function(){
              $(".swal-button").trigger("click");
            },2500)
          }else{
           swal({
              title: "Correcto",
              text: respuesta,
              icon: "success",
              button: "Regresar",
            });
            setTimeout(function(){
              $(".swal-button").trigger("click");
            window.location.replace("paginas/");
            },2500)
          }
        
      }

    });
    event.preventDefault(); 

  });



</script>
</body>
</html>
