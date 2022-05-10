<?php 
/// <summary>
/// Apartado que permite configurar el acceso a datos de nuestra aplicación.
/// </summary>    

    $cadenaConexion = 'mysql:host=localhost;dbname=alcance';
    $usuario = 'root';
    $password = '';

    try 
    {
        // el parámetro PDO::MYSQL_ATTR_FOUND_ROWS => true
        // permite a mysql devolver cuando no hay cambios en la actualización devolver correctamente
        // el numero de registros actualizados.
        $db = new PDO($cadenaConexion, $usuario, $password, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
    } 
    catch (PDOException $e) 
    {
        $error_message = 'Error al conectarse a la bd: ';
        $error_message .= $e->getMessage();
        include('vista/error.php');
        exit();
    } 
