<?php

function conectarDB(){

    $servidor = "localhost";//nombre del servidor de base de datos
    $usuariobd = "root"; //usuario de acceso 
    $passwordbd = "";//contraseña de acceso
    $basedatos = "M07";//nombre de la base de datos a la que deseamos conectar


$conexion = mysqli_connect($servidor,$usuariobd,$passwordbd,$basedatos) /*or die(" fallo en la conexión")*/;

if (!$conexion) {
    
    echo "Error: No se pudo conectar a MySQL." . "<br>";
    echo "errno (error número) de depuración: " . mysqli_connect_errno() . "<br>"; 
    echo "error de depuración: " . mysqli_connect_error() . "<br>"; 
    exit(); 
}
else{
    // echo "Conexión establecida con ".$servidor."</br>";//informacion de depuracion
    // echo "Base de datos ".$basedatos." en uso</br>";//informacion de depuracion
    // echo "Conectado como ".$usuariobd."</br>";//informacion de depuracion
    return $conexion; //devuelve los datos de la conexion establecida al flujo principal
}

}

function desconectarDB($conexion){
    mysqli_close($conexion);
    // echo "se ha desconectado de la bd<br/>";
}



?>