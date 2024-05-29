<?php
    session_start();
    require_once("db/connection.php");
    // include("../../../controller/validarSesion.php");
    $db = new Database();
    $con = $db -> conectar();


   if (isset($_POST['registrar']))
   {
     $cedula= $_POST['cedula'];
    $nombre= $_POST['nombre'];
    $apellido= $_POST['apellido'];
    // $celular= $_POST['celular'];
    $contrasena= $_POST['contrasena'];
    $correo= $_POST['correo'];
    $tipo_user= 2;
    // $id_estado= 1;
    

     $sql= $con -> prepare ("SELECT * FROM usuarios WHERE cedula='$cedula'");
     $sql -> execute();
     $fila = $sql -> fetchAll(PDO::FETCH_ASSOC);

     if ($fila){
        echo '<script>alert ("DOCUMENTO YA EXISTE //CAMBIELO//");</script>';
        
     }

     else
   
     if ($cedula=="" || $nombre=="" || $correo==""  || $contrasena=="" || $tipo_user=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
   
      }
      
      else{

        $pass_cifrado = password_hash($contrasena,PASSWORD_DEFAULT, array("pass"=>12));
        
        $insertSQL = $con->prepare("INSERT INTO usuarios(cedula, nombre, apellido, correo, contrasena, id_tip_user) VALUES($cedula, '$nombre', '$apellido','$correo','$pass_cifrado', '$tipo_user')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="inicio.php"</script>';
     }  
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registro</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">PetiFácil</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Crea una cuenta</h5>
                    <p class="text-center small">Ingresa tus datos para crear la cuenta</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" name="formreg" autocomplete="off" >

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Cedula</label>
                      <div class="input-group has-validation">
                        <input type="text" name="cedula" class="form-control" pattern="[0-9]{5,15}" title="solo se aceptan números" id="cedula" >
                        <div class="invalid-feedback">Por favor, ingrese su cedula, recuerde que solo se aceptan números.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Nombre</label>
                      <input type="text" name="nombre" class="form-control" pattern="[A-Za-z/s]{1,40}" title="Solo se permiten letras" id="nombre" required>
                      <div class="invalid-feedback">Por favor, ingrese su nombre!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Apellido</label>
                      <input type="text" name="apellido" class="form-control" pattern="[a-zA-Z/s]{1,40}" title="Solo se permiten letras" id="apellido" required>
                      <div class="invalid-feedback">Por favor, ingrese su apellido!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Correo</label>
                      <input type="email" name="correo" class="form-control" id="correo" title="Ingrese su correo" required>
                      <div class="invalid-feedback">Por favor, ingrese su correo!</div>
                    </div>
                      
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Contraseña</label>
                      <input type="password" name="contrasena" class="form-control" pattern="[0-9]{1,10}" id="contrasena" title="Solo se aceptan 10 digitos alfanúmericos" required>
                      <div class="invalid-feedback">Por favor, ingrese su contraseña, Recuerde que solo se aceptan 10 digitos alfanúmericos</div>
                    </div>

                    <div class="col-12">
                      <label  for="tipo_user"></label>

                      <?php   

                      $query = $con -> prepare("SELECT * FROM tipo_user where id_tip_user = 2");
                      $query -> execute ();
                      $resultados = $query -> fetchAll(PDO::FETCH_ASSOC);

                      foreach ($resultados as $fila1){
                        ?>

                     <input class="form-control" type="varchar" name="tipo_user" value="<?php echo $fila1['tipo_user']?>" readonly>
                  

                  <?php
                          }
                      ?>
                     </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Estoy de acuerdo y acepto<a href="#">los términos de condiciones</a></label>
                        <div class="invalid-feedback">Debes de aceptar antes de enviar</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <input class="btn btn-primary w-100" name="registrar" value="Registrar" type="submit">
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Ya tienes cuenta? <a href="inicio.php">Acceder</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>