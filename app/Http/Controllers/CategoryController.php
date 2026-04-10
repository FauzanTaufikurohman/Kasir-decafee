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
        // VALIDASI
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // SIMPAN DATA
        Category::create([
            'name' => $request->name
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
        // VALIDASI
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // UPDATE DATA
        $category->update([
            'name' => $request->name
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
