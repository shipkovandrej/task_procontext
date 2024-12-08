<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreRequest;
use App\Http\Requests\Api\User\UpdateRequest;

use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return UserResource::collection($users)->resolve();
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

        return new UserResource($user);
    }

    public function store(StoreRequest $request)
    {
        $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->save();

        return new UserResource($user);
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error_code' => 404,
                'error_message' => 'Пользователь не найден',
            ], 404);
        }

        $request->validated();

        $user->update([
            'name' =>  $request->name ?? $user->name,
            'email' =>  $request->email ?? $user->email,
            'age' =>  $request->age ?? $user->age,
        ]);

        return new UserResource($user);
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
