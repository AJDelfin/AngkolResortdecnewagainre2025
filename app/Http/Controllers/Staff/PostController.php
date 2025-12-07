<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        $posts = Post::with('user')
            ->where('visibility', 'public')
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        $view = $request->query('view', 'posts'); // 'posts' or 'notifications'

        return view('staff.posts.index', compact('posts', 'notifications', 'view'));
    }

    public function show(Post $post)
    {
        return view('staff.posts.show', compact('post'));
    }

    public function create()
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->get();

        return view('staff.posts.create', compact('admins', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visibility' => 'required|in:public,private',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'visibility' => $request->visibility,
            'user_id' => Auth::id(),
        ]);

        if ($request->visibility === 'private' && $request->has('users')) {
            $post->users()->sync($request->users);
        }

        return redirect()->route('staff.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->get();

        return view('staff.posts.edit', compact('post', 'admins', 'customers'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visibility' => 'required|in:public,private',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'visibility' => $request->visibility,
        ]);

        if ($request->visibility === 'private') {
            $post->users()->sync($request->users);
        } else {
            $post->users()->sync([]);
        }

        return redirect()->route('staff.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        return redirect()->route('staff.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $posts = Post::whereIn('id', $ids)->get();

        foreach ($posts as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->delete();
        }

        return redirect()->route('staff.posts.index')->with('success', 'Posts deleted successfully.');
    }
}
