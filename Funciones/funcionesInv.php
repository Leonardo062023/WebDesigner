<?php 
function buscaempresa($id) {
    global $con;
    $sql = $con->Listar("SELECT empl.empresa FROM empleado empl where empl.usuario= '$id'");
    $empre = $sql[0][0];
    return $empre;
}
function validarBd($nombre,$Proveedor){
    global $con;
    $bdp=$con->Listar("SELECT Nombre,Proveedores FROM inventario where Nombre = '$nombre' and Proveedores=$Proveedor");
    if (empty($bdp)) {
        return 1;
    }else{
        return 2;
    }

}

?>