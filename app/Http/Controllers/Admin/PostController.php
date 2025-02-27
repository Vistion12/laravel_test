<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StorePostRequest;
    use App\Http\Requests\UpdatePostRequest;
    use App\Models\Category;
    use App\Models\Post;
    use App\Services\PostService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class PostController extends Controller
    {
        protected $postService;

        public function __construct(PostService $postService)
        {
            $this->postService = $postService;
        }

        public function index()
        {
            //$posts = Post::all();
            $posts = $this->postService->getAllPosts();
            return view('admin.posts.index', compact('posts'));
        }

        public function create()
        {
            $categories = Category::all();
            return view('admin.posts.create', compact('categories'));
        }


        public function edit(Post $post)
        {
            $categories = Category::all();
            return view('admin.posts.edit', compact('post', 'categories'));
        }

        public function update(UpdatePostRequest $request, Post $post)
        {
            try {
                $this->postService->updatePost($post, $request->validated());
                return redirect()->route('admin.posts.index')->with('success', 'Пост успешно обновлен!');
            } catch (\Exception $e) {
                return back()->with('error', 'Ошибка обновления поста: ' . $e->getMessage());
            }
        }

        public function destroy(Post $post)
        {
            try {
                $this->postService->deletePost($post);
                return redirect()->route('admin.posts.index')->with('success', 'Пост успешно удален!');
            } catch (\Exception $e) {
                return back()->with('error', 'Ошибка удаления поста: ' . $e->getMessage());
            }
        }

        public function store(StorePostRequest $request)
        {
            try {
                $this->postService->createPost($request->validated());
                return redirect()->route('admin.posts.index')->with('success', 'Пост успешно добавлен!');
            } catch (\Exception $e) {
                return redirect()->route('admin.posts.create')->with('error', 'Ошибка добавления поста: ' . $e->getMessage());
            }
        }
    }

