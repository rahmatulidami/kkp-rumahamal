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
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Boat on Calm Water"
                    data-caption="Boat on Calm Water"
                    data-date="Uploaded on: 2023-07-25"
                    />
                    <div class="caption">Boat on Calm Water</div>
                </div>

                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Wintry Mountain Landscape"
                    data-caption="Wintry Mountain Landscape"
                    data-date="Uploaded on: 2023-07-26"
                    />
                    <div class="caption">Wintry Mountain Landscape</div>
                </div>
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Mountains in the Clouds"
                    data-caption="Mountains in the Clouds"
                    data-date="Uploaded on: 2023-07-27"
                    />
                    <div class="caption">Mountains in the Clouds</div>
                </div>

                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Boat on Calm Water"
                    data-caption="Boat on Calm Water"
                    data-date="Uploaded on: 2023-07-28"
                    />
                    <div class="caption">Boat on Calm Water</div>
                </div>
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Waves at Sea"
                    data-caption="Waves at Sea"
                    data-date="Uploaded on: 2023-07-29"
                    />
                    <div class="caption">Waves at Sea</div>
                </div>

                <div class="image-container">
                    <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                    class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                    alt="Yosemite National Park"
                    data-caption="Yosemite National Park"
                    data-date="Uploaded on: 2023-07-30"
                    />
                    <div class="caption">Yosemite National Park</div>
                </div>
            </div>
        </div>
        <!-- Gallery -->
    </div>
  </section> <!-- End Section -->

  <!-- Popup Modal -->
  <div id="popup-modal" class="popup-modal">
    <div class="popup-modal-content">
        <i class="bi bi-x-circle close inside"></i>
        <img class="popup-modal-img" id="popup-image">
        <div id="popup-caption"></div>
        <div id="popup-date"></div>
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
    const images = document.querySelectorAll('.gallery-image');
    const modal = document.getElementById('popup-modal');
    const modalImg = document.getElementById('popup-image');
    const captionText = document.getElementById('popup-caption');
    const dateText = document.getElementById('popup-date');
    const closeBtn = document.querySelector('.close.inside');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    let currentImageIndex;

    images.forEach((img, index) => {
        img.addEventListener('click', () => {
            modal.style.display = 'block';
            modalImg.src = img.src;
            captionText.innerHTML = img.getAttribute('data-caption');
            dateText.innerHTML = img.getAttribute('data-date');
            currentImageIndex = index;
        });

        img.addEventListener('mouseover', () => {
            const caption = img.nextElementSibling;
            caption.style.display = 'block';
        });

        img.addEventListener('mouseout', () => {
            const caption = img.nextElementSibling;
            caption.style.display = 'none';
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    prevBtn.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex === 0) ? images.length - 1 : currentImageIndex - 1;
        updateModalImage();
    });

    nextBtn.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex === images.length - 1) ? 0 : currentImageIndex + 1;
        updateModalImage();
    });

    function updateModalImage() {
        modalImg.src = images[currentImageIndex].src;
        captionText.innerHTML = images[currentImageIndex].getAttribute('data-caption');
        dateText.innerHTML = images[currentImageIndex].getAttribute('data-date');
    }
});
</script>

<style>
.image-container {
    position: relative;
    display: inline-block;
}

.caption {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 5px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    text-align: center;
    display: none;
}

.gallery-image {
    width: 100%;
    height: auto;
}

.popup-modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.popup-modal-content {
    position: relative;
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    background-color: white;
    padding: 40px;
}

.popup-modal-img {
    width: 100%;
}

#popup-caption,
#popup-date {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #333;
    padding: 10px 0;
}

#popup-date {
    color: #777;
    font-size: 14px;
}

.close.inside {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #333;
    font-size: 24px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

.popup-nav {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.popup-prev,
.popup-next {
    font-size: 40px;
    color: #f1f1f1;
    cursor: pointer;
    user-select: none;
    transition: 0.3s;
}

.popup-prev:hover,
.popup-next:hover {
    color: #bbb;
}
</style>
