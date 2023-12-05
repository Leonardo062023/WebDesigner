<?php
require_once('../Conexion/Conexion.php');
require_once('../Funciones/funcionesPro.php');
$con = new conexionPDO();
$action = $_REQUEST['action'];
switch ($action) {
    case 1:

        $Proveedor = $_REQUEST['txtProveedor'];
        $bdp = validarBd($Proveedor);
        $Nit = $_REQUEST['txtNit'];
        if ($bdp == 1) {
            //registro en la base de datos 

            $sql_cons  = "INSERT INTO proveedores (Nombre,Nit) VALUES (:Nombre,:Nit)";
            $sql_dato = array(
                array(":Nombre", $Proveedor),
                array(":Nit", $Nit),
            );
            $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
            if (empty($obj_resp)) {
                echo 1;
            } else {
                echo 2;
            }
            
        } else {
            echo 3;
        }
        break;
    case 2:

        $id = $_REQUEST['id'];
        $Proveedor = $_REQUEST['txtProveedor'];
        $Nit = $_REQUEST['txtNit'];

        //Consulta nueva
        $sql_cons = "UPDATE proveedores SET Nombre=:Nombre, Nit=:Nit WHERE id=:id";

        $sql_dato = array(
            array(":Nombre", $Proveedor),
            array(":Nit", $Nit),
            array(":id", $id),
        );
        $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
        if (empty($obj_resp)) {
            echo 1;
        } else {
            echo 2;
        }
        break;

    case 3:
        $id = $_REQUEST['id'];
        //Si no existe el registro como predecesor se elimina.

        $sql_cons = "DELETE FROM proveedores WHERE id = :id";
        $sql_dato = array(
            array(":id", $id)
        );
        $resp = $con->InAcEl($sql_cons, $sql_dato);
        if (empty($resp)) {
            echo 1;
        } else {
            echo 2;
        }
        break;
}
