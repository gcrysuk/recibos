<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReciboModel;
use App\Models\UsuarioModel;

class Recibos extends BaseController
{
    protected $reciboModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->reciboModel = new ReciboModel();
        $this->usuarioModel = new UsuarioModel();
    }

    // Formulario para subir recibo
    public function nuevo()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('recibos/nuevo', $data);
    }

    // Procesar carga de recibo
    public function guardar()
    {
        $archivo = $this->request->getFile('archivo');

        if (!$archivo->isValid() || $archivo->getClientMimeType() !== 'application/pdf') {
            return redirect()->back()->with('error', 'Debe subir un archivo PDF válido.');
        }

        $archivo->move(WRITEPATH . 'recibos'); // guardado en writable/recibos
        $nombreArchivo = $archivo->getName();

        $this->reciboModel->save([
            'usuario_id' => $this->request->getPost('usuario_id'),
            'archivo'    => 'recibos/' . $nombreArchivo,
            'fecha'      => date('Y-m-d'),
            'firma'      => null,
        ]);

        return redirect()->to('/recibos/nuevo')->with('mensaje', 'Recibo cargado correctamente.');
    }
    public function misRecibos()
    {
        $usuarioId = session()->get('usuario_id'); // Asegurarse que el usuario esté logueado
        $reciboModel = new ReciboModel();

        $recibos = $reciboModel->where('usuario_id', $usuarioId)
            ->orderBy('fecha_subida', 'DESC')
            ->findAll();

        return view('recibos/mis_recibos', ['recibos' => $recibos]);
    }
    public function subirMasivo()
    {
        helper(['form', 'filesystem']);

        $archivos = $this->request->getFiles()['recibos'];
        $usuarioModel = new \App\Models\UsuarioModel();
        $reciboModel = new \App\Models\ReciboModel();

        foreach ($archivos as $archivo) {
            if ($archivo->isValid() && $archivo->getExtension() === 'pdf') {
                $nombreArchivo = $archivo->getName(); // ej: 12345678_2024_04.pdf
                $partes = explode('_', pathinfo($nombreArchivo, PATHINFO_FILENAME));

                if (count($partes) === 3) {
                    $dni = $partes[0];
                    $anio = $partes[1];
                    $mes = $partes[2];

                    $usuario = $usuarioModel->where('dni', $dni)->first();

                    if ($usuario) {
                        // Guardar archivo
                        $archivo->move(WRITEPATH . '../public/uploads/recibos', $nombreArchivo);

                        // Guardar en DB
                        $reciboModel->save([
                            'usuario_id' => $usuario['id'],
                            'mes' => $mes,
                            'anio' => $anio,
                            'archivo' => $nombreArchivo,
                            'firmado' => 1, // si ya viene firmado
                            'fecha_subida' => date('Y-m-d'),
                        ]);
                    }
                }
            }
        }

        return redirect()->to('/admin/recibos')->with('mensaje', 'Recibos cargados correctamente.');
    }
    public function vistaSubirMasivo()
    {
        return view('recibos/subir_masivo');
    }
    public function listar()
    {
        $reciboModel = new ReciboModel();

        // Si el usuario es admin ve todo, si no, solo los suyos
        $usuario = session()->get('usuario');
        if ($usuario['rol'] === 'admin') {
            $recibos = $reciboModel->findAll();
        } else {
            $recibos = $reciboModel->where('usuario_id', $usuario['id'])->findAll();
        }

        return view('recibos/listado', ['recibos' => $recibos]);
    }
    public function firmar($id)
    {
        $reciboModel = new ReciboModel();
        $recibo = $reciboModel->find($id);

        if (!$recibo) {
            return redirect()->back()->with('error', 'Recibo no encontrado');
        }

        // Solo permitir que el empleado firme su propio recibo (si no es admin)
        $usuario = session()->get('usuario');
        if ($usuario['rol'] !== 'admin' && $recibo['usuario_id'] != $usuario['id']) {
            return redirect()->back()->with('error', 'No tienes permiso para firmar este recibo');
        }

        // Marcar como firmado (simulado)
        $reciboModel->update($id, [
            'firmado' => 1,
            'fecha_firma' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(site_url('recibos/listar'))->with('success', 'Recibo firmado correctamente');
    }
    public function procesarMasivo()
    {
        helper(['form', 'filesystem']);

        $archivo = $this->request->getFile('archivo');
        $periodo = $this->request->getPost('periodo');

        if (!$archivo->isValid() || $archivo->getClientMimeType() !== 'application/pdf') {
            return redirect()->back()->with('error', 'Archivo inválido. Debe ser un PDF.');
        }

        // Guardar archivo temporalmente
        $nombreArchivo = $archivo->getRandomName();
        $rutaTemporal = WRITEPATH . 'uploads/' . $nombreArchivo;
        $archivo->move(WRITEPATH . 'uploads/', $nombreArchivo);

        // Dividir PDF en páginas individuales
        require_once(APPPATH . 'ThirdParty/fpdf/fpdf.php');
        require_once(APPPATH . 'ThirdParty/fpdi/src/autoload.php');

        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile($rutaTemporal);

        $reciboModel = new \App\Models\ReciboModel();
        $usuarioModel = new \App\Models\UsuarioModel();

        $exito = 0;
        $fallo = 0;

        for ($i = 0; $i < $pageCount; $i++) {
            $pdf = new \setasign\Fpdi\Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile($rutaTemporal);
            $tpl = $pdf->importPage($i + 1);
            $pdf->useTemplate($tpl);

            // Extraer texto de la página para detectar DNI o identificador
            // (esto requiere herramientas adicionales como smalot/pdfparser si lo deseás)
            // Por ahora, simulamos con empleados ordenados
            $usuarios = $usuarioModel->orderBy('id', 'ASC')->findAll();

            if (!isset($usuarios[$i])) {
                $fallo++;
                continue;
            }

            $usuario = $usuarios[$i];

            // Guardar página como nuevo PDF individual
            $nombreNuevo = 'recibo_' . $usuario['id'] . '_' . $periodo . '.pdf';
            $rutaNueva = WRITEPATH . 'recibos/' . $nombreNuevo;
            $pdf->Output($rutaNueva, 'F');

            // Guardar en DB
            $reciboModel->insert([
                'usuario_id'   => $usuario['id'],
                'nombre_archivo' => $nombreNuevo,
                'periodo'      => $periodo,
                'fecha_firma'  => null,
                'ruta'         => $rutaNueva,
            ]);

            $exito++;
        }

        unlink($rutaTemporal); // Limpieza

        return redirect()->back()->with('success', "Proceso completado. $exito recibos cargados, $fallo fallaron.");
    }
}
