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

        <section>
            <h2><?php echo $tituloAgregarModificar ?></h2>
            <form action="." method="POST" >
              <?php
               if(isset($usuarioIdEditar))
               {
                   echo '<input type="hidden" name="accion" value="editar">';
               }
               else 
               {
                     echo '<input type="hidden" name="accion" value="insertar">'; 
               }
               ?>
               
                <input type="hidden" id="id" name="id" value="<?php if(isset($id)){ echo $id; } if(isset($resultado[0]["id"])){ echo $resultado[0]["id"]; }?>">
                
                <label  for="usr">Nombre:</label> 
                <input maxlength="50" type="text" class="form-control"  id="nombre" name="nombre" value="<?php if(isset($nombre)){ echo $nombre; } if(isset($resultado[0]["nombre"])){ echo $resultado[0]["nombre"]; }?>" required>
                <label for="usr">Apellido paterno:</label>
                <input maxlength="50" type="text" class="form-control"  id="apellidopaterno" name="apellidopaterno" value="<?php if(isset($apellidopaterno)){ echo $apellidopaterno; } if(isset($resultado[0]["apellidopaterno"])){ echo $resultado[0]["apellidopaterno"]; }?>" required>
                <label for="usr">Apellido materno:</label>
                <input maxlength="50" type="text" class="form-control"  id="apellidomaterno" name="apellidomaterno" value="<?php if(isset($apellidomaterno)){ echo $apellidomaterno; }  if(isset($resultado[0]["apellidomaterno"])){ echo $resultado[0]["apellidomaterno"]; }?>" required>
                
                <br>
                <label for="estatus">Estatus:</label>

                <select  name="estatusId" id="estatusId" required>
                <option value="1" <?php if( isset($estatusId)){ if($estatusId =="1") {echo 'selected'; }} if( isset($resultado[0]["estatusId"])){ if($resultado[0]["estatusId"] =="1") {echo 'selected'; }}?>  >Activo</option>
                <option value="0" <?php if( isset($estatusId)){ if($estatusId =="0") {echo 'selected'; }} if( isset($resultado[0]["estatusId"])){ if($resultado[0]["estatusId"] =="0") {echo 'selected'; }}?>  >Suspendido</option>
                </select> 
                <br> 
                   <br>
                   
                <label for="estatus">Tipo Usuario:</label>

                <select  name="tipousuarioId" id="tipousuarioId" required>
                <option value="1" <?php if( isset($tipousuarioId)){ if($tipousuarioId =="1") {echo 'selected'; }} if( isset($resultado[0]["tipousuarioId"])){ if($resultado[0]["tipousuarioId"] =="1") {echo 'selected'; }}?>   >Administrador</option>
                <option value="2" <?php if( isset($tipousuarioId)){ if($tipousuarioId =="2") {echo 'selected'; }} if( isset($resultado[0]["tipousuarioId"])){ if($resultado[0]["tipousuarioId"] =="2") {echo 'selected'; }}?>  >Empleado</option>
                </select> 
                <br> 
                <br> 
                   
                <label for="usr">Correo electrónico:</label>
                <input maxlength="200" type="text" class="form-control"  id="correoelectronico2" name="correoelectronico2" value="<?php if(isset($correoelectronico2)){ echo $correoelectronico2; } if(isset($resultado[0]["correoelectronico"])){ echo $resultado[0]["correoelectronico"]; }?>" required>

                <br>
                
                <label for="usr">Password:</label> 
                <input maxlength="200" type="password" class="form-control"  id="password" name="password" value="" required>
                  <div id="pswmeter" class="mt-3"></div>
                  <div id="pswmeter-message" class="mt-3"></div>
                <br>
              <?php 
              // se cambian los titulos de los botones en base a si es una inserción o una edición de usuario.
              if(isset($usuarioIdEditar))
              {
                 echo '<input class="btn btn-primary" type="submit" value="Guardar">'; 
              }
              else 
              {
                 echo '<input class="btn btn-primary" type="submit" value="Agregar">';  
              }
              ?>

            </form>
           
        </section>
    </div>
      
<?php
include_once($raiz.$directorio_general."/vista/menuLateralDerecho.php"); 
include($raiz.$directorio_general."/vista/footer.php"); 
