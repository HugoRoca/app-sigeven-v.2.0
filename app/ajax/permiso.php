<?php

require_once '../models/Permiso.php';

$permiso = new Permiso();

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $permiso->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0"=>$reg->nombre
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