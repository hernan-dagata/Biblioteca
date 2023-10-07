<?php

require_once __DIR__ . "/../models/Database.php";
require_once __DIR__ . "/../models/Libro.php";

class LibroController {
    
    public function createLibro($titulo, $idAutor, $anio_publicacion, $ISBN) {
        $db = (new Database())->getConnection();
        $libro = new Libro($db);

        $libro->titulo = $titulo;
        $libro->idAutor = $idAutor;
        $libro->anio_publicacion = $anio_publicacion;
        $libro->ISBN = $ISBN;

        return $libro->create();
    }

    public function getAllLibros() {
        $db = (new Database())->getConnection();
        $libro = new Libro($db);

        return $libro->read();
    }

    public function getLibro($id) {
        $db = (new Database())->getConnection();
        $libro = new Libro($db);
        
        $libro->id = $id;
        return $libro->readOne();
    }

    public function updateLibro($id, $titulo, $idAutor, $anio_publicacion, $ISBN) {
        $db = (new Database())->getConnection();
        $libro = new Libro($db);
    
        $libro->id = $id;
        $libro->titulo = $titulo;
        $libro->idAutor = $idAutor;
        $libro->anio_publicacion = $anio_publicacion;
        $libro->ISBN = $ISBN;

        return $libro->update();
    }

    public function deleteLibro($id) {
        $db = (new Database())->getConnection();
        $libro = new Libro($db);
    
        $libro->id = $id;
    
        return $libro->delete();
    }

    public function getLibroTituloById($id) {
        $db = (new Database())->getConnection();
        $query = "SELECT titulo FROM libros WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return $row['titulo'];
        }
    
        return null;
    }    
}

?>