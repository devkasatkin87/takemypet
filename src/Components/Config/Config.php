<?php

namespace src\Components\Config;

use src\Components\Config\Interfaces\iConfig;
use Symfony\Component\Config\FileLocator;

class Config implements iConfig
{
    private $config = [];
    private $loader;
    private $locator;

    public function __construct($dir)
    {
        $directories = [
            __ROOT__.'/'.$dir
        ];

        $this->setLocator($directories);
        $this->setLoader();
    }


    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues != null){
            foreach ($configValues as $key => $arr){
                $this->config[$key] = $arr;
            }
        }
    }

    //database.keyvalue
    public function get($keyvalue)
    {
        $pattern = "/[a-zA-z]*\.[a-zA-z]*/";

        if (preg_match($pattern,$keyvalue,$matches) == 1){

            list($key, $value) = explode('.', $keyvalue);

        }else {

            $key = $keyvalue;
            $value = '';

        }

        if ($key && isset($this->config[$key])){

            if ($value && isset($this->config[$key][$value])){

                return $this->config[$key][$value];

            }else {
                
                return $this->config[$key];
            }
        }

        return null;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setLoader()
    {
        $this->loader = new YamlConfigLoader($this->locator);
    }

    public function setLocator($dir)
    {
        $this->locator = new FileLocator($dir);
    }
}