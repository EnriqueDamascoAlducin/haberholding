
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 id="divTituloHeader"><?php echo $_POST['nombre']; ?></h1>
      </div>
      <?php if(in_array("AGREGAR", $permisosActuales)){ ?>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><button class="btn btn-secondary"  data-toggle="modal" data-target="#modal" onclick="agregar();">Agregar</button> </li>
          </ol>
        </div>
      <?php } ?>
    </div>
  </div><!-- /.container-fluid -->
</section>