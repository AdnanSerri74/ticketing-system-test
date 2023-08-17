<?php

namespace app\Core\Middleware;

use app\Core\App;
use app\Core\DB;
use app\Core\Session;

class Authenticated
{
    public function handle(): void
    {
        if (Session::has('_token'))
        {
            $token =  Session::get('_token');

            $db = App::resolve(DB::class);

            $user = $db->query("SELECT token FROM users WHERE token = '$token'")->find();
            if (!$user) {
                Session::destroy();
                redirect(Middleware::HOME);
            }

            return;
        }

        redirect(Middleware::LOGIN);
    }
}