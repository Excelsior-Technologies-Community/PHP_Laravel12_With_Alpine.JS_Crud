<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // 🔍 Search (title + description)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Status Filter (Active / Inactive)
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // 📊 Order
        $posts = $query->orderBy('id', 'asc')->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return back()->with('success', 'Post moved to trash');
    }

    public function toggleStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = !$post->status;
        $post->save();

        return back();
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->get();
        return view('posts.trash', compact('posts'));
    }

    public function restore($id)
    {
        Post::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Post restored');
    }
}
