@extends('layouts.layout')

@section('title', 'Campaign | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>CAMPAIGN</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="current">Campaign</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!--Section -->
<section id="program" class="program section">
  <div class="container section-title" data-aos="fade-up">
    <h2>PROGRAM RUMAH AMAL USK</h2>
    <p>Masjid Jamik Universitas Syiah Kuala</p>
  </div>

  <div class="container">
    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
      <div class="program-filters" data-aos="fade-up" data-aos-delay="100">
        <select id="filter-select" class="isotope-filters" aria-label="filter">
          <option value="*" class="filter-active">ALL</option>
          <option value=".filter-pendidikan">PENDIDIKAN</option>
          <option value=".filter-pemberdayaan">PEMBERDAYAAN</option>
          <option value=".filter-sosial">SOSIAL & KEMANUSIAAN</option>
          <option value=".filter-syiar">SYIAR & QURBAN</option>
          <option value=".filter-kemitraan">KEMITRAAN</option>
          <option value=".filter-fasilitator">FASILITATOR & RELAWAN</option>
        </select>
      </div>

      <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200" id="program-items">
        @foreach($programPosts as $post)
          @php
            // Extracting category names
            $categories = array_column($post['categories'], 'name');
            $filterClass = '';

            // Mapping categories to filter classes
            if (in_array('Pendidikan', $categories)) $filterClass = 'filter-pendidikan';
            elseif (in_array('Pemberdayaan', $categories)) $filterClass = 'filter-pemberdayaan';
            elseif (in_array('Sosial & Kemanusiaan', $categories)) $filterClass = 'filter-sosial';
            elseif (in_array('Syiar & Qurban', $categories)) $filterClass = 'filter-syiar';
            elseif (in_array('Kemitraan', $categories)) $filterClass = 'filter-kemitraan';
            elseif (in_array('Fasilitator & Relawan', $categories)) $filterClass = 'filter-fasilitator';

            // Handling media and URLs safely
            $imageUrl = isset($post['image_url']) ? $post['image_url'] : url('assets/img/default.jpeg');
            $postLink = $post['link'] ?? '#';
            $postTitle = $post['title'] ?? 'Untitled';
          @endphp

          <div class="col-lg-2-4 col-md-6 program-item isotope-item {{ $filterClass }}">
            <div class="program-content h-100">
              <a href="{{ route('pengumuman.show', ['id' => $post['id']]) }}">
                <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $postTitle }}" loading="lazy">
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


</main>

@endsection
