<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title')</title>
  <meta content="Author: Rahmatul dan Ridho, website rumah amal usk" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/favicon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page" style="user-select: none;">

<header id="header" class="header fixed-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center" aria-label="Kembali ke beranda">
                <img src="{{ asset('assets/img/logorumah.png') }}" alt="">
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="active">Beranda</a></li>
                    <li><a href="/profil">Profil</a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdownmenu"><span>Program</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/program" class="dropdownitemm">Program</a></li>
                            <li><a href="/campaign" class="dropdownitemm">Campaign</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdownmenu"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="/berita" class="dropdownitemm">Berita</a></li>
                            <li><a href="/pengumuman" class="dropdownitemm">Pengumuman</a></li>
                            <li><a href="/dokumen" class="dropdownitemm">Dokumen</a></li>
                        </ul>
                    </li>
                    <li><a href="/galeri">Galeri</a></li>
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
        <div class="row gy-4">
            <div class="col-lg-4 col-md-12 footer-about">
                <a href="/" class="logo d-flex align-items-center" aria-label="logo rumah amal">
                    <div class="img">
                        <img src="{{ asset('assets/img/logorumah.png') }}" alt="">
                    </div>
                </a>
                <p>Lantai 1 Masjid Jamik USK <br> T. Nyak Arief, Kopelma Darussalam, Banda Aceh 21311</p>
                <p class="mt-4"><strong>Phone:</strong> 
                  <span>
                    <a href="https://wa.me/628116888123">0811 6888 123</a>
                  </span>
                </p>
                <p><strong>Email:</strong><span><a href="mailto:rumahamal@usk.ac.id"> rumahamal@usk.ac.id</a></span></p>
                <p><strong>Tautan:</strong><span><a href="https://usk.ac.id/"> Universitas Syiah Kuala</a></span></p>
                <div class="social-links d-flex mt-4">
                    <a href="https://www.facebook.com/rumahamalusk/" aria-label="facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                    <a href="https://www.tiktok.com/@rumahamal.usk" aria-label="tiktok"><i class="bi bi-tiktok" aria-hidden="true"></i></i></a>
                    <a href="https://www.instagram.com/rumahamal.usk/" aria-label="instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
              <div class="jadwal">
                <p><strong>Jam Operasional:</strong></p>
                <p class="mt-4"><i class="bi bi-clock"></i> <span>Mon - Fri: 8AM - 5PM</span></p>
                <p><i class="bi bi-clock"></i> <span>Sat - Sun: Closed</span></p>
              </div>  
            </div>

            <div class="col-lg-4 col-md-6 footer-links location-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.062950078828!2d95.3687264!3d5.5709969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304037d79398cc65%3A0x164fb653d9c4a1f7!2sRumah%20Amal%20Masjid%20Jamik%20USK!5e0!3m2!1sen!2sid!4v1688584573276!5m2!1sen!2sid"
                    width="100%"
                    height="100%"
                    style="border:0; border-radius: 15px;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="GMAPS RA USK"
                ></iframe>
            </div>
        </div>
    </div>

    <div class="copyright text-center mt-4">
        <p>© <span>Copyright</span> <a href="/" style="color: #45474B;"><strong class="px-1 sitename">Rumah Amal USK</strong></a><span>All Rights Reserved</span></p>
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

</body>

</html>
