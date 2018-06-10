<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["acceso"] == 1) {
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Usuario
        <small>Listado y registro</small>
      </h1>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Usuario
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
                                <th>Documento</th>
                                <th>Número</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Estado</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Número</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioRegistros">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre(*):</label>
                                <input type="hidden" name="idusuario" id="idusuario">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo Documento(*):</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control selectpicker" required>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEDULA">CEDULA</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Número Documento(*):</label>
                                <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Número documento" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Dirección:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Descripción" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="email" id="email" maxlength="20" placeholder="Email" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Cargo:</label>
                                <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Login(*):</label>
                                <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" autocomplete="off" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>clave(*):</label>
                                <input type="password" class="form-control" name="clave" id="clave" maxlength="20" placeholder="Clave" autocomplete="off" required>
                                <span id="spanPass" style="color: red; display: none;">*Debe de volver a escribir la contraseña</span>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Permisos:</label>
                                <ul id="permisos" style="list-style: none;">
                                </ul>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen:</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="150px" id="imagenmuestra">
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
<script src="scripts/usuario.js"></script>
<?php
}

ob_end_flush();

?>