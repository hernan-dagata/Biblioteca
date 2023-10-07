<?php

class Usuario {
    private $db;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $direccion;
    public $telefono;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, direccion=:direccion, telefono=:telefono";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);

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
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, direccion=:direccion, telefono=:telefono WHERE id=:id";
        $stmt = $this->conn->prepare($query);
    
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
    
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
    
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