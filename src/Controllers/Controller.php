<?php

namespace src\Controllers;

use src\Controllers\Interfaces\iController;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller implements iController
{
    public function render(string $path, array $data = []) : Response
    {
        return new Response("Hello world!");
    }
}