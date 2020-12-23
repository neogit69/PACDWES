<?php
     session_start();
     include 'funciones_bd.php';//contiene funciones de consulta a la base de datos
     include 'auxfunctions.php';//contiene funciones propias utiles y depuracion
  ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Pac Desarrollo Entorno Servidor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/micss.css">
</head>
<body>
  
  <div id="contenedor-menu">
    <nav class="menu">
      <ul>
        <!-- <li><a href="index.php?opcion=creditos">Creditos</a></li> -->
        <li><a href="index.php?option=inicio">Inicio</a></li>
        <li><a href="index.php?opcion=usuarios">Ver Usuarios</a></li>
        <li><a href="index.php?opcion=noticias">Ver Noticias</a></li>
        <li><a href="index.php?opcion=crear_noticias">Crear Noticia</a></li>
        <!-- <li><a href="index.php?opcion=test">Test</a></li> -->
        <li><a href="index.php?opcion=crear_usuarios">Crear Usuario</a></li>
        <?php if(!isset($_SESSION['usuario'])){//cambia opciones del menu para mostrar login o logout segun el caso ?>
          <li><a href="index.php?opcion=login">Login</a></li>
        <?php } else{ ?>
        <li><a href="index.php?opcion=logout">Logout</a></li>
        <?php } ?>
    </ul>
    </nav>
    <div id="estado"><p class="info-usuario"><?php infoIp(); infoSesion();//muestra info en barra de estado menu ?></p></div>
    
  </div>

<!-- fin de la parte de cabecera y menu esta seccion podria ir a cabecera.php pero he optado por hacerlo todo en index.php -->
 <hr/> 

<!-- comienza el cuerpo de presentacion. esto se corresponde con el archivo cuerpo.php propuesto en enunciado PAC -->
<div id="contenedor-cuerpo"><!--contenedor principal CUERPO de la informacion de la base de datos-->
    
    <!-- insertamos el cuerpo para que se visualice dentro de este contenedor -->
    <?php
        
        $opcion=menuControl();//definido en auxfunctions.php
        switch($opcion){
            case "inicio":
                 require 'vista_2.php';//vista inicial de las 5 ultimas publicaciones
            break;
            case "usuarios":
                require 'list_usuarios.php';//listado de los usuarios de la aplicacion
            break;
            case "noticias":
                require 'list_noticias.php';//listado de todas las noticias publicadas
           break;
           case "crear_noticias":
               require 'forms/form_noticias.php';//para la publicacion,edicion y borrado de  noticias
           break;
           case "crear_usuarios":
            require 'forms/form_usuario.php';//para el control de los usuarios
            break;

            case "login":
              require 'forms/form_login.php';//para autenticar los usuarios
              break;
            // case "creditos":
            //     require 'creditos.php';//informacion de autor y funcionamiento del programa
            //     break; 
            // case "test":
            //     require 'docs/documentacion_pac_dwes.html';//pruebas de programacion
            //     break;
           case "logout":
                require 'logout.php';
                break;           
            default:
            require 'vista_2.php';//opcion por defecto al cargar la pagina

        }
    ?>
</div>
<!-- fin del container principal de las noticias-->

<footer>
  <div class="contenedor-footer">
    <?php
       //informacion de estados
      //  infoIp();
      //  infoGet();
      //  infoPost();
       infoSesion();
    ?>
  </div>
</footer>



</body>
</html>
