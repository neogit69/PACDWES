<?php
 //iniicializamos todos los inputs 
 $email=$pwd=$pwd2=$nombre=$direccion=$codigo_postal=$provincia=$genero=$fecha_nacimiento="";
 
 $numerrores=0;
include 'form_functions.php';//contiene funciones que controlan las entradas del formulario antes de ser enviadas ala BD

//controlamos como hemos llegado hasta aqui
if($_SERVER["REQUEST_METHOD"]=="GET"){//si venimos desde el menu
  $modo="CREAR";
  echo '<h2 class="nombre-pagina">Crear Usuario</h2>';
}
if($_SERVER["REQUEST_METHOD"]=="POST"){//si venimos desde list_usuarios.php o desde form_usuario.php
  if(isset($_POST['accion']) && $_POST['accion']=="modificar"){//venimos desde list_usuarios para modificacion
    echo '<h2 class="nombre-pagina">Modificando usuarios</h2>';
    echo "modificando usuario ". $_POST['id']."<br/>";
    $modo="modificar";
    $idmod=$_POST['id'];
    modificaUsuario($idmod);
  }elseif(isset($_POST['accion']) && $_POST['accion']=="borrar"){
    
    borraUsuario($_POST['id']);//no tiempo para confirmacion, se borra del tiron :-(
    header("location:index.php?opcion=usuarios");  
  }
  else{//venimos desde el propio form_usuario porque algun dato es incorrecto
    $modo="CREAR";
    insertaNuevoUsuario();
  }
}

function insertaNuevoUsuario(){
  global $numerrores,$nombre,$email,$pwd,$fecha_nacimiento,$direccion,$provincia,$codigo_postal,$genero;
  // echo '<h2 class="nombre-pagina">Registro de usuarios</h2>';


  //comprobamos campo por campo los datos introducidos
   $numerrores+=test_campo_nombre();//estas funciones se encuentran en form_functions.php
   $numerrores+=test_campo_email();
   $numerrores+=test_campo_pwd();
   $numerrores+=test_campo_pwd2();
   $numerrores+=test_campo_fecha_nacimiento();
   $numerrores+=test_campo_direccion(); 
   $numerrores+=test_campo_codigo_postal(); 
   $numerrores+=test_campo_genero(); 
   $numerrores+=test_campo_provincia(); 
   $numerrores+=test_existe_email($email,"insert",0); //modo insert. si se esta creando usuarios nuevos
   $numerrores+=test_existe_nombre($nombre,"insert",0); 

  //una vez comprobado todo segun el numero de errores encontrados hacemos...
  if($numerrores==0){
    // echo "no se ha encontrado ningun error<br/>";
    // echo "procedemos a crear el usuario<br/>";
    $datosform=array("nombre"=>$nombre,
                      "email"=>$email,
                      "pwd"=>$pwd,
                      "fecha_nacimiento"=>$fecha_nacimiento,
                      "edad"=>calculaEdad($fecha_nacimiento),
                      "direccion"=>$direccion,
                      "provincia"=>$provincia,
                      "codigo_postal"=>$codigo_postal,
                      "genero"=>$genero
                    );
    //si el usuario no existe crearlo, en caso contrario avisar                
    creaUsuario($datosform);
  }else{
    echo "corrige los errores<br/>";
    echo "se han encontrado ".$numerrores." errores<br/>";
    echo "no se ha creado ningun nuevo usuario<br/>";
  }
  
  
    


}

function modificaUsuario($idmod){
  global $numerrores,$nombre,$email,$pwd,$pwd2,$fecha_nacimiento,$direccion,$provincia,$codigo_postal,$genero;
  // echo '<h2 class="nombre-pagina">Registro de usuarios</h2>';
 //recuperar datos
 $datos=datosUsuario($idmod);
 $registro=mysqli_fetch_array($datos,MYSQLI_ASSOC);
 foreach($registro as $nombrevariable=>$valorvariable){//extrae de datosform el nombre y el valor de cada variable
   $varname=$nombrevariable;//contiene el nombre de la variable
   $$varname=$valorvariable;//se asigna el valor
   //de este modo las variables se crean dinámicamente y están disponibles para su uso
 }
 $pwd2=$pwd;
  //cuando se pulse el boton modificar se chequea todo
  if(isset($_POST['enviar']) && $_POST['enviar']=="modificar"){
    echo "SE HA SOLICITADO LA MODIFICACION<br/>";
    //comprobamos campo por campo los datos introducidos
     $numerrores+=test_campo_nombre();//estas funciones se encuentran en form_functions.php
     $numerrores+=test_campo_email();//puede dar problemas porque chequea si usuario ya existe
     $numerrores+=test_campo_pwd();//todo esto deberia ir a una funcion para limpiar codigo duplicado pero.... time time
     $numerrores+=test_campo_pwd2();
     $numerrores+=test_campo_fecha_nacimiento();
     $numerrores+=test_campo_direccion(); 
     $numerrores+=test_campo_codigo_postal(); 
     $numerrores+=test_campo_genero(); 
     $numerrores+=test_campo_provincia();
     $numerrores+=test_existe_email($email,"update",$idmod); //modo insert. si se esta creando usuarios nuevos
     $numerrores+=test_existe_nombre($nombre,"update",$idmod);  
  
    //una vez comprobado todo segun el numero de errores encontrados hacemos...
    if($numerrores==0){
      // echo "no se ha encontrado ningun error<br/>";
      // echo "procedemos a crear el usuario<br/>";
      $datosform=array("nombre"=>$nombre,
                        "email"=>$email,
                        "pwd"=>$pwd,
                        "fecha_nacimiento"=>$fecha_nacimiento,
                        "edad"=>calculaEdad($fecha_nacimiento),
                        "direccion"=>$direccion,
                        "provincia"=>$provincia,
                        "codigo_postal"=>$codigo_postal,
                        "genero"=>$genero
                      );
      //si el usuario no existe crearlo, en caso contrario avisar                
      actualizaUsuario($datosform,$idmod);
    }else{
      // echo "corrige los errores<br/>";
      echo "se han encontrado ".$numerrores." errores<br/>";
      echo "no se ha modificado usuario<br/>";
    }
  }  
}
// function confirmarBorrado($id){
//   return false;
// }
?>
  <form action="" method="post">
    <div id="formulario-usuarios">
      
      <label for="email">Email:</label><br>
      <input type="email"
             id="email"
             placeholder="Introduce tu email" 
             name="email"
             value="<?php echo $email;?>">
             <span class="error">* <?php echo $emailError;?></span>
             <br/>
             
             <label for="pwd">Password:</label><br>
             <input type="password"
             id="pwd"
             placeholder="Introduce contraseña"
             name="pwd" 
             value="<?php echo $pwd;?>">
             <span class="error">* <?php echo $pwdError;?></span>
             <br/>
             
             <label for="pwd2">Verificar Password:</label><br>
             <input type="password"
             id="pwd2" 
             placeholder="Verifica contraseña"
             name="pwd2"
             value="<?php echo $pwd2;?>">
             <span class="error">* <?php echo $pwd2Error;?></span>
             <br/>
             
             <label for="nombre">Nombre de usuario:</label><br>
             <input type="text"
             id="nombre"
             placeholder="Introduce alias (máximo 50 caracteres)"
             name="nombre" 
             size="50"
             maxlength="50"
             value="<?php echo $nombre;?>">
             <span class="error">* <?php echo $nombreError;?></span>
             <br/>
             
             <label for="fecha_nacimiento">Fecha de nacimiento:</label><br>
             <input type="date"
             id="fecha_nacimiento" 
             name="fecha_nacimiento"
             value="<?php echo $fecha_nacimiento;?>">
             <span class="error">* <?php echo $fecha_nacimientoError;?></span>
             <br/>

    </div>
    
    <div class="form-group">
      <label for="direccion">Dirección:</label><br>
      <input type="text"
             id="direccion"
             placeholder="Introduce tu dirección postal"
             name="direccion"
             value="<?php echo $direccion;?>">
             <span class="error">* <?php echo $direccionError;?></span>
             <br/>

      <label for="provincia">Provincia:</label><br>
         <select id="provincia" name="provincia">
            <option value="alicante">Alicante</option>
           <option value="barcelona">Barcelona</option>
           <option value="madrid">Madrid</option>
          <option value="sevilla">Sevilla</option>
        </select>   
         <span class="error">* <?php echo $provinciaError;?></span>
         <br/>
      
      <label for="codigo_postal">Código Postal:</label><br>
      <input type="text" 
             id="codigo_postal"
             name="codigo_postal"
             pattern="\d{5}"
             size="5"
             maxlength="5"
             title="Código postal de 5 digitos"
             placeholder="C.P."
             value="<?php echo $codigo_postal;?>">
             <span class="error">* <?php echo $codigo_postalError;?></span>
             <br/>
    </div>
    
    <div class="radio">
      <label for="genero">Genero</label><br>
      <input type="radio" name="genero" <?php if (isset($genero) && $genero=="mujer") echo "checked";?> value="mujer">Mujer
      <input type="radio" name="genero" <?php if (isset($genero) && $genero=="hombre") echo "checked";?> value="hombre">Hombre
      <span class="error">* <?php echo $generoError;?></span>
  <br><br>
    </div>
    
    <input type="hidden" name="accion" value="<?php echo $modo;?>">
    <?php if (isset($idmod)){?>
    <input type="hidden" name="id" value="<?php echo $idmod;?>">
      <?php }?>
    <button type="submit" name="enviar" value="<?php echo $modo?>"><?php echo $modo?></button><br>
  </form>



