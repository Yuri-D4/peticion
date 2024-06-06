<?php

     session_start();
     require_once("../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];
  include 'plant.php';
 
?>


<head>

  <title>Peticiones</title>
 
</head>

<body>

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
                <h3 class="box-title">Realizar solicitud</h3>
                  <a href="registro.php">aqui</a>
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
                        WHERE solicitudes.documento = $documento 
                        ORDER BY solicitudes.id_estado DESC");
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
                                  <a href="#" class="boton" onclick="window.open('../actualizar/soli.php?id=<?php echo $fila['id_soli']; ?>','','width=800,height=750,toolbar=NO');void(null);">
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