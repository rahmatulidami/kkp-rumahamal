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
                    </div>
                </div>
            </div>
        </div>
  </div>
    </div><!-- End Page Title -->

    <!-- Search Section -->
    <section id="tag-section" class="tag-section section">
        <div class="container">
        <h1>Menampilkan Postingan dengan tag: <b> {{ $tagName }}</b></h1>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">
        <div class="container">
            <div class="row gy-4" id="blog-container">
                @if(count($beritaPosts) > 0)
                @foreach($beritaPosts as $post)
                        <div class="col-lg-4 blog-post-item" data-title="{{ strtolower($post['title']['rendered']) }}">
                            <article>
                                @if($post['image_url'])
                                    <div class="post-img">
                                        <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" style="width: 100%; height: auto;">
                                    </div>
                                @endif
                                <p class="post-category">{{ implode(', ', $post['categories']) }}</p>
                                <h2 class="title">
                                <a href="{{ route('berita.show', $post['slug']) }}">{{ $post['title']['rendered'] }}</a>
                                </h2>
                                <div class="d-flex align-items-center">
                                    <p class="post-date">
                                        <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->format('d F Y') }}</time>
                                    </p>
                                </div>
                            </article>
                        </div><!-- End post list item -->
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="alert alert-warning">Berita yang dicari tidak ditemukan.</p>
                    </div>
                @endif   
            </div>
        </div>
    </section><!-- /Blog Posts Section -->

<!-- Pagination -->
<section id="gallery-pagination" class="gallery-pagination section">
    <div class="container">
        <div class="d-flex justify-content-center">
            <ul class="pagination-list">
                @if($pagination['current_page'] > 1)
                    <li class="page-item">
                        <a href="{{ url("tag/$tag?page=" . ($pagination['current_page'] - 1)) }}" class="page-link prev" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                @endif

                {{-- First page --}}
                @if($pagination['current_page'] > 3)
                    <li class="page-item">
                        <a href="{{ url("tag/$tag?page=1") }}" class="page-link">1</a>
                    </li>
                    @if($pagination['current_page'] > 4)
                        <li class="page-item disabled dots">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                {{-- Middle pages --}}
                @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++)
                    <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                        <a href="{{ url("tag/$tag?page=$i") }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Last page --}}
                @if($pagination['current_page'] < $pagination['total_pages'] - 2)
                    @if($pagination['current_page'] < $pagination['total_pages'] - 3)
                        <li class="page-item disabled dots">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a href="{{ url("tag/$tag?page=" . $pagination['total_pages']) }}" class="page-link">{{ $pagination['total_pages'] }}</a>
                    </li>
                @endif

                @if($pagination['current_page'] < $pagination['total_pages'])
                    <li class="page-item">
                        <a href="{{ url("tag/$tag?page=" . ($pagination['current_page'] + 1)) }}" class="page-link next" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</section>
</main>
@endsection
