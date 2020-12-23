<?php if(isset($_POST['modificar'])){
         echo '<h2 class="nombre-pagina">Modificar noticia</h2>';
         modificarNoticia();
      } elseif (isset($_POST['borrar'])){
        echo '<h2 class="nombre-pagina">BORRAR noticia</h2>';
        cuidadin();
      }
      else{
        echo '<h2 class="nombre-pagina">Nueva noticia</h2>';
        nuevaNoticia(); //crearnuevanoticia 

      }  
?>



<?php
function cuidadin(){
  $idnoticia=$_POST['id'];
  echo "se ha solicitado borrar la noticia con id=$idnoticia";
  $disable="disabled";
  if($_POST['borrar']=="ok"){
    if(isset($_POST['confirmar']) && $_POST['confirmar']=="CONFIRMAR"){
      $disable="";
    }
  }
  if($_POST['borrar']=="borrar"){
    echo "borrandooooo<br/>";
    borraNoticia($idnoticia);
  }
  //salir de php y presentar formulario
   ?> 
   <form action="" method="post">
    <input type="hidden" name="id" value=<?php echo $idnoticia ;?>>
    <input type="text" size="50" name="confirmar" id="confirmar" placeholder="escribe CONFIRMAR en mayusculas para confirmar">
    <button type="submit" value="ok" name="borrar"  >OK</button><br/>
    <button type="submit" value="borrar" name="borrar" <?php echo $disable ;?> >BORRAR</button><br/>
   </form> 
<?php }//cierre de la funcion cuidadin() borrar noticia ?>

<?php
function modificarNoticia(){

  $modo=$_POST['modificar'];
  $idnoticia=$_POST['id'];
  echo "$modo noticia $idnoticia<br/>";
  $resultado=listaNoticiasId($idnoticia);// tipo mysql result o booleano en caso de error
  $registro=mysqli_fetch_array($resultado,MYSQLI_ASSOC);// tipo array con los datos del registro o null
  $titulo_original=$registro['titulo'];
  $contenido_original=$registro['contenido'];
  if(isset($_POST['titulo'])){
    $titulo_modificado=$_POST['titulo'];
    $titulo=$titulo_modificado;
    $modificado=true;
  }
  else{
    $titulo=$titulo_original;
    $modificado=false;
  }
  if(isset($_POST['contenido'])){
    $contenido_modificado=$_POST['contenido'];
    $contenido=$contenido_modificado;
    $modificado=true;
  }
  else{
    $contenido=$contenido_original;
    $modificado=false;
  }
  if($modificado){
    //validar datos y si es correcto mostrar boton de confirmacion y enviar a la base de datos
    if(!empty($_POST['titulo'])&&!empty($_POST['contenido'])){
      $titulo=addslashes( limpiarEntrada($_POST['titulo']));//quizas deberia llevar esto a form_functions donde se comprueban entradas
      $contenido=addslashes( limpiarEntrada($_POST['contenido']));
     
      echo "updateando<br/>";
      updateNoticia($titulo,$contenido,$idnoticia);
      
    }
    else{
      //ocurre algun error
      echo "Falta el titulo o el contenido<br/>";//inf dep
    }
  }
  //salir de php y presentar formulario
  ?>
<form action="" method="POST">
    <input type="hidden" name="id" value=<?php echo $idnoticia ;?>>
    <label for="titulo">Título:</label><br/>
    <input type="text" size="100" id="titulo" value="<?php echo $titulo;?>" name="titulo"><br/>  
    <label for="contenido">Contenido:</label><br/>
    <textarea  rows="10" cols="100" id="contenido" name="contenido" ><?php echo $contenido;?></textarea><br/>
    <button type="submit"  value="modificar" name="modificar" >MODIFICAR</button><br/>
</form>

<?php }//cierre de funcion ?>

<?php
function nuevaNoticia(){
  
  if(isset($_SESSION['usuario'])){
    // echo "acceso de usuario registrado<br/>";
    $disable="";
  }
  else{
    echo "Para publicar noticias tiene que estar registrado<br/>";
    $disable="disabled";
  }
  if(isset($_POST['publicar'])){

    if(!empty($_POST['titulo'])&&!empty($_POST['contenido'])){
      $titulo=addslashes( limpiarEntrada($_POST['titulo']));//quizas deberia llevar esto a form_functions donde se comprueban entradas
      $contenido=addslashes( limpiarEntrada($_POST['contenido']));
      $autor=getNombreId($_SESSION['usuario']);
      $datosform=array("titulo"=>$titulo,
                       "contenido"=>$contenido,
                       "autor"=>$autor);
      insertaNoticia($datosform);//realiza la operacion de insercion
      
      
    }
    else{
      //ocurre algun error
      echo "no se añadio ninguna nueva noticia<br/>";//inf dep
    }
  }
  //salimos de php para presentar el formulario en html
  ?>
<form action="" method="POST">
    
    <label for="titulo">Título:</label><br/>
    <input type="text" size="100" id="titulo" placeholder="Introduce el título de la noticia" name="titulo"><br/>  
    <label for="contenido">Contenido:</label><br/>
    <textarea  rows="10" cols="100" id="contenido" name="contenido"  placeholder="Introduce el cuerpo de la noticia"></textarea><br/>
    <button type="submit"  value="publicar" name="publicar" <?php echo $disable;?>>PUBLICAR</button><br/>
</form>
<?php } //cierre de funcion nuevaNoticia?>




  
