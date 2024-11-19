<?php

namespace App\Services;

use Ljpc\Jumboextras\JumboExtras;

class JumboService
{
    protected $jumbo;

    public function __construct()
    {
        $this->jumbo = new JumboExtras();
    }

    public function login($username, $password)
    {
        return $this->jumbo->login($username, $password);
    }

    public function getProducts()
    {
        return $this->jumbo->getProducts(); // Adjust this method based on the actual API
    }
}