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

    public function getAllAvailableProducts()
    {
        // Initialize an array to hold all products
        $allProducts = [];

        // Get saving offers
        $savingOffers = $this->jumbo->getSavingOffers();
        foreach ($savingOffers as $offer) {
            $allProducts[] = [
                'id' => $offer['id'],
                'title' => $offer['title'],
                'description' => $offer['description'],
                'image' => $offer['image'],
                'type' => 'saving_offer', // Indicate the type of offer
            ];
        }

        // Get redeem offers
        $redeemOffers = $this->jumbo->getRedeemOffers();
        foreach ($redeemOffers as $offer) {
            $allProducts[] = [
                'id' => $offer['id'],
                'title' => $offer['title'],
                'description' => $offer['description'],
                'image' => $offer['image'],
                'type' => 'redeem_offer', // Indicate the type of offer
            ];
        }

        // Get homescreen offers
        $homescreenOffers = $this->jumbo->getHomeScreen();
        foreach ($homescreenOffers as $offer) {
            $allProducts[] = [
                'id' => $offer['id'],
                'title' => $offer['title'],
                'description' => $offer['description'],
                'image' => $offer['image'],
                'type' => 'homescreen_offer', // Indicate the type of offer
            ];
        }

        return $allProducts; // Return the combined list of products
    }
}