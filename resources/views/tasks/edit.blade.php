@extends('layouts.todo')

@section('content')
  <h2 class="text-base font-bold text-slate-800 mb-4">Edit Tugas</h2>

  @if ($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-xs text-rose-700 font-medium">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
      <label for="title" class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Tugas</label>
      <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
             class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-teal-500 focus:outline-none">
    </div>

    <div>
      <label for="description" class="block text-xs font-semibold text-slate-600 mb-1.5">
        Keterangan <span class="font-normal text-slate-400">(opsional)</span>
      </label>
      <textarea id="description" name="description" rows="3"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-teal-500 focus:outline-none">{{ old('description', $task->description) }}</textarea>
    </div>

    <div>
      <label for="category_id" class="block text-xs font-semibold text-slate-600 mb-1.5">
        Kategori <span class="font-normal text-slate-400">(opsional)</span>
      </label>
      <select id="category_id" name="category_id"
              class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-teal-500 focus:outline-none">
        <option value="">— Tanpa kategori —</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" @selected(old('category_id', $task->category_id) == $category->id)>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="flex items-center gap-2 pt-1">
      <button type="submit"
              class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition">
        Simpan Perubahan
      </button>
      <a href="{{ route('tasks.index') }}"
         class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
        Batal
      </a>
    </div>
  </form>
@endsection
