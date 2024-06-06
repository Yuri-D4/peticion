<?php

     session_start();
     require_once("../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];
  include 'plant.php';

  
  if (isset($_POST['enviar']))
   {
       $tipo_nuevo= $_POST['tipo'];

       $insertSQL = $con->prepare("INSERT INTO tipo_solicitud(tipo_soli) VALUES('$tipo_nuevo')");
        $insertSQL -> execute();

       $id_tip_soli= $_POST['tipo_s'];
        $descripcion= $_POST['descripcion'];
        $fecha= date('Y-m-d');
        $id_estado = 2;
    
     $sql= $con -> prepare ("SELECT * FROM solicitudes WHERE documento = $documento AND id_tip_soli = $id_tip_soli AND id_estado = $id_estado");
     $sql -> execute();
     $fila = $sql -> fetchAll(PDO::FETCH_ASSOC);

     if ($fila){
        echo '<script>alert ("DOCUMENTO YA EXISTE //CAMBIELO//");</script>';
        echo '<script>window.location="registro.php"</script>';
     }

     else
   
     if ($id_tip_soli=="" || $descripcion=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
         echo '<script>window.location="registro.php"</script>';
      }
      
      else{
        
        $insertSQL = $con->prepare("INSERT INTO solicitudes (documento, id_tip_soli, fecha, descripcion, id_estado) VALUES($documento, '$id_tip_soli', '$fecha','$descripcion','$id_estado')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="registro.php"</script>';
     }  
    }
 
 
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
                  <h3 class="box-title">Realizar una peticion</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                                <!-- Floating Labels Form -->
              <form class="form_reg" method="POST">
                
                <div class="col-12">
                      <label  for="tipo_s">Seleccione tipo de solucitud</label>
                      <select class="form-control" id="floatingSelect" name="tipo_s" aria-label="State">
                        <option value="">Seleccione</option>
                      <?php   

                      $query = $con -> prepare("SELECT * FROM tipo_solicitud");
                      $query -> execute ();
                      
                      while ($fila = $query -> fetch(PDO::FETCH_ASSOC)){

                          echo "<option value=" . $fila['id_tip_soli'] . ">" . $fila['tipo_soli'] . "</option>";
                        }
                     
                        ?>
                      </select>
                     </div>
                
                <div class="col-12">
                  <div class="form-floating">
                      <label for="floatingTextarea">Otro(opcional)</label>
                    <textarea class="form-control" placeholder="Tipo de solicitud" name="tipo" style="height: 100px;"></textarea>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-floating">
                      <label for="floatingTextarea">Descripcion</label>
                    <textarea class="form-control" placeholder="descripcion" name="descripcion" id="descripcion" style="height: 100px;"></textarea>
                  </div>
                </div>
            
               
                <div class="text-center">
                  <button  name="enviar" class="btn btn-primary">Enviar</button>
                </div>
              </form><!-- End floating Labels Form -->

                </div><!-- /.box-body -->
              </div><!-- /.box -->

              </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
  include 'footer.php';
 
?>