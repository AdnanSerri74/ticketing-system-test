<?php

namespace app\Http\Controllers\Admin;

use app\Core\Authenticator;
use app\Core\Middleware\Middleware;
use app\Http\Forms\LoginForm;

class AuthController
{
    public function loginForm()
    {
        return view('admin/auth/login.view');
    }

    public function login()
    {

        $data = request()->all();

        $form = LoginForm::validate($data);

        $signedIn = (new Authenticator)->attempt(
            $data['email'], $data['password']
        );

        if (!$signedIn) {
            $form->error(
                'email', 'No matching account found for that email address and password.'
            )->throw();
        }

        redirect(Middleware::ADMIN_DASHBOARD);
    }

    public function logout()
    {
        (new Authenticator)->logout();

        redirect(Middleware::LOGIN);
    }
}