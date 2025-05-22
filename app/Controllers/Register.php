<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;


class Register extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        $data = $this->request->getJSON();

        $model = new \App\Models\UserModel();

        $userData = [
            'email'    => $data->email,
            'nombre'   => $data->nombre,
            'password' => password_hash($data->password, PASSWORD_DEFAULT),
        ];

        $model->insert($userData);

        return $this->respondCreated(['message' => 'Usuario registrado correctamente']);
    }
}
