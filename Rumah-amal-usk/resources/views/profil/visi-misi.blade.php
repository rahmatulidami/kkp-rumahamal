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
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li class="current">Visi & Misi</li>
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
        <img src="assets/img/profil/mesjid-jamik.webp" class="img-fluid rounded-4 mb-4" alt="Profil Image">
          <div class="fokus-box">
            <h4 class="title">VISI</h4>
            <p>Menjadi Lembaga Amil Zakat dan pemberdayaan ekonomi umat yang inovatif, responsif, profesional dan terkemuka untuk kemaslahatan bersama yang berbasis masjid.</p>
              
            <div class="row">
              <h4 class="title">MISI</h4>
              <div class="col-md-6">
                <ul class="focus-list">
                  <li>
                    <div class="icon-circle"><i class="fas fa-hand-holding-dollar"></i></div>
                    Menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.
                  </li>
                  <li>
                    <div class="icon-circle"><i class="fas fa-mosque"></i></div>
                    Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat.
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="focus-list">
                  <li>
                    <div class="icon-circle"><i class="fas fa-hands-helping"></i></div>
                    Mendayagunakan dana zakat, infaq, shadaqah maupun wakaf melalui program-program yang terasa manfaatnya.
                  </li>
                  <li>
                    <div class="icon-circle"><i class="fas fa-people-carry"></i></div>
                    Mengangkat martabat mustahik dan membahagiakan muzakki serta donatur.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="250">
          <div class="menu-list">
              <a href="/profil">Profil Singkat</a>
              <a href="/visimisi" class="active">Visi dan Misi</a>
              <a href="/landasanutama">Landasan Utama</a>
              <a href="/fokusprogram" >Fokus Program</a>
              <a href="/struktur">Struktur Organisasi Rumah Amal USK</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

</main>
@endsection
