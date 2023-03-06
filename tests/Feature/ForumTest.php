<?php 


use App\Models\Forum;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $forum = Forum::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $forum->user);
        $this->assertEquals($user->id, $forum->user_id);
    }

    /** @test */

    public function it_has_many_comments()
{
    $user = User::factory()->create();
    $forum = Forum::factory()->create(['user_id' => $user->id]);
    $comment1 = Comment::factory()->create(['forum_id' => $forum->id]);
    $comment2 = Comment::factory()->create(['forum_id' => $forum->id]);

    $this->assertCount(2, $forum->comments);
    $this->assertTrue($forum->comments->contains($comment1));
    $this->assertTrue($forum->comments->contains($comment2));
}
}
