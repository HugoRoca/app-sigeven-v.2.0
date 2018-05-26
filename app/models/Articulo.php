<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/Conexion.php';

Class Articulo
{
    //Implementamoa nuestro constructor
    public function __construct(){

    }

    //Implementamos un método para insertar registros
    public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
        $sql = "INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion) 
                VALUES ('$idcategoria', '$codigo', '$nombre', '$stock', '$descripcion', '$imagen','1')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen){
        $sql = "UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre', 
                    stock='$stock', descripcion='$descripcion', imagen='$imagen' 
                WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para desactivar
    public function desactivar($idarticulo){
        $sql = "UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar
    public function activar($idarticulo){
        $sql = "UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para listar un registro
    public function mostrar($idarticulo){
        $sql = "SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar para listar todos los registros
    public function listar(){
        $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, 
                    a.nombre, a.stock, a.descripcion, a.imagen, a.condicion 
                FROM articulo a 
                INNER JOIN categoria c on a.idcategoria = c.idcategoria";
        return ejecutarConsulta($sql);
    }
}


?>