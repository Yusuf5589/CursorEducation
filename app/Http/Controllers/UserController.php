<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Tüm kullanıcıları listele
     */
    public function all()
    {
        try {
            $users = $this->userRepository->all();
            return response()->json(['users' => $users]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Kullanıcılar listelenirken bir hata oluştu',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Belirli bir kullanıcıyı göster
     */
    public function find(int $id)
    {
        try {
            $user = $this->userRepository->find($id);
            
            if (!$user) {
                return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
            }
            
            return response()->json(['user' => $user]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Kullanıcı aranırken bir hata oluştu',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Yeni kullanıcı oluştur
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:user,username',
                'password' => 'required|string|min:6'
            ], $this->userRepository->errorMessage());

            $user = $this->userRepository->create($validated);
            
            return response()->json([
                'message' => 'Kullanıcı başarıyla oluşturuldu',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Kullanıcı oluşturulurken bir hata oluştu',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Kullanıcı güncelle
     */
    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'new_password' => 'required|string|min:6',
                'current_password' => 'required|string'
            ], $this->userRepository->errorMessage());

            // Kullanıcıyı bul
            $user = $this->userRepository->find($id);
            if (!$user) {
                return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
            }

            // Mevcut şifreyi kontrol et
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json(['message' => 'Mevcut şifre yanlış'], 400);
            }

            // Şifre kontrolü başarılı, güncelleme yap
            $updateData = [
                'username' => $validated['username'],
                'password' => Hash::make($validated['new_password'])
            ];

            $success = $this->userRepository->update($id, $updateData);
            
            if (!$success) {
                return response()->json(['message' => 'Güncelleme işlemi başarısız'], 500);
            }
            
            return response()->json(['message' => 'Kullanıcı başarıyla güncellendi']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Kullanıcı güncellenirken bir hata oluştu',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Kullanıcı sil
     */
    public function delete(int $id)
    {
        try {
            $success = $this->userRepository->delete($id);
            
            if (!$success) {
                return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
            }
            
            return response()->json(['message' => 'Kullanıcı başarıyla silindi']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Kullanıcı silinirken bir hata oluştu',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
