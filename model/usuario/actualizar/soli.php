<?php

     session_start();
     require_once("../../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];

   //empieza la consulta
  
   

   //declaracion de variables de campos en la tabla
   if (isset($_POST['actualizar']))
   {
       $tipo_nuevo= $_POST['tipo'];

        $sql = $con -> prepare(" SELECT * FROM solicitudes WHERE id_soli='".$_GET['id']."'");
        $insertSQL -> execute();

       $id_tip_soli= $_POST['tipo_soli'];
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

<!DOCTYPE html>
<html lang="en">
    <script>
        function centrar() {
            iz=(screen.width-document.body.clientWidth)/2;
            de=(screen.height-document.body.clientHeight)/3;
            moveTo(iz,de);
        }
    </script>
  <html>
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

  <!-- general form elements -->
  <body onload="centrar();">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Actualizar Petición</h3>
        </div>
        <form role="form" method="POST" action="actualizar">
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Documento</label>
                    <p><b><?php echo $documento ?></b></p>
                </div>
                <div class="form-group">
                    <label>Tipo Solicitud</label>
                    <select class="form-control" name="tipo_soli">
                        <option value="">Seleccione</option>
                        <?php   
                        $query = $con->prepare("SELECT * FROM tipo_solicitud");
                        $query->execute();
                        while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $fila['id_tip_soli'] . ">" . $fila['tipo_soli'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Descripción</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Descripción" name="descripcion">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>