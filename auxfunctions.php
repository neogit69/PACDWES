<?php

      function isnuevanoticia(){

        if(isset($_POST['publicar'])){
            if(isset($_POST['titulo'])&&isset($_POST['contenido'])){
            echo "OK";
            //insertar registro en la base de datos
            }
            else{
            echo "ERROR";
            //indicar que pasa
            }
  
        }
      } 

      function calculaEdad($fechanac){//devuelve la edad en años dada una fecha de nacimiento
        $hoy = date_create(date('Y-m-d'));
        $nacimiento = date_create($fechanac);
        $intervalo = date_diff($nacimiento, $hoy);
        if($hoy<$nacimiento){
          return 0;//aun no has nacido
        }
        else{
          $edad=$intervalo->format('%y'); //es un string 
          return (int)$edad;//forzamos a entero
        }
      }



      //devuelve la opcion elegida en los menus
      function menuControl(){
        if(!isset($_GET['opcion'])){
            $opcion="inicio"; 
            //echo "la opcion predeterminada es ".$opcion."<br/>";
            return $opcion;
        }
        else{
            //echo "ERROR : no se ha seleccionado opcion pero se establece en 1 por defecto <br/>";
            $opcion=$_GET['opcion']; //se asigna la opcion elegida
            //echo "la opcion elegida es ".$opcion."<br/>";
            return $opcion;
        }
      }


      function infoPost(){
          foreach($_POST as $k=>$v){
              echo $k."=".$v."<br/>";
          }
      }

      function infoGet(){
        foreach($_GET as $k=>$v){
            echo $k."=".$v."<br/>";
        }
      }  

      function infoIp(){
        echo "Conexión establecida desde : ".$_SERVER['REMOTE_ADDR']."</br>";
      }

      function infoSesion(){
        if(isset($_SESSION['usuario'])){//contiene el id del usuario
          $quien_es=getNombreId($_SESSION['usuario']);//funcion en funciones_bd.php. Extrae el nombre de usuario de la bd
          if($_SESSION['usuario']==1){//si es administrador el id vale 1
            echo "Conectado como : $quien_es (ADMIN)<br/>";
          }
          else{
            echo "Conectado como : $quien_es (Usuario Registrado)<br/>";
          }
        }
        else{
          echo "Conectado como : Invitado <br/>";
        }
      }
      
      function limpiarEntrada($dato) {//comprobar si es necesario addslashes
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
      }

      function generarTabla($tabla,$nombrecss){
        $numfilas=mysqli_num_rows($tabla);
        $numcampos=mysqli_num_fields($tabla);       
        echo "<table class="."'".$nombrecss."'".">";
        echo "<thead>";
        echo "<tr>";
        for($c=1;$c<=$numcampos;$c++){//crea la cabecera de la tabla
          $campo=mysqli_fetch_field($tabla);
          echo "<th>".$campo->name."<br/></th>";//.$campo->length."<br/>".$campo->type."</th>";otros datos de campo
        }
        echo "</tr></thead>";
        echo "<tbody>";
        for($f=1;$f<=$numfilas;$f++){//creamos el cuerpo de la tabla
          $registro=mysqli_fetch_array($tabla,MYSQLI_ASSOC);
          echo "<tr>";
          foreach($registro as $atributo=>$valor){
            if($atributo=="id"){
                $id=$valor;//guardamos el id porque lo necesitamos pasar por el formulario de botones de accion
            }
            echo "<td>".$valor."</td>";
            
            //aqui podemos añadir botones adicionales de modificacion y borrado por campo en un futuro
            
          }
          //aqui añadimos td de botones o formularios por filas solo para administrador y registrados
          if(isset($_SESSION['usuario'])&& $_SESSION['usuario']>=1){
          ?>
          <td>
            <form action="index.php?opcion=crear_usuarios" method="post">
              <input type="hidden" name="accion" value="modificar">
              <input type="hidden" name="id" value="<?php echo $id;//aqui usamos el id ?>">
              <input type="submit" value="MODIFICAR">
            </form>
          </td>
          <td>
            <form action="index.php?opcion=crear_usuarios" method="post">
              <input type="hidden" name="accion" value="borrar">
              <input type="hidden" name="id" value="<?php echo $id;//y aqui tambien?>">
              <input type="submit" value="BORRAR">
            </form>
          </td>
          <?php
          }

          


        }
      
        echo"</tbody></table>";
          
      }

  ?>