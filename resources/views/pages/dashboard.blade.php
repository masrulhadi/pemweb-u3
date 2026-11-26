@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="stack">
    <section class="card hero">
        <h2>Dashboard</h2>
        <p>Selamat datang, <strong>{{ $user->name }}</strong>.</p>
        <p class="muted" style="margin-bottom:0;">Ringkasan singkat aktivitas artikel di aplikasi kamu.</p>
    </section>

    <section class="row">
        <div class="card stat">
            <div class="stat-label">Total Artikel</div>
            <div class="stat-value">{{ $totalArticles }}</div>
            <p class="stat-desc">Jumlah seluruh artikel yang ada di sistem.</p>
        </div>
        <div class="card stat">
            <div class="stat-label">Artikel Kamu</div>
            <div class="stat-value">{{ $myArticles }}</div>
            <p class="stat-desc">Artikel yang dibuat oleh akun kamu.</p>
        </div>
        <div class="card">
            <h3 style="margin-bottom:.5rem;">Aksi Cepat</h3>
            <div class="stack" style="gap:.5rem;">
                <a href="{{ route('articles.create') }}" class="btn btn-primary">+ Tambah Artikel Baru</a>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Lihat Semua Artikel</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">Lihat Halaman Home</a>
            </div>
        </div>
    </section>

    <section class="card">
        <h3 class="section-title">Artikel Terbaru</h3>

        @if ($latestArticles->isNotEmpty())
            <ul class="article-list">
                @foreach ($latestArticles as $article)
                    <li class="article-item" style="align-items:flex-start;">
                        <img src="{{ $article->image_url }}"
                             alt="Thumbnail {{ $article->title }}"
                             style="width: 96px; height: 72px; object-fit: cover; border-radius: 8px; flex-shrink:0;">
                        <div class="article-item-main">
                            <a href="{{ route('articles.show', $article) }}" class="article-item-title">{{ $article->title }}</a>
                            <div class="article-item-meta">oleh {{ $article->user->name }} &bull; {{ $article->created_at->format('d M Y') }}</div>
                            <p class="muted" style="margin:.35rem 0 0;">{{ \Illuminate\Support\Str::limit($article->body, 100) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="muted" style="margin:0;">Belum ada artikel yang bisa ditampilkan.</p>
        @endif
    </section>

    <section class="card">
        <h3 class="section-title">Info Akun</h3>
        <ul style="margin:0 0 .5rem;">
            <li><strong>Nama:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
        </ul>
        <p class="muted" style="margin:0;">Gunakan menu di navbar untuk berpindah antara Home, Artikel, dan Dashboard.</p>
    </section>
</div>
@endsection
