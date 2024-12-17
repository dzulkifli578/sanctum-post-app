<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Interfaces\PostServiceInterface;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class PostService
 *
 * This service handles the business logic related to posts, including creating, reading,
 * updating, and deleting posts. It interacts directly with the Post model and handles 
 * the necessary database operations. The service implements `PostServiceInterface` 
 * to ensure consistency and contract adherence for post-related functionalities.
 *
 * @package App\Services
 */
class PostService implements PostServiceInterface
{
    /**
     * Creates a new post.
     *
     * This method accepts an array of post data, validates it, and creates a new post in the database.
     * It then returns a success message along with the created post's data as a PostResource.
     *
     * @param array $data The post data to create a new post.
     * @return array An array containing a success message and the created post data.
     */
    public function createPost(array $data): array
    {
        $post = Post::create($data);

        return [
            'message' => 'Post created successfully',
            'post' => new PostResource($post),
        ];
    }

    /**
     * Retrieves posts based on search query and time filter.
     *
     * This method fetches posts based on a search query in the title or body and applies
     * a time filter to order the posts by creation date (either ascending or descending).
     * It returns a collection of posts wrapped in PostResource.
     *
     * @param string|null $search The search term to filter posts by title or body.
     * @param string|null $time The time filter for ordering posts ('oldest' or latest).
     * @return array An array containing the filtered posts as PostResource collection.
     * @throws Exception If no posts are found.
     */
    public function readPosts(string|null $search, string|null $time): array
    {
        $idUser = auth()->user()->id;

        $query = Post::where('title', 'like', "%$search%")
            ->orWhere('body', 'like', "%$search%")
            ->where('user_id', $idUser);

        $time === 'oldest' ?
            $query->orderBy('created_at') :
            $query->orderByDesc('created_at');

        $posts = $query->get();

        if ($posts->isEmpty())
            throw new Exception('No post found');

        return ['posts' => PostResource::collection($posts)];
    }

    /**
     * Updates an existing post.
     *
     * This method updates a post with the given data based on the post's ID.
     * It returns a success message and the updated post data wrapped in PostResource.
     *
     * @param int $id The ID of the post to update.
     * @param array $data The updated post data.
     * @return array An array containing a success message and the updated post data.
     * @throws Exception If the post is not found.
     */
    public function updatePost(int $id, array $data): array
    {
        $post = Post::find($id);

        if (!$post)
            throw new Exception('Post not found');

        $post->update($data);

        return [
            'message' => 'Post updated successfully',
            'post' => new PostResource($post),
        ];
    }

    /**
     * Deletes a post.
     *
     * This method deletes a post from the database based on the post's ID.
     * It also resets the auto-increment value for the `posts` table if necessary.
     *
     * @param int $id The ID of the post to delete.
     * @return array An array containing a success message after deletion.
     * @throws Exception If the post is not found.
     */
    public function deletePost(int $id): array
    {
        $post = Post::find($id);

        if (!$post)
            throw new Exception('Post not found');

        $post->delete();

        $this->resetAutoIncrement('posts');

        return ['message' => 'Post deleted successfully'];
    }

    /**
     * Resets the auto-increment value for a specified table.
     *
     * This private method adjusts the auto-increment value for the given table based on the
     * highest existing ID value. It supports multiple database drivers.
     *
     * @param string $table The name of the table to reset the auto-increment value.
     * @return void
     * @throws Exception If the database driver is not supported.
     */
    private function resetAutoIncrement(string $table): void
    {
        $dbDriver = DB::getDriverName();
        $maxId = DB::table($table)->max('id') ?? 0;

        match ($dbDriver) {
            'mysql' => DB::statement("ALTER TABLE $table AUTO_INCREMENT = " . $maxId + 1),
            'pgsql' => DB::statement("SELECT setval('{$table}_id_seq', " . $maxId + 1 . ", false)"),
            'sqlite' => DB::statement("UPDATE sqlite_sequence SET sq = $maxId WHERE name = $table"),
            default => throw new Exception("Database driver $dbDriver is not supported.")
        };
    }
}
