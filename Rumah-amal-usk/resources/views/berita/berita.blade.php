@extends('layouts.layout')

@section('title', 'Berita | Rumah Amal USK')

@section('content')

<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>BERITA</h1>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Berita</li>
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
                            @if($post['image_url'])
                                <div class="post-img">
                                    <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" style="width: 100%; height: auto;">
                                </div>
                            @endif
                            <p class="post-category">{{ $post['categories'][0] ?? 'Uncategorized' }}</p>
                            <h2 class="title">
                                <a href="{{ $post['link'] }}">{{ $post['title']['rendered'] }}</a>
                            </h2>
                            <div class="d-flex align-items-center">
                                <p class="post-date">
                                    <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->format('M d, Y') }}</time>
                                </p>
                            </div>
                        </article>
                    </div><!-- End post list item -->
                @endforeach
            </div>
        </div>
    </section><!-- /Blog Posts Section -->

    <!-- Blog Pagination Section -->
    <section id="blog-pagination" class="blog-pagination section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <ul>
                    @if($pagination['current_page'] > 1)
                        <li><a href="{{ url('berita?page=' . ($pagination['current_page'] - 1)) }}"><i class="bi bi-chevron-left"></i></a></li>
                    @endif

                    @for($i = 1; $i <= $pagination['total_pages']; $i++)
                        <li><a href="{{ url('berita?page=' . $i) }}" class="{{ $pagination['current_page'] == $i ? 'active' : '' }}">{{ $i }}</a></li>
                    @endfor

                    @if($pagination['current_page'] < $pagination['total_pages'])
                        <li><a href="{{ url('berita?page=' . ($pagination['current_page'] + 1)) }}"><i class="bi bi-chevron-right"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </section><!-- /Blog Pagination Section -->

</main>
@endsection
