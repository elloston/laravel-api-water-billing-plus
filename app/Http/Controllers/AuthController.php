<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
{
    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return response()->json(['message' => 'Registered Successfully'], 201);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $this->agent->setUserAgent($request->header('User-Agent'));
        $device = $this->agent->device();

        $user = User::where('email', $validatedData['email'])->firstOrFail();

        if (!Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($device)->plainTextToken;

        return response()->json($token, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(null, 204);
    }
}
