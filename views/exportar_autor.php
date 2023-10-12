<?php
require_once '../Assets/utils/fpdf.php'; 
require_once __DIR__ . "/../controllers/AutorController.php";

$autorController = new AutorController();
$result = $autorController->getAllAutores();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Lista de autores', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(20, 7, 'ID',  1, 0, 'L', 1);
$pdf->Cell(90, 7, 'Nombre', 1, 0, 'L', 1);
$pdf->Cell(50, 7, 'Fecha de nacimiento', 1, 1, 'L', 1);

$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(20, 7, $row['id'], 1);
    $pdf->Cell(90, 7, $row['nombre'], 1);
    $pdf->Cell(50, 7, $row['fechaNacimiento'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
