<?php

namespace src\Components\Config;

use src\Components\Config\Interfaces\iConfigLoader;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader extends FileLoader implements iConfigLoader 
{
    /**
     * Handle the config values
     * @param mixed $resource The resource
     * @return array Array with yaml contents
     * */
    public function load($resource, $type = null)
    {
        try{

            return Yaml::parse(file_get_contents($resource));

        }catch (ParseException $error){
            
            printf('Unable to parse the YAML string: %s', $error->getMessage());
        }
        
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yaml' == pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}