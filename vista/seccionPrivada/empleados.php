<?php
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
include_once($raiz.$directorio_general."/vista/header.php");

// candado de seguridad que permite que solo un empleado que inicio sesión acceda al formulario
 if(!isset($_SESSION['accesoempleado']))
 {
     echo "<meta http-equiv='refresh' CONTENT='0; url=../controlador/index.php'>";
     exit();
 }
?>

<?php
include_once($raiz.$directorio_general."/vista/menuSuperior.php"); 
?>

<div class="container-fluid text-center">    
  <div class="row content">

    <?php
    include_once($raiz.$directorio_general."/vista/menuLateralizquierdo.php"); 
    ?>

      
    <div class="col-md-8 text-left"> 

        <section style=" text-align: center">
            <h2>Bienvenido empleado</h2>

            <p>Apartado para funcionalidades de un empleado </p>
            <p>El menu de administrador se oculta en base al tipousuarioId</p>
        </section>
    </div>
      
<?php
include_once($raiz.$directorio_general."/vista/menuLateralDerecho.php"); 
include($raiz.$directorio_general."/vista/footer.php"); 
