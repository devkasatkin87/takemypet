<?php

namespace src\System;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

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
    private static $container;

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
     * Defines the DI container and load yaml files with classes and it's configuration
     */
    public static function setContainer()
    {
        try {

        self::$container = new ContainerBuilder();
        $loader = new YamlFileLoader(self::$container, new FileLocator(__DIR__.'/Config/'));
        $loader->load('services.yaml');

        return self::$container;

        } catch (Exception $e){
            
            print_r($e->getMessage());
        }
    }

    /**
     * @return Symfony\Component\DependencyInjection\ContainerBuilder;
     */
    public static function getContainer()
    {
        return self::$container;
    }

    /**
     * This method starts the application. It set and load data in DI container.
     * This method load config files and start routing.
     */
    public function run()
    {
        $container = self::setContainer();
        $container->get('router')->run();
    }


}