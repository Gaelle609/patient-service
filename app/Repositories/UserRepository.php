<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }

    public function login(){
        $user = $this->model()::first();
       $token= $user->logged_in();
       return $token;

    }

    public function logout(){
        $user = $this->model()::first();
        $user->logged_out();
    }

    public function grantPermission(int $userId, array $permissionIds)
    {
    
        return $this->model()::findOrFail($userId)->permissionGranted($userId, ...$permissionIds);
    }
    
    public function revokePermission(int $userId, array $permissionIds)
    {
    
        return $this->model()::findOrFail($userId)->permissionRevoked($userId, ...$permissionIds);
    }
}
