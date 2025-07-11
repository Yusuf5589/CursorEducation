<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Tüm kullanıcıları getir
     */
    public function all(): Collection;

    /**
     * ID'ye göre kullanıcı bul
     */
    public function find(int $id): ?User;

    /**
     * Yeni kullanıcı oluştur
     */
    public function create(array $data): User;

    /**
     * Kullanıcı güncelle
     */
    public function update(int $id, array $data): bool;

    /**
     * Kullanıcı sil
     */
    public function delete(int $id): bool;
}
