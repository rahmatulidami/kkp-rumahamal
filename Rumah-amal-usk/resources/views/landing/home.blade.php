@extends('layouts.layout')

@section('title', 'Beranda')

@section('content')
  <main class="main">

    <!-- Hero Section -->
<section id="hero" class="hero section accent-background">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/about.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h2><span>Welcome to </span><span class="accent">Rumah Amal USK</span></h2>
                        <p>Sed autem laudantium dolores. Voluptatem itaque ea consequatur eveniet. Eum quas beatae cumque eum quaerat.</p>
                        <a href="#about" class="btn-get-started">Selengkapnya</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/about-2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h2><span>Welcome to </span><span class="accent">Rumah Amal USK</span></h2>
                        <p>Sed autem laudantium dolores. Voluptatem itaque ea consequatur eveniet. Eum quas beatae cumque eum quaerat.</p>
                        <a href="#about" class="btn-get-started">Selengkapnya</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/about.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h2><span>Welcome to </span><span class="accent">Rumah Amal USK</span></h2>
                        <p>Sed autem laudantium dolores. Voluptatem itaque ea consequatur eveniet. Eum quas beatae cumque eum quaerat.</p>
                        <a href="#about" class="btn-get-started">Selengkapnya</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

      <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
          <div class="container position-relative">
              <div class="row gy-4 mt-5">

                  <div class="col-xl-4 col-md-6">
                      <div class="icon-box">
                          <h4 class="title"><a href="" class="stretched-link">Infak</a></h4>
                          <p>Bersyukur atas rizki, berbagi kebahagian dengan sesama muslim.</p>
                          <a class="btn-btn-primary" href="#" role="button">Infak</a>
                      </div>
                  </div><!--End Icon Box -->

                  <div class="col-xl-4 col-md-6">
                      <div class="icon-box">
                          <h4 class="title"><a href="" class="stretched-link">Zakat</a></h4>
                          <p>Menyempurnakan rukun islam, mensucikan harta dan mententramkan jiwa.</p>
                          <a class="btn-btn-primary" href="#" role="button">Zakat</a>
                      </div>
                  </div><!--End Icon Box -->

                  <div class="col-xl-4 col-md-6">
                      <div class="icon-box">
                          <h4 class="title"><a href="" class="stretched-link">Program</a></h4>
                          <p>Rumah amal masjid jamik Universitas Syiah Kuala menyediakan bebarapa program donasi </p>
                          <a class="btn-btn-primary" href="#" role="button">Program</a>
                      </div>
                  </div><!--End Icon Box -->

              </div>
          </div>
      </div>

    </div>

</section><!-- /Hero Section -->

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
          <a href="assets/img/portfolio/product-1.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">Product 1</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

      <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-branding">
        <div class="campaign-unggulan-content h-100">
          <a href="assets/img/portfolio/branding-1.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/branding-1.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">Branding 1</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

      <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-books">
        <div class="campaign-unggulan-content h-100">
          <a href="assets/img/portfolio/books-1.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/books-1.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">Books 1</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

      <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-app">
        <div class="campaign-unggulan-content h-100">
          <a href="assets/img/portfolio/app-2.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/app-2.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">App 2</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

      <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-product">
        <div class="campaign-unggulan-content h-100">
          <a href="assets/img/portfolio/product-2.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/product-2.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">Product 2</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

      <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-branding">
        <div class="campaign-unggulan-content h-100">
          <a href="assets/img/portfolio/branding-2.jpg" data-gallery="campaign-unggulan-gallery-app" class="glightbox"><img src="assets/img/portfolio/branding-2.jpg" class="img-fluid" alt=""></a>
          <div class="campaign-unggulan-info">
            <h4><a href="campaign-unggulan-details.html" title="More Details">Branding 2</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
            <a class="btn-btn-primary" href="#" role="button">DONASI</a>
          </div>
        </div>
      </div><!-- End campaign-unggulan Item -->

    </div><!-- End Portfolio Container -->

  </div>

</div>

</section><!-- /Portfolio Section -->



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
              <a href="">Selengkapnya</a>

              <div class="position-relative mt-4">
                <img src="assets/img/profil/rek-rumahamal.png" class="img-fluid rounded-4" alt="">
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

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
          <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
        </div>

        <p class="post-category">Politics</p>

        <h2 class="title">
          <a href="/detail-berita">Dolorum optio tempore voluptas dignissimos</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Maria Doe</p>
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
          <img src="assets/img/blog/blog-2.jpg" alt="" class="img-fluid">
        </div>

        <p class="post-category">Sports</p>

        <h2 class="title">
          <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author-2.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Allisa Mayer</p>
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
          <img src="assets/img/blog/blog-3.jpg" alt="" class="img-fluid">
        </div>

        <p class="post-category">Entertainment</p>

        <h2 class="title">
          <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et soluta</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author-3.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Mark Dower</p>
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

<!-- Portfolio Section -->
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
      <li data-filter=".filter-app">App</li>
      <li data-filter=".filter-product">Product</li>
      <li data-filter=".filter-branding">Branding</li>
      <li data-filter=".filter-books">Books</li>
    </ul> <!-- End program Filters -->

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-app">
        <div class="program-content h-100">
          <a href="assets/img/portfolio/app-1.jpg" data-gallery="program-gallery-app" class="glightbox"><img src="assets/img/portfolio/app-1.jpg" class="img-fluid" alt=""></a>
          <div class="program-info">
            <h4><a href="program-details.html" title="More Details">App 1</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
          </div>
        </div>
      </div><!-- End program Item -->

      <div class="col-lg-4 col-md-6 program-item isotope-item filter-product">
        <div class="program-content h-100">
          <a href="assets/img/portfolio/product-1.jpg" data-gallery="program-gallery-app" class="glightbox"><img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt=""></a>
          <div class="program-info">
            <h4><a href="program-details.html" title="More Details">Product 1</a></h4>
            <p>Lorem ipsum, dolor sit amet consectetur</p>
          </div>
        </div>
      </div><!-- End program Item -->

    </div><!-- End Portfolio Container -->

  </div>

</div>

</section><!-- /Portfolio Section -->

<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">

<div class="container">
  <img src="assets/img/cta-bg.jpg" alt="">
  <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
    <div class="col-xl-10">
      <div class="text-center">
        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
        <h3>Call To Action</h3>
        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a class="cta-btn" href="#">Call To Action</a>
      </div>
    </div>
  </div>
</div>

</section><!-- /Call To Action Section -->

<!-- Clients Section -->
     <!-- Section Title -->
     <div class="container section-title" data-aos="fade-up">
        <h2>MITRA RUMAH AMAL USK</h2>
    <section id="clients" class="clients section">

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