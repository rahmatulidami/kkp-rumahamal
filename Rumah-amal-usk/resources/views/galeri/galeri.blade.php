@extends('layouts.layout')

@section('title', 'Dokumentasi | Rumah Amal USK')

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
</div>

  <!-- Section -->
  <section id="galeri" class="galeri section">
    <div class="container">
      <!-- Gallery -->
        <div class="row">
            @foreach ($images as $image)
                <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                    <div class="image-container">
                        <a href="{{ $image['href'] }}" class="gallery-link">
                            <img
                            src="{{ $image['src'] }}"
                            class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                            alt="{{ $image['alt'] }}"
                            data-caption="{{ $image['caption'] }}"
                            loading="lazy"
                            />
                        </a>
                        <div class="caption">{{ $image['caption'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Gallery -->
    </div>
  </section> <!-- End Section -->

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

        loadingSpinner.style.display = 'block'; // Show loading spinner
        const newSrc = images[currentImageIndex].parentElement.href;
        
        // Set up the image loader
        const tempImg = new Image();
        tempImg.src = newSrc;
        
        tempImg.onload = () => {
            modalImg.src = newSrc; // Set the new image source
            loadingSpinner.style.display = 'none'; // Hide loading spinner
        };

        tempImg.onerror = () => {
            // Handle error, possibly hide the spinner or show an error message
            loadingSpinner.style.display = 'none'; // Hide loading spinner
        };

        // Reset the src to trigger loading
        modalImg.src = '';
    }
});
</script>
