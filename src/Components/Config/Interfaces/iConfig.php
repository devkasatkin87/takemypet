<?php

namespace src\Components\Config\Interfaces;

interface iConfig
{
    public function addConfig($file);
    public function getConfig($keyvalue);
}