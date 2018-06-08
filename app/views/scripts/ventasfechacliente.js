var tabla;

function init() {
    listar();
    $.post("../ajax/venta.php?op=selectCliente", function(r){
		$("#idcliente").html(r);
		$('#idcliente').selectpicker('refresh');
	});	
}

//function listar
function listar() {
    var fecha_inicio = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val();
    var idcliente = $('#idcliente').val();

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
            url: '../ajax/consultas.php?op=ventasFechaCliente',
            data: {fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, idcliente: idcliente},
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


init();