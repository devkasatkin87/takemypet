<?php

namespace src\Components\Config;

use src\Components\Config\Interfaces\iConfig;
use Symfony\Component\Config\FileLocator;

class Config implements iConfig
{
    /**
     * @var array $config includes array of configuration data
     * @var src\Components\Config\Interfaces\iConfigLoader $loader includes type of configuration file loader
     * @var Symfony\Component\Config\FileLocator $locator The locator receives a collection of locations where it should look for files
     */
    private $config = [];
    private $loader;
    private $locator;

    public function __construct(string $dir,string $loaderType)
    {
        $directories = [
            __ROOT__.'/'.$dir
        ];

        $this->setLocator($directories);
        $this->setLoader($loaderType);
    }

    /**
     * Adds data in array of configuration
     * @param string $file Name of file with configuration data
     */
    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues != null){
            foreach ($configValues as $key => $arr){
                $this->config[$key] = $arr;
            }
        }
    }

    /**
     * Gets configuration data for a given key
     * @param string $keyvalue Parameter for finding the configuration. It should be "key.value"
     * @return mixed Returns array of configuration if $keyvalue is defined like "key"
     * or string of configuration if $keyvalue is defined like "key.value"
     */
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

    private function getConfig()
    {
        return $this->config;
    }

    private function setLoader($className)
    {
        $this->loader = new $className($this->locator);
    }

    private function setLocator($dir)
    {
        $this->locator = new FileLocator($dir);
    }
}