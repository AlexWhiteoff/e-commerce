<?php

namespace core;

/**
 * The main class of the system core
 */
class Core
{
    protected static $instance;
    private static $mainTemplate;
    private static $dataBase;

    private function __construct()
    {
        spl_autoload_register('\core\Core::__autoload');

        global $config;

        self::$dataBase = new Database(
            $config['Database']['Server'],
            $config['Database']['Username'],
            $config['Database']['Password'],
            $config['Database']['Database']
        );

        $this->__deleteTmpFiles();
    }

    /**
     * Returns an instance of the system core
     * @return Core
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new core();
            return self::getInstance();
        } else {
            return self::$instance;
        }
    }

    /**
     * Returns a database connection object
     */
    public function getDataBase()
    {
        return self::$dataBase;
    }
    /**
     * System initialization
     */
    public function init()
    {
        session_start();
        self::$mainTemplate = new Template();
    }
    /**
     * Performs the basic process of the CMS-system
     */
    public function run()
    {
        $pathParts = ['', ''];

        if (array_key_exists('path', $_GET)) {
            $path = $_GET['path'];
            $pathParts = explode('/', $path);
        }

        empty($pathParts[0]) ? $className = 'controller\\HomeController' : $className = 'controller\\' . ucfirst($pathParts[0]) . 'Controller';
        empty($pathParts[1]) ? $methodName = 'actionIndex' : $methodName = 'action' . ucfirst($pathParts[1]);

        if (class_exists($className)) {
            $controller = new $className();

            if (method_exists($controller, $methodName)) {
                $method = new \ReflectionMethod($className, $methodName);
                $paramsArray = [];
                foreach ($method->getParameters() as $parameter) {
                    array_push($paramsArray, isset($_GET[$parameter->name]) ? $_GET[$parameter->name] : null);
                }
                $result = $method->invokeArgs($controller, $paramsArray);
                if (is_array($result)) {
                    self::$mainTemplate->setParams($result);
                }
            } else
                // throw new \Exception('404 Not found');
                header('Location: /home/404');
        } else
            // throw new \Exception('404 Not found');
            header('Location: /home/404');
    }
    /**
     * Autoloader classes
     * @param $classname string Class name
     */
    public static function __autoload($className)
    {
        $fileName = $className . '.php';
        if (is_file($fileName))
            include($fileName);
    }

    /**
     * Deleting temporary files older than 24h
     */
    public function __deleteTmpFiles()
    {
        $dir = "files/tmp/";

        foreach (glob($dir . '*') as $file) {
            if (time() - filectime($file) > 86400)
                unlink($file);
        }
    }

    /**
     * Shutting down the system and outputting the result
     */
    public function done()
    {
        self::$mainTemplate->display('view/layout/header.php');
        self::$mainTemplate->display('view/layout/footer.php');
    }
}
