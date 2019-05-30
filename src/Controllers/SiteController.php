<?php

namespace src\Controllers;

use Symfony\Component\HttpFoundation\Response;

class SiteController
{
    public function actionIndex()
    {
        return new Response("<h3>Hello world!</h3><br>");
    }
}