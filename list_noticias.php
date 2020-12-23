<h2 class="nombre-pagina">Historico de noticias</h2>


<?php
  $resultados=listaNoticias();//obtenemos el resource con la tabla de datos devuelta
  $numregistros=mysqli_num_rows($resultados);//contamos el numero de filas devueltas
  $numcampos=mysqli_num_fields($resultados);//contamos el numero de campos 
  //recorremos la tabla segun el numero de filas
  for($f=1;$f<=$numregistros;$f++){
    $registro = mysqli_fetch_array($resultados,MYSQLI_ASSOC);//extrae registros de la tabla resultados a array asociativo
    echo '<h2 class="titulo" id="'.$registro['id'].'">'.$registro['titulo'].'</h2>'; //para el retorno
    echo '<p class="info-noticia"> publicado el '.$registro['hora_creacion'].' por '.$registro['autor'].'</p>'; 
    echo '<p>'.nl2br($registro['contenido']).'</p>';
    echo '<p class="likes">'.$registro['likes'].' Likes'.'</p>';          
    echo '<p><a href="likes.php?like='.$registro['id'].'"'.'>LIKE</a></p>';
    //si el usuario es administrador mostramos botones modificar y borrar en todas las noticias
    //si el usuario está registrado mostramos botones sólo en las noticias propias
    //los invitados no tienen botones para editar ni modificar nada
    if(isset($_SESSION['usuario']) && $_SESSION['usuario']==1){
      ?>
          <form action="index.php?opcion=crear_noticias" method="post">
            <input type="hidden" name="modificar" value="modificar">
            <input type="hidden" name="id" value="<?php echo $registro['id'];?>">
            <input type="submit" value="MODIFICAR">
          </form>
          <form action="index.php?opcion=crear_noticias" method="post">
            <input type="hidden" name="borrar" value="">
            <input type="hidden" name="id" value="<?php echo $registro['id'];?>">
            <input type="submit" value="BORRAR">
          </form>    
    
    <?php }
    
    echo "<hr/>";
  }
?>

