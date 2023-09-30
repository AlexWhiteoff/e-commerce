<?php

namespace controller;

use core\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('home', null, ['namePage' => 'Grovemade&reg;']);
    }

    public function action404()
    {
        return $this->render('404', null, ['namePage' => '404 Error: Page Not Found']);
    }
}