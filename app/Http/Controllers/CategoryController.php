<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $categories)
    {
        return view('categories.edit', compact('categories'));
    }

    public function update(Request $request, Category $categories)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $categories->update([
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $categories)
    {
        if (Auth::id() == $categories->user_id) {
            $categories->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        } else {
        return redirect()->route('categories.index')->with('danger', 'You are not authorized to delete this category!');
        }
    }

}