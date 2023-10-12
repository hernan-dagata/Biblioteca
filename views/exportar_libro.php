<?php
require_once '../controllers/LibroController.php';
require_once '../controllers/AutorController.php';
require_once '../Assets/utils/fpdf.php';

$libroController = new LibroController();
$autorController = new AutorController();

$result = $libroController->getAllLibros();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Lista de libros', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(15, 10, 'ID', 1, 0, 'L', 1);
$pdf->Cell(60, 10, 'Título', 1, 0, 'L', 1);
$pdf->Cell(50, 10, 'Autor', 1, 0, 'L', 1);
$pdf->Cell(20, 10, 'Año', 1, 0, 'L', 1);
$pdf->Cell(40, 10, 'ISBN', 1, 1, 'L', 1);

$dbInstance = new Database();
$db = $dbInstance->getConnection();
$pdf->SetFont('Arial', '', 12);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $autorObj = new Autor($db);
    $autorObj->id = $row['idAutor'];
    $autorResult = $autorObj->readOne();
    $autorData = $autorResult->fetch(PDO::FETCH_ASSOC);

    $pdf->Cell(15, 10, $row['id'], 1);
    $pdf->Cell(60, 10, $row['titulo'], 1);
    $pdf->Cell(50, 10, $autorData['nombre'], 1);
    $pdf->Cell(20, 10, $row['anio_publicacion'], 1);
    $pdf->Cell(40, 10, $row['ISBN'], 1, 1);
}

$pdf->Output();
?>