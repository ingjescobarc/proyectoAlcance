<?php 
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
include_once($raiz.$directorio_general."/vista/header.php");

// candado de seguridad que permite que solo un administrador que inicio sesión acceda al formulario
if(!isset($_SESSION['accesoadministrador']))
{
     echo "<meta http-equiv='refresh' CONTENT='0; url=../controlador/index.php'>";
     exit();
 }

include_once($raiz.$directorio_general."/vista/menuSuperior.php"); 
?>
  
<div class="container-fluid text-center">    
  <div class="row content">
    
      
    <?php
    include_once($raiz.$directorio_general."/vista/menuLateralizquierdo.php"); 
    ?>

      
    <div class="col-md-8 text-left"> 

        <section>
            <h2>Consultar usuarios</h2>
            <form action="." method="POST" >
                <input type="hidden" name="accion" value="insertar">

      


<table id="datatableUsuarios" class="display" style="width:100%">
<thead>
    <tr>
        <th>Nombre</th>
        <th>Apellido paterno</th>
        <th>Apellido materno</th>
        <th>Correo electrónico</th>
        <th>Tipo usuario</th>
        <th>Estatus</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
</thead>
</table>


            
            </form>
            
            
            
        </section>
    </div>
      
<?php include_once($raiz.$directorio_general."/vista/menuLateralDerecho.php"); ?>

<?php 
include($raiz.$directorio_general."/vista/footer.php"); 
