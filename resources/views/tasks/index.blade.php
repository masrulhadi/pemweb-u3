@extends('layouts.todo')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-2">
      <h2 class="text-base font-bold text-slate-800">Daftar Tugas</h2>
      <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-teal-50 text-teal-700">
        {{ $tasks->count() }}
      </span>
    </div>
    <a href="{{ route('tasks.create') }}"
       class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold transition">
      + Tambah Tugas
    </a>
  </div>

  <ul class="space-y-2.5">
    @forelse ($tasks as $task)
      <li class="flex items-start justify-between gap-3 p-3.5 rounded-xl border transition {{ $task->is_done ? 'border-emerald-200 bg-emerald-50/40' : 'border-slate-200 hover:border-teal-300 bg-slate-50/50' }}">
        <div class="min-w-0">
          <span class="text-sm font-medium {{ $task->is_done ? 'text-slate-400' : 'text-slate-700' }}">
            @if ($task->is_done)
              <s>{{ $task->title }}</s>
            @else
              {{ $task->title }}
            @endif
          </span>

          @if ($task->description)
            <p class="text-xs text-slate-500 mt-0.5">{{ $task->description }}</p>
          @endif

          @if ($task->category)
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-semibold border border-indigo-100">
              {{ $task->category->name }}
            </span>
          @endif
        </div>

        <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end">
          <form action="{{ route('tasks.toggle', $task) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="px-2.5 py-1 rounded-lg text-xs font-medium border transition {{ $task->is_done ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border-emerald-200' : 'bg-sky-50 text-sky-700 hover:bg-sky-100 border-sky-200' }}">
              {{ $task->is_done ? 'Batal' : 'Selesai' }}
            </button>
          </form>
          <a href="{{ route('tasks.edit', $task) }}"
             class="px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200">
            Edit
          </a>
          <form action="{{ route('tasks.destroy', $task) }}" method="POST">
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
        <p class="font-semibold text-slate-500 text-sm">Belum ada tugas</p>
        <p class="text-xs mt-1">Klik tombol "+ Tambah Tugas" di atas untuk mulai mencatat.</p>
      </li>
    @endforelse
  </ul>
@endsection
