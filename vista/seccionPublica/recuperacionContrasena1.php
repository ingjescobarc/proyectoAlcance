<?php
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
include_once($raiz.$directorio_general."/vista/header.php");
?>

<div class="container-fluid text-center">    
  <div class="row content">

 <section>
        <div class="col-md-4 text-left"></div>
     
        <div class="col-md-4 text-left"> 
            <h2>Recuperación de contraseña</h2>
            <form action="." method="POST" >
                 <input type="hidden" name="accion" value="recuperarpaso1">
                <p>Ingrese su correo eléctronico y enviaremos las instrucciones para acceder nuevamente al sistema</p>
                <label for="usr">Correo electrónico:</label>
                <input maxlength="200" type="text" class="form-control"  id="correoelectronico3" name="correoelectronico3" value="" required>
                <br>
                 <input class="btn btn-primary" type="submit" value="Recuperar"> 
            </form>
            </div>
            
            <div class="col-md-4 text-left"></div>
        </section>

    </div>
    
</div>
      


