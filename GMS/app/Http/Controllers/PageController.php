<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Display a list of pages
    public function index()
    {
        $pages = Page::all();
        return view('pages.index', compact('pages'));
    }

    // Show a single page
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.show', compact('page'));
    }

    // Create a new page (optional, for backend use)
    public function create()
    {
        return view('pages.create');
    }

    // Store a new page
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Page::create($validated);

        return redirect()->route('pages.index')->with('success', 'Page created successfully!');
    }
}
