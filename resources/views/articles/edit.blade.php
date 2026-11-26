@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<section class="card">
    <div class="page-header">
        <h2 style="margin:0;">Edit Artikel / Berita</h2>
        <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <p class="muted">Perbarui data berita di bawah ini. Kosongkan URL gambar untuk kembali memakai gambar placeholder.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Judul Artikel</label>
        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required placeholder="Masukkan judul berita">

        <label for="image">URL Gambar (opsional)</label>
        <input type="url" id="image" name="image" value="{{ old('image', $article->image) }}" placeholder="https://example.com/gambar.jpg">

        <p class="muted form-hint">Pratinjau gambar saat ini:</p>
        <img src="{{ $article->image_url }}" alt="Gambar artikel" style="width: 100%; max-width: 420px; height: 220px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border); margin-bottom: .5rem;">

        <label for="body">Isi Berita</label>
        <textarea id="body" name="body" rows="10" required>{{ old('body', $article->body) }}</textarea>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Artikel</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</section>
@endsection
