<?php

     session_start();
     require_once("../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];
  include 'plant.php';
 

   //empieza la consulta
  
   

   //declaracion de variables de campos en la tabla
   if (isset($_POST['actualizar']))
   {
       $tipo_nuevo= $_POST['tipo'];

        $sql = $con -> prepare(" SELECT * FROM solicitudes WHERE id_soli='".$_GET['id']."'");
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
        echo '<script>window.location="soli.php"</script>';
     }

     else
   
     if ($id_tip_soli=="" || $descripcion=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
         echo '<script>window.location="soli.php"</script>';
      }
      
      else{
        
        $insertSQL = $con->prepare("UPDATE solicitudes (documento, id_tip_soli, fecha, descripcion, id_estado) VALUES($documento, '$id_tip_soli', '$fecha','$descripcion','$id_estado')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="soli.php"</script>';
     }  
    }
 
 
?>

  <!-- general form elements -->
  <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Actualizar Petición</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Documento</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="documento">
                    </div>

                    <div class="form-group">
                      <label>Tipo Solicitud</label>
                      <select class="form-control">
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

                    <div class="form-group">
                      <label for="exampleInputPassword1">Descripción</label>
                      <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Descripción">
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
   