<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["compras"] == 1) {

?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Compras
      </h1>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Ingreso
                            <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <div class="panel-body table-responsive" id="listadoRegistros">
                        <table id="tblListado" class="table table-hover table-bordered table-condensed table-striped">
                            <thead>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Documento</th>
                                <th>Número</th>
                                <th>Total Compra</th>
                                <th>Estado</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Documento</th>
                                <th>Número</th>
                                <th>Total Compra</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioMostrar">
                        <form>
                            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Proveedor(*):</label>
                                <select name="idproveedorMostrar" id="idproveedorMostrar" class="form-control selectpicker" disabled></select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date" class="form-control" name="fecha_horaMostrar" id="fecha_horaMostrar" disabled>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo Comprobante(*):</label>
                                <select name="tipo_comprobanteMostrar" id="tipo_comprobanteMostrar" class="form-control selectpicker" disabled>
                                    <option value="">--Seleccione--</option>
                                    <option value="Boleta">Boleta</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Ticket">Ticket</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Serie(*):</label>
                                <input type="text" class="form-control" name="serie_comprobanteMostrar" id="serie_comprobanteMostrar" disabled>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Número(*):</label>
                                <input type="text" class="form-control" name="num_comprobanteMostrar" id="num_comprobanteMostrar" disabled>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Impuesto(*):</label>
                                <input type="text" class="form-control" name="impuestoMostrar" id="impuestoMostrar" disabled>
                            </div>
                            <div id="tableMostrar" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table id="detallesMostrar" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color: #A9D0F5">
                                        <th>Artículo</th>
                                        <th>Cantidad</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-danger" onclick="cancelarForm()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>

                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Proveedor(*):</label>
                                <input type="hidden" name="idingreso" id="idingreso">
                                <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required></select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" autocomplete="off" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo Comprobante(*):</label>
                                <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                                    <option value="">--Seleccione--</option>
                                    <option value="Boleta">Boleta</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Ticket">Ticket</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Serie(*):</label>
                                <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" autocomplete="off" required maxlength="7" placeholder="Serie">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Número(*):</label>
                                <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" autocomplete="off" required maxlength="10" placeholder="Número">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Impuesto(*):</label>
                                <input type="text" class="form-control" name="impuesto" id="impuesto" autocomplete="off" required maxlength="10" placeholder="Impuesto">
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal" href="#myModal">
                                    <button type="button" id="btnAgregaArt" class="btn btn-primary">
                                        <span class="fa fa-plus"></span> Agregar Artículos
                                    </button>
                                </a>
                            </div>
                            <div id="tableInsertar" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color: #A9D0F5">
                                        <th>Opciones</th>
                                        <th class="text-center">Artículo</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Precio Compra</th>
                                        <th class="text-center">Precio Venta</th>
                                        <th class="text-center">Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right"><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarForm()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Seleccione un Artículo</h4>
            </div>
            <div class="modal-body">
                <table id="tblArticulos" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </thead>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
}
else{
    require 'noacceso.php';
}
    require 'footer.php';
?>

<script src="scripts/ingreso.js"></script>
<?php
}

ob_end_flush();

?>