<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $users = User::get();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error_code' => 404,
                'error_message' => 'Пользователь не найден',
            ], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'age' => 'required|integer|min:1|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;

        $user->save();

        return $user->getFields();

    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error_code' => 404,
                'error_message' => 'Пользователь не найден',
            ], 404);
        }

        $request->validate([
            'name' => 'string',
            'email' => 'string|email|unique:users,email,' . $id,
            'age' => 'integer|min:1|max:255',
        ]);

        $user->update([
            'name' =>  $request->name ?? $user->name,
            'email' =>  $request->email ?? $user->email,
            'age' =>  $request->age ?? $user->age,
        ]);

        return $user;
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error_code' => 404,
                'error_message' => 'Пользователь не найден',
            ], 404);
        }

        $user->delete();

        return response()->json(['result' => 'Успешно']);
    }
}
