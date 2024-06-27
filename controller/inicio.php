<?php
require_once("../db/connection.php");
$db = new Database();
$con = $db -> conectar();
session_start();

if (isset($_POST["inicio"])) {

    $documento = $_POST["documento"];
    
    $contrasena = htmlentities(addslashes($_POST['contrasena']));

    $sql = $con->prepare("SELECT * FROM usuarios where documento = '$documento'");
    $sql->execute();
    $fila = $sql->fetch();


    if(gettype($fila) == "array" && password_verify($contrasena, $fila['contrasena'])){

        $_SESSION['documento'] = $fila['documento'];
        $_SESSION['id_tip_user'] = $fila ['id_tip_user'];
        echo "contraseña:",$contrasena;

        if ($_SESSION['id_tip_user'] == 1) {
            header ("Location: ../model/administrador/index.php");
            exit();
        }
        
     else if ($_SESSION['id_tip_user'] == 2) {
         header ("Location: ../model/usuario/index.php");
         exit();
         } 
   
        }else {
            header("location: inicio.php");
            exit();
        }
    }