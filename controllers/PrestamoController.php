<?php

require_once __DIR__ . "/../models/Database.php";
require_once __DIR__ . "/../models/Prestamo.php";

class PrestamoController {

    public function createPrestamo($idUsuario, $idLibro, $fechaPrestamo, $fechaDevolucion) {
        $db = (new Database())->getConnection();
        $prestamo = new Prestamo($db);

        $prestamo->idUsuario = $idUsuario;
        $prestamo->idLibro = $idLibro;
        $prestamo->fechaPrestamo = $fechaPrestamo;
        $prestamo->fechaDevolucion = $fechaDevolucion;

        return $prestamo->create();
    }

    public function getAllPrestamos() {
        $db = (new Database())->getConnection();
        $prestamo = new Prestamo($db);

        return $prestamo->read();
    }

    public function updatePrestamo($id, $idUsuario, $idLibro, $fechaPrestamo, $fechaDevolucion) {
        $db = (new Database())->getConnection();
        $prestamo = new Prestamo($db);
    
        $prestamo->id = $id;
        $prestamo->idUsuario = $idUsuario;
        $prestamo->idLibro = $idLibro;
        $prestamo->fechaPrestamo = $fechaPrestamo;
        $prestamo->fechaDevolucion = $fechaDevolucion;
    
        return $prestamo->update();
    }
    
    public function deletePrestamo($id) {
        $db = (new Database())->getConnection();
        $prestamo = new Prestamo($db);
    
        $prestamo->id = $id;
    
        return $prestamo->delete();
    }
}

?>
