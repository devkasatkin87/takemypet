<?php

namespace src\Controllers;

use Symfony\Component\HttpFoundation\Response;

class ArticlesController
{
    public function actionIndex(int $number)
    {
        print_r($number);
        return new Response("<p><?php echo print_r($number)?></p>");
    }
}