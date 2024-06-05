<?php

include'plantilla.php';

  if (isset($_POST['enviar']))
   {
      $id_tip_soli= $_POST['tipo_s'];
      $descripcion= $_POST['descripcion'];
      $fecha= date('Y-m-d');
      $id_estado = 2;
    
     $sql= $con -> prepare ("SELECT * FROM solicitudes WHERE documento = $documento AND id_tip_soli = $id_tip_soli AND id_estado = $id_estado");
     $sql -> execute();
     $fila = $sql -> fetchAll(PDO::FETCH_ASSOC);

     if ($fila){
        echo '<script>alert ("DOCUMENTO YA EXISTE //CAMBIELO//");</script>';
        echo '<script>window.location="registrope.php"</script>';
     }

     else
   
     if ($id_tip_soli=="" || $descripcion=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
         echo '<script>window.location="registrope.php"</script>';
      }
      
      else{
        
        $insertSQL = $con->prepare("INSERT INTO solicitudes (documento, id_tip_soli, fecha, descripcion, id_estado) VALUES($documento, '$id_tip_soli', '$fecha','$descripcion','$id_estado')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="registrope.php"</script>';
     }  
    }
 
?>


<head>

  <title>Peticiones</title>
 
</head>

<body>

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->


            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Realizar una peticion</h5>

                                <!-- Floating Labels Form -->
              <form class="row g-3" method="POST">
                
                <div class="col-12">
                      <label  for="tipo_s">Seleccione tipo de solucitud</label>
                      <select class="form-select" id="floatingSelect" name="tipo_s" aria-label="State">
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
                    <textarea class="form-control" placeholder="descripcion" name="descripcion" id="descripcion" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Descripcion</label>
                  </div>
                </div>
            
               
                <div class="text-center">
                  <button  name="enviar" class="btn btn-primary">Enviar</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>
                </div>

              </div>
            </div><!-- End Recent Sales -->

          

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

        

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

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