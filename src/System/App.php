<?php

namespace src\System;

use src\Components\Router\Router;

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
     * This method starts the application. It resolves controllers and actions.  
     */
    public function run()
    {
        $router = Router::getRouterInstance(__DIR__);
        $router->run();
    }


}