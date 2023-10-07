<?php

class Prestamo {
    private $conn;
    private $table_name = "prestamos";

    public $id;
    public $idUsuario;
    public $idLibro;
    public $fechaPrestamo;
    public $fechaDevolucion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET idUsuario=:idUsuario, idLibro=:idLibro, fechaPrestamo=:fechaPrestamo, fechaDevolucion=:fechaDevolucion";

        $stmt = $this->conn->prepare($query);

        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->idLibro = htmlspecialchars(strip_tags($this->idLibro));
        $this->fechaPrestamo = htmlspecialchars(strip_tags($this->fechaPrestamo));
        $this->fechaDevolucion = htmlspecialchars(strip_tags($this->fechaDevolucion));

        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":idLibro", $this->idLibro);
        $stmt->bindParam(":fechaPrestamo", $this->fechaPrestamo);
        $stmt->bindParam(":fechaDevolucion", $this->fechaDevolucion);

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

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET idUsuario=:idUsuario, idLibro=:idLibro, fechaPrestamo=:fechaPrestamo, fechaDevolucion=:fechaDevolucion WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->idUsuario = htmlspecialchars(strip_tags($this->idUsuario));
        $this->idLibro = htmlspecialchars(strip_tags($this->idLibro));
        $this->fechaPrestamo = htmlspecialchars(strip_tags($this->fechaPrestamo));
        $this->fechaDevolucion = htmlspecialchars(strip_tags($this->fechaDevolucion));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":idUsuario", $this->idUsuario);
        $stmt->bindParam(":idLibro", $this->idLibro);
        $stmt->bindParam(":fechaPrestamo", $this->fechaPrestamo);
        $stmt->bindParam(":fechaDevolucion", $this->fechaDevolucion);
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

}

?>