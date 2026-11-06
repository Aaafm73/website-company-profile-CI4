<?php

namespace Tests\Support\Libraries;

use Config\App;

/**
 * Class ConfigReader
 *
 * An extension of BaseConfig that prevents the constructor from
 * loading external values. Used to read actual local values from
 * a config file.
 */
class ConfigReader extends App
{
    // Menghindari pemuatan nilai environment agar tes membaca konfigurasi file.
    public function __construct()
    {
    }
}
