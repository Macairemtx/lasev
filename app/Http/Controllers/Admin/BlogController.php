<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('media')->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $authors = User::where('role', 'admin')->get();
        return view('admin.blogs.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'body' => 'required|string',
            'author_id' => 'nullable|exists:users,id',
            'is_premium' => 'boolean',
            'category' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['author_id'] = $request->author_id ?? auth()->id();
        $data['is_premium'] = $request->has('is_premium');
        $data['category'] = $request->category ?? 'general';

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog créé avec succès.');
    }

    public function show($id)
    {
        $blog = Blog::with(['media', 'author'])->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $authors = User::where('role', 'admin')->get();
        return view('admin.blogs.edit', compact('blog', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'body' => 'required|string',
            'author_id' => 'nullable|exists:users,id',
            'is_premium' => 'boolean',
            'category' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_premium'] = $request->has('is_premium');
        $data['category'] = $request->category ?? $blog->category ?? 'general';

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog supprimé avec succès.');
    }
}

