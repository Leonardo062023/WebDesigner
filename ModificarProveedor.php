<?php

require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
$action = $_REQUEST["action"];
if ($action == 1) {

    $title = "Agregar Proveedor";
    $accion = "javascript:agregar();";
} else {
    $id = ((base64_decode($_REQUEST["id"])));
    $title = "Modificar Proveedor";
    $accion = "javascript:modificar();";
    $sql = $con->Listar("SELECT * FROM Proveedores where id = $id");
    $id = $sql[0][0];
    $Proveedor = $sql[0][1];
    $Nit = $sql[0][2];
}
?>
<link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="JS/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
<title><?php echo $title ?></title>
</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 35px;">
    <div class="container-fluid text-center">
        <div class="row content" style="margin-top: 1px;">
            <div class="col-sm-12 text-center">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <?php echo $title ?></h2>

                <div class="client-form" style="margin-top: -10px;width: 50%; border: 4px solid #020324; border-radius: 10px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                    <form name="form" id="form" class="form-horizontal" action="<?php echo $accion; ?>">
                        <?php
                        if ($action == 2) { ?>
                            <input type="hidden" name="id" value="<?php echo $id  ?>">
                        <?php
                        }
                        ?>
                        <p align="center" style="margin-bottom: 15px; margin-top: 20px;margin-left: 30px; font-size: 80%">Los campos
                            marcados con <strong class="obligado">*</strong> son obligatorios.</p>
                        <!----------Campo para llenar Nit-->
                        <div style="margin-top: 10px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Nit" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Nit:</label>
                            <input type="text" name="txtNit" id="txtNit" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $Nit ?>" onkeypress="return txtValidas(event,'num')" title="Nit" placeholder="Nit" required>
                        </div>
                        <!----------Fin Campo Nit-->
                        <!----------Campo para llenar Proveedor-->
                        <div style="margin-top: 10px;display: flex; align-items: center; justify-content: space-between; width: 50%;">
                            <label for="Proveedor" style="margin-right: 50px;" class="col-sm-5 control-label"><strong class="obligado">*</strong>Nombre:</label>
                            <input type="text" name="txtProveedor" id="txtProveedor" style="width: 250px;" class="form-control" maxlength="100" value="<?php echo $Proveedor ?>" title="Nombre del proveedor" placeholder="Nombre del Proveedor" required>

                        </div>
                        <!----------Fin Campo Proveedor-->

                        <div class="form-group" style="margin-top: 10px;">
                            <label for="no" class="col-sm-5 control-label"></label>
                            <button type="submit" class="btn btn-primary sombra" style=" margin-top: 10px; margin-bottom: 10px; margin-left: 0px;">Guardar</button>
                        </div>


                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
<script>
    function agregar() {
        //  Obtén el elemento input por su ID
        var inputElement = document.getElementById('txtProveedor');
        // Obtiene el valor del input
        var valorInput = inputElement.value;
        jsShowWindowLoad('Agregando Datos ...');

        var formData = new FormData($("#form")[0]);
        $.ajax({
            type: 'POST',
            url: "json/ProveedorJson.php?action=1",
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
                        window.history.back();
                    })

                } else if (response == 2) {
                    $("#mensaje").html('No Se Ha Podido Agregar Información');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                    })

                } else {
                    $("#mensaje").html('El Proveedor  ' + valorInput + ' ya existe');
                    $("#modalRespuestas").modal("show");
                    $("#Aceptar").click(function() {
                        $("#modalRespuestas").modal("hide");
                        document.location = 'Proveedor.php';
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
            url: "json/ProveedorJson.php?action=2",
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
                        document.location = 'Proveedor.php';
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