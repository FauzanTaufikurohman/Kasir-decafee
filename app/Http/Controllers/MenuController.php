<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();
        $categories = Category::all();
        return view('pages.menu.index', compact('menus', 'categories'));
    }

    public function store(Request   $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'desc' => 'required|string|max:255',
            'stok' => 'required|integer',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'harga' => $request->harga,
            'desc' => $request->desc,
            'stok' => $request->stok,
            'category_id' => $request->category,
            'image' => $imagePath
        ]);

        return redirect()->route('menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('pages.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'desc' => 'required|string|max:255',
            'stok' => 'required|integer',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = $menu->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu', 'public');
        }

        $menu->update([
            'name' => $request->name,
            'harga' => $request->harga,
            'desc' => $request->desc,
            'stok' => $request->stok,
            'category_id' => $request->category,
            'image' => $imagePath
        ]);

        return redirect()->route('menu')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu')->with('success', 'menu berhasil dihapus');
    }
}