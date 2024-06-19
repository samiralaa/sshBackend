<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait MethodHandelTrait
{
    public function clint(Request $request, $id = null, $id2 = null)
    {
        // Handle the request based on method and parameters
        if ($request->isMethod('post')) {
            // Handle POST request
        } elseif ($request->isMethod('get')) {
            // Handle GET request
        }

        // Handle parameters if provided
        if ($id && $id2) {
            // Handle case with both id and id2
        } elseif ($id) {
            // Handle case with only id
        } else {
            // Handle case with no id
        }

        // Your logic here
        return response()->json(['message' => 'Handled request', 'id' => $id, 'id2' => $id2]);
    }


//     Route::middleware('auth:sanctum')->prefix('clint')->group(function () {
//     // Route for POST /clint
//     Route::post('/', [ActiviteOrderController::class, 'clint']);
    
//     // Route for GET /clint
//     Route::get('/', [ActiviteOrderController::class, 'clint']);
    
//     // Route for GET /clint/{id}
//     Route::get('/{id}', [ActiviteOrderController::class, 'clint']);
    
//     // Route for POST /clint/{id}
//     Route::post('/{id}', [ActiviteOrderController::class, 'clint']);
    
//     // Route for GET /clint/{id}/{id2}
//     Route::get('/{id}/{id2}', [ActiviteOrderController::class, 'clint']);
// });
}
