@extends('layouts.app')

@section('title', $article->title)

@section('content')
<article class="card">
    <a href="{{ route('articles.index') }}" class="muted" style="font-size:.95rem;">&larr; Kembali ke daftar artikel</a>
    <h1 style="margin: .5rem 0 .25rem; font-size: 1.85rem;">{{ $article->title }}</h1>
    <p class="article-meta">
        Dipublikasikan pada {{ $article->created_at->format('d M Y') }} oleh {{ $article->user->name }}
    </p>

    <img src="{{ $article->image_url }}"
         alt="Gambar untuk {{ $article->title }}"
         class="article-detail-img">

    <div class="article-body">
        {!! nl2br(e($article->body)) !!}
    </div>

    <div class="detail-actions">
        <a href="{{ route('home') }}">Home</a>
        <span>&middot;</span>
        <a href="{{ route('articles.index') }}">Semua artikel</a>
        @auth
            @if ($article->user_id === auth()->id())
                <span>&middot;</span>
                <a href="{{ route('articles.edit', $article) }}">Edit artikel</a>
            @endif
        @endauth
    </div>
</article>
@endsection
