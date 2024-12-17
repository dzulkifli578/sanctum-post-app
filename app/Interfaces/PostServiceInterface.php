<?php

namespace App\Interfaces;

interface PostServiceInterface
{
    public function createPost(array $data): array;
    public function readPosts(string|null $search, string|null $time): array;
    public function updatePost(int $id, array $data): array;
    public function deletePost(int $id): array;
}