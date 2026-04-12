<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('pages.menu.category-index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_menu' => 'required|string|max:255',
            'cat_menu' => 'required|string|max:255'
        ]);

        Category::create([
            'type_menu' => $request->type_menu,
            'cat_menu' => $request->cat_menu
        ]);

        return redirect()->route('category')->with('success', 'Kategori berhasil ditambahkan');
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.menu.category-edit', compact('category'));
    }
    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'type_menu' => 'required|string|max:255',
            'cat_menu' => 'required|string|max:255'
        ]);

        $category->update([
            'type_menu' => $request->type_menu,
            'cat_menu' => $request->cat_menu
        ]);

        return redirect()->route('category')->with('success', 'Kategori berhasil diperbarui');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category')->with('success', 'Kategori berhasil dihapus');
    }
}
