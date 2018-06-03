<?php

require_once '../models/Ingreso.php';

if (strlen(session_id()) < 1) {
    session_start();
}

$ingreso = new Ingreso();

$idingreso = isset($_POST["idingreso"]) ? limpiarCadena($_POST["idingreso"]) : "";
$idproveedor = isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "";
$idusuario = $_SESSION["idusuario"];
$tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";
$serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
$num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$impuesto = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]) : "";
$total_compra = isset($_POST["total_compra"]) ? limpiarCadena($_POST["total_compra"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idingreso)) {
            $rspta = $ingreso->insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_compra, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_compra"], $_POST["precio_venta"]);
            echo $rspta ? "Ingreso registrado" : "No se pudieron registrar los ingresos";
        }
        break;
    case 'anular':
        $rspta = $ingreso->anular($idingreso);
        echo $rspta ? "Ingreso anulado" : "No se puedo anular el ingreso";
        break;
    case 'mostrar':
        $rspta = $ingreso->mostrar($idingreso);
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $ingreso->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0"=>($reg->estado == 'Aceptado') ? '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-pencil"></i></button> '.
                    '<button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>' : 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->proveedor,
                "3"=>$reg->usuario,
                "4"=>$reg->tipo_comprobante,
                "5"=>$reg->serie_comprobante . '-' . $reg->num_comprobante,
                "6"=>$reg->total_compra,
                "7"=>($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</<span>' : '<span class="label bg-red">Anulado</<span>'
            );
        }

        $results = array(
            "sEcho"=>1, //información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total de registro a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);

        break;
    case 'selectProveedor':
        require_once '../models/Persona.php';
        $persona = new Persona();

        $rspt = $persona->listarP();

        $result = '';
        
        while ($reg = $rspt->fetch_object()) {
            $result = '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>' . $result;
        }

        echo '<option value="">--Seleccione--</option>' . $result;

        break;
    case 'listarActiculos':
        require_once '../models/Articulo.php';
        $articulo = new Articulo();

        $rspta = $articulo->listarActivos();

        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>'<img src="../Files/Articulos/'.$reg->imagen.'" height="50px" width="50px">'
            );
        }

        $results = array(
            "sEcho"=>1, //información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total de registro a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);
        break;
}

?>