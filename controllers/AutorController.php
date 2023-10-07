<?php

require_once __DIR__ . "/../models/Database.php";
require_once __DIR__ . "/../models/Autor.php";

class AutorController {
    public function createAutor($nombre, $fechaNacimiento) {
        $db = (new Database())->getConnection();
        $autor = new Autor($db);

        $autor->nombre = $nombre;
        $autor->fechaNacimiento = $fechaNacimiento;

        return $autor->create();
    }

    public function getAllAutores() {
        $db = (new Database())->getConnection();
        $autor = new Autor($db);

        return $autor->read();
    }

    public function updateAutor($id, $nombre, $fechaNacimiento) {
        $db = (new Database())->getConnection();
        $autor = new Autor($db);
    
        $autor->id = $id;
        $autor->nombre = $nombre;
        $autor->fechaNacimiento = $fechaNacimiento;
    
        return $autor->update();
    }
    
    public function deleteAutor($id) {
        $db = (new Database())->getConnection();
        $autor = new Autor($db);
    
        $autor->id = $id;
    
        return $autor->delete();
    }

}

?>