<?php
session_start();
require_once("../../../db/connection.php");
//include("../../../controller/validarSesion.php");
$db = new Database();
$con = $db->conectar();

$documento= $_SESSION['documento'];
     if (!isset($_SESSION['documento'])) {
       header("Location: ../../../index.php");
       exit;
     }

$identificador = $_GET['id'];

// Obtener la solicitud actual
$sql = $con->prepare("SELECT solicitudes.*, tipo_solicitud.tipo_soli, usuarios.nombre, usuarios.apellido 
                      FROM solicitudes 
                      INNER JOIN tipo_solicitud ON solicitudes.id_tip_soli = tipo_solicitud.id_tip_soli 
                      INNER JOIN usuarios ON solicitudes.documento = usuarios.documento
                      WHERE solicitudes.id_soli = $identificador");
$sql->execute();
$fila = $sql->fetch();

$documento = $fila['documento'];
$nombre = $fila['nombre'];
$apellido = $fila['apellido'];
$descripcion = $fila['descripcion'];
$tipo_soli = $fila['tipo_soli'];
$id_tip_soli = $fila['id_tip_soli'];
$id_estado = 1;

// Declaración de variables de campos en la tabla
if (isset($_POST['responder'])) {

    $respuesta=$_POST['respuesta'];

        if ($respuesta=="")
        {
        echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
    
        }

        else{
         // Actualizar la solicitud
        $insert = $con ->prepare("UPDATE solicitudes  SET id_estado = $id_estado WHERE id_soli= $identificador");
        $insert ->execute();

        $insertSQL = $con->prepare("INSERT INTO respuesta(id_soli, respuesta) VALUES ($identificador, '$respuesta')");
        $insertSQL->execute();
        echo '<script>alert("Respuesta cargada exitosamente");</script>';
        echo '<script> window.close(); </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<script>
    function centrar() {
        iz = (screen.width - document.body.clientWidth) / 2;
        de = (screen.height - document.body.clientHeight) / 3;
        moveTo(iz, de);
    }
</script>
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
</head>
<body onload="centrar();">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Responder Petición</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="documento">Documento</label>
                                        <p class="form-control-static"><b><?php echo $documento; ?></b></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <p class="form-control-static"><b><?php echo $nombre; ?></b></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <p class="form-control-static"><b><?php echo $apellido; ?></b></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_soli">Tipo Solicitud</label>
                                        <p class="form-control-static"><b><?php echo $tipo_soli; ?></b></p>
                                        <input type="hidden" name="tipo_s" value="<?php echo $id_tip_soli; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <p class="form-control-static"><b><?php echo $descripcion; ?></b></p>
                                        <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                        <label for="documento">Responder</label>
                                        <input type="text" name="respuesta" value="respuesta">
                                    </div>
                            
                        </div><!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="responder" class="btn btn-primary">Responder</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</body>
</html>
