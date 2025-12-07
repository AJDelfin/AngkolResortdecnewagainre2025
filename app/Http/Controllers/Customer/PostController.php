<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        $posts = Post::latest()->paginate(10);

        $view = $request->query('view', 'posts'); // 'posts' or 'notifications'

        return view('customer.posts.index', compact('notifications', 'posts', 'view'));
    }
}
