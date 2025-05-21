<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf_processor
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('documento_model');
        $this->CI->load->model('usuario_model');
    }

    public function process_recibos($file_path)
    {
        // Aquí implementaremos la lógica para:
        // 1. Extraer texto del PDF para buscar DNIs
        // 2. Separar el PDF en archivos individuales
        // 3. Asignar a los empleados correspondientes

        try {
            // Este es un esquema básico, se implementará completamente más adelante
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file_path);

            $pages = $pdf->getPages();
            $processed = 0;

            foreach ($pages as $page) {
                $text = $page->getText();

                // Buscar DNI en el texto (patrón simplificado)
                preg_match('/DNI[:\s]*([0-9]{7,8})/i', $text, $matches);

                if (isset($matches[1])) {
                    $dni = $matches[1];
                    $empleado = $this->CI->usuario_model->get_by_dni($dni);

                    if ($empleado) {
                        // Guardar este recibo para este empleado
                        // Aquí falta implementar la lógica para extraer la página individual

                        $documento_data = array(
                            'usuario_id' => $empleado->id,
                            'nombre' => 'Recibo ' . date('Y-m-d'),
                            'ruta' => 'ruta/al/archivo/individual.pdf', // Esto se implementará después
                            'estado' => 'pendiente',
                            'fecha_creacion' => date('Y-m-d H:i:s')
                        );

                        $this->CI->documento_model->insert($documento_data);
                        $processed++;
                    }
                }
            }

            return array('status' => 'success', 'count' => $processed);
        } catch (Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }
}
