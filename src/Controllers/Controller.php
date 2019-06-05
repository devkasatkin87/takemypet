<?php

namespace src\Controllers;

use src\Controllers\Interfaces\iController;
use Symfony\Component\HttpFoundation\Response;
use src\View\View;

abstract class Controller implements iController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Implements a view selection mechanism
     * @param string $path path to the template
     * @param array $data The array of data reveived from controller
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function render(string $path, array $data = []) : Response
    {
        return new Response($this->view->make($path, $data));
    }
}