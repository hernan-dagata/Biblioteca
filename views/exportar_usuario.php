<?php
require_once '../controllers/UsuarioController.php';
require_once '../Assets/utils/fpdf.php';

$usuarioController = new UsuarioController();

$result = $usuarioController->getAllUsuarios();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Lista de Usuarios', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);

$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 10, 'ID', 1, 0, 'L', 1);
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'L', 1);
$pdf->Cell(60, 10, utf8_decode('Dirección'), 1, 0, 'L', 1);
$pdf->Cell(30, 10, utf8_decode('Teléfono'), 1, 1, 'L', 1);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(50, 10, utf8_decode($row['nombre']), 1);
    $pdf->Cell(60, 10, utf8_decode($row['direccion']), 1);
    $pdf->Cell(30, 10, $row['telefono'], 1, 1);
}

$pdf->Output();
?>
