<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class HomeController extends Controller
{
    public function index()
    {
        $comments = Comment::approved()->with('user')->latest()->take(6)->get();
        return view('home', compact('comments'));
    }
}