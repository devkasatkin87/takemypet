<?php

namespace src\View;

use src\View\Interfaces\iView;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class View implements iView
{
    private $templating;

    /**
     * In construct resolve mechanism to chose right template from storage
     */
    public function __construct()
    {
        $filesystemLoader = new FilesystemLoader(__ROOT__.'/src/web/views/%name%/%name%.php');
        $this->templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    }

    /**
     * Parses the path to file with template and returns the output text. 
     * The second argument of render is an array of variables to use in the template. 
     * @param string $path path to the template
     * @param array $data The array of data reveived from controller
     * @return string
     */
    public function make(string $path, array $data = []) : string
    {
        return $this->templating->render($path, $data);
    }
}