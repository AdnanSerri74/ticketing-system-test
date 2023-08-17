<?php

namespace app\Http\Controllers;

class HomeController
{
    public function home()
    {
        redirect('/submit-a-ticket');
    }
}