<!DOCTYPE html>
<html lang="en">

<head>
  @yield('meta')

  <title>@yield('title')</title>

  <!-- Favicons -->
  <!-- <link href="{{ asset('assets/img/favicon.png') }}" rel="icon"> -->
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link href="{{ asset('assets/img/favicon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Tambahkan ini di dalam <head> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

</head>

<body class="index-page" style="user-select: none;">

<header id="header" class="header fixed-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center" aria-label="Kembali ke beranda">
                <img src="{{ asset('assets/img/logorumah.webp') }}" alt="">
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="/profil" class="{{ Request::is('profil') || Request::is('struktur') || Request::is('fokusprogram') || Request::is('visimisi') || Request::is('landasanutama') ? 'active' : '' }}">Profil</a></li>

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdownmenu {{ Request::is('program') || Request::is('campaign') ? 'active' : '' }}"><span>Program</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/program" id="dropdownitemm" class="{{ Request::is('program') ? 'active' : '' }}">Program</a></li>
                            <li><a href="/campaign" id="dropdownitemm" class="{{ Request::is('campaign') ? 'active' : '' }}">Kampanye</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdownmenu {{ Request::is('berita') || Request::is('pengumuman') || Request::is('dokumen') ? 'active' : '' }}"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/berita" id="dropdownitemm" class="{{ Request::is('berita') ? 'active' : '' }}">Berita</a></li>
                            <li><a href="/pengumuman" id="dropdownitemm" class="{{ Request::is('pengumuman') ? 'active' : '' }}">Pengumuman</a></li>
                            <li><a href="/dokumen" id="dropdownitemm" class="{{ Request::is('dokumen') ? 'active' : '' }}">Dokumen</a></li>
                        </ul>
                    </li>
                    <li><a href="/dokumentasi" class="{{ Request::is('galeri') ? 'active' : '' }}">Galeri</a></li>
                    <li class="language-switcher">
                        <a href="javascript:void(0)" class="language-link">
                            <img src="{{ asset('assets/img/flag-ID.png') }}" alt="Indonesian Flag" class="flag-icon">
                            <span>ID</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="?lang=en" class="language-link">
                                <img src="{{ asset('assets/img/flag-EN.jpg') }}" alt="English Flag" class="flag-icon">
                                <span>EN</span>
                            </a></li>
                        </ul>
                    </li>
                    <li class="login-button">
                        <button id="login-button" class="btn btn-primary">Login</button>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>
</header>

@yield('content')

<footer id="footer" class="footer accent-background">
    <div class="container footer-top">
        <div class="row gy-4 justify-content-between">
            
            <!-- About Section -->
            <div class="col-lg-4 col-md-6 footer-about text-center text-md-start">
                <a href="/" class="logo d-flex align-items-center justify-content-md-start justify-content-center" aria-label="logo rumah amal">
                    <img src="{{ asset('assets/img/logorumah.webp') }}" alt="Logo Rumah Amal" class="footer-logo">
                </a>
                <p class="footer-address">Lantai 1 Masjid Jamik USK <br> T. Nyak Arief, Kopelma Darussalam, Banda Aceh 21311</p>
                <div class="jadwal mt-3">
                    <h1><strong>Jam Operasional:</strong></h1>
                    <p><i class="bi bi-clock"></i> Senin - Jum'at: 08.00 - 17.00</p>
                    <p><i class="bi bi-clock"></i> Sabtu - Minggu: Tutup</p>
                </div>
                
            </div>
            
            <!-- Contact Section -->
            <div class="col-lg-4 col-md-6 footer-contact text-center text-md-start">
                <h1><strong>Hubungi Kami:</strong></h1>
                <p><strong>WA:</strong> <a href="https://wa.me/628116888123">0811 6888 123</a></p>
                <p><strong>Email:</strong> <a href="mailto:rumahamal@usk.ac.id">rumahamal@usk.ac.id</a></p>
                <p><strong>Tautan:</strong> <a href="https://usk.ac.id/">Universitas Syiah Kuala</a></p>
                <strong><a href="/faq">FAQ</a></strong>
                <div class="social-links d-flex justify-content-center justify-content-md-start mt-3">
                    <a href="https://www.facebook.com/rumahamalusk/" aria-label="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.tiktok.com/@rumahamal.usk" aria-label="tiktok"><i class="bi bi-tiktok"></i></a>
                    <a href="https://www.instagram.com/rumahamal.usk/" aria-label="instagram"><i class="bi bi-instagram"></i></a>
                </div>

                <div class="mt-3 text-center">
                    <a href="https://forms.gle/tVuo2prHcHjnZsWHA" class="keluhan-btn" target="_blank">
                        Ajukan Keluhan
                    </a>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="col-lg-4 col-md-12 footer-map text-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.062950078828!2d95.3687264!3d5.5709969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304037d79398cc65%3A0x164fb653d9c4a1f7!2sRumah%20Amal%20Masjid%20Jamik%20USK!5e0!3m2!1sen!2sid!4v1688584573276!5m2!1sen!2sid"
                    width="100%" height="250px" style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="GMAPS RA USK"></iframe>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright text-center mt-4">
        <p><span>Copyright &copy; 2025</span> <a href="/" class="sitename"><strong>Rumah Amal USK.</strong></a> <span>All Rights Reserved</span></p>
    </div>
</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  
  @stack('scripts')

</body>

</html>
