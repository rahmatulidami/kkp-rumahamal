@extends('layouts.layout')

@section('title', 'Profil | Rumah Amal USK')

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
            <h1>PROFIL</h1>
          </div>
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li class="current">Profil</li>
          </ol>
      </div>
    </nav>
  </div>
  <!-- End Page Title -->

    <!-- About Section -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/profil/usk.png" class="img-fluid rounded-4 mb-4" alt="Profil Image">
          <div class="content">
              <h3>RUMAH AMAL MASJID JAMIK USK</h3>
              <p>
              Rumah Amal Masjid Jamik Universitas Syiah Kuala adalah lembaga amil zakat, infaq dan shadaqah yang telah berdiri sejak 2016 untuk menghimpun dan menyalurkan dana (Zakat, Infaq dan Shadaqah).
              <br><br>
              Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya. Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat, Mendayagunakan dana zakat, infaq shadaqah maupun wakaf melalui program-program yang terasa manfaatnya, Mengangkat martabat mustahik, dan membahagiakan muzakki dan donatur.
              <br><br>
              Rumah Amal Masjid Jamik USK pada tahun 2023 telah menjalin kerjasama dengan lembaga Amil Zakat Nasional (LAZNAS) Rumah Amal Salman dengan Keputusan Mentri Agama Republik Indonesia No 854 Tahun 2023, sehingga Rumah Amal Masjid Jamik USK secara resmi menjadi bagian dari LAZNAS Rumah Amal Salman dengan Surat Keputusan Pengurus Rumah Amal Nomor 68 Tahun 2023.
              </p>
          </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="250">
          <div class="menu-list">
              <a href="/profil" class="active">Profil Singkat</a>
              <a href="/visimisi">Visi dan Misi</a>
              <a href="/landasanutama">Landasan Utama</a>
              <a href="/fokusprogram">Fokus Program</a>
              <a href="/struktur">Struktur Organisasi Rumah Amal USK</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

</main>
@endsection