<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.*' => 'required|string|max:255',
        ]);

        $names = $request->input('name');
        foreach ($names as $name) {
            if (!empty($name)) {
                Category::create(['name' => $name]);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Categories created successfully.');
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function reset()
    {
        // Menghapus semua kategori
        Category::truncate();

        return redirect()->route('categories.index')->with('success', 'All categories have been deleted.');
    }

}

