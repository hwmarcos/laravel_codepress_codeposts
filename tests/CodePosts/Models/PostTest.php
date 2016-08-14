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

    public function test_can_soft_delete()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        $post->delete();
        $this->assertTrue($post->trashed());
        $this->assertCount(0, $post->all());
    }

    public function test_can_get_rows_deleted()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        Post::create([
            'title' => 'post Test2',
            'content' => 'post content2'
        ]);
        $post->delete();
        $post = Post::onlyTrashed()->get();
        $this->assertEquals(1, $post[0]->id);
        $this->assertEquals('post Test', $post[0]->title);
    }

    public function test_can_get_rows_deleted_and_activated()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        Post::create([
            'title' => 'post Test2',
            'content' => 'post content2'
        ]);
        $post->delete();
        $posts = Post::withTrashed()->get();
        $this->assertCount(2, $posts);
        $this->assertEquals(1, $posts[0]->id);
        $this->assertEquals('post Test', $posts[0]->title);
    }

    public function test_can_force_delete()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        $post->forceDelete();
        $this->assertCount(0, $post->all());
    }

    public function test_can_restore_rows_from_deleted()
    {
        $post = Post::create([
            'title' => 'post Test',
            'content' => 'post content'
        ]);
        $post->delete();
        $post->restore();
        $post->find(1);
        $this->assertEquals(1, $post->id);
        $this->assertEquals('post Test', $post->title);
    }

}