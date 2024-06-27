<?php
session_start();
require_once("../../db/connection.php");

$db = new Database();
$con = $db->conectar();

include 'plant.php';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            total solicitudes
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Solicitudes</li>
        </ol>
    </section>

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="box">
        
            <div class="box-header">
                <form method="post" action="funciones/total_excel.php">
                    <button type="submit" name="total_excel" class="boton">
                        <i class="fa fa-arrow-down"></i> Descargar reporte
                    </button>
                </form>
                
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo de Solicitud</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $con->prepare("SELECT solicitudes.id_soli, solicitudes.documento, tipo_solicitud.tipo_soli, solicitudes.fecha, solicitudes.descripcion, estado.nom_estado, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.correo 
                                                FROM solicitudes 
                                                INNER JOIN tipo_solicitud ON tipo_solicitud.id_tip_soli = solicitudes.id_tip_soli 
                                                INNER JOIN estado ON estado.id_estado = solicitudes.id_estado 
                                                INNER JOIN usuarios ON usuarios.documento = solicitudes.documento 
                                                WHERE solicitudes.id_estado 
                                                ORDER BY solicitudes.fecha ASC"); // Cambio a ASC para ordenar de la más vieja a la más nueva
                        $result->execute();
                        $result = $result->fetchAll(); 
                        foreach ($result as $fila) {
                        ?>
                        
                        <tr>
                            <td><?php echo $fila['documento']; ?></td>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['apellido']; ?></td>
                            <td><?php echo $fila['tipo_soli']; ?></td>
                            <td><?php echo $fila['fecha']; ?></td>
                            <td><?php echo $fila['descripcion']; ?></td>
                            <td><?php echo $fila['nom_estado']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div><!-- /.box-header -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
include 'footer.php';
?>
