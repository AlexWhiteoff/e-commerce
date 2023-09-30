<?php

namespace core;

use ReflectionClass;

/**
 * Базовий клас для всіх контролерів
 * @package core
 */
class Controller
{
    public function postFilter($fields)
    {
        return Utils::ArrayFilter($_POST, $fields);
    }

    public function isMethodPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            return true;
        else
            return false;
    }
    public function isMethodGet()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
            return true;
        else
            return false;
    }

    public function render($viewName, $localParams = null, $globalParams = null)
    {
        $tmpl = new Template();

        is_array($localParams) ? $tmpl->setParams($localParams) : false;
        !is_array($globalParams) ? $globalParams = [] : false;

        $moduleName = strtolower((new ReflectionClass($this))->getShortName());
        $globalParams['Content'] = $tmpl->render("view/{$moduleName}/{$viewName}.php");

        return $globalParams;
    }
}
