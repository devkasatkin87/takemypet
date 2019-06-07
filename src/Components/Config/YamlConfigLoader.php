<?php

namespace src\Components\Config;

use src\Components\Config\Interfaces\iConfigLoader;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader extends FileLoader implements iConfigLoader 
{
    public function load($resource, $type = null)
    {
        return Yaml::parse(file_get_contents($resource));
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yaml' == pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}