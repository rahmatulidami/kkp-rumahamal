@extends('layouts.layout')

@section('title', 'Program | Rumah Amal USK')

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
          <div class="col-lg-8">
            <h1>PROGRAM RUMAH AMAL USK</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Beranda</a></li>
          <li class="current">Program</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- Section -->
  <section id="program" class="program section">
    <div class="container">
      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
        <div class="program-filters" data-aos="fade-up" data-aos-delay="100">
          <select id="filter-select" class="isotope-filters" aria-label="filter">
            <option value="*" class="filter-active">SEMUA</option>
            <option value=".filter-pendidikan">PENDIDIKAN</option>
            <option value=".filter-pemberdayaan">PEMBERDAYAAN</option>
            <option value=".filter-sosial">SOSIAL & KEMANUSIAAN</option>
            <option value=".filter-syiar">SYIAR & QURBAN</option>
            <option value=".filter-kemitraan">KEMITRAAN</option>
            <option value=".filter-fasilitator">FASILITATOR & RELAWAN</option>
          </select>
        </div>

        <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200" id="program-items">
            <p> Sedang Memuat Program ...</p>
        </div>
        <p id="no-program-message" class="text-center alert alert-warning" style="display: none;">Kategori program yang dicari tidak ditemukan.</p>
      </div>
    </div>
  </section>

</main>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
  const programContainer = document.getElementById("program-items");
  const loadingText = document.querySelector("#program-items p");
  const noProgramMessage = document.getElementById("no-program-message");

  // Fetch program data dari API
  fetch("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/program")
    .then(response => response.json())
    .then(data => {
      // Hapus teks loading sebelum menampilkan program
      loadingText.style.display = "none";
      programContainer.innerHTML = '';

      if (data.length === 0) {
        noProgramMessage.style.display = "block";
        return;
      } else {
        noProgramMessage.style.display = "none";
      }

      // Render program
      data.forEach(post => {
        let filterClass = '';
        const categories = post.categories;

        // Mapping kategori ke filter class
        if (categories.includes(61)) filterClass = 'filter-pendidikan';
        else if (categories.includes(64)) filterClass = 'filter-pemberdayaan';
        else if (categories.includes(65)) filterClass = 'filter-sosial';
        else if (categories.includes(62)) filterClass = 'filter-syiar';
        else if (categories.includes(63)) filterClass = 'filter-kemitraan';
        else if (categories.includes(66)) filterClass = 'filter-fasilitator';
        else filterClass = 'filter-none'; // Tambahkan ini jika kategori tidak cocok

        // Ambil gambar dari konten
        const parser = new DOMParser();
        const doc = parser.parseFromString(post.content.rendered, "text/html");
        const imgElement = doc.querySelector("img");
        const imageUrl = imgElement ? imgElement.src : "/assets/img/default.jpeg";

        // Buat URL ke halaman detail program
        const postSlug = post.slug || "";
        const postLink = `/program/${postSlug}`;
        const postTitle = post.title.rendered || "Untitled";

        // Buat HTML untuk setiap program
        const programItem = `
          <div class="col-lg-2-4 col-md-6 program-item isotope-item ${filterClass}">
            <div class="program-content h-100">
              <a href="${postLink}">
                <img src="${imageUrl}" class="img-fluid" alt="${postTitle}">
              </a>
            </div>
          </div>
        `;

        // Tambahkan program ke dalam container
        programContainer.innerHTML += programItem;
      });

      // Inisialisasi Isotope
      const iso = new Isotope(programContainer, {
        itemSelector: '.isotope-item',
        layoutMode: 'masonry'
      });

      // Event listener untuk filter
      document.getElementById('filter-select').addEventListener('change', function() {
        const filterValue = this.value;
        iso.arrange({ filter: filterValue });

        // Tunggu sebentar sebelum mengecek jumlah elemen yang terlihat
        setTimeout(() => {
          let visibleItems = Array.from(document.querySelectorAll('.isotope-item')).filter(item => {
            return item.getBoundingClientRect().height > 0;
          });

          console.log("Jumlah program yang terlihat:", visibleItems.length);

          if (visibleItems.length === 0) {
            noProgramMessage.style.display = "block";
          } else {
            noProgramMessage.style.display = "none";
          }
        }, 500);
      });
    })
    .catch(error => {
      console.error('Error fetching program data:', error);
      programContainer.innerHTML = "<p>Gagal memuat program.</p>";
      noProgramMessage.style.display = "block";
    });
});

</script>
@endpush
