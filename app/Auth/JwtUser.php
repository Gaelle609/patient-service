<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class JwtUser implements Authenticatable
{
    public function __construct(public array $attributes) {}

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
    
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->attributes['id'];
    }

    public function getAuthPassword(): ?string
    {
        return null; // Pas utilisé pour JWT
    }

    public function getRememberToken(): ?string
    {
        return null;
    }

    public function setRememberToken($value): void
    {
        // Pas utilisé pour JWT
    }

    public function getRememberTokenName(): ?string
    {
        return null;
    }

    public function getAuthPasswordName(): string
    {
        return 'password'; // Obligatoire mais non utilisé pour JWT
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->attributes['permissions'] ?? []);
    }
}
