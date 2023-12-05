<?php
require_once('Conexion/Conexion.php');
$con = new conexionPDO();
?>

<head>
    <link rel="icon" href="IMAGE/LOGO.png" />
    <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="JS/funciones.js"></script>
</head>

<body style="font-size: 14px; background-image: url(IMAGE/session/fondo.gif); background-size: 100% 100%;">


    <style>
        ul li {
            margin: 10px 0;
        }
    </style>
    <style>
        .login {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }

        #sha {
            max-width: 340px;
            -webkit-box-shadow: 0px 0px 18px 0px rgba(48, 50, 50, 0.48);
            -moz-box-shadow: 0px 0px 18px 0px rgba(48, 50, 50, 0.48);
            box-shadow: 0px 0px 18px 0px rgba(48, 50, 50, 0.48);
            border-radius: 6%;
        }
    </style>
    <title>Inicio de sesion</title>


    <div class="container well" id="sha" style="margin-top:200px;margin-bottom:70px; background-color:#FFF; opacity: 0.9;">
        <form class="login" id="form" name="form" action="javaScript:ingresar()" method="POST">
            <h3 align="center" style="margin-bottom: 10px; margin-right: 4px; margin-left: 4px;margin-top:-8px">Inicio de Sesión</h3>

            <div class="form-group" style="margin-top: -10px">
                <label class="control-label">
                    <strong class="obligado">*</strong>Usuario:
                </label>
                <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Usuario" onkeypress="return txtValidas(event,'car')" required="" title="Ingrese usuario" autofocus="">
            </div>
            <div class="form-group" style="margin-top: -10px">
                <label class="control-label">
                    <strong class="obligado">*</strong>Contraseña:
                </label>
                <input type="password" class="form-control" name="txtPass" id="txtPass" placeholder="Contraseña" onkeypress="return txtValidas(event,'num')" required="" title="Ingrese contraseña">
            </div>
            <div class="form-group" style="margin-top: -10px">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesión</button>
            </div>
            <div class="form-group" style="margin-top: -10px">
                <label class="control-label">
                    <a href="RegistrarUsuario.php" style="margin-left:100px"> Registrar Usuario</a>
                </label>
            </div>
        </form>
    </div>
    



    <script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>


    <?php require_once 'footer.php'; ?>
</body>

<script>


    function ingresar() {
        jsShowWindowLoad('Validando Datos ...');
        if ($("#txtUsuario").val() != "" && $("#txtPass").val() != "") {
            var formData = new FormData($("#form")[0]);
            $.ajax({
                type: 'POST',
                url: "json/SessionJson.php?action=1",
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    jsRemoveWindowLoad();
                    let resultado = JSON.parse(response);
                    let rta = resultado["rta"];
                    // let txt = capitalizarPrimeraLetra(resultado["msj"]);
                    let txt = capitalizarPrimeraLetraDeCadaPalabra(resultado["msj"]);

                    if (rta == 1) {
                        $("#modal-title").html('Bienvenido   ' + txt);
                        $("#mensaje").html('Inicio de Sesion Correctamente');
                        $("#modalRespuestas").modal("show");
                        $("#Aceptar").click(function() {
                            $("#modalRespuestas").modal("hide");
                            var formData = new FormData($("#form")[0]);

                            document.location = 'index2.php';
                        })

                    } else if (rta == 2) {
                        $("#modal-title").html('');
                        $("#mensaje").html('Usuario y/o contraseña erronea');
                        $("#modalRespuestas").modal("show");
                        $("#Aceptar").click(function() {
                            $("#modalRespuestas").modal("hide");
                        })

                    }
                }
            });
        }


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