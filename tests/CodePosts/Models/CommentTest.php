<?php

namespace CodePress\CodeComments\Tests\Model;

use CodePress\CodePosts\tests\AbstractTestCase;
use CodePress\CodePosts\Models\Comment;
use CodePress\CodePosts\Models\Post;
use Illuminate\Validation\Validator;
use Mockery as m;

class CommentTest extends AbstractTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function test_inject_validator_in_comment_model()
    {
        $comment = new Comment();
        $validator = m::mock(Validator::class);
        $comment->setValidator($validator);
        $this->assertEquals($comment->getValidator(), $validator);
    }

    public function test_should_check_if_is_valid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = 'comment content';
        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with(['content' => 'comment content']);
        $validator->shouldReceive('fails')->andReturn(false);
        $comment->setValidator($validator);
        $this->assertTrue($comment->isValid());
    }

    public function test_should_check_if_is_invalid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = '';

        $messageBag = m::mock('Illuminate\Support\MessageBag');

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);

        $validator->shouldReceive('setData')->with(['content' => '']);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);

        $comment->setValidator($validator);
        $this->assertFalse($comment->isValid());
        $this->assertEquals($messageBag, $comment->errors);
    }

    public function test_if_a_comment_can_be_persisted()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        $comment = Comment::create([
            'content' => 'comment content',
            'post_id' => $post->id,
        ]);
        $this->assertEquals('comment content', $comment->content);
        $comment = Comment::all()->first();
        $this->assertEquals('comment content', $comment->content);
        $post = Comment::find(1)->post;
        $this->assertEquals('post Test', $post->title);
    }

    public function test_can_validate_comment()
    {
        $comment = new Comment();
        $comment->content = 'comment content';
        $factory = $this->app->make('Illuminate\Validation\Factory');
        $validator = $factory->make([], []);
        $comment->setValidator($validator);
        $this->assertTrue($comment->isValid());
        $comment->content = null;
        $this->assertFalse($comment->isValid());
    }

}