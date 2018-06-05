var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e){
        guardarEditar(e);	
    });

    //Cargamos los items al select proveedor
    $.post('../ajax/ingreso.php?op=selectProveedor', function(r){
        $('#idproveedor').html(r);
        $('#idproveedor').selectpicker('refresh');
        $('#idproveedorMostrar').html(r);
        $('#idproveedorMostrar').selectpicker('refresh');
    });
}

//función limpiar
function limpiar() {
    $('#idproveedor').val('');
    $("#idproveedor").selectpicker('refresh');
    $('#proveedor').val('');
    $('#serie_comprobante').val('');
    $('#num_comprobante').val('');
    $('#fecha_hora').val('');
    
    $('#impuesto').val('');
    $('#total_compra').val('');
    $('.filas').remove();
    $('#total').val(0);
    $('#total_compra').val(0);

    var now = new Date();
    var day = ('0' + now.getDate()).slice(-2);
    var month = ('0' + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + '-' + (month) + '-' + (day);
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $('#tipo_comprobante').val('');
    $('#tipo_comprobante').selectpicker('refresh');
}

//función mostrar formulario
function mostrarForm(flag, nuevo) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#formularioMostrar').hide();
        //$('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
        listarActiculos();
        $('#btnGuardar').hide();
        $('#btnCancelar').show();
        detalle = 0;
        $('#btnAgregaArt').show();
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
        $('#formularioMostrar').hide();
        $('#btnAgregar').show();
    }
}

//functión cancelarForm
function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

//function listar
function listar() {
    tabla = $('#tblListado').dataTable({
        'aProcessing': true, //activamos el procesamiento del datatable
        'aServerSide': true, //paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        'ajax': {
            url: '../ajax/ingreso.php?op=listar',
            type: 'get',
            dataType: 'json',
            error: function e() {
                console.log(e.responseText);
            }},
        'bDestroy': true,
        'iDisplayLength': 10, //paginación
        'order': [[0, 'desc']] //ordenar (columns, orden)
    }).DataTable();
}

//function listar articulos
function listarActiculos() {
    tabla = $('#tblArticulos').dataTable({
        'aProcessing': true, //activamos el procesamiento del datatable
        'aServerSide': true, //paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [],
        'ajax': {
            url: '../ajax/ingreso.php?op=listarActiculos',
            type: 'get',
            dataType: 'json',
            error: function e() {
                console.log(e.responseText);
            }},
        'bDestroy': true,
        'iDisplayLength': 5, //paginación
        'order': [[0, 'desc']] //ordenar (columns, orden)
    }).DataTable();
}

function guardarEditar(e) {
    e.preventDefault(); //No se activará la acción predeterminado del evento
    //$('#btnGuardar').prop('disabled', true);
    modificarSubtotales();

    var formData = new FormData($('#formulario')[0]);

    $.ajax({
        url: '../ajax/ingreso.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            listar();
        }
    });

    limpiar();
}

function mostrar(idingreso) {
    $('#formularioMostrar').show();
    $('#listadoRegistros').hide();
    $.post('../ajax/ingreso.php?op=mostrar', {idingreso: idingreso}, function(data){
        data = JSON.parse(data);
        //mostrarForm(true);
        $('#idproveedorMostrar').val(data.idproveedor);
        $('#idproveedorMostrar').selectpicker('refresh');
        $('#tipo_comprobanteMostrar').val(data.tipo_comprobante);
        $('#tipo_comprobanteMostrar').selectpicker('refresh');
        $('#serie_comprobanteMostrar').val(data.serie_comprobante);
        $('#num_comprobanteMostrar').val(data.num_comprobante);
        $('#fecha_horaMostrar').val(data.fecha);
        $('#impuestoMostrar').val(data.impuesto);
        $('#idingresoMostrar').val(data.idingreso);
        
        $.post('../ajax/ingreso.php?op=listarDetalle&id=' + idingreso, function(r){
            $('#detallesMostrar').html(r);
        });
    });
}

//Funcion para anular registros
function anular(idingreso) {
    bootbox.confirm('¿Está seguro de anular el ingreso?', function(result){
        if(result){
            $.post('../ajax/ingreso.php?op=anular', {idingreso: idingreso}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//Declaracion de variables necesarias para trabajar con las compras y sus detalles
var impuesto = 18;
var cont = 0;
var detalle = 0;

$('#btnGuardar').hide();
$('#tipo_comprobante').change(marcarImpuesto);

function marcarImpuesto(){
    var tipo_comprobante = $('#tipo_comprobante option:selected').text();

    if (tipo_comprobante == 'Factura') {
        $('#impuesto').val(impuesto);
    }else{
        $('#impuesto').val('0');
    }

    $('#serie_comprobante').focus();
}

function agregarDetalle(idarticulo, articulo){
    var cantidad = 1;
    var precio_compra = 0;
    var precio_venta = 0;

    if(idarticulo != ''){
        var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila' + cont + '">' +
                        '<td><button type="button" class="btn btn-danger btn-block" onclick="eliminarDetalle(' + cont + ')"><i class="fa fa-trash"></i></button></td>' +
                        '<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
                        '<td><input type="number" autocomplete="off" class="form-control text-center" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
                        '<td><input type="text" autocomplete="off" class="form-control text-right" name="precio_compra[]" id="precio_compra[]" value="' + precio_compra + '" onkeyup="modificarSubtotales();" onkeypress="return SoloDecimalesInputs(event,this);"></td>' +
                        '<td><input type="text" autocomplete="off" class="form-control text-right" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '" onkeypress="return SoloDecimalesInputs(event,this);"></td>' +
                        '<td><h5 class="text-right" name="subtotal" id="subtotal' + cont + '">' + subtotal + '</h5></td>' +
                        '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'
                    '</tr>';
        cont++;
        detalle++;
        $('#detalles').append(fila);
        modificarSubtotales();
    }else{
        alert('Error al ingresar el detalle, revisar los datos del artículo');
    }
}

function modificarSubtotales(){
    var cant = document.getElementsByName('cantidad[]');
    var prec = document.getElementsByName('precio_compra[]');
    var sub = document.getElementsByName('subtotal');

    for (let i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpS = sub[i];

        var r = inpC.value * inpP.value;
        inpS.value = parseFloat(Math.round(r * 100) / 100).toFixed(2);

        document.getElementsByName('subtotal')[i].innerHTML = inpS.value;
    }
    calcularTotales();
}

function calcularTotales(){
    var sub = document.getElementsByName('subtotal');
    var total = 0.0;
    
    for (let i = 0; i < sub.length; i++) {
        total += parseFloat(document.getElementsByName('subtotal')[i].value);        
    }

    $('#total').html('S/. ' + total);
    $('#total_compra').val(total);
    evaluar();
}

function evaluar() {
    if (detalle > 0) {
        $('#btnGuardar').show();
    }else{
        $('#btnGuardar').hide();
        cont = 0;
    }
}

function eliminarDetalle(indice){
    $('#fila' + indice).remove();
    calcularTotales();
    detalle = detalle - 1;
    evaluar();
}

init();