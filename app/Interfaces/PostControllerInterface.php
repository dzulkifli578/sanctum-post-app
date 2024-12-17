<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface PostControllerInterface
{
    public function createPost(Request $request): JsonResponse;
    public function readPosts(Request $request): JsonResponse;
    public function updatePost(Request $request, int $id): JsonResponse;
    public function deletePost(Request $request, int $id): JsonResponse;
}