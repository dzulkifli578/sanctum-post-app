<?php

namespace App\Interfaces;

interface AuthServiceInterface
{
    public function register(array $data): array;
    public function login(array $credentials): array;
    public function profile(): array;
    public function logout(): array;
}