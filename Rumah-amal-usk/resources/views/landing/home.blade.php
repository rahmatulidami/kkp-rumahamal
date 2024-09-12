@extends('layouts.layout')

@section('title', 'Beranda | Rumah Amal USK')

@section('content')

<main class="main">

<!-- Hero Section -->
<section id="hero">
    <div class="hero-slider swiper init-swiper">
        <script type="application/json" class="swiper-config">
          {
              "loop": true,
              "speed": 600,
              "autoplay": false,
              "slidesPerView": 1,
              "spaceBetween": 0,
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
            @foreach($latestPosts as $post)
                <div class="swiper-slide">
                    <div class="image-container">
                        <a href="{{ route('berita.show', ['slug' => $post['slug']]) }}">
                            <img src="{{ $post['image_url'] }}" alt="{{ $post['title']['rendered'] ?? 'Post Image' }}" loading="lazy">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<!-- End Hero Section -->

<!-- icon zakat/infak Section -->  
<section id="icon-boxed" class="icon-boxes section">
  <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
      <div class="row gy-4">
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="/donasi-infak" class="stretched-link">Infak</a></h4>
            <p>Bersyukur atas rizki, berbagi kebahagian dengan sesama muslim.</p>
            <a class="btn-btn-primary" href="/donasi-infak" role="button">Infak</a>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="/donasi-zakat" class="stretched-link">Zakat</a></h4>
            <p>Menyempurnakan rukun islam, mensucikan harta dan mententramkan jiwa.</p>
            <a class="btn-btn-primary" href="/donasi-zakat" role="button">Zakat</a>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="icon-box">
            <h4 class="title"><a href="#program" class="stretched-link">Program</a></h4>
            <p>Rumah amal masjid jamik USK menyediakan beberapa program donasi.</p>
            <a class="btn-btn-primary" href="#program" role="button">Program</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End icon zakat/infak Section -->  

<!-- Campaign Section -->
<section id="campaign-unggulan" class="campaign-unggulan section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>CAMPAIGN UNGGULAN</h2>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

      @foreach ($campaigns as $campaign)
            <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-{{ $campaign['category'] }}">
              <div class="campaign-unggulan-content h-100">
                <a href="{{ route('campaign.show', ['slug' => $campaign['slug']]) }}" aria-label="Detail campaign"><img src="{{ $campaign['image'] }}" alt="" loading="lazy"></a>
                <div class="campaign-unggulan-info">
                <h3>
                    <a href="{{ route('campaign.show', ['slug' => $campaign['slug']]) }}" aria-label="Detail campaign">{{ $campaign['title']['rendered'] }}</a>
                </h3>
                  <div class="progress-container">
                    <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">{{ $campaign['acf']['lama_campaign'] ?? 'N/A' }} hari</div>
                      </div>
                    </div>

                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $campaign['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="--progress-percentage: {{ $campaign['percentage'] }}%;">
                      <div class="progress-bar" style="width: var(--progress-percentage);"></div>
                    </div>

                    <div class="progress-info">
                      <div class="progress-start">
                        <span>Terkumpul</span>
                        <div class="amount">Rp. {{ number_format($campaign['terkumpul'], 0, ',', '.') }}</div>
                      </div>

                      <div class="progress-end">
                        <span>Dana dibutuhkan</span>
                        <div class="jumlah">Rp. {{ number_format($campaign['dibutuhkan'], 0, ',', '.') }}</div>
                      </div>
                    </div>

                  </div>
                  <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
                </div>
              </div>
            </div><!-- End campaign-unggulan Item -->
          @endforeach


      </div>

      <div class="button-wrapper">
        <a class="button-selengkapnya" href="{{ route('campaign.index') }}" role="button">Selengkapnya</a>
      </div>

    </div>

  </div>

</section>
<!-- /campaign Section -->

<!-- About Section -->
<section id="about" class="about section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>PROFIL<br></h2>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">
    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
      <img src="assets/img/profil/usk.png" class="img-fluid rounded-4 mb-4" alt="" loading="lazy">
      <img src="assets/img/profil/mesjid-jamik.png" class="img-fluid rounded-4 mb-4" alt="" loading="lazy">
    </div>
    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
      <div class="content ps-0 ps-lg-5">
        <h3>RUMAH AMAL MASJID JAMIK USK</h2>
        <p>
        Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya. Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat, Mendayagunakan dana zakat, infaq shadaqah maupun wakaf melalui program-program yang terasa manfaatnya, Mengangkat martabat mustahik, dan membahagiakan muzakki dan donatur.
        </p>
        <a href="/profil">Selengkapnya</a>

        <div class="position-relative mt-4">
          <img src="assets/img/profil/rek-rumahamal.png" class="img-fluid rounded-4" alt="" loading="lazy">
        </div>
      </div>
    </div>
  </div>

</div>

</section>
<!-- /About Section -->

<!-- Pengumuman Section -->
<section id="pengumuman" class="pengumuman section">
    <div class="container section-title" data-aos="fade-up">
        <h2>PENGUMUMAN</h2>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach($latestPengumumanPosts as $post)
                <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article>
                        @if(isset($post['image_url']) && $post['image_url'])
                            <div class="post-img">
                                <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" loading="lazy">
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
                                @if(isset($post['date']))
                                    <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->format('M d, Y') }}</time>
                                @else
                                    <span>No Date</span>
                                @endif
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach

            <div class="button-wrapper">
                <a class="button-selengkapnya" href="/pengumuman" role="button">Pengumuman Lainnya</a>
            </div>
        </div>
    </div>
</section>

<!-- Recent Posts Section -->
<section id="recent-posts" class="recent-posts section">
    <div class="container section-title" data-aos="fade-up">
        <h2>BERITA TERKINI</h2>
    </div>
    <div class="container">
        <div class="row gy-4">
            @foreach($latestBeritaPosts as $post)
                <div class="col-lg-4">
                    <article>
                        @if(isset($post['image_url']) && $post['image_url'])
                            <div class="post-img">
                                <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" style="width: 100%; height: auto;" loading="lazy">
                            </div>
                        @endif
                        <p class="post-category">{{ implode(', ', $post['categories'] ?? []) }}</p>
                        <h2 class="title">
                            <a href="{{ route('berita.show', ['slug' => $post['slug']]) }}">{{ $post['title']['rendered'] }}</a>
                        </h2>
                        <div class="d-flex align-items-center">
                            <p class="post-date">
                                @if(isset($post['date']))
                                    <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->format('M d, Y') }}</time>
                                @else
                                    <span>No Date</span>
                                @endif
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="button-wrapper">
            <a class="button-selengkapnya" href="/berita" role="button">Berita Lainnya</a>
        </div>
    </div>
</section>

<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">
  <div class="container">
    <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
        <div class="row d-flex flex-wrap">
          <div class="col-md-8 text-center p-2">
            <div class="video-container">
              <iframe id="youtube-video" src="https://www.youtube.com/embed/C1Asqu3uHxs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen title="Youtube RA USK"></iframe>
            </div>
          </div>
          <div class="col-md-4 text-center p-2">
            <div class="instagram-container">
              <iframe src="https://www.instagram.com/rumahamal.usk/embed" frameborder="0" title="Instagram RA USK"></iframe>
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
                        "slidesPerView": 6,
                        "spaceBetween": 10 
                    },
                    "480": {
                        "slidesPerView": 6,
                        "spaceBetween": 20 
                    },
                    "640": {
                        "slidesPerView": 6,
                        "spaceBetween": 30
                    },
                    "992": {
                        "slidesPerView": 6,
                        "spaceBetween": 60
                    }
                }
            }
            </script>
            <div class="swiper-wrapper align-items-center">
				        <div class="swiper-slide"><img src="assets/img/clients/kosong.png" class="img-fluid" alt="" loading="lazy"></div>
                <div class="swiper-slide"><img src="assets/img/clients/kosong.png" class="img-fluid" alt="" loading="lazy"></div>
                <div class="swiper-slide"><img src="assets/img/clients/RAsalman.png" class="img-fluid" alt="" loading="lazy"></div>
                <div class="swiper-slide"><img src="assets/img/clients/hi.png" class="img-fluid" alt="" loading="lazy"></div>
				        <div class="swiper-slide"><img src="assets/img/clients/kosong.png" class="img-fluid" alt="" loading="lazy"></div>
                <div class="swiper-slide"><img src="assets/img/clients/kosong.png" class="img-fluid" alt="" loading="lazy"></div>
            </div>
        </div>
    </div>
</section>
<!-- /Clients Section -->
  </main>

  @endsection