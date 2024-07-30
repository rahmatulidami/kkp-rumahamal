{{-- resources/views/posts/show-detail.blade.php --}}
@extends('layouts.layout')

@section('title', $post->title)

@section('content')
<main class="main">
    <div class="container">
        <article>
            <div class="post-img">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid">
            </div>
            <h1 class="title">{{ $post->title }}</h1>
            <p class="post-category">{{ implode(', ', $post->categories->pluck('name')->toArray()) }}</p>
            <div class="post-content">
                {!!$post->content!!} <!-- Pastikan konten sudah di-escape dengan benar jika menggunakan HTML -->
            </div>
            <div class="post-meta">
                <p class="post-date">
                    <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time>
                </p>
            </div>
        </article>
    </div>
</main>
@endsection
