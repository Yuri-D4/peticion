<?php

     session_start();
     require_once("../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];
  include 'plant.php';
 
?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Solicitudes
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Solicitudes</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
        <div class="box">
                <div class="box-header">
                  <h3 class="box-title">No respondidas</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form method="post" action="funciones/nores_excel.php">
                            <button type="submit" name="nores_excel" class="boton">
                                <i class="fa fa-arrow-down"></i> Descargar reporte
                            </button>
                        </form>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Cedula</th>
                        <th>Tipo de Solicitud</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Actualizar</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        
                        $result = $con->prepare ("SELECT solicitudes.id_soli, solicitudes.documento, tipo_solicitud.tipo_soli, solicitudes.fecha, solicitudes.descripcion, estado.nom_estado
                        FROM solicitudes
                        INNER JOIN tipo_solicitud ON tipo_solicitud.id_tip_soli = solicitudes.id_tip_soli
                        INNER JOIN estado ON estado.id_estado = solicitudes.id_estado 
                        WHERE solicitudes.documento = $documento AND solicitudes.id_estado = 2
                        ORDER BY solicitudes.fecha DESC");
                        $result->execute();
                        $result = $result->fetchAll();
                        foreach ($result as $fila) {
                        ?>
                        
                        <tr>
                                <td><?php echo $fila['documento']; ?></td>
                                <td><?php echo $fila['tipo_soli']; ?></td>
                                <td><?php echo $fila['fecha']; ?></td>
                                <td><?php echo $fila['descripcion']; ?></td>
                                <td><?php echo $fila['nom_estado']; ?></td>
                                <td>
                                  <a href="#" class="boton" onclick="window.open('actualizar/soli.php?id=<?php echo $fila['id_soli']; ?>','','width=800,height=400,toolbar=NO');void(null);">
                                    <i class="fa fa-repeat"></i>
                                  </a>
                        </td>

                        </tr>
                        <?php
                       
                        }
                        ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
  include 'footer.php';
 
?>