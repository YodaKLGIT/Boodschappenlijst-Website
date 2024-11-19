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
            // Authenticate with Jumbo API
            $username = env('JUMBO_USERNAME'); // Use environment variables for credentials
            $password = env('JUMBO_PASSWORD');
            $this->jumboService->login($username, $password);

            // Retrieve products
            $products = $this->jumboService->getProducts();

            // Return products as JSON response
            return response()->json($products);
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}