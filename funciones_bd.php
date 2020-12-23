<?php

include 'conexion.php';//contiene las funciones para conectar y desconectar la base de datos

function consultaNoticias($limite=5){//retorna las ultimas noticias en funcion de $limite, por defecto 5
    $conexion=conectarDB();
    $query = "SELECT * FROM noticias ORDER BY hora_creacion DESC LIMIT $limite";
    $respuesta = mysqli_query($conexion, $query);
    //como los datos ya se han cargado en $respuesta podemos desconectar
    desconectarDB($conexion);
    //comprobamos si se ha obtenido un resultado inesperado
    if(!$respuesta){
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
        exit;
    }else{
        return $respuesta;
    }
}

function listaNoticias(){
    $conexion=conectarDB();
    $query = "SELECT * FROM noticias ORDER BY hora_creacion DESC ";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;
}

function listaNoticiasId($id){
    $conexion=conectarDB();
    $query = "SELECT * FROM noticias WHERE id=$id ";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;
}

function updateNoticia($titulo,$contenido,$idnoticia){
    $conexion=conectarDB();
    $query="UPDATE noticias SET titulo='".$titulo."' ,contenido='".$contenido."' WHERE id=$idnoticia";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;
}

function borraNoticia($idnoticia){
    $conexion=conectarDB();
    $query="DELETE FROM noticias WHERE id=$idnoticia";
    $respuesta = mysqli_query($conexion, $query);
    if (mysqli_query($conexion, $query)) {
        echo "Borrada noticia satisfactoriamente<br/>";
        // header("location:index.php?opcion=login");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
    desconectarDB($conexion);
    return $respuesta;
}


function actualizaLikes($idnoticia,$likes){
    $conexion=conectarDB();
    $query="UPDATE noticias SET likes=$likes WHERE id=$idnoticia";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;//realmente se necesita devolver algo??
} 

function getNumLikes($idnoticia){
    $conexion=conectarDB();
    $query="SELECT likes FROM noticias WHERE id=$idnoticia";
    $respuesta = mysqli_query($conexion, $query);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    $numlikes=$datos['likes'];
    desconectarDB($conexion);
    return $numlikes;
} 

function listaUsuarios(){
    $conexion=conectarDB();
    $query = "SELECT * FROM usuarios ";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;
}

function datosUsuario($id){
    $conexion=conectarDB();
    $query = "SELECT * FROM usuarios WHERE id=$id ";
    $respuesta = mysqli_query($conexion, $query);
    desconectarDB($conexion);
    return $respuesta;
}

function insertaNoticia($datosform){
    foreach($datosform as $nombrevariable=>$valorvariable){//extrae de datosform el nombre y el valor de cada variable
        $varname=$nombrevariable;//contiene el nombre de la variable
        $$varname=$valorvariable;//se asigna el valor
        //de este modo las variables se crean dinámicamente y están disponibles para su uso
    }
    $conexion=conectarDB();
    $hora_creacion=date('Y-m-d H:i:s');
    // $usuario="Anónimo";//de momento hasta que implemente usuarios y sesiones
    $query = "INSERT INTO noticias VALUES ('','".$titulo."','".$contenido."','".$autor."','".$hora_creacion."',0) ";
    if (mysqli_query($conexion, $query)) {
          echo "Nueva noticia creada satisfactoriamente<br/>";
          header("location:index.php");
    } else {
          echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
    desconectarDB($conexion);
    
}

function creaUsuario($datosform){
    
    $conexion=conectarDB();
    // echo "se ha llamado a creaUsuario()<br/>";//info dep
    foreach($datosform as $nombrevariable=>$valorvariable){//extrae de datosform el nombre y el valor de cada variable
        $varname=$nombrevariable;//contiene el nombre de la variable
        $$varname=$valorvariable;//se asigna el valor
        //de este modo las variables se crean dinámicamente y están disponibles para su uso
    }
        
    $query = "INSERT INTO usuarios
              VALUES
              ('','".$nombre."','".$pwd."','".$email."','".$edad."',
              '".$fecha_nacimiento."','".$direccion."','".$codigo_postal."','".$provincia."','".$genero."') ";
    if (mysqli_query($conexion, $query)) {
          echo "Nuevo usuario creado satisfactoriamente<br/>";
          header("location:index.php?opcion=login");
    } else {
          echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
    desconectarDB($conexion);
}

function actualizaUsuario($datosform,$idmod){
    
    $conexion=conectarDB();
    // echo "se ha llamado a creaUsuario()<br/>";//info dep
    foreach($datosform as $nombrevariable=>$valorvariable){//extrae de datosform el nombre y el valor de cada variable
        $varname=$nombrevariable;//contiene el nombre de la variable
        $$varname=$valorvariable;//se asigna el valor
        //de este modo las variables se crean dinámicamente y están disponibles para su uso
    }
        
    $query = "UPDATE usuarios SET nombre='".$nombre."',
                                  email='".$email."',
                                  pwd='".$pwd."',
                                  direccion='".$direccion."', 
                                  provincia='".$provincia."',
                                  fecha_nacimiento='".$fecha_nacimiento."',
                                  edad=$edad,
                                  genero='".$genero."' 
                                  WHERE id=$idmod;";
    if (mysqli_query($conexion, $query)) {
          echo "usuario modificado satisfactoriamente<br/>";
        //   header("location:index.php?opcion=login");
    } else {
          echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
    desconectarDB($conexion);
}

function borraUsuario($idusuario){
    $conexion=conectarDB();
    $query="DELETE FROM usuarios WHERE id=$idusuario";
    $respuesta = mysqli_query($conexion, $query);
    if (mysqli_query($conexion, $query)) {
        echo "Usuario borrado satisfactoriamente<br/>";
        // header("location:index.php?opcion=login");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }
    desconectarDB($conexion);
    return $respuesta;
}

function compruebaLoginUsuario(){
    $conexion=conectarDB();
    $query="SELECT * FROM usuarios WHERE email="."'".$_POST['email']."'";//cuidado que la entrada esta sin limpiar
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    if($filas!=0){
        if($_POST['pwd']==$datos['pwd']){
            return true;
        }else{
            echo "el password es incorrecto<br/>";
            return false;
        }
    }
    else{
        echo "usuario inexistente<br/>";
        return false;
    }
}

function getNombreUsuario($email){
    
    $conexion=conectarDB();
    $query="SELECT * FROM usuarios WHERE email="."'".$email."'";
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    if($filas!=0){
        // echo " existe un usuario con esa direccion<br/>";
        return $datos['nombre'];
    }
    else{
        // echo "usuario inexistente<br/>";
        return false;
    }
}

function existeUsuario($nombre){
    
    $conexion=conectarDB();
    $query="SELECT * FROM usuarios WHERE nombre="."'".$nombre."'";
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    if($filas!=0){
        // echo " existe un usuario con esa direccion<br/>";
        return $datos['nombre'];
    }
    else{
        // echo "usuario inexistente<br/>";
        return false;
    }
}

function getNombreId($id){
    
    $conexion=conectarDB();
    $query="SELECT nombre FROM usuarios WHERE id=$id";
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    if($filas!=0){
        return $datos['nombre'];
    }
    else{
        return false;
    }
}

function getIdUsuario($email){
    
    $conexion=conectarDB();
    $query="SELECT id FROM usuarios WHERE email="."'".$email."'";
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    // echo "se han encontrado ".$filas." coincidencias<br/>";
    if($filas!=0){
        // echo " existe un usuario con esa direccion<br/>";
        return $datos['id'];
    }
    else{
        // echo "usuario inexistente<br/>";
        return false;
    }
}

function getIdUsuarioByName($nombre){
    
    $conexion=conectarDB();
    $query="SELECT id FROM usuarios WHERE nombre="."'".$nombre."'";
    $respuesta=mysqli_query($conexion,$query);
    desconectarDB($conexion);//una vez hemos obtenido el recurso solicitado ya podemos desconectar
    $filas=mysqli_num_rows($respuesta);
    $datos=mysqli_fetch_array($respuesta,MYSQLI_ASSOC);
    // echo "se han encontrado ".$filas." coincidencias<br/>";
    if($filas!=0){
        // echo " existe un usuario con esa direccion<br/>";
        return $datos['id'];
    }
    else{
        // echo "usuario inexistente<br/>";
        return false;
    }
}
?>

