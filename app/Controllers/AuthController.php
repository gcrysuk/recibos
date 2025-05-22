<?php
// app/Controllers/AuthController.php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $data = $this->request->getJSON();

        $model = new UserModel();
        $user = $model->where('email', $data->email)->first();

        if (!$user || !password_verify($data->password, $user['password'])) {
            return $this->failUnauthorized('Email o contraseña incorrectos.');
        }

        // Guardar en sesión
        session()->set([
            'user_id' => $user['id'],
            'email'   => $user['email'],
            'logged_in' => true,
        ]);

        return $this->respond(['message' => 'Login exitoso.']);
    }

    public function logout()
    {
        session()->destroy();
        return $this->respond(['message' => 'Sesión finalizada.']);
    }
}
