<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // Perbaikan di sini: dari 'todo' menjadi 'todos'
        $categories = Category::with('todos')->where('user_id', Auth::id())->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        if ($category->user_id != Auth::id()) {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to edit this category!');
        }

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id != Auth::id()) {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to update this category!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => ucfirst($request->title),
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id != Auth::id()) {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to delete this category!');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}