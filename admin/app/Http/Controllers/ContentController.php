<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    // List all content
    public function index()
    {
        $contents = Content::all();
        return view('admin.contents.index', compact('contents'));
    }

    // Show create form
    public function create()
    {
        return view('admin.contents.create');
    }

    // Store new content
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:contents,slug',
            'body' => 'nullable|string',
            'type' => 'required|string',
            'is_published' => 'boolean',
        ]);

        Content::create($validated);

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully.');
    }

    // Show edit form
    public function edit(Content $content)
    {
        return view('admin.contents.edit', compact('content'));
    }

    // Update content
    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:contents,slug,' . $content->id,
            'body' => 'nullable|string',
            'type' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $content->update($validated);

        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully.');
    }

    // Delete content
    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Content deleted successfully.');
    }
}
