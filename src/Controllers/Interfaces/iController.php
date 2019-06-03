<?php

namespace src\Controllers\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface iController
{
    /**
     * Render page on the set path with the set parameters
     * @param string $path The path to teplate page
     * @param array $data The data reveived from controller
     */
    public function render(string $path, array $data) : Response;
}