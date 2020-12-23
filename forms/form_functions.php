<?php
$emailError=$pwdError=$pwd2Error=$nombreError=$direccionError=$codigo_postalError=$provinciaError=$generoError="";
$fecha_nacimientoError="";
function test_campo_nombre(){
    global $nombreError,$nombre;
    if (empty($_POST["nombre"])) {
      $nombreError = "El nombre es obligatorio";
      return 1;
    } else {
      $nombre = limpiarEntrada($_POST["nombre"]);
      // los nombres deben estar compuestos de caracteres
      if (!preg_match("/^[a-zA-Z][a-z A-Z 0-9]{2,50}$/",$nombre)) {
        $nombreError = "El nombre debe empezar por una letra seguida de 2 o más letras y numeros y como maximo 50 caracteres en total";
        return 1;
      }
      return 0;
    }
  }
  
  function test_campo_email(){
    
    global $emailError,$email;
    if (empty($_POST["email"])) {
      $emailError = "El email es obligatorio";
      return 1;
    } else {
      $email = limpiarEntrada($_POST["email"]);
      // los emails deben estar bien formados, lo comprobamos con filter_var
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "la direccion de correo es incorrecta";
        return 1;
      }
     
      return 0;
    }
  }
  
  function test_campo_pwd(){
    
    global $pwdError,$pwd;
    if (empty($_POST["pwd"])) {
      $pwdError = "El password es obligatorio";
      return 1;
    } else {
      $pwd = limpiarEntrada($_POST["pwd"]);
      if (!preg_match("/^[a-zA-Z0-9]{6,16}$/",$pwd)) {
        $pwdError= "el password debe contener entre 6 y 16 caracteres alfanumericos";
        return 1;
      }
      return 0;
    }
  }
  
  function test_campo_pwd2(){
    
    global $pwd2Error,$pwd,$pwd2;
    if (empty($_POST["pwd2"])) {
      $pwd2Error = "El password es obligatorio";
      return 1;
    } else {
      $pwd2 = limpiarEntrada($_POST["pwd2"]);
      if (!preg_match("/^[a-zA-Z0-9]{6,16}$/",$pwd2)) {
        $pwd2Error = "el password debe contener entre 6 y 16 caracteres alfanumericos";
        return 1;
      }else{
        //el patron coincide y comprobamos si los dos pwd son iguales
        if($pwd!=$pwd2){
          $pwd2Error="El password no coincide<br/>";
          return 1;
        }
      }
      return 0;
    }
  }
  
  function test_campo_fecha_nacimiento(){
    
    global $fecha_nacimientoError,$fecha_nacimiento;
    if(empty($_POST['fecha_nacimiento'])){
      $fecha_nacimientoError="La fecha es obligatoria";
      return 1;
    }else{
      $fecha_nacimiento=limpiarEntrada($_POST['fecha_nacimiento']);
      $edad=calculaEdad($fecha_nacimiento);
      // echo "la variable edad es tipo ".gettype($edad)."<br/>";
      // echo "la edad calculada es ".$edad."<br/>";
      if($edad<18){
        $fecha_nacimientoError="Debes ser mayor de edad para registrarte";
        return 1;
      }
      return 0;
    }
  }
  
  function test_campo_direccion(){
    
    global $direccionError,$direccion;
    if (empty($_POST["direccion"])) {
      $direccionError = "La dirección es obligatoria";
      return 1;
    }else {
      $direccion = limpiarEntrada($_POST["direccion"]);
      return 0;
    }
  }
  
  function test_campo_codigo_postal(){
    
    global $codigo_postalError,$codigo_postal;
    if (empty($_POST["codigo_postal"])) {
      $codigo_postalError = "El código postal es obligatorio";
      return 1;
    } else {
      $codigo_postal = limpiarEntrada($_POST["codigo_postal"]);
      return 0;
    }
    
  }
  
  function test_campo_genero(){
    
    global $generoError,$genero;
    if (empty($_POST["genero"])) {
      $generoError = "Debes selecionar una casilla";
      return 1;
    } else {
      $genero = limpiarEntrada($_POST["genero"]);
      return 0;
    }
  }
  
  function test_campo_provincia(){
    
    global $provinciaError,$provincia;
  if (empty($_POST["provincia"])) {
    $provinciaError = "Debes selecionar una provincia";
    return 1;
  } else {
    $provincia=limpiarEntrada($_POST['provincia']);
    return 0;
  }
 }

 //si se esta insertando se impide crear usuarios con mismo email o nombre existente
 //si se esta actualizando impide modificar nombre o email si existen y pertenecen a otro usuario
 //pero si existen y son los tuyos propios no se queja(es un poco extraño pero funciona :)
 function test_existe_email($email,$modo,$idmod){//para impedir  emails duplicados
  global $emailError;
  if(getNombreUsuario($email) && $modo=="insert"){
    $emailError="El usuarioya existe<br/>";
    return 1;
  }
  if(getNombreUsuario($email) && $modo=="update" && $idmod!=getIdUsuario($email)){
    $emailError="El usuarioya existe<br/>";
    return 1;
  }
  
  return 0;
 }

 function test_existe_nombre($nombre,$modo,$idmod){//para impedir nombres  duplicados
  global $nombreError;
  if(existeUsuario($nombre) && $modo=="insert"){
    $nombreError="El nombre ya existe, seleccione otro<br/>";
    return 1;
  }
  if(existeUsuario($nombre) && $modo=="update" && $idmod!=getIdUsuarioByName($nombre)){
    $nombreError="El nombre ya existe, pruebe con otro<br/>";
    return 1;
  }
  
  return 0;
 }
?>