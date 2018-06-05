<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/Conexion.php';

Class Persona
{
    //Implementamoa nuestro constructor
    public function __construct(){

    }

    //Implementamos un método para insertar registros
    public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email){
        $sql = "INSERT INTO persona (tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) 
                VALUES ('$tipo_persona', '$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email){
        $sql = "UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre', tipo_documento='$tipo_documento', 
                 num_documento='$num_documento', direccion='$direccion', telefono='$telefono', email='$email' 
                WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para desactivar categorías
    public function eliminar($idpersona){
        $sql = "DELETE FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para listar un registro
    public function mostrar($idpersona){
        $sql = "SELECT * FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar para listar todos los registros
    public function listarP(){
        $sql = "SELECT * FROM persona WHERE tipo_persona='Proveedor'";
        return ejecutarConsulta($sql);
    }

    //Implementar para listar todos los registros
    public function listarC(){
        $sql = "SELECT * FROM persona WHERE tipo_persona='Cliente'";
        return ejecutarConsulta($sql);
    }
}


?>