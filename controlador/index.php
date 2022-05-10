<?php 
 session_start();
/// <summary>
/// Controlador principal que se encarga de mandar llamar a la vista o al modelo según se requiera.
/// Desarrollado por José Escobar C. 2022.
/// </summary>

$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";

// Instancias a diferentes clases y accesos a datos.
require($raiz.$directorio_general."/modelo/conexionBd.php");
require($raiz.$directorio_general."/modelo/usuariosModel.php");
require($raiz.$directorio_general."/utilerias/mensajes.php");
require($raiz.$directorio_general."/utilerias/RijndaelOpenSSL.php");
require($raiz.$directorio_general."/utilerias/Arreglos.php");
require($raiz.$directorio_general."/utilerias/Enumerados.php");


/*Inicialización de clases*/
$mensajes = new mensajes();
$arreglos = new Arreglos();
$rijndael = new RijndaelOpenSSL();
$enumerados = new Enumerados();

if(!isset($_SESSION["parametros"]))
{
    //Guardamos los parametros en una sesion para tenerlos disponibles en todo momento;
    $_SESSION["parametros"] = consultarParametros();
}

$mostrarMensaje = false;
$mensaje = "";  
$tipoMensaje = "";

// variables para los formularios de agregar y editar usuario
$id = "";
$nombre = "";
$apellidopaterno = "";
$apellidomaterno = "";
$estatus = "";
$correoelectronico = "";
$correoelectronicoTmp = "";
        
//Administra titulos
$tituloAgregarModificar = "";

// variable que permite detectar que acción esta realizando el usuario ejemplo login, insertar, consultar
$accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_STRING);

// variable que permite detectar que menu se mostrará al usuario
$menu = filter_input(INPUT_GET, 'menu',FILTER_SANITIZE_STRING);

//permite detectar si el usuario dio click en el botón de logout de la zona superior derecha, para finalizar sesión.
$logout = filter_input(INPUT_GET, 'logout',FILTER_SANITIZE_STRING);

//permite detectar si el usuario dio click en el botón de recuperar contraseña
$recuperacion = filter_input(INPUT_GET, 'recuperacion',FILTER_SANITIZE_STRING);

//variable que es enviada cuando dan click en el correo, con la finalidad
// de mostrar el formulario recuperacionContraseña2.php para ingresar la nueva contraseña
$recuperarpaso2 = filter_input(INPUT_GET, 'recuperarpaso2',FILTER_SANITIZE_STRING);

// paso que permite actualizar finalmente la contraseña de acceso
if($accion == "recuperarpaso3")
{
    $usuarioId = filter_input(INPUT_POST, 'usuarioId',FILTER_SANITIZE_STRING);
    $password3 = filter_input(INPUT_POST, 'password3',FILTER_SANITIZE_STRING);
    $repassword3 = filter_input(INPUT_POST, 'repassword3',FILTER_SANITIZE_STRING);
    
    if($password3 !=$repassword3 )
    {
        // ocurrio un error al actualizar el password
        $mostrarMensaje = true;
        $mensaje = "Las contraseñas tienen que ser iguales";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
        
        include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena2.php"); 
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        exit(); 
    }

    $passRijdael = $arreglos->obtenerParametro('rijdaelpass', $_SESSION["parametros"]);
    $passwordEncriptadoUsuario = $rijndael->encrypt($password3, $passRijdael);
    
    $count = actualizarcontraseña($usuarioId, $passwordEncriptadoUsuario);

    if($count <= 0)
    {
        // ocurrio un error al actualizar el password
        $mostrarMensaje = true;
        $mensaje = "Ocurrio un problema al intentar actualizar el password, intentelo nuevamente";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
        
        include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena2.php"); 
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        exit();
    }
    else
    {
        // ocurrio un error al actualizar el password
        $mostrarMensaje = true;
        $mensaje = "Contraseña actualizada correctamente";
        $tipoMensaje = 1; // 1= correcto  2 = warning 3 = error
        
        include_once($raiz.$directorio_general."/vista/seccionPublica/login.php");  
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        exit();     
    }
}

if(isset($recuperarpaso2))
{
    // obtenemos de la url el id del usuario en base 64
    $codificadoBase64 = $recuperarpaso2;
    $decodificado = base64_decode($codificadoBase64);
    $usuarioId = (int)trim($decodificado);
    
    include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena2.php"); 
    exit();
}

if(isset($recuperacion))
{
    include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena1.php"); 
    exit();
}

// flujo que permite iniciar el proceso para recuperar el acceso al sistema.
if($accion == "recuperarpaso1")
{
    $correoelectronicoTmp = filter_input(INPUT_POST, "correoelectronico3", FILTER_SANITIZE_EMAIL);
    if(!filter_var($correoelectronicoTmp, FILTER_VALIDATE_EMAIL)) 
    {
        $mostrarMensaje = true;
        $mensaje = "Correo electrónico incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 =   
        
        include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena1.php");  
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        exit();
    }
    else
    {
        //procedemos a enviar el correo
        $resultado = consultarUsuarioByCorreoElectronico($correoelectronicoTmp);
        
        if(count($resultado) <= 0)
        {
            $mostrarMensaje = true;
            $mensaje = "Correo electrónico no existe en el sistema";
            $tipoMensaje = 3; // 1= correcto  2 = warning 3 =   
            include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena1.php");   

            if(isset($mostrarMensaje) == true)
            {   
                $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
            }
            exit();
        }
         
        // obtenemos el password llave que requiere rijndael para desencriptar.
        $rutaBaseSistema = $arreglos->obtenerParametro('uribaseportal', $_SESSION["parametros"]);

        $cadena = $resultado[0]["id"]; //guardamos el id del usuario y lo codificamos en base64
        $codificado = base64_encode($cadena);
        $rutaBaseSistema = $rutaBaseSistema . "controlador/";
        $liga="<a href='$rutaBaseSistema?recuperarpaso2=$codificado'>click para cambiar mi contraseña</a>";

        $para      = $correoelectronicoTmp;
        $titulo    = 'Recuperación de contraseña ';

        $cabeceras = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . "\r\n" .
         'Content-type: text/html; charset=utf-8' . "\r\n" .
         phpversion();
        
        $mensajeGeneral = '<html>'.
	'<head><title>Recuperar contraseña</title></head>'.
	'<body><h1>Alcance Recuperación de Contraseña</h1>'.
	'Por favor de click en la siguiente liga para cambiar su contraseña'.
	'<hr>'.
	$liga.
	'</body>'.
	'</html>';

            $enviar = mail($para, $titulo, $mensajeGeneral, $cabeceras);
 
            include_once($raiz.$directorio_general."/vista/seccionPublica/recuperacionContrasena1.php");  
            if($enviar)
            {
                $tipoMensaje = 1; // 1= correcto  2 = warning 3 =  
                $mostrarMensaje = true;
                $mensaje = "Recibira en su bandeja de correo las instrucciones para ingresar al sistema";
            }
            else
            {
                $mostrarMensaje = true;
                $mensaje = "No se logrpo enviar el correo electronico con las instrucciones, intente nuevamente.";
                $tipoMensaje = 3; // 1= correcto  2 = warning 3 =        
            }
            
            if(isset($mostrarMensaje) == true)
            {   
                $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
            } 
            exit();
    }
   
}

if($accion == "login")
{   
    $correoelectronicoTmp = filter_input(INPUT_POST, "correoelectronico", FILTER_SANITIZE_EMAIL);
    if(!filter_var($correoelectronicoTmp, FILTER_VALIDATE_EMAIL)) 
    {
        $mostrarMensaje = true;
        $mensaje = "Correo electrónico incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 =        
    }
    else
    {
        $resultado = consultarUsuarioByCorreoElectronico($correoelectronicoTmp);
        
        if(count($resultado) >= 1)
        {
            $passwordrecibido = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
            $passwordBdEncriptado = $resultado[0]["password"];

            // obtenemos el password llave que requiere rijndael para desencriptar.
            $passRijdael = $arreglos->obtenerParametro('rijdaelpass', $_SESSION["parametros"]);
            $desencriptado = $rijndael->decrypt($passwordBdEncriptado, $passRijdael);
            
//            $passwordrecibido = 1;
//            $desencriptado= 1;
            if($passwordrecibido != $desencriptado)
            {
                $mostrarMensaje = true;
                $mensaje = "Password incorrecto";
                $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error

                include_once($raiz.$directorio_general."/vista/seccionPublica/login.php");  
                if(isset($mostrarMensaje) == true)
                {   
                   $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
                }
                exit();
            }
            else
            {
                if($resultado[0]["estatusId"] != (int)enumerados::Estatus_Activo )
                {
                    // usuario suspendido
                    $mostrarMensaje = true;
                    $mensaje = $resultado[0]["nombre"]. " tu usuario esta suspendido, contácta al administrador, gracias.";
                    $tipoMensaje = 2; // 1= correcto  2 = warning 3 = error
                    
                    include_once($raiz.$directorio_general."/vista/seccionPublica/login.php");  
                    if(isset($mostrarMensaje) == true)
                    {   
                        $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
                    }
                    exit();
                }
                
                // Login correcto
               $mostrarMensaje = true;
               $mensaje = "Bienvenido :" . $resultado[0]["nombre"];
               $tipoMensaje = 1; // 1= correcto  2 = warning 3 = error
               
               $_SESSION["datosusuario"] = $resultado;
               
               if($resultado[0]["tipousuarioId"] == 1)
               {
                   $_SESSION["accesoadministrador"] = 1;
                   include_once($raiz.$directorio_general."/vista/seccionPrivada/consultarUsuarios.php"); 
               }
               else
               {
                   $_SESSION["accesoempleado"] = 1;
                   include_once($raiz.$directorio_general."/vista/seccionPrivada/empleados.php"); 
               }
            }
        }
        else
        {
            $mostrarMensaje = true;
            $mensaje = "El correo electrónico no existe";
            $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error

            include_once($raiz.$directorio_general."/vista/seccionPublica/login.php");  

            if(isset($mostrarMensaje) == true)
            {   
               $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
            }
            exit();
        }
      

    }
}

if($accion == "insertar")
{    
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $apellidopaterno = filter_input(INPUT_POST, "apellidopaterno", FILTER_SANITIZE_STRING);
    $apellidomaterno = filter_input(INPUT_POST, "apellidomaterno", FILTER_SANITIZE_STRING);
    $estatusId = filter_input(INPUT_POST, "estatusId", FILTER_SANITIZE_NUMBER_INT);
    $tipousuarioId = filter_input(INPUT_POST, "tipousuarioId", FILTER_SANITIZE_NUMBER_INT);
    $correoelectronico2 = filter_input(INPUT_POST, "correoelectronico2", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    
    //    echo $nombre."<br>";
    //    echo $apellidopaterno."<br>";
    //    echo $apellidomaterno."<br>";
    //    echo $estatusId."<br>";
    //    echo $tipousuarioId."<br>";
    //    echo $correoelectronico2."<br>";
    
    $correoelectronicoTmp = filter_input(INPUT_POST, "correoelectronico2", FILTER_SANITIZE_EMAIL);
    if(!filter_var($correoelectronicoTmp, FILTER_VALIDATE_EMAIL)) 
    {
        $mostrarMensaje = true;
        $mensaje = "Correo electrónico incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error

        include_once($raiz.$directorio_general."/vista/seccionPrivada/agregarUsuarios.php"); 
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        exit();         
    }
    
    if ($nombre && $apellidopaterno && $apellidomaterno && isset($estatusId) && isset($tipousuarioId) && $correoelectronico2) 
    {
        $passRijdael = $arreglos->obtenerParametro('rijdaelpass', $_SESSION["parametros"]);
        $passwordEncriptadoUsuario = $rijndael->encrypt($password, $passRijdael);
    
        $count = insertarUsuario($nombre, $apellidopaterno, $apellidomaterno, (int)$estatusId, (int)$tipousuarioId, $correoelectronico2, $passwordEncriptadoUsuario);
        
       if($count >= 1)
       {
        $mostrarMensaje = true;
        $mensaje = "El usuario se insertó correctamente";
        $tipoMensaje = 1; // 1= correcto  2 = warning 3 = error
        include_once($raiz.$directorio_general."/vista/seccionPrivada/consultarUsuarios.php"); 
        
       }
       else
       {
        $mostrarMensaje = true;
        $mensaje = "Ocurrio un error al intentar registrar el usuario";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
       }
    }
    else 
    {          
        $mostrarMensaje = true;
        $mensaje = "Ocurrio un error, algun dato de registro es incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
    }
}

if($accion == "editar")
{    
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $apellidopaterno = filter_input(INPUT_POST, "apellidopaterno", FILTER_SANITIZE_STRING);
    $apellidomaterno = filter_input(INPUT_POST, "apellidomaterno", FILTER_SANITIZE_STRING);
    $estatusId = filter_input(INPUT_POST, "estatusId", FILTER_SANITIZE_NUMBER_INT);
    $tipousuarioId = filter_input(INPUT_POST, "tipousuarioId", FILTER_SANITIZE_NUMBER_INT);
    $correoelectronico2 = filter_input(INPUT_POST, "correoelectronico2", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    
    $tituloAgregarModificar = "Editar usuario";
    
    $correoelectronicoTmp = filter_input(INPUT_POST, "correoelectronico2", FILTER_SANITIZE_EMAIL);
    if(!filter_var($correoelectronicoTmp, FILTER_VALIDATE_EMAIL)) 
    {
        $mostrarMensaje = true;
        $mensaje = "Correo electrónico incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
        
        $usuarioIdEditar ="ok";
        include_once($raiz.$directorio_general."/vista/seccionPrivada/agregarUsuarios.php"); 
        if(isset($mostrarMensaje) == true)
        {   
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        
        exit(); 
    }
    
    if ($id && $nombre && $apellidopaterno && $apellidomaterno && isset($estatusId) && isset($tipousuarioId) && $correoelectronico2  && $password) 
    {
        
        $passRijdael = $arreglos->obtenerParametro('rijdaelpass', $_SESSION["parametros"]);
        $passwordEncriptadoUsuario = $rijndael->encrypt($password, $passRijdael);
        
       $count = actualizarUsuario($id, $nombre, $apellidopaterno, $apellidomaterno, $estatusId, $tipousuarioId, $correoelectronico2, $passwordEncriptadoUsuario);
       if($count >= 1)
       {
        $mostrarMensaje = true;
        $mensaje = "El usuario se actualizó correctamente";
        $tipoMensaje = 1; // 1= correcto  2 = warning 3 = error
       }
       else
       {
        $mostrarMensaje = true;
        $mensaje = "Error al actualizar el usuario";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
       }

        if(isset($mostrarMensaje) == true)
        {  
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
    }
    else 
    {          
        $mostrarMensaje = true;
        $mensaje = "Ocurrio un error, algun dato al actualizar es incorrecto";
        $tipoMensaje = 3; // 1= correcto  2 = warning 3 = error
        
        $usuarioIdEditar ="ok";
        include_once($raiz.$directorio_general."/vista/seccionPrivada/agregarUsuarios.php"); 
        
        if(isset($mostrarMensaje) == true)
        {  
            $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
        }
        
        exit(); 
    }
    
    include_once($raiz.$directorio_general."/vista/seccionPrivada/consultarUsuarios.php"); 
}

if($menu == 1) // menu agregar usuarios
{       
        $tituloAgregarModificar = "Agregar usuario";
        $usuarioIdEditar = filter_input(INPUT_GET, 'editar',FILTER_SANITIZE_STRING);
        if(isset($usuarioIdEditar))
        { 
           $tituloAgregarModificar = "Editar usuario";
           // consultamos la información del usuario a editar
           $resultado = consultarUsuarioById($usuarioIdEditar);
        }
        include_once($raiz.$directorio_general."/vista/seccionPrivada/agregarUsuarios.php"); 
}
else
if($menu == 2) // menu consultar usuarios
{
    include_once($raiz.$directorio_general."/vista/seccionPrivada/consultarUsuarios.php"); 
     
    //// OPERACIONES PARA BORRADO DE USUARIOS ////
    $usuarioIdBorrar = filter_input(INPUT_GET, 'borrar',FILTER_SANITIZE_STRING);
    if(isset($usuarioIdBorrar))
    {   
        $resultado = borrarUsuario($usuarioIdBorrar);
        echo "resultado=". $resultado;
        
        if($resultado >0)
        {
            $mostrarMensaje = true;
            $mensaje = "Usuario eliminado correctamente";
            $tipoMensaje = 1; // 1= correcto  2 = warning 3 = error 
        }
    }
}

// si no hay ninguna acción detectada ni menu seleccionado mostramos el formulario de login.
if(!isset($accion) && !isset($menu))
{
   include_once($raiz.$directorio_general."/vista/seccionPublica/login.php");  
}

 // permite invocar a la capa de utilerias clase mensaje
 // para invocar la funcionalidad para mostrar mensajes al usuario en diferentes colores.
if(isset($mostrarMensaje) == true)
{   $mensajes = new mensajes();
    $mensajes->mostrarMensaje($mensaje, $tipoMensaje);
}

// destruye todas las sesiones del sistema y redireccionamos a la pantalla de login
if(isset($logout))
{
        session_destroy();
        echo "<meta http-equiv='refresh' CONTENT='0; url=../controlador/index.php'>";
        exit();
}
