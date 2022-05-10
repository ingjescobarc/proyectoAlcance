<?php 
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
include_once($raiz.$directorio_general."/vista/header.php");
?>

<div class="container-fluid text-center">    
  <div class="row content">

   <div class="col-md-4 text-center"> 
   </div>
      
    <div class="col-md-4 text-center"> 
        <section>
            <form action="." method="POST" >
                <h2>Acceso al sistema</h2>
                <input type="hidden" name="accion" value="login">
                <label for="usr">Correo electrónico:</label> 
                <input maxlength="200" type="text" class="form-control"  id="correoelectronico" name="correoelectronico" value="ingjescobarc@yahoo.com.mx" required>
                <label for="usr">Contraseña:</label>
                <input maxlength="200" type="password" class="form-control"  id="password" name="password" value="ingjescobarc" required>
                <br>
                <input class="btn btn-primary" type="submit" value="Entrar">
                <br>
                <br>
                             <a href=".?recuperacion=1">Olvide mi contraseña</a>
            </form>

        </section>
        <br>

      
  </div>
</div>
      
<?php 
include($raiz.$directorio_general."/vista/footer.php"); 
