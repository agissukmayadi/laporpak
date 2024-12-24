<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories')->with('success', 'Category deleted successfully');
    }
}
