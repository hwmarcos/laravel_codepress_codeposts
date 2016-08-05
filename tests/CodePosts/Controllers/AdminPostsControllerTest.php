<?php

namespace CodePress\CodePosts\Tests\Controllers;

use CodePress\CodePosts\Controllers\AdminPostsController;
use CodePress\CodePosts\Repository\PostRepositoryEloquent;
use CodePress\CodePosts\tests\AbstractTestCase;
use CodePress\CodePosts\Controllers\Controller;
use Illuminate\Routing\ResponseFactory;
use Mockery as m;

class AdminPostsControllersTest extends AbstractTestCase
{

    public function test_should_extends_from_controller()
    {
        $repo = m::mock(PostRepositoryEloquent::class);
        $responseFactory = m::mock(ResponseFactory::class);
        $controller = new AdminPostsController($responseFactory, $repo);
        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_controller_should_run_index_method_and_return_right_arguments()
    {
        $repo = m::mock(PostRepositoryEloquent::class);
        $responseFactory = m::mock(ResponseFactory::class);
        $controller = new AdminPostsController($responseFactory, $repo);
        $html = m::mock();
        $postsResult = ['Post 1', 'Post 2'];
        $repo->shouldReceive('all')->andReturn($postsResult);
        $responseFactory->shouldReceive('view')
            ->with('codepost::index', ['posts' => $postsResult])
            ->andReturn($html);
        $this->assertEquals($controller->index(), $html);
    }

}