<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $userAuth = Auth::user();
        $users = User::where('name', '!=', 'admin')
            ->where('id', '!=', $userAuth->id)
            ->select(['id', 'name', 'email', 'is_admin'])
            ->paginate(5);

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно удален!');
        }
        return back()->with('error', 'Ошибка удаления Пользователя');
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $data = $request->validated();
        $data['is_admin'] = $request->has('is_admin') ? 1 : 0;

        $user->fill($data);

        if ($user->save()) {
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно изменен!');
        }

        return back()->with('error', 'Ошибка изменения Пользователя');
    }

    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $validated['is_admin'] = $request->has('is_admin') ? 1 : 0;

        try {
            User::create($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.users.create')->with('error', 'Ошибка добавления пользователя! ' . $e->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно добавлен');
    }

    public function addAdmin(string $id){
        $user = User::find($id);
        if($user){
            $user->is_admin=(($user->is_admin == 1) ?0:1);
            if($user->save()){
                return response()->json([
                    'success'=> 'true',
                    'message'=> 'Статус админа успешно изменен',
                ]);}
            return response()->json([
                'success'=> false,
                'message'=> 'Статус админа не изменен'],404);

        }

        return response()->json([
            'success'=> false,
            'message'=> 'Пользователь не найден'],404);
    }
}
