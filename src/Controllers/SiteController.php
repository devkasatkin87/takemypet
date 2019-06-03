<?php

namespace src\Controllers;

use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('');
    }
}