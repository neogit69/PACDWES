<?php
//consultar la base de datos para comprobar el mail y el password del usuario
//si existe y el pasword es correcto iniciar sesion
//si no existe o el password es incorrecto avisar y corregir
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // echo "se ha enviado algo";
    //comprobar los datos
    if(compruebaLoginUsuario()){
        echo "vamos a iniciar sesion<br/>";
        // session_start();//solo si no se ha iniciado previamente
        echo "estado actual de sesion es ".session_status()."<br/>";
        $_SESSION['usuario']=getIdUsuario($_POST['email']);
        header("location:index.php");
        foreach($_SESSION as $k=>$v){
            echo $k."--->".$v."<br/>";
        }

        // 0 PHP_SESSION_DISABLED si las sesiones están deshabilitadas.
        // 1 PHP_SESSION_NONE si las sesiones están habilitadas, pero no existe ninguna.
        // 2 PHP_SESSION_ACTIVE si las sesiones están habilitadas, y existe una.
    }
    else{
        echo "revisa los datos de inicio de sesion<br/>";
    }
}

?>
<div id="formulario-login">
    <h2>Inicio de sesión</h2>
    <form action="" method="post">
        <label for="email">Email :</label><br/>
        <input type="email" name="email" id="email" required><br/>
        <label for="pwd">Password :</label><br/>
        <input type="password" name="pwd" id="pwd" required><br/>
        <input type="submit" name="enviar" value="enviar"><br/>
    </form>
</div>

