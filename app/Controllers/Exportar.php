<?php
namespace App\Controllers;
use App\Models\DatosUsuarioModel;
use App\Models\PagoModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exportar extends BaseController
{
    public function excelPagos()
    {
        $usuarioModel = new DatosUsuarioModel();
        $pagoModel = new PagoModel();

        // Obtener datos
        $datos = $usuarioModel->select('datos_usuarios.*, pagos.id_pago, pagos.estado, pagos.fecha_pago')
            ->join('pagos', 'pagos.id_usuario = datos_usuarios.id_usuario', 'left')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados simples
        $sheet->setCellValue('A1', 'ID Usuario');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Apellido');
        $sheet->setCellValue('D1', 'Cédula');
        $sheet->setCellValue('E1', 'ID Pago');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('G1', 'Fecha Pago');

        // Datos
        $fila = 2;
        foreach ($datos as $item) {
            $sheet->setCellValue('A' . $fila, $item['id_usuario']);
            $sheet->setCellValue('B' . $fila, $item['nombre']);
            $sheet->setCellValue('C' . $fila, $item['apellido']);
            $sheet->setCellValue('D' . $fila, $item['cedula']);
            $sheet->setCellValue('E' . $fila, $item['id_pago'] ?? 'N/A');
            $sheet->setCellValue('F' . $fila, $item['estado'] ?? 'Pendiente');
            $sheet->setCellValue('G' . $fila, $item['fecha_pago'] ?? '');
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'pagos_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
