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
            <li class="current">Fokus Program</li>
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
              <h4 class="title">FOKUS PROGRAM</h4>
              <div class="row">
                <div class="col-md-6">
                  <ul class="focus-list">
                    <li>
                      <div class="icon-circle"><i class="fas fa-hand-holding-usd"></i></div>
                      Peningkatan fundraising internal & eksternal
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-donate"></i></div>
                      Penyaluran dana zakat, infaq, shadaqah & wakaf
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-graduation-cap"></i></div>
                      Peningkatan kualitas pendidikan umat
                    </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="focus-list">
                    <li>
                      <div class="icon-circle"><i class="fas fa-mosque"></i></div>
                      Peningkatan kemandirian ekonomi masjid & jama’ah
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-briefcase"></i></div>
                      Pemberdayaan ekonomi masyarakat muslim
                    </li>
                    <li>
                      <div class="icon-circle"><i class="fas fa-bullhorn"></i></div>
                      Pemberdayaan sosial & syi’ar dakwah
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
              <a href="/landasanutama">Landasan Utama</a>
              <a href="/fokusprogram" class="active">Fokus Program</a>
              <a href="/struktur">Struktur Organisasi Rumah Amal USK</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

</main>
@endsection