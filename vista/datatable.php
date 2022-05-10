<?php 
// Archivo que consulta todos los usuarios para mostrarlos en el pluggin jquery datatable inicializado
// en el archivo vista/header.php

$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";

require($raiz.$directorio_general."/modelo/conexionBd.php");
require($raiz.$directorio_general."/modelo/usuariosModel.php");

echo consultarTodosUsuarios();
        