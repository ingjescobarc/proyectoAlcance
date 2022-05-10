<?php
class Arreglos
{
    
    /// <summary>
    /// Método que permite obtener el valor de un parámetro en particular
    /// en base al nombre del parámetro.
    /// </summary>
    function obtenerParametro($nombreParametro, $arreglo)
    {

        $valor ="";
        //$nombreParametro = "rijdaelpass";
        foreach($arreglo as $key => $val) 
        {
            if($val["nombre"] == $nombreParametro)
            {
                $valor = $val["valor"];
            }
        }
        
        return $valor;

    }    
            
}

