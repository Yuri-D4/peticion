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
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Tipo de Solicitud</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Atender</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        
                        $result = $con->prepare ("SELECT solicitudes.id_soli, solicitudes.documento, tipo_solicitud.tipo_soli, solicitudes.fecha, solicitudes.descripcion, estado.nom_estado, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.correo FROM solicitudes INNER JOIN tipo_solicitud ON tipo_solicitud.id_tip_soli = solicitudes.id_tip_soli INNER JOIN estado ON estado.id_estado = solicitudes.id_estado INNER JOIN usuarios ON usuarios.documento = solicitudes.documento WHERE solicitudes.id_estado = 2 ORDER BY solicitudes.fecha DESC");
                        $result->execute();
                        $result = $result->fetchAll();
                        foreach ($result as $fila) {
                        ?>
                        
                        <tr>
                                <td><?php echo $fila['documento']; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['apellido']; ?></td>
                                <td><?php echo $fila['correo']; ?></td>
                                <td><?php echo $fila['tipo_soli']; ?></td>
                                <td><?php echo $fila['fecha']; ?></td>
                                <td><?php echo $fila['descripcion']; ?></td>
                                <td><?php echo $fila['nom_estado']; ?></td>
                                <td>
                                  <a href="#" class="boton" onclick="window.open('respuesta/respon.php?id=<?php echo $fila['id_soli']; ?>','','width=800,height=500,toolbar=NO');void(null);">
                                    <i class="fa  fa-reply"></i>
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