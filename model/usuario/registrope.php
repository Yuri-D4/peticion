<?php

  include'plantilla.php';

  if (isset($_POST['registrar']))
   {
     $cedula= $_POST['cedula'];
     $id_tip_soli= $_POST['id_tip_soli'];
    $fecha= $_POST['fecha'];
    $descripcion= $_POST['descripcion'];
    $id_estado= $_POST['id_estado'];
    
     $sql= $con -> prepare ("SELECT * FROM solicitudes");
     $sql -> execute();
     $fila = $sql -> fetchAll(PDO::FETCH_ASSOC);

     if ($fila){
        echo '<script>alert ("DOCUMENTO YA EXISTE //CAMBIELO//");</script>';
        
     }

     else
   
     if ($cedula=="" || $id_tip_soli=="" || $fecha==""  || $descripcion=="" || $id_estado=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
   
      }
      
      else{
        
        $insertSQL = $con->prepare("INSERT INTO solicitudes (cedula, id_tip_soli, fecha, descripcion, id_estado) VALUES($cedula, '$id_tip_soli', '$fecha','$descripcion','$id_estado')");
        $insertSQL -> execute();
        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="inicio.php"</script>';
     }  
    }
 
?>


<head>

  <title>Bienvenido</title>
 
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
                  <h5 class="card-title">Peticiones</h5>

                                <!-- Floating Labels Form -->
              <form class="row g-3">
                <div class="col-md-12">
                  <div class="form-floating">
                  <input type="text" name="cedula" class="form-control" pattern="[0-9]{5,15}" title="solo se aceptan números" id="cedula" >
                    <label for="floatingName">Cedula</label>
                  </div>
                </div>

                <div class="col-12">
                      <label  for="tipo_solic">Seleccione tipo de solucitud</label>
                      <select class="form-select" id="floatingSelect" name="tipo_solicitud" aria-label="State">
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


                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
                    <label for="floatingEmail">Fecha</label>
                  </div>
                </div>

                
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-floating">
                      <label  for="estado"></label>
                        <?php   

                            $query = $con -> prepare("SELECT * FROM estado where id_estado = 2");
                            $query -> execute ();
                            $resultados = $query -> fetchAll(PDO::FETCH_ASSOC);

                            foreach ($resultados as $fila1){
                            ?>

                            <input class="form-control" type="varchar" name="id_estado" value="<?php echo $fila1['nom_estado']?>" readonly>


                            <?php
                                }
                            ?>
                     </div>
                     </div>
                     </div>

                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="descripcion" name="descripcion" id="descripcion" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Descripcion</label>
                  </div>
                </div>
            
               
                <div class="text-center">
                  <button type="registrar" name="registar" class="btn btn-primary">Enviar</button>
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