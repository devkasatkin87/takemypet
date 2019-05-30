<?php

namespace src\Components\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Defines and implements the routing mechanism
 * @package src\Components\Router
 * @var Symfony\Component\HttpFoundation\Request $request
 * @var Symfony\Component\HttpFoundation\Response $response
 * @var Router $router
 * @var Symfony\Component\Routing\RequestContext $requestContext
 * @var Symfony\Component\HttpKernel\Controller\ControllerResolver $controller
 * @var Symfony\Component\HttpKernel\Controller\ArgumentResolver $arguments
 * @var string $basePath
 * @var  $routerInstance
 *  
 */
class Router
{

    private $request;
    private $response;
    //private $router;
    private $routes;
    private $requestContext;
    private $controller;
    private $arguments;
    private $basePath;

    public static $routerInstance = null;

    /**
     * Helper methods are invoked in the constructor to enable execution of the method mechanism $this->run()
     */
    private function __construct(string $basePath)
    {
        $this->setRequest();
        $this->setRequestContext();
        // $this->setRouter();
        $this->setRoutes();

        $this->basePath = $basePath;

    }

    /**
     * This method realize singleton pattern and brings opportunity for create single object instance. 
     * @return Router Instance of object type App
     */
    public static function getRouterInstance(string $basePath)
    {
        if (empty(self::$routerInstance)){
            self::$routerInstance = new Router($basePath);
        }
        return self::$routerInstance;
    }

    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }

    private function setRequestContext()
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    private function setRoutes()
    {
        $this->routes = $this->getRoutesCollection();
    }

    private function getController()
    {
        return (new ControllerResolver())->getController($this->request);
    }

    private function getArguments($controller)
    {
        return (new ArgumentResolver())->getArguments($this->request, $this->controller);
    }

    /**
     * Realize the routing mechanism
     * @return bool
     */
    public function run()
    {
        $matcher = new UrlMatcher($this->routes, $this->requestContext);
        try {
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));
            
            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);

            $this->response = call_user_func_array($this->controller, $this->arguments);
            //dd($response);
        } 
        catch(Exception $e) {
            print_r($e->getMessageError());
        }

            $this->response->send();
            return true;
    }

    /**
     * Get route datas from Yaml file
     * @return RouteCollection
     */
    private function getRoutesCollection() : RouteCollection
    {
        $fileLocator = new FileLocator([__DIR__.'/Config/']);
        $loader = new YamlFileLoader($fileLocator);
        return $loader->load('routes.yaml');
    }
}