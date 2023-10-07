<?php

class Libro {
    private $conn;
    private $table_name = "libros";

    public $id;
    public $titulo;
    public $idAutor;
    public $anio_publicacion;
    public $ISBN;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET titulo=:titulo, idAutor=:idAutor, anio_publicacion=:anio_publicacion, ISBN=:ISBN";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->idAutor = htmlspecialchars(strip_tags($this->idAutor));
        $this->anio_publicacion = htmlspecialchars(strip_tags($this->anio_publicacion));
        $this->ISBN = htmlspecialchars(strip_tags($this->ISBN));

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":idAutor", $this->idAutor);
        $stmt->bindParam(":anio_publicacion", $this->anio_publicacion);
        $stmt->bindParam(":ISBN", $this->ISBN);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo=:titulo, idAutor=:idAutor, anio_publicacion=:anio_publicacion, ISBN=:ISBN WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->idAutor = htmlspecialchars(strip_tags($this->idAutor));
        $this->anio_publicacion = htmlspecialchars(strip_tags($this->anio_publicacion));
        $this->ISBN = htmlspecialchars(strip_tags($this->ISBN));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":idAutor", $this->idAutor);
        $stmt->bindParam(":anio_publicacion", $this->anio_publicacion);
        $stmt->bindParam(":ISBN", $this->ISBN);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        return $stmt;
    }
}

?>