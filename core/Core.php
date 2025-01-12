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
        spl_autoload_register([self::class, '__autoload']);

        $dbConfig = Configuration::get('config', 'Database');

        self::$dataBase = new Database(
            $dbConfig['Server'],
            $dbConfig['Username'],
            $dbConfig['Password'],
            $dbConfig['Database']
        );
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
        date_default_timezone_set('Europe/Kiev');
        Logger::log('Session started', 'INFO');
        self::$mainTemplate = new Template();
        // TempFiles::init();
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

        $className = empty($pathParts[0])
            ? 'controller\\HomeController'
            : 'controller\\' . ucfirst($pathParts[0]) . 'Controller';

        $methodName = empty($pathParts[1])
            ? 'actionIndex'
            : 'action' . ucfirst($pathParts[1]);

        Logger::log("Attempting to load class: {$className}, method: {$methodName}", 'INFO');

        $methodName = class_exists($className) && method_exists($className, $methodName) ? $methodName : 'action404';
        $className = class_exists($className) && $methodName !== 'action404' ? $className : 'controller\\HomeController';


        $controller = new $className();


        $method = new \ReflectionMethod($className, $methodName);

        if ($method->isPublic()) {
            $paramsArray = [];
            foreach ($method->getParameters() as $parameter) {
                if (!$parameter->isOptional() && !isset($_GET[$parameter->name])) {
                    Logger::log("Missing required parameter: {$parameter->name}");
                    throw new \Exception("Missing required parameter: {$parameter->name}");
                }
                $paramsArray[] = $_GET[$parameter->name] ?? $parameter->getDefaultValue();
            }

            $result = $method->invokeArgs($controller, $paramsArray);

            if (is_array($result)) {
                self::$mainTemplate->setParams($result);
            }
        }

        return;
    }

    /**
     * Autoloader classes
     * @param $classname string Class name
     */
    public static function __autoload($className)
    {
        $fileName = __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';

        if (is_file($fileName)) {
            include($fileName);
        } else {
            Logger::log("File not found for class '$className': $fileName", 'WARNING');
            return;
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
