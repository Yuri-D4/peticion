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
                  <h3 class="box-title">Respondidas</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form method="post" action="funciones/aten_excel.php">
                    <button type="submit" name="aten_excel" class="boton">
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
                        <th>Respuesta</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        
                        $result = $con->prepare ("SELECT solicitudes.id_soli, solicitudes.documento, tipo_solicitud.tipo_soli, solicitudes.fecha, solicitudes.descripcion, estado.nom_estado, respuesta.respuesta
                        FROM solicitudes
                        INNER JOIN tipo_solicitud ON tipo_solicitud.id_tip_soli = solicitudes.id_tip_soli
                        INNER JOIN estado ON estado.id_estado = solicitudes.id_estado 
                        INNER JOIN respuesta ON respuesta.id_soli = solicitudes.id_soli 
                        WHERE solicitudes.documento = $documento AND solicitudes.id_estado = 1
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
                                <td><?php echo $fila['respuesta']; ?></td>
                                <td><?php echo $fila['nom_estado']; ?></td>

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