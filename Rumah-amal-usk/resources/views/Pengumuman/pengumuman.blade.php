@extends('layouts.layout')

@section('title', 'Pengumuman | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">

@endsection

@section('content')

<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>PENGUMUMAN</h1>
                    </div>
                </div>
            </div>
        </div>

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li class="current">Pengumuman</li>
                </ol>
            </div>
        </nav>
    </div>
    </div><!-- End Page Title -->

    <!-- Search Section -->
    <section id="search-section" class="search-section section">
        <div class="container">
            <form action="{{ route('pengumuman') }}" method="GET" class="search-form">
                <input type="text" name="search" id="search-input" class="form-control"
                    placeholder="Cari pengumuman berdasarkan judul..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-green">Cari</button>
            </form>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">
        <div class="container">
            <div class="row gy-4">
                @if(count($pengumumanPosts) > 0)
                    @foreach($pengumumanPosts as $post)
                        <div class="col-lg-4">
                            <article>
                                @if($post['image_url'])
                                    <div class="post-img">
                                        <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" style="width: 100%; height: auto;">
                                    </div>
                                @endif
                                <p class="post-category">
                                    {{ end($post['categories']) ?? 'Uncategorized' }}
                                </p>
                                <h2 class="title">
                                    <a href="{{ route('pengumuman.show', ['slug' => $post['slug']]) }}">{{ $post['title']['rendered'] }}</a>
                                </h2>
                                <div class="d-flex align-items-center">
                                    <p class="post-date">
                                        <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->translatedFormat('d F Y') }}</time>
                                    </p>
                                </div>
                            </article>
                        </div><!-- End post list item -->
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="alert alert-warning">Pengumuman yang dicari tidak ditemukan.</p>
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
                            <a href="{{ url('pengumuman?page=' . ($pagination['current_page'] - 1)) }}" class="page-link prev" aria-label="Previous">
                                <i class="bi bi-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    {{-- First page --}}
                    @if($pagination['current_page'] > 3)
                        <li class="page-item">
                            <a href="{{ url('pengumuman?page=1') }}" class="page-link">1</a>
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
                            <a href="{{ url('pengumuman?page=' . $i) }}" class="page-link">{{ $i }}</a>
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
                            <a href="{{ url('pengumuman?page=' . $pagination['total_pages']) }}" class="page-link">{{ $pagination['total_pages'] }}</a>
                        </li>
                    @endif

                    @if($pagination['current_page'] < $pagination['total_pages'])
                        <li class="page-item">
                            <a href="{{ url('pengumuman?page=' . ($pagination['current_page'] + 1)) }}" class="page-link next" aria-label="Next">
                                <i class="bi bi-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </section><!-- /Pagination -->

</main>
@endsection
