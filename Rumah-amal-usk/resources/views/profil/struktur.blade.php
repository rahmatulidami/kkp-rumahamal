@extends('layouts.layout')

@section('title', 'Profil | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">

@endsection

@section('content')

<!-- Lightbox2 CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <!-- <div class="col-lg-8">
            <h1>PROFIL</h1>
          </div> -->
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li class="current">Struktur Organisasi Rumah Amal USK</li>
          </ol>
      </div>
    </nav>
  </div>
  <!-- End Page Title -->

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row gy-4">
        
        <!-- Gambar Struktur -->
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            <div class="container section-title" data-aos="fade-up">
                <h2>STRUKTUR ORGANISASI RUMAH AMAL USK</h2>
            </div>

            <div class="gambar">
                <a href="assets/img/struktur.png" data-lightbox="struktur" data-title="Struktur Organisasi Rumah Amal USK">
                    <img src="assets/img/struktur.webp" alt="Struktur Organisasi" class="img-fluid" width="645" height="749">
                </a>
            </div>
        </div>

        <!-- Menu Sidebar -->
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="250">
          <div class="menu-list">
          <a href="/profil" >Profil Singkat</a>
              <a href="/visimisi">Visi dan Misi</a>
              <a href="/landasanutama">Landasan Utama</a>
              <a href="/fokusprogram">Fokus Program</a>
              <a href="/struktur" class="active">Struktur Organisasi Rumah Amal USK</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

</main>
@endsection