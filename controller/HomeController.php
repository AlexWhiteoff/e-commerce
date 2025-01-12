<?php

namespace controller;

use core\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('home', null, ['namePage' => 'Woodmade&reg;']);
    }

    public function action404()
    {
        header('HTTP/1.0 404 Not Found');

        return $this->render('404', null, ['namePage' => '404 Error: Page Not Found']);
    }
}
