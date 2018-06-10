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

    //Implementar para listar todos los registros activos
    public function listarActivos(){
        $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, 
                    a.nombre, a.stock, a.descripcion, a.imagen, a.condicion 
                FROM articulo a 
                INNER JOIN categoria c on a.idcategoria = c.idcategoria
                WHERE a.condicion = '1'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla ingresodetalle)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,
                    a.codigo,a.nombre,a.stock,(
                        SELECT precio_venta 
                        FROM ingresodetalle 
                        WHERE idarticulo = a.idarticulo 
                        order by idingresodetalle 
                        desc limit 0,1) as precio_venta,
                    a.descripcion,a.imagen,a.condicion 
                FROM articulo a 
                INNER JOIN categoria c ON a.idcategoria = c.idcategoria 
                WHERE a.condicion='1'
                    AND a.stock > 0";
		return ejecutarConsulta($sql);		
	}
}


?>