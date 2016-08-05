<?php

namespace CodePress\CodePosts\Controllers;

use CodePress\CodePosts\Repository\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;

class AdminPostsController extends Controller
{

    private $repository;
    private $response;

    public function __construct(ResponseFactory $response, PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function index()
    {
        $posts = $this->repository->all();
        return $this->response->view('codepost::index', compact('posts'));
    }

    public function create()
    {
        $posts = $this->repository->all();
        return view('codepost::create', compact('posts'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->repository->create($request->all());
        return redirect()->route('admin.posts.index');
    }

    public function edit($id)
    {
        $post = $this->repository->find($id);
        $posts = $this->repository->all();
        return $this->response->view('codepost::edit', compact('posts', 'post'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $this->repository->update($data, $request->id);
        return redirect()->route('admin.posts.index');
    }

}