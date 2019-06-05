<?php

namespace src\View\Interfaces;

interface iView
{
    /**
     * Makes the page from templates with given data
     * @param string $path Path to the template
     * @param array $data The data displayed on the page
     */
    public function make(string $path, array $data = []);
}