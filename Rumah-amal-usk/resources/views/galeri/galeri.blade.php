@extends('layouts.layout')

@section('title', 'Dokumentasi | Rumah Amal USK')

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
        <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
                <h1>DOKUMENTASI</h1>
            </div>
        </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li class="current">Dokumentasi</li>
          </ol>
      </div>
    </nav>
  </div>
</div>

  <!-- Section -->
  <section id="galeri" class="galeri section">
    <div class="container">
      <!-- Gallery -->
        <div class="row">
        @foreach ($images as $image)
            <div class="col-lg-3 col-md-4 mb-4 mb-lg-0">
                <div class="image-container">
                    <a href="{{ $image['href'] }}" class="gallery-link" aria-label="{{ $image['alt'] }}">
                        <img src="{{ $image['src'] }}" 
                            class="w-100 shadow-1-strong rounded mb-4 gallery-image" 
                            alt="{{ $image['alt'] }}"
                            loading="eager"
                            data-fullsize="{{ $image['href'] }}"> <!-- Tambahkan atribut data-fullsize -->
                    </a>
                    <div class="caption">{{ $image['caption'] }}</div>
                </div>
            </div>
        @endforeach
        </div>
        <!-- Gallery -->
    </div>
  </section> <!-- End Section -->


<!-- Pagination -->
<section id="gallery-pagination" class="gallery-pagination section">
    <div class="container">
        <div class="d-flex justify-content-center">
            <ul class="pagination-list">
                @if($pagination['current_page'] > 1)
                    <li class="page-item">
                        <a href="{{ url('dokumentasi?page=' . ($pagination['current_page'] - 1)) }}" class="page-link prev" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                @endif

                {{-- First page --}}
                @if($pagination['current_page'] > 3)
                    <li class="page-item">
                        <a href="{{ url('dokumentasi?page=1') }}" class="page-link" aria-label="halaman 1">1</a>
                    </li>
                    @if($pagination['current_page'] > 4)
                        <li class="page-item disabled dots">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                {{-- Middle pages --}}
                @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++)
                    <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                        <a href="{{ url('dokumentasi?page=' . $i) }}" class="page-link" aria-label="halaman 2">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Last page --}}
                @if($pagination['current_page'] < $pagination['total_pages'] - 2)
                    @if($pagination['current_page'] < $pagination['total_pages'] - 3)
                        <li class="page-item disabled dots">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a href="{{ url('dokumentasi?page=' . $pagination['total_pages']) }}" aria-label="next" class="page-link">{{ $pagination['total_pages'] }}</a>
                    </li>
                @endif

                @if($pagination['current_page'] < $pagination['total_pages'])
                    <li class="page-item">
                        <a href="{{ url('dokumentasi?page=' . ($pagination['current_page'] + 1)) }}" class="page-link next" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</section><!-- /Pagination -->

  <!-- Popup Modal -->
  <div id="popup-modal" class="popup-modal">
    <div class="popup-modal-content">
        <i class="bi bi-x-circle close inside"></i>
        <div class="modal-image-container">
            <img class="popup-modal-img" id="popup-image" alt="Modal Image">
            <div id="popup-caption"></div>
            <div id="loading-spinner" class="loading-spinner"></div>
        </div>
    </div>
    <div class="popup-nav">
        <i class="bi bi-chevron-left popup-prev" id="prev"></i>
        <i class="bi bi-chevron-right popup-next" id="next"></i>
    </div>
  </div>

</main>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const images = Array.from(document.querySelectorAll('.gallery-image'));
    const modal = document.getElementById('popup-modal');
    const modalImg = document.getElementById('popup-image');
    const captionText = document.getElementById('popup-caption');
    const closeBtn = document.querySelector('.close.inside');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const loadingSpinner = document.getElementById('loading-spinner');

    let currentImageIndex = null;

    images.forEach((img, index) => {
        img.addEventListener('click', (e) => {
            e.preventDefault(); 
            modal.style.display = 'block';
            currentImageIndex = index;
            updateModalImage();
        });

        img.addEventListener('mouseover', () => {
            const caption = img.nextElementSibling;
            if (caption) {
                caption.style.display = 'block';
            }
        });

        img.addEventListener('mouseout', () => {
            const caption = img.nextElementSibling;
            if (caption) {
                caption.style.display = 'none';
            }
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    prevBtn.addEventListener('click', () => {
        if (images.length === 0) return;
        currentImageIndex = (currentImageIndex === 0) ? images.length - 1 : currentImageIndex - 1;
        updateModalImage();
    });

    nextBtn.addEventListener('click', () => {
        if (images.length === 0) return;
        currentImageIndex = (currentImageIndex === images.length - 1) ? 0 : currentImageIndex + 1;
        updateModalImage();
    });
    function updateModalImage() {
        if (currentImageIndex === null || images.length === 0) return;

        loadingSpinner.style.display = 'block';
        const currentImage = images[currentImageIndex];
        
        // Gunakan data-fullsize sebagai fallback jika href tidak ada
        const newSrc = currentImage.dataset.fullsize || currentImage.parentElement.href;
        
        // Validasi URL
        if (!newSrc) {
            console.error('Image URL is undefined');
            loadingSpinner.style.display = 'none';
            return;
        }

        const tempImg = new Image();
        tempImg.src = newSrc;
        
        tempImg.onload = () => {
            modalImg.src = newSrc;
            modalImg.alt = currentImage.alt;
            captionText.textContent = currentImage.dataset.caption || '';
            loadingSpinner.style.display = 'none';
        };

        tempImg.onerror = () => {
            console.error('Failed to load image:', newSrc);
            loadingSpinner.style.display = 'none';
            captionText.textContent = 'Gambar tidak dapat dimuat';
        };
}
});
</script>
@endpush