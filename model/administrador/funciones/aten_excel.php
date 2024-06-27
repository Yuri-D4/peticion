<?php
session_start();
require_once("../../../db/connection.php");
require_once '../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Establecer conexión a la base de datos
$db = new Database();
$con = $db->conectar();

if (isset($_POST['aten_excel'])) { // Asegúrate de usar el nombre correcto de tu botón
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar los encabezados de columna
    $sheet->setCellValue('A1', 'Cedula');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Apellido');
    $sheet->setCellValue('D1', 'Correo');
    $sheet->setCellValue('E1', 'Tipo de Solicitud');
    $sheet->setCellValue('F1', 'Fecha');
    $sheet->setCellValue('G1', 'Descripción');
    $sheet->setCellValue('H1', 'Estado');

    // Obtener datos de la base de datos
    $result = $con->prepare("SELECT solicitudes.documento, usuarios.nombre, usuarios.apellido, usuarios.correo, tipo_solicitud.tipo_soli, solicitudes.fecha, solicitudes.descripcion, estado.nom_estado 
                            FROM solicitudes 
                            INNER JOIN tipo_solicitud ON tipo_solicitud.id_tip_soli = solicitudes.id_tip_soli 
                            INNER JOIN estado ON estado.id_estado = solicitudes.id_estado 
                            INNER JOIN usuarios ON usuarios.documento = solicitudes.documento 
                            WHERE solicitudes.id_estado = 1 
                            ORDER BY solicitudes.fecha ASC");
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    // Llenar datos
    $row = 2;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item['documento']);
        $sheet->setCellValue('B' . $row, $item['nombre']);
        $sheet->setCellValue('C' . $row, $item['apellido']);
        $sheet->setCellValue('D' . $row, $item['correo']);
        $sheet->setCellValue('E' . $row, $item['tipo_soli']);
        $sheet->setCellValue('F' . $row, $item['fecha']);
        $sheet->setCellValue('G' . $row, $item['descripcion']);
        $sheet->setCellValue('H' . $row, $item['nom_estado']);
        $row++;
    }

    // Establecer encabezados para la descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Solicitudes Respondidas.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
    header('Cache-Control: cache, must-revalidate'); 
    header('Pragma: public'); 

    // Guardar como Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>
