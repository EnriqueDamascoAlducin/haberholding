<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Perfil</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">User Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="https://icon-library.net/images/no-image-available-icon/no-image-available-icon-22.jpg"  alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">Registrar Usuario</h3>

            <p class="text-muted text-center">
              <center>
                <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                  <input type="number" placeholder="No empleado" class="form-control" style="border-color:transparent;" >
                </div>
              </center>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
              </li>
              <li class="list-group-item">
                <input type="text" id="apellidop" name="apellidop" class="form-control" placeholder="Apellido Paterno">
              </li>
              <li class="list-group-item">
                <input type="text" id="apellidom" name="apellidom" class="form-control" placeholder="Apellido Materno">
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block" onclick="getData()"><b>Registrar</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->

        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#Personales" data-toggle="tab">Datos Personales</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Historial de Equipos</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Equipo Asignado</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="Personales">
                <div class="form-group">
                  <div class="row">
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label for="depto" class="control-label">Departamento</label>
                      <select class="form-control" id="depto" name="depto">
                          <option value="">Departamento</option>
                          <option value="1">Sistemas</option>
                      </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <label for="area" class="control-label">Área</label>
                        <select class="form-control" id="area" name="area">
                            <option value="">Área</option>
                            <option value="1">Desarrollo</option>
                            <option value="1">Soporte</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label for="ingreso" class="control-label">Fecha de Ingreso</label>
                      <input type="date" id="ingreso" name="ingreso" class="form-control">
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label for="correo" class="control-label">Correo</label>
                      <input type="email" id="correo" name="correo" class="form-control" placeholder="ejemplo@ejemplo.com">
                    </div>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label for="contrasena" class="control-label">Contraseña</label>
                      <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña">
                    </div>
                  </div>
                </div>
                <!-- Post -->

                <!-- /.post -->

                <!-- Post -->

                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <div class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-danger">
                      10 Feb. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-envelope bg-primary"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-user bg-info"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                      <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-comments bg-warning"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-success">
                      3 Jan. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <div>
                    <i class="far fa-clock bg-gray"></i>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <!-- adminLte/paginas/usuarios/formularios/registrarUsuario.php
                  ../../../controladores/usuariosController.php
            -->
              <div class="tab-pane" id="settings">
                <form class="form-horizontal" action="../../../controladores/usuariosController.php" method="POST" >
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="nombre" name="nombre" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="correo" name="correo" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName2" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName2" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<script type="text/javascript">
  function getData(){
    var nombre;
    var apellidop;
    var apellidom;
    /*nombre = document.getElementById('nombre').value;
    apellidop = document.getElementById('apellidop').value;
    apellidom = document.getElementById('apellidom').value;*/
    nombre = $("#nombre").val();
    apellidop = $("#apellidop").val();
    apellidom = $("#apellidom").val();
    alert(nombre + " " + apellidop + " " + apellidom);
  }
</script>
