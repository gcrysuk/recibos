<?php

namespace App\Controllers;

use App\Models\FirmaModel;
use CodeIgniter\RESTful\ResourceController;

class FirmaController extends ResourceController
{
    protected $modelName = 'App\Models\FirmaModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $firma = $this->model->find($id);
        return $firma ? $this->respond($firma) : $this->failNotFound('Firma no encontrada');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'id' => $this->model->getInsertID(),
                'mensaje' => 'Firma registrada correctamente'
            ]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respond(['mensaje' => 'Firma actualizada']);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Firma eliminada']);
        }

        return $this->failNotFound('Firma no encontrada');
    }
}
