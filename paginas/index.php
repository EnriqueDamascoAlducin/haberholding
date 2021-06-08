<?php include_once 'controladores/finsession.php'; ?>
<?php include_once 'controladores/conexion.php'; ?>

<?php
  $query = "SELECT (id_modulo), nombre_modulo, ruta_modulo, icono_modulo FROM modulos WHERE status_modulo <> 0 ";
  $modulos = $con->query($query);

  $querySubmodulos = "SELECT DISTINCT(sub.id), sub.nombre,sub.icono, sub.ruta FROM submodulos sub INNER JOIN permisos_submodulos ps ON sub.id = ps.idsubmodulo INNER JOIN permisos_submodulos_usuarios psu ON ps.id = psu.idpermiso WHERE psu.status<>0 AND sub.status<>0 AND  psu.idusuario = " . $_SESSION['usuario'] . " AND sub.modulo = ?";
  $PrepareSubmodulos = $con->prepare($querySubmodulos);
  $queryCountSubmodulos = "SELECT COUNT(ps.id) as total FROM submodulos sub INNER JOIN permisos_submodulos ps ON sub.id = ps.idsubmodulo INNER JOIN permisos_submodulos_usuarios psu ON ps.id = psu.idpermiso WHERE psu.status<>0 AND sub.status<>0 AND  psu.idusuario = " . $_SESSION['usuario'] . " AND sub.modulo = ?";
  $PrepareCountSubmodulos = $con->prepare($queryCountSubmodulos);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HaberHolding</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../dist/img/logo_hh.jpg">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="../dist/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  
  <base href="/haberholding/paginas/" target="_blank">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
      
  		<?php if($_SESSION['tipo_usuario'] == 'externo'){ ?>
        <a class="nav-link" target="_PARENT" href="../clientes.php">
      <?php }else{ ?>
        <a class="nav-link" target="_PARENT" href="../">
      <?php } ?>
          <i class="fas fa-sign-out-alt"></i>Salir
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/logo_hh.jpg"
           alt="HH"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b>Haber </b> Holding</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if($_SESSION['sexo_usu']==2){ ?>
            <img src=" ../dist/img/userW.jpg" class="img-circle elevation-2" alt="Mujer">
          <?php } else{ ?>
            <img src=" ../dist/img/userM.jpg" class="img-circle elevation-2" alt="Hombre">
          <?php } ?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nombre_usu'] .' ' . $_SESSION['apellidop_usu']?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Modulos con permisos -->
          <?php while ($modulo = $modulos->fetch_assoc()) { ?>
            <?php
              $permisoSubmodulos = 0;
              $PrepareCountSubmodulos->bind_param('i',$modulo['id_modulo']);
              $PrepareCountSubmodulos->execute();
              $cantSubmodulos = $PrepareCountSubmodulos->get_result();
              foreach ($cantSubmodulos as $cantSubmodulo) {
                $permisoSubmodulos = ($cantSubmodulo['total']);
              }
              if($permisoSubmodulos>0){
                $PrepareSubmodulos->bind_param('i',$modulo['id_modulo']);
                $PrepareSubmodulos->execute();
                $submodulos = $PrepareSubmodulos->get_result();
            ?>
              <li class="nav-item has-treeview">
                <a  class="nav-link">
                  <i class="nav-icon <?php echo $modulo['icono_modulo']; ?>"></i>
                  <p>
                    <i class="right fas fa-angle-left"></i><?php echo $modulo['nombre_modulo'] ?>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <?php foreach ($submodulos as $submodulo) { ?>
                    <li class="nav-item">
                      <a onclick="cargarVista('<?php echo $modulo['ruta_modulo'].$submodulo['ruta']; ?>','<?php echo $submodulo['nombre']; ?>','<?php echo $submodulo['id']; ?>')" class="nav-link">
                        <i class="<?php echo $submodulo['icono'] ?> nav-icon"></i>
                        <p><?php echo $submodulo['nombre'] ?></p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Contenido -->
    <section class="content" id="contenidoPrincipal">

    </section>
    <!-- /.Contenido -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">

    </div>
    <strong>Copyright &copy;  Haber Holding.</strong> Derechos Reservados
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script src="../dist/js/sweetalert.min.js"></script>
<script src="../dist/js/bootstrap4-toggle.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  function cargarVista(ruta,nombre,id) {
    parametros ={
      nombre:nombre,
      ruta:ruta,
      id:id
    }
    $.ajax({
      url: 'vistas'+ruta+"index.php",
      data:parametros,
      type:'POST',
      beforeSend:function(){
        $("#contenidoPrincipal").html("<h1 class='text-center'>Cargando Contenido</h1>");
      },
      success:function(respuesta){
        $("#contenidoPrincipal").html(respuesta);
      },
      error:function(codigo,teextstatus,otro){
        $("#contenidoPrincipal").html("<h1 style='color:red'> Error "+teextstatus+"</h1>");
      }
    });
  }

</script>
</body>
</html>
