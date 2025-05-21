<?php

namespace App\Controllers;

use App\Models\DocumentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Documentos extends BaseController
{
    protected $model;
    protected $pdfProcessor;
    protected $session;

    public function __construct()
    {
        $this->model = new DocumentoModel();
        $this->pdfProcessor = service('pdf_processor'); // Asume que tienes este servicio
        $this->session = service('session');

        // Verificar login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data['documentos'] = $this->model->getAll();
        return view('documentos/listado', $data);
    }

    public function upload()
    {
        return view('documentos/upload');
    }

    public function processUpload()
    {
        // Configuración para subida de archivos
        $validationRule = [
            'documento' => [
                'label' => 'Documento PDF',
                'rules' => 'uploaded[documento]'
                    . '|mime_in[documento,application/pdf]'
                    . '|max_size[documento,5120]', // 5MB
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->to('documentos/upload')
                ->with('error', $this->validator->getErrors()['documento'])
                ->withInput();
        }

        $file = $this->request->getFile('documento');

        if (!$file->isValid()) {
            return redirect()->to('documentos/upload')
                ->with('error', $file->getErrorString())
                ->withInput();
        }

        // Mover el archivo al directorio de uploads
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $filePath = WRITEPATH . 'uploads/' . $newName;

        // Procesar el PDF (asumiendo que tienes este servicio)
        $result = $this->pdfProcessor->processRecibos($filePath);

        if ($result['status'] == 'success') {
            return redirect()->to('documentos')
                ->with('success', 'Se procesaron ' . $result['count'] . ' recibos correctamente');
        } else {
            return redirect()->to('documentos/upload')
                ->with('error', 'Error al procesar: ' . $result['message']);
        }
    }

    public function view($id)
    {
        $documento = $this->model->getById($id);

        if (!$documento) {
            throw new PageNotFoundException('No se encontró el documento con ID: ' . $id);
        }

        $data['documento'] = $documento;
        return view('documentos/view', $data);
    }

    public function byUser($userId)
    {
        // Usando el método del modelo (nota: hay discrepancia entre user_id y usuario_id)
        $data['documentos'] = $this->model->where('user_id', $userId)->findAll();
        return view('documentos/listado', $data);
    }
}
