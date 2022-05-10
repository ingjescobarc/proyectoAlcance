<?php
class mensajes
{
/// <summary>
/// Funcionalidad que permite desplegar una notifición al cliente.
/// Cada mensaje se muestra en diferente color para resaltar la gravedad del incidente.
/// <param name="$mensaje">Mensaje que se mostrará.</param>
/// <param name="$tipoMensaje"> Tipo de mensaje  1= correcto  2 = warning 3=error.</param>
/// </summary>
/// <returns></returns>
function mostrarMensaje($mensaje, $tipoMensaje)
{
    if($tipoMensaje == 1)
    {
       echo "<script type='text/javascript'>$.notify('$mensaje', {color: '#fff', background: '#23c552', verticalAlign:'bottom'});</script>"; 
    }
    
    if($tipoMensaje == 2)
    {
       echo "<script type='text/javascript'>$.notify('$mensaje', {color: '#f8d6a9', background: '#f84f31', verticalAlign:'bottom'});</script>"; 
    }
    
    if($tipoMensaje == 3)
    {
       echo "<script type='text/javascript'>$.notify('$mensaje', {color: '#fff', background: '#D44950', verticalAlign:'bottom'});</script>"; 
    }


}

}