<?php 

/// <summary>
/// Definiciones y accesos a las diferentes operaciones para el usuario.
/// </summary>   

function insertarUsuario($nombre, $apellidopaterno, $apellidomaterno, $estatusId, $tipousuarioId, $correoelectronico, $passwordEncriptadoUsuario)
{
        global $db;
        $count = 0;
        $query = "INSERT INTO usuarios 
                        (nombre,apellidopaterno,apellidomaterno,estatusId, tipousuarioId, correoelectronico, password) 
                    VALUES 
                        (:nombre, :apellidopaterno, :apellidomaterno, :estatusId, :tipousuarioId, :correoelectronico, :password)";
        $statement = $db->prepare($query);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellidopaterno', $apellidopaterno);
        $statement->bindValue(':apellidomaterno', $apellidomaterno);
        $statement->bindValue(':estatusId', $estatusId);
        $statement->bindValue(':tipousuarioId', $tipousuarioId);
        $statement->bindValue(':correoelectronico', $correoelectronico);
        $statement->bindValue(':password', $passwordEncriptadoUsuario); //password encriptado con algoritmo rijdael
        if ($statement->execute()) 
        {
            $count = $statement->rowCount();
        }
        $statement->closeCursor();
        return $count;
}

    function consultarTodosUsuarios() 
    {
        global $db;
        $query = 'SELECT distinct u.id, u.nombre, u.apellidopaterno, u.apellidomaterno, u.correoelectronico, u.estatusId, u.tipousuarioId, 
        (select descripcion from estatus where id = u.estatusId) as estatusDescripcion,
        (select descripcion from tipousuario where id = u.tipousuarioId) as tipousuarioDescripcion
        FROM usuarios as u
        order by u.id desc';
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        return json_encode(['data' => $results]);
    }

    function borrarUsuario($id) 
    {
        global $db;
        $count = 0;
        $query = 'DELETE FROM usuarios
                WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        if ($statement->execute()) {
            $count = $statement->rowCount();
        }
        $statement->closeCursor();
        return $count;
    }

    function consultarUsuarioById($id) 
    {
        global $db;
        $query = 'SELECT * FROM usuarios
                WHERE id = :id ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    }
    
    function actualizarUsuario($id, $nombre, $apellidopaterno, $apellidomaterno, $estatusId, $tipousuarioId, $correoelectronico, $password) {
        global $db;
        $count = 0;
        $query = 'UPDATE usuarios
                SET nombre = :nombre, apellidopaterno = :apellidopaterno, apellidomaterno = :apellidomaterno, 
                    estatusId = :estatusId, tipousuarioId = :tipousuarioId, correoelectronico = :correoelectronico, password = :password WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellidopaterno', $apellidopaterno);
        $statement->bindValue(':apellidomaterno', $apellidomaterno);
        $statement->bindValue(':estatusId', (int)$estatusId);
        $statement->bindValue(':tipousuarioId', (int)$tipousuarioId);
        $statement->bindValue(':correoelectronico', $correoelectronico);
        $statement->bindValue(':password', $password);
        if ($statement->execute())  
        {
            $count = $statement->rowCount();
        }
        $statement->closeCursor();
        return $count;
    }
    
        function actualizarcontraseña($id, $password) {
        global $db;
        $count = 0;
        $query = 'UPDATE usuarios
                SET password = :password WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':password', $password);
        if ($statement->execute())  
        {
            $count = $statement->rowCount();
        }
        $statement->closeCursor();
        return $count;
    }
    
    function consultarUsuarioByCorreoElectronico($correoelectronico) 
    {
        global $db;
        $query = 'SELECT * FROM usuarios
                WHERE correoelectronico = :correoelectronico ';
        $statement = $db->prepare($query);
        $statement->bindValue(':correoelectronico', $correoelectronico);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();

        return $results;
    }
    
    function consultarParametros() 
    {
        global $db;
        $query = 'SELECT nombre, valor FROM parametros';
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    }
   