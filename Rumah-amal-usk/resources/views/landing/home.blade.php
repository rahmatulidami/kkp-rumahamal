@extends('layouts.layout')

@section('title', 'Beranda')

@section('content')

<main class="main">

  <!-- Hero Section -->
  <section id="hero">
    <div class="container" data-aos="fade-up">

    <div class="hero-slider swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "navigation": {
            "nextEl": ".swiper-button-next",
            "prevEl": ".swiper-button-prev"
          },
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>
        <div class="swiper-wrapper align-items-center">

          <div class="swiper-slide">
            <img src="assets/img/campaign/palestine.png" alt="">
          </div>

          <div class="swiper-slide">
            <img src="assets/img/campaign/palestine.png" alt="">
          </div>

          <div class="swiper-slide">
            <img src="assets/img/campaign/palestine.png" alt="">
          </div>

          <div class="swiper-slide">
            <img src="assets/img/campaign/palestine.png" alt="">
          </div>

          </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero Section -->
  
<section id="icon-boxed" class="icon-boxes">
  <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
      <div class="row gy-4 mt-5">
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="#" class="stretched-link">Infak</a></h4>
            <p>Bersyukur atas rizki, berbagi kebahagian dengan sesama muslim.</p>
            <a class="btn-btn-primary" href="/donasi-infak" role="button">Infak</a>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="#" class="stretched-link">Zakat</a></h4>
            <p>Menyempurnakan rukun islam, mensucikan harta dan mententramkan jiwa.</p>
            <a class="btn-btn-primary" href="#" role="button">Zakat</a>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="#" class="stretched-link">Program</a></h4>
            <p>Rumah amal masjid jamik USK menyediakan beberapa program donasi.</p>
            <a class="btn-btn-primary" href="#" role="button">Program</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Portfolio Section -->
<section id="campaign-unggulan" class="campaign-unggulan section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>CAMPAIGN UNGGULAN</h2>
</div><!-- End Section Title -->

<div class="container">

  <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <!-- <ul class="campaign-unggulan-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
      <li data-filter="*" class="filter-active">All</li>
      <li data-filter=".filter-app">App</li>
      <li data-filter=".filter-product">Product</li>
      <li data-filter=".filter-branding">Branding</li>
      <li data-filter=".filter-books">Books</li>
    </ul>End campaign-unggulan Filters -->

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

    <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->


  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
      <div class="campaign-unggulan-content h-100">
          <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
          <div class="campaign-unggulan-info">
              <h4><a href="campaign-unggulan-details.html" title="More Details">Peduli Palestine</a></h4>
              <div class="progress-container">
                <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">3 hari lagi</div>
                      </div>
                  </div>

                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar w-75"></div>
                  </div>

                  <div class="progress-info">
                      <div class="progress-start">
                          <span>Terkumpul</span>
                          <div class="amount">Rp. 2.500.000</div>
                      </div>

                      <div class="progress-end">
                          <span>Dana dibutuhkan</span>
                          <div class="jumlah">Rp. 3.000.000</div>
                      </div>
                  </div>
                  
              </div>
              <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
          </div>
      </div>
  </div><!-- End campaign-unggulan Item -->

  </div>

  <a class="button-selengkapnya" href="/campaign" role="button">Selengkapnya</a>

</div>

</section><!-- /campaign Section -->



    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>PROFIL<br></h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/profil/usk.png" class="img-fluid rounded-4 mb-4" alt="">
            <img src="assets/img/profil/mesjid-jamik.png" class="img-fluid rounded-4 mb-4" alt="">
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
              <h3>RUMAH AMAL MASJID JAMIK USK</h2>
              <p>
              Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya. Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat, Mendayagunakan dana zakat, infaq shadaqah maupun wakaf melalui program-program yang terasa manfaatnya, Mengangkat martabat mustahik, dan membahagiakan muzakki dan donatur.
              </p>
              <a href="/profil">Selengkapnya</a>

              <div class="position-relative mt-4">
                <img src="assets/img/profil/rek-rumahamal.png" class="img-fluid rounded-4" alt="">
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

  <!-- Pengumuman Section -->
<section id="pengumuman" class="pengumuman section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>PENGUMUMAN</h2>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Politics</p>

        <h2 class="title">
          <a href="/detail-pengumuman">Dolorum optio tempore voluptas dignissimos</a>
        </h2>

        <div class="d-flex align-items-center">
          <div class="post-meta">
            <p class="post-date">
              <time datetime="2022-01-01">Jan 1, 2022</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Sports</p>

        <h2 class="title">
          <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
        </h2>

        <div class="d-flex align-items-center">
          <div class="post-meta">
            <p class="post-date">
              <time datetime="2022-01-01">Jun 5, 2022</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Entertainment</p>

        <h2 class="title">
          <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et soluta</a>
        </h2>

        <div class="d-flex align-items-center">
          <div class="post-meta">
            <p class="post-date">
              <time datetime="2022-01-01">Jun 22, 2022</time>
            </p>
          </div>
        </div>

      </article>
      
    </div><!-- End post list item -->
    <a class="btn-btn-primary" href="/pengumuman" role="button">Selengkapnya</a>
  </div><!-- End recent posts list -->

</div>

</section><!-- Pengumuman Section -->

<!-- Recent Posts Section -->
<section id="recent-posts" class="recent-posts section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>BERITA TERKINI</h2>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Politics</p>

        <h2 class="title">
          <a href="/detail-berita">Dolorum optio tempore voluptas dignissimos</a>
        </h2>

        <div class="d-flex align-items-center">
          <div class="post-meta">
            <p class="post-date">
              <time datetime="2022-01-01">Jan 1, 2022</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Sports</p>

        <h2 class="title">
          <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
        </h2>

        <div class="d-flex align-items-center">
          <div class="post-meta">
            <p class="post-date">
              <time datetime="2022-01-01">Jun 5, 2022</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
      <article>

        <div class="post-img">
          <img src="assets/img/campaign/palestine.png" alt="" class="img-fluid">
        </div>

        <p class="post-category">Entertainment</p>

        <h2 class="title">
          <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et soluta</a>
        </h2>

        <div class="d-flex align-items-center">
         <div class="post-meta">
           <p class="post-date">
              <time datetime="2022-01-01">Jun 22, 2022</time>
            </p>
          </div>
        </div>

      </article>
      
    </div><!-- End post list item -->
    <a class="btn-btn-primary" href="/berita" role="button">Selengkapnya</a>
  </div><!-- End recent posts list -->

</div>

</section><!-- /Recent Posts Section -->

<!-- Program Section -->
<section id="program" class="program section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>PROGRAM RUMAH AMAL USK</h2>
  <p>Masjid Jamik Universitas Syiah Kuala</p>
</div><!-- End Section Title -->

<div class="container">

  <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <ul class="program-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
      <li data-filter="*" class="filter-active">All</li>
      <li data-filter=".filter-app">BPRA-UKT</li>
      <li data-filter=".filter-product">program</li>
      <li data-filter=".filter-branding">program</li>
      <li data-filter=".filter-books">program</li>
    </ul> <!-- End program Filters -->

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-app">
        <div class="program-content h-100">
          <a href=""><img src="assets/img/RA-kegiatan.jpeg" class="img-fluid" alt=""></a>
        </div>
      </div><!-- End program Item -->

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-product">
        <div class="program-content h-100">
          <a href=""><img src="assets/img/RA-kegiatan.jpeg" class="img-fluid" alt=""></a>
        </div>
      </div><!-- End program Item -->

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-app">
        <div class="program-content h-100">
          <a href=""><img src="assets/img/RA-kegiatan.jpeg" class="img-fluid" alt=""></a>
        </div>
      </div><!-- End program Item -->

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-product">
        <div class="program-content h-100">
          <a href=""><img src="assets/img/RA-kegiatan.jpeg" class="img-fluid" alt=""></a>
        </div>
      </div><!-- End program Item -->

    </div><!-- End program Container -->

  </div>

</div>

</section><!-- /Porogram Section -->

<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">
  <div class="container">
    <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-xl-10">
        <div class="row d-flex flex-wrap">
          <div class="col-md-8 text-center p-2">
            <div class="video-container">
              <iframe id="youtube-video" src="https://www.youtube.com/embed/C1Asqu3uHxs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-md-4 text-center p-2">
            <div class="instagram-container">
              <iframe src="https://www.instagram.com/rumahamal.usk/embed" frameborder="0"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Call To Action Section -->

<!-- Clients Section -->
     <!-- Section Title -->
     
    <section id="clients" class="clients section">
    <div class="container section-title" data-aos="fade-up">
      <h2>MITRA RUMAH AMAL USK</h2>
    </div>
      <div class="container">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
        </div>

      </div>

    </section><!-- /Clients Section -->
  </main>

  @endsection