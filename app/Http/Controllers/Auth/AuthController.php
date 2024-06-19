<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json(['success' => $success], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the password matches
        if (!password_verify($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Login the user
        Auth::login($user);

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json(['success' => $success], 200);
    }
    public function users ()
    {
        $users = User::select('id','email','name')->get();
        return response()->json(['users' => $users], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function refresh(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();
        $token = $request->user()->createToken('MyApp')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    public function me(Request $request)
    {
        $user = $request->user()->only('id', 'name', 'email');
        return response()->json(['data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $request->user()->update($request->all());
        return response()->json($request->user());
    }
    public function show($id)
    {
        
        $user = User::find($id);
        return response()->json($user);
    }
    public function destroy($id)
    {
       
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    
   
}
