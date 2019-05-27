<?php
namespace src\App;
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
     * This method has private type of access and undefined
     */
    private function __construct(){}

    public static function getAppInstance()
    {
        if (empty(self::$appInstance)){
            self::$appInstance = new App();
        }
        return self::$appInstance;
    }

    public function run()
    {
        print_r("Hello world!");
    }


}