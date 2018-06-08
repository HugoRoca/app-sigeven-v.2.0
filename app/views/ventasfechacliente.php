<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["consultav"] == 1) {

?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Consulta
        <small>Listado</small>
      </h1>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Consulta de ventas por fecha y cliente
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente</label>
                            <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true"></select>
                            <button class="btn btn-success" onclick="listar()">Mostar</button>
                        </div>
                        <table id="tblListado" class="table table-hover table-bordered table-condensed table-striped">
                            <thead>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Comprobante</th>
                                <th>Número</th>
                                <th>Total Compra</th>
                                <th>Impuesto</th>
                                <th>Estado</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Comprobante</th>
                                <th>Número</th>
                                <th>Total Compra</th>
                                <th>Impuesto</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
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

<script src="scripts/ventasfechacliente.js"></script>
<?php
}

ob_end_flush();

?>