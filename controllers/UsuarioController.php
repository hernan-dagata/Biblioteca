<?php

require_once __DIR__ . "/../models/Database.php";
require_once __DIR__ . "/../models/Usuario.php";

class UsuarioController {
    
    public function createUsuario($nombre, $direccion, $telefono) {
        $db = (new Database())->getConnection();
        $usuario = new Usuario($db);

        $usuario->nombre = $nombre;
        $usuario->direccion = $direccion;
        $usuario->telefono = $telefono;

        return $usuario->create();
    }
    
    public function getAllUsuarios() {
        $db = (new Database())->getConnection();
        $usuario = new Usuario($db);

        return $usuario->read();
    }

    public function updateUsuario($id, $nombre, $direccion, $telefono) {
        $db = (new Database())->getConnection();
        $usuario = new Usuario($db);
    
        $usuario->id = $id;
        $usuario->nombre = $nombre;
        $usuario->direccion = $direccion;
        $usuario->telefono = $telefono;
    
        return $usuario->update();
    }

    public function deleteUsuario($id) {
        $db = (new Database())->getConnection();
        $usuario = new Usuario($db);
    
        $usuario->id = $id;
    
        return $usuario->delete();
    }

    public function getUsuarioNombreById($id) {
        $db = (new Database())->getConnection();
        $query = "SELECT nombre FROM usuarios WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return $row['nombre'];
        }
    
        return null;
    }    
}

?>