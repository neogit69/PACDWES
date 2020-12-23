<?php
    if(isset($_SERVER['HTTP_COOKIE'])){
        if(isset($_SESSION['usuario'])){
            unset($_SESSION['usuario']);
            unset($_SERVER['HTTP_COOKIE']);
            session_destroy();
            header("location:index.php");
            echo "Desconectado,vuelva pronto!";
        }else{
            echo "no estas conectado como usuario";
        }
    }
?>