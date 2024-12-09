<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Requests\Update\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;

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

    public function store(StoreUserRequest $request)
    {
        // Валидация данных через Request
        $validated = $request->validated();

        $user = $this->userService->createUser($validated);

        return response()->json($user, Response::HTTP_CREATED, options:JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        return $this->userService->findOrFail($id);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        // Валидация данных из запроса
        $validated = $request->validated();

        // Проверяем, если в запросе есть новый пароль, то хешируем его
        if ($request->has('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        // Найдем пользователя и обновим его
        $user = $this->userService->updateUser($id, $validated);

        // Возвращаем ответ с обновленными данными
        return response()->json($user, Response::HTTP_OK, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return response(null, 204);
    }
}
