@extends('layouts.layout')

@section('title', 'Profil | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>VISI & MISI RUMAH AMAL USK</h1>
          </div>
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


  <section id="visi" class="visi section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>VISI</h2>
  </div><!-- End Section Title -->

        <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
            <div class="container position-relative">
                <div class="row gy-4 mt-5">
                    <div class="col-xl-4 col-md-6">
                      <div class="visi-box">
                        <h4 class="title">VISI</h4>
                        <p>Menjadi Lembaga Amil Zakat dan pemberdayaan ekonomi umat yang inovatif, responsif, profesional dan terkemuka untuk kemaslahatan bersama yang berbasis masjid.</p>
                      </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="visi-box">
                            <h4 class="title">MISI</h4>
                            <ul>
                                <li> Menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya. </li>
                                <br>
                                <li>Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat.</li>
                                <br>
                                <li>Mendayagunakan dana zakat, infaq shadaqah maupun wakaf melalui program-program yang terasa manfaatnya</li>
                                <br>
                                <li>Mengangkat martabat mustahik, dan membahagiakan muzakki dan donatur.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="visi-box">
                            <h4 class="title">LANDASAN UTAMA</h4>
                            <ul>
                                <li>Financial Support System Masjid Jamik Universitas Syiah Kuala.</li>
                                <br>
                                <li>Perlunya lembaga pengelola Zakat, Infaq dan Shadaqah di Lingkungan Universitas Syiah Kuala.</li>
                                <br>
                                <li>Amanah Asosiasi Masjid Kampus Indonesia (AMKI).</li>
                                <br>
                                <li>Pengelolaan mandiri untuk masyarakat di sekitar Universitas Syiah Kuala.</li>
                                <br>
                                <li>Menunjang keberhasilan pendidikan mahasiswa Universitas Syiah Kuala.</li>
                                <br>
                                <li>Mendekatkan Muzakki dengan Mustahik Zakat.</li>
                                <br>
                                <li>Penyaluran yang cepat dan innovatif.</li>
                                <br>
                                <li>Meningkatkan sinergitas antara universitas, dosen, mahasiswa dan masyarakat.</li>
                                <br>
                                <li>Meningkatkan citra dan positioning Universitas Syiah Kuala.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="visi-box">
                            <h4 class="title">FOKUS PROGRAM</h4>
                            <ul>
                                <li>Peningkatan fundraising internal maupun eksternal melalui program-program yang kreatif dan inovatif serta saling memberi manfaat.</li>
                                <br>
                                <li>Penyaluran dana zakat, infaq, shadaqah dan wakaf yang inovatif, syar’i dan tepat sasaran.</li>
                                <br>
                                <li>Peningkatan kualitas pendidikan umat.</li>
                                <br>
                                <li>Peningkatan kemandirian ekonomi masjid dan jama’ah.</li>
                                <br>
                                <li>Pemberdayaan ekonomi masyarakat muslim.</li>
                                <br>
                                <li>Pemberdayaan sosial dan syi’ar dakwah bagi masyarakat.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  </section><!-- /visi-mmisi Section -->

  <!-- Section struktur -->
   <section class="struktur-organisasi" id="struktur-organisasi section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>STRUKTUR ORGANISASI RUMAH AMAL USK</h2>
    </div><!-- End Section Title -->

    <div class="gambar">
      <img src="assets/img/struktur.png" alt="">
    </div>

   </section>


</main>
@endsection