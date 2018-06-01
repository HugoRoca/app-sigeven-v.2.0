<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["almacen"] == 1) {

?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Categorías
        <small>Listado y registro</small>
      </h1>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Categoría
                            <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-hover table-bordered table-condensed table-striped">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre:</label>
                                <input type="hidden" name="idcategoria" id="idcategoria">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Descripción:</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                <button class="btn btn-danger" onclick="cancelarForm()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>
<?php
}
else{
    require 'noacceso.php';
}
    require 'footer.php';
?>

<script src="scripts/categoria.js"></script>
<?php
}

ob_end_flush();

?>