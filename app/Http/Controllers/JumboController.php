<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JumboService;

class JumboController extends Controller
{
    protected $jumboService;

    public function __construct(JumboService $jumboService)
    {
        $this->jumboService = $jumboService;
    }

    public function getProducts(Request $request)
    {
        try {
            // Example: Using username/password authentication
            $username = env('JUMBO_USERNAME');
            $password = env('JUMBO_PASSWORD');
            $this->jumboService->login($username, $password);

            // OR, if using access/refresh tokens
            // $this->jumboService->setTokens($accessToken, $refreshToken);

            // Fetch products from the Jumbo API
            $products = $this->jumboService->getAllAvailableProducts();

            // Return products as JSON response
            return response()->json($products);
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}