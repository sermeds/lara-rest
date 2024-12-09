<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Регистрация пользователя
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userService->createUser($validated);
        return response()->json([
            'message' => 'Регистрация успешна.',
            'user' => $user,
        ], 201);
    }

    // Вход в систему
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt(Arr::only($validated, ['email', 'password']))) {
            return response()->json(['message' => 'Неверные учетные данные.'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Вход успешен.',
            'token' => $token,
        ], 200);
    }

    // Выход из системы
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Выход успешен.'], 200);
    }
}

