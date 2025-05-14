@extends('layouts.layout')

@section('title', 'Profil | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">

    <!-- Tambahkan ini di dalam <head> -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li class="current">Landasan Utama</li>
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
          <div class="fokus-box">
              <h4 class="title">LANDASAN UTAMA</h4>
              <div class="row">
                <div class="col-md-6">
                  <ul class="focus-list">
                    <li>
                      <div class="icon-circle"><i class="fas fa-hand-holding-heart"></i></div>
                      Financial Support System Masjid Jamik Universitas Syiah Kuala.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-donate"></i></div>
                      Perlunya lembaga pengelola Zakat, Infaq dan Shadaqah di Lingkungan Universitas Syiah Kuala.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-users"></i></div>
                      Amanah Asosiasi Masjid Kampus Indonesia (AMKI).
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-home"></i></div>
                      Pengelolaan mandiri untuk masyarakat di sekitar Universitas Syiah Kuala.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-user-graduate"></i></div>
                      Menunjang keberhasilan pendidikan mahasiswa Universitas Syiah Kuala.
                    </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="focus-list">
                    <li>
                      <div class="icon-circle"><i class="fas fa-hands-helping"></i></div>
                      Mendekatkan Muzakki dengan Mustahik Zakat.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-rocket"></i></div>
                      Penyaluran yang cepat dan inovatif.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-handshake"></i></div>
                      Meningkatkan sinergitas antara universitas, dosen, mahasiswa, dan masyarakat.
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-chart-line"></i></div>
                      Meningkatkan citra dan positioning Universitas Syiah Kuala.
                    </li>
                  </ul>
                </div>
              </div>
          </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="250">
          <div class="menu-list">
              <a href="/profil">Profil Singkat</a>
              <a href="/visimisi">Visi dan Misi</a>
              <a href="/landasanutama" class="active">Landasan Utama</a>
              <a href="/fokusprogram" >Fokus Program</a>
              <a href="/struktur">Struktur Organisasi Rumah Amal USK</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

</main>
@endsection
