<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * READ: tampilkan seluruh kategori beserta jumlah tugasnya.
     */
    public function index(): View
    {
        $categories = Category::withCount('tasks')->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * CREATE: validasi lalu simpan kategori baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'max:100', 'unique:categories,name'],
        ]);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit berisi data kategori lama.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * UPDATE: validasi lalu perbarui nama kategori.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
        ]);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * DELETE: hapus kategori (tugas terkait tetap ada, kategori menjadi kosong).
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
