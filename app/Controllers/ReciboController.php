<?php

namespace App\Controllers;

use App\Models\ReciboModel;
use CodeIgniter\RESTful\ResourceController;

class ReciboController extends ResourceController
{
    protected $modelName = 'App\Models\ReciboModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $recibo = $this->model->find($id);
        return $recibo ? $this->respond($recibo) : $this->failNotFound('Recibo no encontrado');
    }

    public function create()
    {
        $file = $this->request->getFile('archivo');

        if (!$file->isValid() || $file->getClientMimeType() !== 'application/pdf') {
            return $this->failValidationErrors('Debe subir un archivo PDF válido.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);  // podés cambiar la ruta si querés

        $model = new ReciboModel();

        $data = [
            'usuario_id' => $this->request->getPost('usuario_id'),
            'archivo'    => $newName,
            'firmado'     => 'pendiente'
        ];

        $id = $model->insert($data);

        return $this->respondCreated(['id' => $id, 'mensaje' => 'Recibo subido correctamente.']);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respond(['mensaje' => 'Recibo actualizado']);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Recibo eliminado']);
        }

        return $this->failNotFound('Recibo no encontrado');
    }
    public function showUploadForm()
    {
        return view('recibos/upload_form'); // Muestra el formulario
    }

    public function upload()
    {
        // Validar archivo y datos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'archivo' => 'uploaded[archivo]|ext_in[archivo,pdf]|max_size[archivo,2048]',
            'usuario_id' => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        // Obtener archivo y datos
        $archivo = $this->request->getFile('archivo');
        $usuarioId = $this->request->getPost('usuario_id');

        // Mover archivo a carpeta "writable/uploads"
        $nuevoNombre = $archivo->getRandomName();
        $archivo->move(WRITEPATH . 'uploads', $nuevoNombre);

        // Guardar en base de datos (ejemplo)
        $data = [
            'usuario_id' => $usuarioId,
            'archivo' => $nuevoNombre,
            'ruta' => 'uploads/' . $nuevoNombre
        ];

        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Recibo subido correctamente']);
        }

        return $this->failServerError('Error al guardar en BD');
    }
    public function porUsuario($usuario_id)
    {
        $model = new \App\Models\ReciboModel();
        $recibos = $model->where('usuario_id', $usuario_id)->findAll();

        return $this->respond($recibos);
    }
}
