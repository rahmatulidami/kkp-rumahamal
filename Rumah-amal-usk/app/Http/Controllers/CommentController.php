<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment; // Adjust according to your Comment model

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'comment' => 'required|string',
            'berita_id' => 'required|integer|exists:posts,id', // Assuming 'posts' is your table
        ]);

        // Create the comment
        Comment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'content' => $validated['comment'],
            'berita_id' => $validated['berita_id'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Comment posted successfully!');
    }
}
