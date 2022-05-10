<?php
$raiz=getenv("DOCUMENT_ROOT");
$directorio_general="/proyectoAlcance";
include_once($raiz.$directorio_general."/vista/header.php");
?>
<div class="container-fluid text-center">    
  <div class="row content">
  <section>
         <div class="col-md-4 text-left"> 
        </div>
     
        <div class="col-md-4 text-left"> 
            <h2>Recuperación de contraseña</h2>
            <form action="." method="POST" >
                <input type="hidden" name="accion" value="recuperarpaso3">
                <input type="hidden" name="usuarioId" value="<?php if( isset($usuarioId)) {echo $usuarioId; } ?>">
                <p>Ingrese su nueva contraseña</p>

                <label for="usr">password:</label> 
                <input maxlength="200" type="password" class="form-control"  id="password3" name="password3" value="" required>
                  <div id="pswmeter" class="mt-3"></div>
                  <div id="pswmeter-message" class="mt-3"></div>
                
                <br>
                <br>
                <label for="usr">confirme nuevamente su password:</label> 
                <input maxlength="200" type="password" class="form-control"  id="repassword3" name="repassword3" value="" required>
                <br>
                <input class="btn btn-primary" type="submit" value="Cambiar password"> 
            </form>
        </div>
            
        <div class="col-md-4 text-left"> 
        </div>
        </section>
    </div>
</div>

<script>
    
    // Run pswmeter with options
    const myPassMeter = passwordStrengthMeter({
      containerElement: '#pswmeter',
      passwordInput: '#password3',
      showMessage: true,
      messageContainer: '#pswmeter-message',
      messagesList: [
        'Write your password...',
        'Easy peasy!',
        'That is a simple one',
        'That is better',
        'Yeah! that password rocks ;)'
      ],
      height: 6,
      borderRadius: 0,
      pswMinLength: 8,
      colorScore1: '#aaa',
      colorScore2: '#aaa',
      colorScore3: '#aaa',
      colorScore4: 'limegreen'
    });
    
    </script>
      


