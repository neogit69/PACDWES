<h2 class="nombre-pagina">listado de usuarios</h2>


<?php
  if(!isset($_SESSION['usuario'])){
    echo "Esta página no esta disponible para usuarios anonimos<br/>";
    echo "<a href='index.php?opcion=crear_usuarios'>registrate<a> o <a href='index.php?opcion=login'>inicia sesion<a><br/> ";
  }else{
    if($_SESSION['usuario']==1){//vista de administrador

      $usuarios=listaUsuarios();//listaUsuarios esta en funciones_bd.php devuelve todos los usuarios
      generarTabla($usuarios,"lista-usuarios");//presenta una tabla con los datos de usuarios.se ubica en auxfunctions.php
    }
    else{
      echo "estamos en modo usuario registrado<br/>";//solo mostramos los datos del usuario conectado
      $respuesta=datosUsuario($_SESSION['usuario']);
      // $datos_usuario=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
      generarTabla($respuesta,"datos-usuario");
      
     
    }
  }
?>