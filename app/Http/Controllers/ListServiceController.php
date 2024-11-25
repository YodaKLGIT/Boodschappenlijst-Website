<?php

namespace App\Http\Controllers;

use App\Models\ListItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Contracts\ListServiceInterface;
use Illuminate\Http\Request;

class ListServiceController extends Controller
{
    protected $listService;

    public function __construct(ListServiceInterface $listService)
    {
        $this->listService = $listService;
    }

    /**
     * Helper method to resolve model parameters dynamically.
     * 
     * @param string $method
     * @param array $parameters
     * @return array
     */
    private function resolveParameters(string $method, array $parameters): array
    {
        // Map method names to expected parameter types
        $parameterMappings = [
            'removeProductFromList' => [
                ListItem::class,  
                Product::class,   
            ],
            'updateName' => [
                Request::class,
                ListItem::class,  
            ],
            'toggleFavorite' => [
                ListItem::class,  
            ],
            'Newlist' => [
                ListItem::class,  
                User::class,      
            ],
            'Newproduct' => [
                ListItem::class,  
                Product::class,  
            ],
            // Add more methods as needed
        ];

        // Check if there's a mapping for this method
        if (isset($parameterMappings[$method])) {
            foreach ($parameters as $key => $parameter) {
                if (is_numeric($parameter)) {
                    // Resolve parameter to model instance
                    $modelClass = $parameterMappings[$method][$key] ?? null;
                    if ($modelClass) {
                        $parameters[$key] = $modelClass::find($parameter);
                    }
                }
            }
        }

        return $parameters;
    }

    /**
     * Handle dynamic method calls to ListService.
     */
    public function __call($method, $parameters)
    {
        // Check if the method exists in the service
        if (method_exists($this->listService, $method)) {
            // Resolve models for parameters
            $parameters = $this->resolveParameters($method, $parameters);
    
            // If any parameter is null (failed resolution), return error
            if (in_array(null, $parameters, true)) {
                return redirect()->back()->withErrors(['error' => 'Invalid parameters or not found']);
            }
    
            // Call the method dynamically on the service
            $result = call_user_func_array([$this->listService, $method], $parameters);
    
            // Handle the result and redirect accordingly
            if ($result === true) {
                // If result is true, redirect back with a success message
                return redirect()->back()->with('success', 'Operation completed successfully.');
            } elseif ($result === false) {
                // If result is false, return to the previous page with an error message
                return redirect()->back()->withErrors(['error' => 'Operation failed.']);
            } elseif ($method === 'getFavoriteLists') {
                // If the method is `getFavoriteLists`, we should render the view for the favorites
                $lists = $result;  
    

                return view('lists.index', compact('lists'));
            }
    
            return $result;  
        }
    
        // Handle method not found
        return response()->json(['error' => 'Method not found'], 404);
    }
    

}


