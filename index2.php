<?php
require_once('Conexion/Conexion.php');
$con = new conexionPDO();
require_once 'menu.php';
$usuario = $_SESSION['usuario'];
$sql = $con->Listar("SELECT em.*  FROM empleado empl LEFT JOIN empresa em ON empl.Empresa = em.Id 
 where empl.usuario = '$usuario'");

$razonsocial = $sql[0][2];
$mision = $sql[0][3];
$vision = $sql[0][4];
$imgEmpre = $sql[0][7];

?>

<style>
    /* tabla */
    .table {
        margin-top: 20px;
        margin-left: 25%;
        width: 50%;
        text-align: center;

    }

    .table thead tr {
        background-color: grey;
    }

    .table thead td {
        text-align: center;
        width: 50%;
    }

    .table tbody td {
        text-align: center;
    }


    /* carrucel */
    h1 {
        text-align: center;
    }

    #carrusel-caja {
        -moz-animation: automatizacion 7s infinite linear;
        -o-animation: automatizacion 7s infinite linear;
        -webkit-animation: automatizacion 7s infinite linear;
        animation: automatizacion 7s infinite linear;

        -webkit-transition: all 0.75s ease;
        -moz-transition: all 0.75s ease;
        -ms-transition: all 0.75s ease;
        -o-transition: all 0.75s ease;
        transition: all 0.75s ease;

        height: 500px;
        width: 300%;
    }

    #carrusel-contenido {
        margin: 0 auto;
        overflow: hidden;
        text-align: left;
    }

    .imagenes {
        border-radius: 25px;
        height: 500px;
        width: 90%;
    }

    .carrusel-elemento {
        text-align: center;
        float: left;
        width: 33.333%;
    }

    @-moz-keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }

    @-webkit-keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }

    @keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }
</style>
<title>Inicio</title>
</head>
<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 36px;">
    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-12 text-left">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <?php echo $razonsocial; ?></h2>
                <div id="carrusel-contenido" style=" margin-top: 25px;">
                    <div id="carrusel-caja">
                        <div class="carrusel-elemento">
                            <img class="imagenes" src="IMAGE/BD/<?php echo $imgEmpre ?>">
                        </div>
                        <!-- <div class="carrusel-elemento">
                        <img class="imagenes" src="IMAGE/imagen2.png">
                    </div> -->

                        <div class="carrusel-elemento">
                            <table id="tabla" class="table table-striped table-condensed" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td class="cabeza">
                                            <h5 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><strong> MISIÓN </strong></h5>
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="campos" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><?php echo $mision ?></td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>
                        <div class="carrusel-elemento">
                            <table id="tabla" class="table table-striped table-condensed" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td class="cabeza">
                                            <h5 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><strong>VISIÓN </strong></h5>
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="campos" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><?php echo $vision ?></td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>

<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>