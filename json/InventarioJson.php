<?php
require_once('../Conexion/Conexion.php');
require_once('../Funciones/funcionesInv.php');
$con = new conexionPDO();
$action = $_REQUEST['action'];
switch ($action) {
    case 1:

        $Producto = $_REQUEST['txtProducto'];
        $Proveedor = $_REQUEST['txtProveedor'];
        $bdp = validarBd($Producto, $Proveedor);
        if ($bdp == 1) {


            $Cantidad = $_REQUEST['txtCantidad'];
            $FechaIng = $_REQUEST['txtFechaIngreso'];
            $FechaExp = $_REQUEST['txtFechaExpi'];
            if (empty($FechaExp)) {
                $FechaExp = "0000-00-00";
            }

            $ValorU = $_REQUEST['txtValorU'];



            //registro en la base de datos 

            $sql_cons  = "INSERT INTO INVENTARIO (Nombre,Cantidad,Fecha_ingreso,Fecha_exp,Proveedores,Valor) 
            VALUES (:Nombre,:Cantidad,:Fecha_ingreso,:Fecha_exp,:Proveedores,:Valor)";
            $sql_dato = array(
                array(":Nombre", $Producto),
                array(":Cantidad", $Cantidad),
                array(":Fecha_ingreso", $FechaIng),
                array(":Fecha_exp", $FechaExp),
                array(":Proveedores", $Proveedor),
                array(":Valor", $ValorU),
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
        $Producto = $_REQUEST['txtProducto'];
        $CantidadBod = $_REQUEST['txtCantidad'];
        $FechaIng = $_REQUEST['txtFechaIngreso'];
        $FechaExp = $_REQUEST['txtFechaExpi'];
        if (empty($FechaExp)) {
            $FechaExp = "0000-00-00";
        }
        $Proveedor = $_REQUEST['txtProveedor'];
        $ValorU = $_REQUEST['txtValorU'];
        $Adicional = $_REQUEST['txtAdicional'];
        $Operacion = $_REQUEST['Sltopera'];
        if (empty($Adicional)) {
            $Adicional = 0;
        }
        if ($Operacion == '+') {
            $Cantidad = $CantidadBod + $Adicional;
        } elseif ($Operacion == '-') {
            $Cantidad = $CantidadBod - $Adicional;
        }

        //Consulta nueva
        $sql_cons = "UPDATE inventario 
          SET Nombre=:Nombre,Cantidad=:Cantidad,Fecha_ingreso=:Fecha_ingreso,Fecha_exp=:Fecha_exp,Proveedores=:Proveedores,Valor=:Valor
         WHERE id=:id";

        $sql_dato = array(
            array(":Nombre", $Producto),
            array(":Cantidad", $Cantidad),
            array(":Fecha_ingreso", $FechaIng),
            array(":Fecha_exp", $FechaExp),
            array(":Proveedores", $Proveedor),
            array(":Valor", $ValorU),
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

        $sql_cons = "DELETE FROM inventario WHERE id = :id";
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
