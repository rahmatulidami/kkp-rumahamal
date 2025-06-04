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
  const cacheKey = 'programs_cache';
  const cacheExpiry = 15 * 60 * 1000; // 30 menit cache

  // Cek cache pertama
  const cachedData = localStorage.getItem(cacheKey);
  if (cachedData) {
    const { data, timestamp } = JSON.parse(cachedData);
    if (Date.now() - timestamp < cacheExpiry) {
      renderPrograms(data);
      return;
    }
  }

  // Jika tidak ada cache atau expired, fetch baru
  loadingText.style.display = "block";
  
  fetch("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/program")
    .then(response => response.json())
    .then(data => {
      // Simpan ke cache
      localStorage.setItem(cacheKey, JSON.stringify({
        data: data,
        timestamp: Date.now()
      }));
      renderPrograms(data);
    })
    .catch(error => {
      console.error('Error:', error);
      loadingText.textContent = "Gagal memuat program";
    });

  function renderPrograms(data) {
    loadingText.style.display = "none";
    programContainer.innerHTML = '';
    
    if (!data || data.length === 0) {
      noProgramMessage.style.display = "block";
      return;
    }

    const fragment = document.createDocumentFragment();
    
    data.forEach(post => {
      const filterClass = getFilterClass(post);
      const item = document.createElement('div');
      item.className = `col-lg-2-4 col-md-6 program-item isotope-item ${filterClass}`;
      item.innerHTML = `
       <div class="program-content h-100">
          <a href="/program/${post.slug || ''}">
            <img 
                data-src="${getImageUrl(post)}" 
                class="img-fluid lazy" 
                alt="${post.title.rendered || 'Untitled'}" 
                loading="eager"
                width="300"
                height="200">
          </a>
        </div>
      `;
      fragment.appendChild(item);
    });

    programContainer.appendChild(fragment);
    initIsotope();
    initLazyLoad();
  }

  function getFilterClass(post) {
    const categories = post.categories || [];
    if (categories.includes(61)) return 'filter-pendidikan';
    if (categories.includes(64)) return 'filter-pemberdayaan';
    if (categories.includes(65)) return 'filter-sosial';
    if (categories.includes(62)) return 'filter-syiar';
    if (categories.includes(63)) return 'filter-kemitraan';
    if (categories.includes(66)) return 'filter-fasilitator';
    return 'filter-none';
  }

  function getImageUrl(post) {
    try {
      const parser = new DOMParser();
      const doc = parser.parseFromString(post.content.rendered || "", "text/html");
      const img = doc.querySelector("img");
      return img ? img.src : "/assets/img/default.jpeg";
    } catch {
      return "/assets/img/default.jpeg";
    }
  }

  function initIsotope() {
    const iso = new Isotope(programContainer, {
      itemSelector: '.isotope-item',
      layoutMode: 'masonry',
      transitionDuration: 0
    });

    let filterTimeout;
    document.getElementById('filter-select').addEventListener('change', function() {
      clearTimeout(filterTimeout);
      filterTimeout = setTimeout(() => {
        iso.arrange({ filter: this.value });
        checkVisibleItems();
      }, 100);
    });
  }

  function initLazyLoad() {
    const lazyImages = [].slice.call(document.querySelectorAll('.lazy'));
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
          }
        });
      });

      lazyImages.forEach(img => imageObserver.observe(img));
    } else {
      // Fallback untuk browser lama
      lazyImages.forEach(img => {
        img.src = img.dataset.src;
      });
    }
  }

  function checkVisibleItems() {
    setTimeout(() => {
      const visibleItems = [].slice.call(document.querySelectorAll('.isotope-item'))
        .filter(item => item.offsetParent !== null);
      
      noProgramMessage.style.display = visibleItems.length === 0 ? "block" : "none";
    }, 300);
  }
});
</script>
@endpush
