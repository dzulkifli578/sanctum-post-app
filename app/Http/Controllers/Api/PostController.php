<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\PostControllerInterface;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class PostController
 *
 * This controller handles operations related to posts, including creating, reading,
 * updating, and deleting posts. It interacts with the PostService to handle the business
 * logic of these operations.
 *
 * @package App\Http\Controllers\Api
 */
class PostController extends Controller implements PostControllerInterface
{
    private $service;

    /**
     * PostController constructor.
     *
     * @param PostService $service The PostService instance to handle business logic.
     */
    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * Creates a new post.
     *
     * Validates the incoming request data and calls the PostService to create a new post.
     *
     * @param Request $request The incoming HTTP request.
     * @return JsonResponse The response containing the success message and the created post data.
     */
    public function createPost(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $array = $this->service->createPost($data);
        $message = $array['message'];
        $post = $array['post'];

        return response()->json([
            'message' => $message,
            'post' => $post,
        ]);
    }

    /**
     * Retrieves posts based on search and time query parameters.
     *
     * Fetches posts using the PostService and optionally filters them based on
     * search and time parameters. Returns a list of posts.
     *
     * @param Request $request The incoming HTTP request containing optional query parameters.
     * @return JsonResponse The response containing the list of posts or an error message.
     */
    public function readPosts(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search');
            $time = $request->query('time');

            $array = $this->service->readPosts($search, $time);
            $posts = $array['posts'];

            return response()->json(['posts' => $posts]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Updates an existing post.
     *
     * Validates the incoming request data and calls the PostService to update the specified post.
     * Only updates fields that are provided (title and body).
     *
     * @param Request $request The incoming HTTP request containing the updated post data.
     * @param int $id The ID of the post to update.
     * @return JsonResponse The response containing the success message and the updated post data.
     */
    public function updatePost(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validate([
                'title' => 'sometimes|string',
                'body' => 'sometimes|string',
            ]);

            $array = $this->service->updatePost($id, $data);
            $message = $array['message'];
            $post = $array['post'];

            return response()->json([
                'message' => $message,
                'post' => $post,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Deletes a specified post.
     *
     * Calls the PostService to delete the specified post.
     *
     * @param Request $request The incoming HTTP request.
     * @param int $id The ID of the post to delete.
     * @return JsonResponse The response containing the success message.
     */
    public function deletePost(Request $request, int $id): JsonResponse
    {
        try {
            $array = $this->service->deletePost($id);
            $message = $array['message'];

            return response()->json(['message' => $message]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
