@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="stack">
    <section class="card hero">
        <div class="eyebrow">Portal Berita &middot; Laravel</div>
        <h1>Berita, Ide, dan Cerita yang Terus Tumbuh</h1>
        <p class="lead">
            Jelajahi artikel terbaru, baca insight dari para penulis, dan kelola konten Anda dalam satu tempat dengan tampilan yang cepat dan modern.
        </p>

        @guest
            <div class="form-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
            </div>
        @endguest

        @auth
            <div class="form-actions">
                <a href="{{ route('articles.create') }}" class="btn btn-primary">+ Tulis Artikel</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Buka Dashboard</a>
            </div>
        @endauth
    </section>

    <section>
        <div class="section-head">
            <div>
                <h3 class="section-title">Berita Terbaru</h3>
                <p class="section-sub">Update terkini dari komunitas penulis.</p>
            </div>
        </div>

        @if ($articles->isNotEmpty())
            <div class="row" style="margin-top:1rem;">
                @foreach ($articles as $article)
                    <article class="card article-card">
                        <img src="{{ $article->image_url }}"
                             alt="Gambar {{ $article->title }}"
                             class="article-thumb">
                        <div class="article-card-body">
                            <h4 style="margin: 0 0 .3rem 0; font-size: 1.15rem;">
                                <a href="{{ route('articles.show', $article) }}">
                                    {{ $article->title }}
                                </a>
                            </h4>
                            <p class="article-meta">
                                {{ $article->created_at->format('d M Y') }} &middot; {{ $article->user->name }}
                            </p>
                            <p class="article-excerpt">
                                {{ \Illuminate\Support\Str::limit($article->body, 120) }}
                            </p>
                            <a href="{{ route('articles.show', $article) }}" class="article-link">
                                Baca selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="card empty-state" style="margin-top:1rem;">
                <p style="margin:0 0 .4rem; font-size:1.05rem; color:#e2e8f0;">Belum ada berita yang tersedia.</p>
                <p style="margin:0;">Jadilah yang pertama membagikan cerita.</p>
                @auth
                    <p style="margin:.9rem 0 0;"><a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">Tambah Artikel</a></p>
                @endauth
            </div>
        @endif
    </section>
</div>
@endsection
