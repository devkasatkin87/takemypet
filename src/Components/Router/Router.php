<?php

namespace src\Components\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Defines and implements the routing mechanism
 * @package src\Components\Router
 * @var Symfony\Component\HttpFoundation\Request $request
 * @var Symfony\Component\HttpFoundation\Response $response
 * @var Symfony\Component\Routing\RouteCollection $route
 * @var Symfony\Component\EventDispatcher\EventDispatcher $dispatcher;
 * @var string $basePath
 * @var src\Components\Router $routerInstance
 *  
 */
class Router
{

    private $request;
    private $response;
    private $routes;
    private $basePath;
    private $dispatcher;

    public static $routerInstance = null;

    /**
     * Helper methods are invoked in the constructor to enable execution of the method mechanism $this->run()
     * @param string $basePath Base path of Application
     */
    public function __construct(string $basePath)
    {
        $this->setRequest();
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

    /**
     * Realize the routing mechanism
     * @return bool
     */
    public function run() : bool
    {
        try {
            $matcher = new UrlMatcher($this->routes, new RequestContext());

            $this->setDispatcher($matcher);

            $controllerResolver = new ControllerResolver();
            $argumentResolver = new ArgumentResolver();

            $kernel = new HttpKernel($this->dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

            $this->response = $kernel->handle($this->request);
            
        } catch (NotFoundHttpException $exeption){
            $this->response = new Response("Page not found", 404);
        } catch (\Exception $e){
            $this->response = new Response("An occured error", 500);
        } 
        $this->response->send();

        $kernel->terminate($this->request, $this->response);
        return true;
    }

    /**
     * @param Symfony\Component\Routing\Matcher\UrlMatcher $matcher route match result
     */
    public function setDispatcher($matcher)
    {
        $this->dispatcher = new EventDispatcher();
        $this->dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));
    }

    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }

    private function setRoutes()
    {
        $this->routes = $this->getRoutesCollection();
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

    public function test()
    {
        echo "test message\n";
    }
}