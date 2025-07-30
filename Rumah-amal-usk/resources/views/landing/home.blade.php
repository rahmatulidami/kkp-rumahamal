@extends('layouts.layout')

@section('title', 'Beranda | Rumah Amal USK')

@section('meta')
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya.">
    
    <!-- Preload hero images -->
    @isset($heroImages)
        @foreach($heroImages as $image)
            @if($image)
                <link rel="preload" href="{{ $image }}" as="image" fetchpriority="high">
            @endif
        @endforeach
    @endisset

    <!-- Inline critical CSS -->
    <style>
        /* Hero Section Styles */
        .hero-slider {
            position: relative;
            min-height: 518.79px;
            overflow: hidden;
        }
        .hero-slider .swiper-wrapper {
            transition-timing-function: cubic-bezier(0.17, 0.67, 0.83, 0.67);
        }
        .hero-slider .image-container {
            width: 100%;
            height: 100%;
        }
        .hero-slider .image-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .loading-placeholder {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            height: 518.79px;
            width: 100%;
        }
        @keyframes shimmer {
            to { background-position: -200% 0; }
        }
        
        /* Navigation buttons */
        .swiper-button-prev,
        .swiper-button-next {
            color: white;
            background: rgba(0,0,0,0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 20px;
        }
        
        /* Pagination */
        .swiper-pagination-bullet {
            background: white;
            opacity: 0.5;
            width: 10px;
            height: 10px;
        }
        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #fff;
        }
    </style>
@endsection

@section('content')

<main class="main">

<!-- Hero Section -->
<section id="hero">
    <div class="container-fluid">
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
                @isset($heroSlides)
                    @foreach($heroSlides as $slide)
                        <div class="swiper-slide">
                            <div class="image-container">
                                @if(!empty($slide['link']))
                                    <a href="{{ $slide['link'] }}" aria-label="{{ $slide['title'] }}">
                                @endif
                                
                                @if($slide['image_url'])
                                    <img src="{{ $slide['image_url'] }}" 
                                        alt="{{ $slide['title'] }}" 
                                        width="1297" 
                                        height="518.79"
                                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                        {{ $loop->first ? 'fetchpriority="high"' : '' }}
                                        style="aspect-ratio: 5/2">
                                @else
                                    <img src="{{ asset('assets/img/default-hero.jpg') }}" 
                                        alt="Default Hero Image"
                                        width="1297"
                                        height="518.79"
                                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                        {{ $loop->first ? 'fetchpriority="high"' : '' }}
                                        style="aspect-ratio: 5/2">
                                @endif
                                
                                @if(!empty($slide['link']))
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <div class="loading-placeholder"></div>
                    </div>
                @endisset
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- End Hero Section -->

<!-- Rest of your content remains exactly the same -->
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
            <h4 class="title"><a href="/program" class="stretched-link">Program</a></h4>
            <p>Rumah amal masjid jamik USK menyediakan beberapa program donasi.</p>
            <a class="btn-btn-primary" href="/program" role="button">Program</a>
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
    <h2>KAMPANYE UNGGULAN</h2>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

      @foreach ($campaigns as $campaign)
            <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-{{ $campaign['category'] }}">
              <div class="campaign-unggulan-content h-100">
                <a href="{{ route('campaign.show', ['slug' => $campaign['slug']]) }}" aria-label="Detail campaign"><img src="{{ $campaign['image'] }}" alt="" loading="lazy" width="416" height="234" style="aspect-ratio: 16/9"></a>
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
      <img src="assets/img/profil/mesjid.webp" class="img-fluid rounded-4 mb-4" alt="" loading="lazy" width="800" height="450" style="aspect-ratio: 16/9">
    </div>
    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
      <div class="content ps-0 ps-lg-5">
        <h3>RUMAH AMAL MASJID JAMIK USK</h2>
        <p>
        Kami menyediakan sistem dan layanan yang memudahkan para muzakki atau donatur dalam menunaikan zakat, infaq, shadaqah, maupun wakaf dengan sebaik-baiknya. Menjadikan masjid sebagai pusat pemberdayaan ekonomi umat, Mendayagunakan dana zakat, infaq shadaqah maupun wakaf melalui program-program yang terasa manfaatnya, Mengangkat martabat mustahik, dan membahagiakan muzakki dan donatur.
        </p>
        <a href="/profil">Selengkapnya</a>

        <div class="position-relative mt-4">
          <div class="rekening-container">
              <img src="assets/img/logobsi.webp" alt="BSI Logo" class="logo-bsi" width="100" height="100" style="aspect-ratio: 1/1">
              <div class="rekening-info">
                  <p><strong>Bank Syariah Indonesia (<span class="bsi-bold">BSI</span>)</strong></p>
                  <p><strong>No. Rekening: <span class="bsi-bold">7099400409</span></strong></p>
                  <p><strong>A.N.<span class="bsi-bold">Rumah Amal Masjid Jamik USK</span></strong></p>
              </div>
          </div>
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
                            <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" loading="lazy" width="416" height="234" style="aspect-ratio: 16/9">
                            </div>
                        @endif
                        <div class="category">
                        <p class="post-category">
                            {{ end($post['categories']) ?? 'Uncategorized' }}
                        </p>
                        </div>
                        <h2 class="title">
                            <a href="{{ route('pengumuman.show', ['slug' => $post['slug']]) }}">{{ $post['title']['rendered'] }}</a>
                        </h2>
                        <div class="d-flex align-items-center">
                            <p class="post-date">
                                @if(isset($post['date']))
                                    <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->translatedFormat('d F Y') }}</time>
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
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article>
                        @if(isset($post['image_url']) && $post['image_url'])
                            <div class="post-img">
                            <img src="{{ $post['image_url'] }}" alt="" class="img-fluid" loading="lazy" width="416" height="234" style="aspect-ratio: 16/9">
                            </div>
                        @endif
                        <div class="category">
                            <p class="post-category">{{ implode(', ', $post['categories'] ?? []) }}</p>
                        </div>
                        <h2 class="title">
                            <a href="{{ route('berita.show', ['slug' => $post['slug']]) }}">{{ $post['title']['rendered'] }}</a>
                        </h2>
                        <div class="d-flex align-items-center">
                            <p class="post-date">
                                @if(isset($post['date']))
                                    <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->translatedFormat('d F Y') }}</time>
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

<!-- News Letter Section -->
<section id="News-letter" class="News-letter section">
    <div class="container section-title" data-aos="fade-up">
        <h2>NEWS LETTER</h2>
    </div>
    <div class="container">
        <div class="row gy-4">
           @foreach($newsletterImages as $newsletter)
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article>
                        @if(isset($newsletter['image_url']) && $newsletter['image_url'])
                            <div class="post-img">
                            <img src="{{$newsletter['image_url'] }}" alt="" class="img-fluid" loading="lazy" width="234" height="416" style="aspect-ratio: 9/16">
                            </div>
                        @endif
                    
                        <!-- <h2 class="title">
                            <a href="{{ $newsletter['link'] }}">{{ $newsletter['title'] }}</a>
                        </h2> -->
                        
                    </article>
                </div>
            @endforeach
        </div>
        <!-- <div class="button-wrapper">
            <a class="button-selengkapnya" href="/berita" role="button">News Letter Lainnya</a>
        </div> -->
    </div>
</section>


<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">
  <div class="container">
    <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
        <div class="row d-flex flex-wrap">
          <div class="col-md-8 text-center p-2">
          <div class="video-container">
              <iframe id="youtube-video" src="https://www.youtube.com/embed/jPpcdsT2kF4" frameborder="0"  allowfullscreen title="Youtube RA USK" loading="lazy"></iframe>
          </div>
          </div>
          <div class="col-md-4 text-center p-2">
            <div class="instagram-container">
            <iframe src="https://www.instagram.com/rumahamal.usk/embed" frameborder="0" title="Instagram RA USK" loading="lazy"></iframe>
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
                "watchOverflow": true,
                "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                },
                "breakpoints": {
                    "320": {
                        "slidesPerView": 5,
                        "spaceBetween": 20 
                    },
                    "480": {
                        "slidesPerView": 5,
                        "spaceBetween": 20 
                    },
                    "640": {
                        "slidesPerView": 5,
                        "spaceBetween": 30
                    },
                    "992": {
                        "slidesPerView": 5,
                        "spaceBetween": 60
                    }
                }
            }
            </script>
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><img src="assets/img/clients/RAsalman.png" class="img-fluid" alt="" loading="lazy" width="166" height="57.98" style="aspect-ratio: 2.86/1"></div>
                <div class="swiper-slide"><img src="assets/img/clients/hi.png" class="img-fluid" alt="" loading="lazy" width="166" height="57.98" style="aspect-ratio: 2.86/1"></div>
                <div class="swiper-slide"><img src="assets/img/clients/Bank_Syariah_Indonesia.svg" class="img-fluid" alt="" loading="lazy" width="166" height="57.98" style="aspect-ratio: 2.86/1"></div>
				<div class="swiper-slide"><img src="assets/img/clients/Maybank_logo-6.svg" class="img-fluid" alt="" loading="lazy" width="166" height="57.98" style="aspect-ratio: 2.86/1"></div>
                <div class="swiper-slide"><img src="assets/img/clients/logosdq_whiteq.svg" class="img-fluid" alt="" loading="lazy"width="166" height="57.98" style="aspect-ratio: 2.86/1"></div>
                
            </div>
        </div>
    </div>
</section>
<!-- /Clients Section -->
</main>

@endsection

@push('scripts')
<script>
// Global variable to track Swiper loading state
window.swiperLoaded = false;

// Function to load Swiper
function loadSwiper() {
    return new Promise((resolve) => {
        if (typeof Swiper !== 'undefined') {
            window.swiperLoaded = true;
            return resolve();
        }
        
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/swiper@11.0.5/swiper-bundle.min.js';
        script.onload = function() {
            window.swiperLoaded = true;
            resolve();
        };
        script.async = true;
        document.head.appendChild(script);
    });
}

// Function to initialize hero carousel with safety check
function initHeroCarousel() {
    if (!window.swiperLoaded || typeof Swiper === 'undefined') {
        console.warn('Swiper not loaded yet - retrying...');
        setTimeout(initHeroCarousel, 100);
        return;
    }
    
    const heroSlider = document.querySelector('.hero-slider');
    if (!heroSlider) return;
    
    const configScript = heroSlider.querySelector('.swiper-config');
    if (!configScript) return;
    
    try {
        const options = JSON.parse(configScript.textContent);
        new Swiper(heroSlider, options);
    } catch (e) {
        console.error('Error initializing hero carousel:', e);
    }
}

// Function to initialize clients slider with safety check
function initClientsSlider() {
    if (!window.swiperLoaded || typeof Swiper === 'undefined') {
        console.warn('Swiper not loaded yet for clients slider - retrying...');
        setTimeout(initClientsSlider, 100);
        return;
    }
    
    const clientsSlider = document.querySelector('#clients .swiper');
    if (!clientsSlider) return;

    const configScript = clientsSlider.querySelector('.swiper-config');
    if (!configScript) return;

    try {
        const options = JSON.parse(configScript.textContent);
        new Swiper(clientsSlider, options);
    } catch (e) {
        console.error('Error initializing clients slider:', e);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Load Swiper first
    loadSwiper().then(() => {
        // Initialize hero carousel when visible
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    initHeroCarousel();
                    heroObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        const heroSection = document.getElementById('hero');
        if (heroSection) heroObserver.observe(heroSection);
        
        // Initialize clients slider with lower priority
        if ('requestIdleCallback' in window) {
            window.requestIdleCallback(initClientsSlider);
        } else {
            // Fallback with slight delay
            setTimeout(initClientsSlider, 500);
        }
    }).catch(err => {
        console.error('Failed to load Swiper:', err);
    });
});
</script>
@endpush