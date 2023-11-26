<?php

namespace Tests\Feature\UseCases;

use App\Models\Post;
use App\Models\User;
use App\UseCases\PostStoreAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class PostStoreActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @doesNotPerformAssertions
     */
    public function test5つまで投稿()
    {
        $user = User::factory()->create();
        Post::factory()->count(4)->create(['user_id' => $user->id]);

        $post = new Post();
        $post->user_id = $user->id;
        $post->message = 'test';

        $postStoreAction = new PostStoreAction();
        $postStoreAction($user->id, $post);
    }

    public function test6つまで投稿はNG()
    {
        $user = User::factory()->create();
        Post::factory()->count(5)->create(['user_id' => $user->id]);

        $post = new Post();
        $post->user_id = $user->id;
        $post->message = 'test';

        $postStoreAction = new PostStoreAction();
        $this->expectException(HttpException::class);
        $postStoreAction($user->id, $post);
    }
}