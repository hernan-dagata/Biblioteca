<?php
require_once '../controllers/PrestamoController.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/LibroController.php';
require_once '../Assets/utils/fpdf.php';

$prestamoController = new PrestamoController();
$usuarioController = new UsuarioController();
$libroController = new LibroController();

$result = $prestamoController->getAllPrestamos();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Lista de Prestamos', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);

$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 10, 'ID', 1, 0, 'L', 1);
$pdf->Cell(50, 10, 'Usuario', 1, 0, 'L', 1);
$pdf->Cell(60, 10, 'Libro', 1, 0, 'L', 1);
$pdf->Cell(35, 10, utf8_decode('Fecha préstamo'), 1, 0, 'L', 1);
$pdf->Cell(35, 10, utf8_decode('Fecha devolución'), 1, 1, 'L', 1);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(50, 10, utf8_decode($usuarioController->getUsuarioNombreById($row['idUsuario'])), 1);
    $pdf->Cell(60, 10, utf8_decode($libroController->getLibroTituloById($row['idLibro'])), 1);
    $pdf->Cell(35, 10, $row['fechaPrestamo'], 1);
    $pdf->Cell(35, 10, $row['fechaDevolucion'], 1, 1);
}

$pdf->Output();
?>
