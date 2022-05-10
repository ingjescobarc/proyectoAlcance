<div class="col-sm-2 sidenav">
    <p> <h3>Menu principal</h3></p>

<?php
if(isset($_SESSION["datosusuario"]))
{
    if($_SESSION["datosusuario"][0]["tipousuarioId"] == 1)
    {
        // es administrador
        ?>
        <p><a href="?menu=1">Agregar usuarios</a></p>
        <p><a href="?menu=2">Consultar usuarios</a></p>
        <?php
    }
    else
    {
        // es empleado
        ?>

         Bienvenido empleado...
   
        <?php 
    }
}

?>
</div>


