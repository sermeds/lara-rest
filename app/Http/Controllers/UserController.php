<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Requests\Update\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->all();
    }

    public function show($id)
    {
        return $this->userService->findOrFail($id);
    }

    public function store(StoreUserRequest $request)
    {
        Log::debug("blabla");
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $users = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdUsers= [];
        foreach ($users as $user) {
            $createdUsers[] = $this->userService->createUser($user);
        }

        return response()->json($createdUsers, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function update(UpdateUserRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedUsers = [];
            foreach ($validated as $user) {
                if (!isset($user['id'])) {
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                // Проверяем, если в запросе есть новый пароль, то хешируем его
                if (isset($user['password'])) {
                    $user['password'] = bcrypt($user['password']);
                }
                $updatedUsers[] = $this->userService->updateUser($user['id'], $user);
            }
            return response()->json($updatedUsers, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $user = $this->userService->updateUser($id, $validated);
        return response()->json($user, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->userService->deleteUser($id);
            return response(null, 204);
        }

        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->userService->deleteUser($id);
        }

        return response(null, 204);
    }
}
