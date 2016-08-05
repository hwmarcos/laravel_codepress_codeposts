<?php

namespace CodePress\CodePosts\Tests\Model;

use CodePress\CodePosts\tests\AbstractTestCase;
use CodePress\CodePosts\Models\Post;
use Illuminate\Validation\Validator;
use Mockery as m;

class PostTest extends AbstractTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function test_inject_validator_in_post_model()
    {
        $post = new Post();
        $validator = m::mock(Validator::class);
        $post->setValidator($validator);
        $this->assertEquals($post->getValidator(), $validator);
    }

    public function test_should_check_if_is_valid_when_it_is()
    {
        $post = new Post();
        $post->title = 'post Test';
        $post->content = 'post content';
        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with(['title' => 'post Test', 'content' => 'post content']);
        $validator->shouldReceive('fails')->andReturn(false);
        $post->setValidator($validator);
        $this->assertTrue($post->isValid());
    }

    public function test_if_a_post_can_be_persisted()
    {
        $post = Post::create([
            'title' => 'post Teste',
            'content' => 'post content',
        ]);
        $this->assertEquals('post Teste', $post->title);
        $this->assertEquals('post content', $post->content);
        $post = Post::all()->first();
        $this->assertEquals('post Teste', $post->title);
        $this->assertEquals('post content', $post->content);
    }

    public function test_can_validate_post()
    {
        $post = new Post();
        $post->title = 'post Test';
        $post->content = 'post content';
        $factory = $this->app->make('Illuminate\Validation\Factory');
        $validator = $factory->make([], []);
        $post->setValidator($validator);
        $this->assertTrue($post->isValid());
        $post->title = null;
        $this->assertFalse($post->isValid());
    }

    public function test_can_add_comments()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        $post->comments()->create([
            'content' => 'comment content 1'
        ]);
        $post->comments()->create([
            'content' => 'comment content 2'
        ]);

        $comments = Post::find(1)->comments;
        $this->assertCount(2, $comments);
        $this->assertEquals('comment content 1', $comments[0]->content);
        $this->assertEquals('comment content 2', $comments[1]->content);
    }

}