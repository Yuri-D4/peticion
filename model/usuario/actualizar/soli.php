<?php
session_start();
require_once("../../../db/connection.php");

$db = new Database();
$con = $db->conectar();

$documento= $_SESSION['documento'];
     if (!isset($_SESSION['documento'])) {
       header("Location: ../../../index.php");
       exit;
     }

$id_soli = $_GET['id'];

// Obtener los datos actuales de la solicitud
$sql = $con->prepare("SELECT * FROM solicitudes WHERE id_soli = ?");
$sql->execute([$id_soli]);
$solicitud = $sql->fetch(PDO::FETCH_ASSOC);

// Declaración de variables de campos en la tabla
if (isset($_POST['actualizar'])) {
    $id_tip_soli = $_POST['tipo_soli'];
    $descripcion = $_POST['descripcion'];
    $fecha = date('Y-m-d');
    $id_estado = 2;

    // Validación de datos
    if (empty($id_tip_soli) || empty($descripcion)) {
        echo '<script>alert("EXISTEN DATOS VACIOS");</script>';
        echo '<script> window.close(); </script>';
    } else {
        // Verificación de existencia previa
        $sql = $con->prepare("SELECT * FROM solicitudes WHERE documento = ? AND id_tip_soli = ? AND id_estado = ? AND id_soli != ?");
        $sql->execute([$documento, $id_tip_soli, $id_estado, $id_soli]);
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            echo '<script>alert("DOCUMENTO YA EXISTE //CAMBIELO//");</script>';
            echo '<script> window.close(); </script>';
        } else {
            // Actualización de la solicitud
            $updateSQL = $con->prepare("UPDATE solicitudes SET id_tip_soli = ?, descripcion = ?, fecha = ?, id_estado = ? WHERE id_soli = ?");
            $updateSQL->execute([$id_tip_soli, $descripcion, $fecha, $id_estado, $id_soli]);
            echo '<script>alert("REGISTRO EXITOSO");</script>';
            echo '<script> window.close(); </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <script>
        function centrar() {
            iz = (screen.width - document.body.clientWidth) / 2;
            de = (screen.height - document.body.clientHeight) / 3;
            moveTo(iz, de);
        }
    </script>
</head>
<body onload="centrar();">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Actualizar Petición</h3>
        </div>
        <form role="form" method="POST" action="">
            <div class="box-body">
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <p><b><?php echo htmlspecialchars($documento); ?></b></p>
                </div>
                <div class="form-group">
                    <label>Tipo Solicitud</label>
                    <select class="form-control" name="tipo_soli">
                        <option value="">Seleccione</option>
                        <?php
                        $query = $con->prepare("SELECT * FROM tipo_solicitud");
                        $query->execute();
                        while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $fila['id_tip_soli'] == $solicitud['id_tip_soli'] ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($fila['id_tip_soli']) . "' $selected>" . htmlspecialchars($fila['tipo_soli']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" placeholder="Descripción" name="descripcion" value="<?php echo htmlspecialchars($solicitud['descripcion']); ?>">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
