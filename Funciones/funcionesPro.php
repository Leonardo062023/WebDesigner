<?php 
function buscaempresa($id) {
    global $con;
    $sql = $con->Listar("SELECT empl.empresa FROM empleado empl where empl.usuario= '$id'");
    $empre = $sql[0][0];
    return $empre;
}
function validarBd($Proveedor){
    global $con;
    $bdp=$con->Listar("SELECT Nombre  FROM proveedores where  nombre = '$Proveedor'");
    if (empty($bdp)) {
        return 1;
    }else{
        return 2;
    }

}



?>