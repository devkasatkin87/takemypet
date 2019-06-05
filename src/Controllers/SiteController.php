<?php

namespace src\Controllers;

use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
    /**
     * @Routing /index.php
     */
    public function actionIndex()
    {
        return $this->render('index', ['title' => 'Index Page']);
    }
}