<?php

include_once '../../../controladores/finsession.php';
include_once '../../../controladores/conexion.php';
$deptos = $con->query("SELECT id_depto as id, nombre_depto as nombre From departamentos where status_depto <> 0  ");
$marcas = $con->query("SELECT id, nombre  From marcas where status <> 0  ");
$modelos = $con->query("SELECT id, nombre  From modelos where status <> 0  ");

?>
<form   method="post">
  <div class="row">
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
      <div class="form-group">
        <label for="deptos">Departamentos</label>
        <select class="form-control" name="deptos" id="filtro_deptos">
          <option value="">Departamentos</option>
          <?php
            while ($depto = $deptos->fetch_assoc()) {
          ?>
            <option value="<?php echo $depto['id'] ?>"><?php echo $depto['nombre'] ?></option>
          <?php
            }
          ?>
        </select>
      </div>
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
      <div class="form-group">
        <label for="marca">Marcas</label>
        <select class="form-control" name="marca" id="filtro_marca">
          <option value="">Marca</option>
          <?php
            while ($marca = $marcas->fetch_assoc()) {
          ?>
            <option value="<?php echo $marca['id'] ?>"><?php echo $marca['nombre'] ?></option>
          <?php
            }
          ?>
        </select>
      </div>
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
      <div class="form-group">
        <label for="modelos">Modelos</label>
        <select class="form-control" name="modelos" id="filtro_modelos">
          <option value="">Modelos</option>
          <?php
            while ($modelo = $modelos->fetch_assoc()) {
          ?>
            <option value="<?php echo $modelo['id'] ?>"><?php echo $modelo['nombre'] ?></option>
          <?php
            }
          ?>
        </select>
      </div>
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
      <div class="form-group">
        <label for="garantia">Garantia</label>
        <input type="date" name=garantia"" id="filtro_garantia" value="" class="form-control">
      </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
      <div class="form-group">
        <label for="garantia"></label>
          <button type="button" name="filter" class="btn btn-info" onclick=" cargarTabla()"> <i class="fa fa-search fa-lg"></i> </button>
          <button type="button" name="report-excel" id="report-excel" class="btn btn-success"> <i class="fa fa-file-excel fa-lg"></i></button>
          <button type="button" name="report-pdf" id="report-pdf" class="btn btn-danger"> <i class="fa fa-file-pdf fa-lg "></i> </button>
        </div>
    </div>
  </div>
</form>
