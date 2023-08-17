<?php

namespace app\Core\Middleware;

use app\Core\Session;

class Guest
{
    public function handle(): void
    {
        if (Session::has('_token'))
            redirect(Middleware::ADMIN_DASHBOARD);
    }
}