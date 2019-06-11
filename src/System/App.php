<?php

namespace src\System;

use src\Components\Router\Router;
use src\Components\Config\Config;
use src\Components\Locator;

/**
 * This class difines an entrypoint in application. 
 * It has some methods which determine the various settings of the application and directly launch the application.
 * @package src\app
 *  
 */
class App
{
    /**
     * @property App $appInstance  Instance of Application
     */
    private static $appInstance;
    public static $config;

    /**
     * This method has private type of access and undefined.
     */
    private function __construct(){}

    /**
     * This method realize singleton pattern and brings opportunity for create single object instance. 
     * @return App Instance of object type App
     */
    public static function getAppInstance()
    {
        if (empty(self::$appInstance)){
            self::$appInstance = new App();
        }
        return self::$appInstance;
    }


    /**
     * Load config files
     * @param string $directory
     * @param string $filename
     */
    private function loadConfig(string $directory, string $filename)
    {
        self::$config = new Config($directory, 'src\Components\Config\YamlConfigLoader');
        self::$config->addConfig($filename);
    }

    /**
     * This method starts the application. It resolves controllers and actions.
     * This method load config files
     */
    public function run()
    {
        $configDirectory = 'src/Config';
        $configFilename = 'database.yaml';
        $this->loadConfig($configDirectory, $configFilename);
        $router = Router::getRouterInstance(__ROOT__);
        $router->run();
    }


}