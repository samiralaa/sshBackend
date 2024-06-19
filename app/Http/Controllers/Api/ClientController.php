<?php

namespace App\Http\Controllers\Api;

use App\Models\Clint;
use Illuminate\Http\Request;
use App\Http\Requests\ClintRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Clint::with('tripOrders', 'activiteOrders')->get();
        return response()->json(['success' => true, 'data' => $clients], 200);
    }

    public function register(ClintRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = Clint::create($input);
        $token =  $user->createToken('MyApp')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token, 'name' => $user->name], 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['success' => true, 'token' => $token, 'name' => $user->name], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Successfully logged out'], 200);
    }

    public function profile()
    {
        return response()->json(['success' => true, 'data' => auth()->user()], 200);
    }

    public function show($id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $client], 200);
    }

    public function update(Request $request, $id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->update($request->all());
        return response()->json(['success' => true, 'data' => $client], 200);
    }

    public function destroy($id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->delete();
        return response()->json(['success' => true, 'message' => 'Client deleted successfully'], 200);
    }

    public function getAllTripOrders($id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $client->tripOrders], 200);
    }

    public function getAllActiviteOrders($id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $client->activiteOrders], 200);
    }

    public function getAllTripOrdersByClient($id)
    {
        $client = Clint::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $client->tripOrders], 200);
    }
}
