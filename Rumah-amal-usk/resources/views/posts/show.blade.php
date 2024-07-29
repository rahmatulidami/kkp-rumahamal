@extends('layouts.layout')

@section('title', $type)

@section('content')

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>{{ strtoupper($type) }}</h1>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">{{ $type }}</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">

      <div class="container">
        <div class="row gy-4">
          @foreach($posts as $post)
            <div class="col-lg-4">
              <article>
                <div class="post-img">
                  <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid">
                </div>

                <p class="post-category">{{ implode(', ', $post->categories->pluck('name')->toArray()) }}</p>

                <h2 class="title">
                  <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                </h2>

                <div class="d-flex align-items-center">
                  <div class="post-meta">
                    <p class="post-date">
                      <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time>
                    </p>
                  </div>
                </div>
              </article>
            </div><!-- End post list item -->
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $posts->links() }}
        </div>
      </div>

    </section><!-- /Blog Posts Section -->

  </main>
@endsection
