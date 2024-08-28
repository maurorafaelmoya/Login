<?php

    $conexion = mysqli_connect("localhost", 'root', '', 'php_proyect');

    if($conexion){
        // echo "Conexion Exitosa";
    }else{
        echo 'Conexion fallida';
    }

?>