<?php

if (!isset($_SESSION["doc"]) || !isset($_SESSION['tipo_user'])){
    header ("location:../../../index.html");
    exit();
}
?>