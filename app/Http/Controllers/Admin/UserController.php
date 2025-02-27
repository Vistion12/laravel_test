<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно удален!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка удаления пользователя: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => 'unique:users,email,' . $user->id . '|required|min:5|max:255',
        ]);

        $data['is_admin'] = $request->get('is_admin') == 'on' ? 1 : 0;

        try {
            $this->userService->updateUser($user, $data);
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно изменен!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка изменения пользователя: ' . $e->getMessage());
        }
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['is_admin'] = $request->has('is_admin') ? 1 : 0;

        try {
            $this->userService->createUser($data);
            return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно добавлен!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.create')->with('error', 'Ошибка добавления пользователя: ' . $e->getMessage());
        }
    }

    public function addAdmin(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден',
            ], 404);
        }

        try {
            Log::info('Изменение статуса админа для пользователя: ' . $user->id);
            $this->userService->toggleAdminStatus($user);
            return response()->json([
                'success' => true,
                'message' => 'Статус админа успешно изменен',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка изменения статуса админа: ' . $e->getMessage(),
            ], 500);
        }
    }
}
