<!-- resources/views/posts/show.blade.php -->
@extends('layouts.layout')

@section('title', $type)

@section('content')
<main class="main">
    <section id="blog-posts" class="blog-posts section">
        <div class="container">
            <div class="row gy-4">
                @foreach($posts as $post)
                <div class="col-lg-4">
                    <article>
                        <a href="{{ url('/' . strtolower($type) . '/' . $post->title) }}"> <!-- Link ke halaman detail post -->
                            <div class="post-img">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>
                            <p class="post-category">{{ implode(', ', $post->categories->pluck('name')->toArray()) }}</p>
                            <h2 class="title">{{ $post->title }}</h2>
                            <div class="d-flex align-items-center">
                                <div class="post-meta">
                                    <p class="post-date">
                                        <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </article>
                </div><!-- End post list item -->
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $posts->links() }} <!-- Pagination -->
            </div>
        </div>
    </section>
</main>
@endsection
