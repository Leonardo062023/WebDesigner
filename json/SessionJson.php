<?php
session_start();
require_once('../Conexion/Conexion.php');
$con = new conexionPDO();
$action = $_REQUEST['action'];
$usuario =$_REQUEST['txtUsuario'];
$clave = $_REQUEST['txtPass'];
switch ($action) {
    case 1:
        $sqlclave = $con->Listar("SELECT clave, usuario  FROM empleado where LOWER(usuario) = '$usuario'");
        
        if ($clave == $sqlclave[0][0]) {
            $usuario = $sqlclave[0][1];
            $datos = array("rta" => 1,"msj" => $usuario);
            $_SESSION['usuario'] = $usuario;
            echo json_encode($datos);
        }else{
            $datos = array("rta" => 2,"msj" => "NA");
            echo json_encode($datos);
        }
        break;
    
    case 2:
        # code...
        break;
}
?>