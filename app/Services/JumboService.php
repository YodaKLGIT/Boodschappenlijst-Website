<?php

namespace App\Services;

use LJPc\JumboExtras\Calls\JumboExtras;

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
        return $this->jumbo->getSavingOffers();
    }
}