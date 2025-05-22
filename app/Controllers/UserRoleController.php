<?php

namespace App\Controllers;

use App\Models\UserRoleModel;
use CodeIgniter\RESTful\ResourceController;

class UserRoleController extends ResourceController
{
    protected $modelName = 'App\Models\UserRoleModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Asignación no encontrada');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['id' => $this->model->getInsertID()]);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['id' => $id, 'mensaje' => 'Asignación actualizada']);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'mensaje' => 'Asignación eliminada']);
        }
        return $this->failNotFound('Asignación no encontrada');
    }
}
