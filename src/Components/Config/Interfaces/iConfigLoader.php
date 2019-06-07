<?php 

namespace src\Components\Config\Interfaces;

interface iConfigLoader
{
    public function load($resource, $type);
    public function supports($resource, $type);
}