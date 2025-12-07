<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use App\Models\Post;
use App\Models\Room;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_public', true)->latest()->take(3)->get();
        $rooms = Room::latest()->take(3)->get();
        $cottages = Cottage::latest()->take(3)->get();

        return view('welcome', compact('posts', 'rooms', 'cottages'));
    }
}
