<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * READ: tampilkan seluruh daftar tugas.
     */
    public function index(): View
    {
        $tasks = Task::with('category')->latest()->get(); // Ambil semua tugas, urutkan dari terbaru

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Tampilkan form tambah tugas.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('tasks.create', compact('categories'));
    }

    /**
     * CREATE: validasi lalu simpan tugas baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        Task::create($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit berisi data tugas lama.
     */
    public function edit(Task $task): View
    {
        $categories = Category::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'categories'));
    }

    /**
     * UPDATE: validasi lalu perbarui data tugas.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * DELETE: hapus tugas dari database.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    /**
     * Tandai tugas selesai / batalkan tanda selesai.
     */
    public function toggleDone(Task $task): RedirectResponse
    {
        $task->update(['is_done' => ! $task->is_done]);

        return redirect()->route('tasks.index')
            ->with('success', $task->is_done
                ? 'Tugas ditandai selesai.'
                : 'Tanda selesai dibatalkan.');
    }
}
