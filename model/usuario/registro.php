<?php
session_start();
require_once("../../db/connection.php");

$db = new Database();
$con = $db->conectar();

$documento = $_SESSION['documento'];
include 'plant.php';

function solicitud($con, $documento, $id_tip_soli, $fecha, $descripcion, $id_estado)
{
    try {
        $sql = $con->prepare("SELECT * FROM solicitudes WHERE documento = :documento AND id_tip_soli = :id_tip_soli AND id_estado = :id_estado");
        $sql->bindParam(':documento', $documento);
        $sql->bindParam(':id_tip_soli', $id_tip_soli);
        $sql->bindParam(':id_estado', $id_estado);
        $sql->execute();
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            echo '<script>alert("El documento ya existe. Por favor, cámbielo.");</script>';
            echo '<script>window.location="registro.php"</script>';
        } else if (empty($id_tip_soli) || empty($descripcion)) {
            echo '<script>alert("Existen datos vacíos. Por favor, complete todos los campos.");</script>';
            echo '<script>window.location="registro.php"</script>';
        } else {
            $insertSQL = $con->prepare("INSERT INTO solicitudes (documento, id_tip_soli, fecha, descripcion, id_estado) VALUES(:documento, :id_tip_soli, :fecha, :descripcion, :id_estado)");
            $insertSQL->bindParam(':documento', $documento);
            $insertSQL->bindParam(':id_tip_soli', $id_tip_soli);
            $insertSQL->bindParam(':fecha', $fecha);
            $insertSQL->bindParam(':descripcion', $descripcion);
            $insertSQL->bindParam(':id_estado', $id_estado);
            $insertSQL->execute();
            echo '<script>alert("Registro exitoso.");</script>';
            echo '<script>window.location="registro.php"</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }
}

if (isset($_POST['enviar'])) {
    $id_tip_soli = $_POST['tipo_s'];
    $tipo_nuevo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha = date("Y-m-d");
    $id_estado = 2;

    try {
        if (empty($id_tip_soli) && !empty($tipo_nuevo)) {
            $checkSQL = $con->prepare("SELECT * FROM tipo_solicitud WHERE tipo_soli = :tipo_soli");
            $checkSQL->bindParam(':tipo_soli', $tipo_nuevo);
            $checkSQL->execute();
            $tipoExistente = $checkSQL->fetch(PDO::FETCH_ASSOC);

            if ($tipoExistente) {
                $id_tip_soli = $tipoExistente['id_tip_soli'];
            } else {
                $insertSQL = $con->prepare("INSERT INTO tipo_solicitud (tipo_soli) VALUES (:tipo_soli)");
                $insertSQL->bindParam(':tipo_soli', $tipo_nuevo);
                $insertSQL->execute();
                $id_tip_soli = $con->lastInsertId();
            }
            echo '<script>alert("Tipo de solicitud registrado.");</script>';
        }

        if (!empty($id_tip_soli)) {
            solicitud($con, $documento, $id_tip_soli, $fecha, $descripcion, $id_estado);
        } else {
            echo '<script>alert("Debe seleccionar un tipo de solicitud o ingresar uno nuevo.");</script>';
            echo '<script>window.location="registro.php"</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Solicitudes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Solicitudes</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Realizar una petición</h3>
            </div>
            <div class="box-body">
                <form class="form_reg" method="POST">
                    <div class="col-12">
                        <label for="tipo_s">Seleccione tipo de solicitud</label>
                        <select class="form-control" id="floatingSelect" name="tipo_s" aria-label="State">
                            <option value="">Seleccione</option>
                            <?php
                            try {
                                $query = $con->prepare("SELECT * FROM tipo_solicitud");
                                $query->execute();
                                while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $fila['id_tip_soli'] . "'>" . $fila['tipo_soli'] . "</option>";
                                }
                            } catch (PDOException $e) {
                                echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <label for="floatingTextarea">Otro (opcional)</label>
                            <input class="form-control" placeholder="Tipo de solicitud" name="tipo">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <label for="floatingTextarea">Descripción</label>
                            <input class="form-control" placeholder="Descripción" name="descripcion" id="descripcion">
                        </div>
                    </div>
                    <div class="text-center">
                        <input name="enviar" class="btn btn-primary" value="Enviar" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
include 'footer.php';
?>
