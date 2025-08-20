<?php

use App\Models\Permission;
use Firebase\JWT\JWT;

function getFakeJwtToken() {
     $permissions = Permission::pluck('name')->toArray();
    $payload = [
        'id' => 1,
        'email' => 'gaelle@example.com',
        'name' => 'gaelle',
        'permissions' => $permissions,
        'iat' => time(),
        'exp' => time() + 3600,
    ];
    return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
}
