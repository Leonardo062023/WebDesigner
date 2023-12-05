<?php

require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
$action = $_REQUEST["action"];
if ($action == 1) {

    $title = "Agregar Producto";
    $accion = "javascript:agregar();";
} else {
    $id = ((base64_decode($_REQUEST["id"])));
    $title = "Modificar Producto";
    $accion = "javascript:modificar();";
    $sql = $con->Listar("SELECT inv.*, pro.nombre 
    FROM Inventario inv 
    INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id= $id");
    $id = $sql[0][0];
    $Producto = $sql[0][1];
    $Cantidad = $sql[0][2];
    $FechaIng = $sql[0][3];
    $FechaExp = $sql[0][4];
    $ValorU = $sql[0][5];
    $Proveedor = $sql[0][7];
}
?>
<style>
    /* Estilo para el select */
    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        color: #333;
        width: 200px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    /* Estilo para el select cuando está enfocado */
    select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Estilo para el select al pasar el mouse */
    select:hover {
        background-color: #f2f2f2;
    }

    /* Estilo para las opciones del select */
    select option {
        background-color: #fff;
        color: #333;
        padding: 5px;
    }

    /* Estilo para las opciones del select al pasar el mouse */
    select option:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>
<link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="JS/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
<title><?php echo $title ?></title>
</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 35px;">
    <div class="container-fluid text-center">
        <div class="row content" style="margin-top: 1px;">
            <div class="col-sm-10 text-center">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <?php echo $title ?></h2>

                <div style="margin-top: -10px;width: 50%; border: 4px solid #020324; border-radius: 10px; margin: 0 auto; display: flex; align-items: center; justify-content: center;" class="client-form">
                    <form name="form" id="form" class="form-horizontal" action="<?php echo $accion; ?>">
                        <?php
                        if ($action == 2) { ?>
                            <input type="hidden" name="id" value="<?php echo $id  ?>">
                        <?php
                        }
                        ?>
                        <p align="center" style="margin-bottom: 15px; margin-top: 20px;margin-left: 30px; font-size: 80%">Los campos
                            marcados con <strong class="obligado">*</strong> son obligatorios.</p>

                        <!----------Campo para llenar Producto-->
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Producto" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Producto:</label>
                            <input type="text" name="txtProducto" id="txtProducto" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $Producto ?>" title="Nombre del Producto"  placeholder="Nombre del Producto" required>

                        </div>
                        <!----------Fin Campo Producto-->
                        <!----------Campo para llenar Cantidad-->
                        <div style="margin-top: 10px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Cantidad" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Cantidad:</label>
                            <?php if ($action == 1) { ?>
                                <input type="text" name="txtCantidad" id="txtCantidad" style="width: 80px;" class="form-control" maxlength="100" value="<?php echo $Cantidad ?>" title="Cantidad" onkeypress="return txtValidas(event,'num')" placeholder="Cantidad" required>
                            <?php  } else { ?>
                                <input type="text" name="txtCantidad" id="txtCantidad" style="width: 80px;" class="form-control" maxlength="100" value="<?php echo $Cantidad ?>" title="Cantidad" onkeypress="return txtValidas(event,'num')" placeholder="Cantidad" required readonly>

                                <select name="Sltopera" id="Sltopera" style="border: 0px;margin-left: 10px;margin-right: 10px;" title="Operación">
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                </select>
                                <input type="text" name="txtAdicional" id="txtAdicional" style="width: 80px;" class="form-control" maxlength="100" value="" title="Adicional" onkeypress="return txtValidas(event,'num')" placeholder="">
                            <?php } ?>


                        </div>
                        <!----------Fin Campo Cantidad-->
                        <!----------Campo para llenar FechaIngreso-->
                        <div style="margin-top: 5px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Fecha Ingreso" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Fecha Ingreso:</label>
                            <input type="date" name="txtFechaIngreso" id="txtFechaIngreso" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $FechaIng ?>" title="Fecha Ingreso" placeholder="Fecha Ingreso" required>

                        </div>
                        <!----------Fin Campo FechaIngreso-->

                        <!----------Campo para llenar FechaExpi-->
                        <div style="margin-top: 1px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Fecha Expiracion" style="margin-right: 50px;" class="col-sm-5 control-label">Fecha Expiracion:</label>
                            <input type="date" name="txtFechaExpi" id="txtFechaExpi" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $FechaExp ?>" title="Fecha Expiracion" placeholder="Fecha Expiracion">

                        </div>
                        <!----------Fin Campo FechaExpi-->

                        <!----------Campo para llenar Proveedor-->
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Proveedor" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Proveedor:</label>
                            <select name="txtProveedor" id="txtProveedor" required>

                                <?php
                                $sqlprov = $con->Listar("SELECT *FROM proveedores");
                                foreach ($sqlprov as $prov) { ?>
                                    <option value="<?php echo $prov[0] ?>"><?php echo $prov[1] ?></option>
                                <?php   } ?>


                            </select>


                        </div>
                        <!----------Fin Campo Proveedor-->

                        <!----------Campo para llenar ValorU-->
                        <div style="margin-top: 1px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="ValorU" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Valor Unitario:</label>
                            <input type="text" name="txtValorU" id="txtValorU" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $ValorU ?>" title="Valor por Unidad" onkeypress="return txtValidas(event,'num')" placeholder="$" required>

                        </div>
                        <!----------Fin Campo ValorU-->

                        <div class="form-group" style="margin-top: 10px;">
                            <label for="no" class="col-sm-5 control-label"></label>
                            <button type="submit" class="btn btn-primary sombra" style=" margin-top: 10px; margin-bottom: 10px; margin-left: 0px;">Guardar</button>
                        </div>


                    </form>
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <div class="col-sm-12 text-center" style="margin-left: -60%;">

                    <header style="background-color: #333; color: #fff; padding: 10px; text-align: right; ">
                        <h4 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Información adicional</h4>

                        <nav style="background-color: #eee; padding: 10px;border-radius: 7px;">
                            <ul style="list-style-type: none; margin: 0; padding: 0; text-align: center;">
                                <li ><a href="ModificarProveedor.php?action=1" style="text-decoration: none; color: #333;">Proveedores</a></li>
                                
                            </ul>
                        </nav>
                    </header>
                </div>
            </div>


        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
<script>
    function agregar() {
        //  Obtén el elemento input por su ID
        var inputElement = document.getElementById('txtProducto');
        // Obtiene el valor del input
        var valorInput = inputElement.value;
        jsShowWindowLoad('Agregando Datos ...');

        var formData = new FormData($("#form")[0]);
        $.ajax({
            type: 'POST',
            url: "json/InventarioJson.php?action=1",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                jsRemoveWindowLoad();
                // alert(response);
                // console.log(response);
                if (response == 1) {
                    $("#mensaje").html('Información agregada Correctamente');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                        document.location = 'Inventario.php';
                    })

                } else if (response == 2) {
                    $("#mensaje").html('No Se Ha Podido Agregar Información');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                    })

                } else {
                    $("#mensaje").html('Este Producto  ' + valorInput + ' ya existe en el inventario');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                        document.location = 'Inventario.php';
                    })
                }
            }
        });

    }

    function modificar() {
        jsShowWindowLoad('Modificando Datos ...');
        var formData = new FormData($("#form")[0]);
        $.ajax({
            type: 'POST',
            url: "json/InventarioJson.php?action=2",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // alert(response);
                jsRemoveWindowLoad();
                // console.log(response);
                if (response == 1) {
                    $("#mensaje").html('Información Modificada Correctamente');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                        document.location = 'Inventario.php';
                    })
                } else {
                    // $("#modal-title").html('');
                    $("#mensaje").html('No Se Ha Podido Modificar Información');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                    })

                }
            }
        });
    }
</script>
<script type="text/javascript" src="js/select2.js"></script>
<script type="text/javascript">
    $("#txtProveedor").select2();
</script>

<div class="modal fade" id="modalRespuestas" role="dialog" align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="forma-modal" class="modal-header">
                <h4 class="modal-title" id="modal-title" style="font-size: 24; padding: 3px;"></h4>
            </div>
            <div class="modal-body" style="margin-top: 8px">
                <label id="mensaje" name="mensaje" style="font-weight: normal"></label>
            </div>
            <div id="forma-modal" class="modal-footer">
                <button type="button" id="Aceptar" class="btn" style="color: #000; margin-top: 2px" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>