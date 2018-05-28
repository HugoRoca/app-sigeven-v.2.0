var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e){
		guardarEditar(e);	
    });
    
    $.post('../ajax/articulo.php?op=selectCategoria', function(r){
        $('#idcategoria').html(r);
        $('#idcategoria').selectpicker('refresh');
    });

    $('#imagenmuestra').hide();
}

//función limpiar
function limpiar() {
    $('#codigo').val('');
    $('#nombre').val('');    
    $('#descripcion').val('');
    $('#stock').val('');
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#imagen").val("");
    $('#print').hide();
    $('#idarticulo').val('');
}

//función mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
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
            url: '../ajax/articulo.php?op=listar',
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
    $('#btnGuardar').prop('disabled', true);
    var formData = new FormData($('#formulario')[0]);

    $.ajax({
        url: '../ajax/articulo.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}

function mostrar(idarticulo) {
    $.post('../ajax/articulo.php?op=mostrar', {idarticulo: idarticulo}, function(data){
        data= JSON.parse(data);
        mostrarForm(true);

        $('#idcategoria').val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $('#codigo').val(data.codigo);
        $('#nombre').val(data.nombre);
        $('#stock').val(data.stock);
        $('#descripcion').val(data.descripcion);
        $('#imagenmuestra').show();
        $('#imagenmuestra').attr('src', '../Files/Articulos/' + data.imagen);
        $('#imagenactual').val(data.imagen);
        $('#idarticulo').val(data.idarticulo);

        generarBarCode();

    });
}

//Funcion para desactivar registros
function desactivar(idarticulo) {
    bootbox.confirm('¿Está seguro de desactivar el artículo?', function(result){
        if(result){
            $.post('../ajax/articulo.php?op=desactivar', {idarticulo: idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//Funcion para activar registros
function activar(idarticulo) {
    bootbox.confirm('¿Está seguro de activar el artículo?', function(result){
        if(result){
            $.post('../ajax/articulo.php?op=activar', {idarticulo: idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function generarBarCode() {
    codigo = $('#codigo').val();
    JsBarcode('#barCode', codigo);
    $('#print').show();
}

function imprimir() {
    $('#print').printArea();
}

init();