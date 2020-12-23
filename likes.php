<?php
session_start();
include 'funciones_bd.php';
$from=$_SERVER['HTTP_REFERER'];
if(isset($_GET['like'])){
    $idnoticia=$_GET['like'];
    // echo "se ha hecho like en la noticia $idnoticia <br/>";
    // echo "la noticia tenia ".getNumLikes($idnoticia)." likes <br/>";
    if(isset($_SESSION['usuario'])){
      $id=$_SESSION['usuario'];
    }else{
      $id='invitado';
    }
    $nombre_cookie="noticia".$idnoticia."UID".$id;
    // echo "elnombredelacookie se ha establecido en ".$nombre_cookie."<br/>";
    if(isset($_COOKIE[$nombre_cookie])){
      // echo "exite la cookie<br> ya se ha dado like";
    }
    else{

      setcookie($nombre_cookie,'liked');
      $likes=getNumLikes($idnoticia)+1;//consulta numero likes. funcion en funciones_bd.php
      actualizaLikes($idnoticia,$likes);
    }
    //aumentar el contador de likes
    //guardar cookie usuario ya likeo
    //visualizar noticias con likes actualizados
  }
  $cadenaretorno=$from.'#'.$idnoticia;
  header("location:$cadenaretorno");//te devuelve automaticamente al sitio donde se hizo click
  // echo "FROM : $from <br/>";
  // echo $cadenaretorno."<br/>";
    // echo $from.'?id="'.$idnoticia.'"';
?>