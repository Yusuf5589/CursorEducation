<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function errorMessage(){
        return [
            'username.required' => 'Kullanıcı adı alanı zorunludur.',
            'username.string' => 'Kullanıcı adı alanı metin olmalıdır.',
            'username.max' => 'Kullanıcı adı en fazla 255 karakter olmalıdır.',
            'username.unique' => 'Bu kullanıcı adı zaten kullanılmaktadır.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.string' => 'Şifre alanı metin olmalıdır.',
            'password.min' => 'Şifre alanı en az 6 karakter olmalıdır.',
            'current_password.required' => 'Mevcut şifre alanı zorunludur.',
            'current_password.string' => 'Mevcut şifre alanı metin olmalıdır.',
            'new_password.required' => 'Yeni şifre alanı zorunludur.',
            'new_password.string' => 'Yeni şifre alanı metin olmalıdır.',
            'new_password.min' => 'Yeni şifre alanı en az 6 karakter olmalıdır.',
        ];
    }


    /**
     * Tüm kullanıcıları getir
     */
    public function all(): Collection
    {
        return User::select('id', 'username', 'created_at', 'updated_at')->get();
    }

    /**
     * ID'ye göre kullanıcı bul
     */
    public function find(int $id): ?User
    {
        return User::select('id', 'username', 'created_at', 'updated_at')->find($id);
    }

    /**
     * Yeni kullanıcı oluştur
     */
    public function create(array $data): User
    {
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Kullanıcı güncelle
     */
    public function update(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }
        
        return $user->update($data);
    }

    /**
     * Kullanıcı sil
     */
    public function delete(int $id): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }
        
        return $user->delete();
    }
}