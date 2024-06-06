<?php
     require_once("../../db/connection.php");
     //include("../../../controller/validarSesion.php");
     $db = new Database();
     $con = $db -> conectar();

   
  $documento= $_SESSION['documento'];

  // if (!isset($documento)){
  //   //include("../../../controller/validar_licencia.php");
  //   echo '<script>No has iniciado sesion</script>';
  //   header("Location: ../inicio/login.php");
  //   }
  
  $con_nombre = $con->prepare("SELECT * FROM usuarios WHERE documento = '$documento'");
  $con_nombre->execute();
  $nombre = $con_nombre->fetchAll(PDO::FETCH_ASSOC);
  foreach ($nombre as $fila) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
  }
  $completo = $nombre . " " . $apellido;

  if(isset($_POST['cerrar_sesion']))
{
    session_destroy();


    header('location:../../index.php');
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
      .cerrar{
        text-decoration: none;
        background-color: transparent;
        border: 0;
      .form_reg{
        width: 70vh;
      }
      }
    </style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo"><b>PETI</b>Fácil</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
                
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
                  <span class="hidden-xs"><?php echo $completo; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>
                    <?php echo $completo; ?>
                      <small>Usuario</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <form method="POST">
                        <input type="submit" class="btn btn-default btn-flat" name="cerrar_sesion" value="Cerrar Sesion">
                      </form>
                      </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            
            <div class="pull-left info">
              <p><?php echo $completo; ?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Activo</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">

            <li class="header">Panel de control</li>
            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
            
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-list-alt"></i> <span>Peticiones</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li><a href="atendidas.php"><i class="fa fa-check"></i> atendidas</a></li>
              <li><a href="total_soli.php"><i class="fa fa-minus-square-o"></i> Todas</a></li>
              </ul>
            </li>
            <li><a href="registro.php"><i class="fa fa-pencil-square-o"></i> Realizar Peticion</a></li>
            <li>
              <form method="POST">
                <a href="../../index.php"><i class="fa fa-sign-out"></i> 
                <input type="submit" value="Cerrar Sesion" class="cerrar" name="Cerrar sesion">
              </a>
            </li>
              </form>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Right side column. Contains the navbar and content of the page -->
      