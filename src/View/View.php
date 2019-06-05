<?php

namespace src\View;

use src\View\Interfaces\iView;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class View implements iView
{
    private $templating;

    public function __construct()
    {
        $filesystemLoader = new FilesystemLoader(__ROOT__.'/src/web/views/%name%/%name%.php');
        $this->templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
    }

    public function make(string $path, array $data = [])
    {
        return $this->templating->render($path, $data);
    }
}