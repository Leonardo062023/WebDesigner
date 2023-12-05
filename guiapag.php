<?php
require_once('../Conexion/Conexion.php');
$con = new conexionPDO();
require_once '../menu.php';
$usuario = $_SESSION['usuario'];

?>
<title>Inventario</title>
</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-size: 100% 800px;">
    <div class="container-fluid text-center">
        <div class="row content" style="margin-top: 1px;">
            <div class="col-sm-12 text-left">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> CONTACTENOS MEDIANTE</h2>

            </div>

        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>


<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>