<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Получить список пользователей (исключая администратора и текущего пользователя)
     */
    public function getAllUsers($paginate = 5, $excludeAdmin = true, $excludeAuthUser = true)
    {
        $query = User::query();

        if ($excludeAdmin) {
            $query->where('name', '!=', 'admin');
        }

        if ($excludeAuthUser) {
            $query->where('id', '!=', auth()->id());
        }

        return $query->select(['id', 'name', 'email', 'is_admin'])->paginate($paginate);
    }

    /**
     * Создать пользователя
     */
    public function createUser(array $data)
    {
        try {
            return User::create($data);
        } catch (\Exception $e) {
            Log::error('Ошибка при создании пользователя: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Обновить пользователя
     */
    public function updateUser(User $user, array $data)
    {
        try {
            $user->fill($data);
            return $user->save();
        } catch (\Exception $e) {
            Log::error('Ошибка при обновлении пользователя: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Удалить пользователя
     */
    public function deleteUser(User $user)
    {
        try {
            return $user->delete();
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении пользователя: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Изменить статус администратора
     */
    public function toggleAdminStatus(User $user)
    {
        try {
            $user->is_admin = (($user->is_admin == 1) ?0:1);
            return $user->save();
        } catch (\Exception $e) {
            Log::error('Ошибка при изменении статуса администратора: ' . $e->getMessage());
            throw $e;
        }
    }
}
