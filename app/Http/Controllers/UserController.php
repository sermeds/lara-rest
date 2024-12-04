<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Requests\Update\UpdateUserRequest;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(StoreUserRequest $request)
    {
        // Валидация данных через Request
        $validated = $request->validated();

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        return $user;
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
        $user = User::findOrFail($id);
        $user->update($validated);

        // Возвращаем ответ с обновленными данными
        return response()->json($user, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response(null, 204);
    }
}
