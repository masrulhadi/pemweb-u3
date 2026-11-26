@extends('layouts.todo')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-2">
      <h2 class="text-base font-bold text-slate-800">Daftar Kategori</h2>
      <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700">
        {{ $categories->count() }}
      </span>
    </div>
    <a href="{{ route('categories.create') }}"
       class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold transition">
      + Tambah Kategori
    </a>
  </div>

  <ul class="space-y-2.5">
    @forelse ($categories as $category)
      <li class="flex items-center justify-between gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-indigo-300 bg-slate-50/50 transition">
        <div class="min-w-0">
          <span class="text-sm font-medium text-slate-700">{{ $category->name }}</span>
          <span class="ml-1.5 text-xs text-slate-400">{{ $category->tasks_count }} tugas</span>
        </div>
        <div class="flex items-center gap-1.5 shrink-0">
          <a href="{{ route('categories.edit', $category) }}"
             class="px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200">
            Edit
          </a>
          <form action="{{ route('categories.destroy', $category) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-2.5 py-1 rounded-lg text-xs font-medium bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200">
              Hapus
            </button>
          </form>
        </div>
      </li>
    @empty
      <li class="text-center py-10 px-4 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
        <p class="font-semibold text-slate-500 text-sm">Belum ada kategori</p>
        <p class="text-xs mt-1">Klik tombol "+ Tambah Kategori" di atas untuk mulai membuat.</p>
      </li>
    @endforelse
  </ul>

  <p class="text-xs text-slate-400 mt-4">
    Menghapus kategori tidak menghapus tugasnya — tugas hanya menjadi tanpa kategori.
  </p>
@endsection
