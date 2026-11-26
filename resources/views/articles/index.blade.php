@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<section class="card">
    <div class="page-header">
        <h2>Daftar Artikel</h2>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">+ Artikel Baru</a>
    </div>

    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    @if ($articles->isNotEmpty())
        <ul class="article-list">
            @foreach ($articles as $article)
                <li class="article-item">
                    <div class="article-item-main">
                        <a href="{{ route('articles.show', $article) }}" class="article-item-title">
                            {{ $article->title }}
                        </a>
                        <div class="article-item-meta">oleh {{ $article->user->name }} &middot; {{ $article->created_at->format('d M Y') }}</div>
                    </div>

                    @if ($article->user_id === auth()->id())
                        <div class="article-actions">
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('articles.destroy', $article) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        {{ $articles->links('pagination::bootstrap-5') }}
    @else
        <div class="empty-state">
            <p style="margin-bottom:.75rem;">Belum ada artikel.</p>
            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">Buat artikel pertama</a>
        </div>
    @endif
</section>
@endsection
