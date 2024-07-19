@extends('layouts.layout')

@section('title', 'Detail-Campaign | Rumah Amal USK')

@section('content')

<main class="main">

<section id="campaign-detail" class="campaign-detail section">
    <div class="container">
        <div class="campaign-detail-info">
            <div class="left">
                <a href=""><img src="assets/img/campaign/palestine.png" alt=""></a>
            </div>
            <div class="right">
                <h4><a href="/detail-campaign" title="More Details">Peduli Palestine</a></h4>
                <div class="progress-container">
                    <div class="Durasi">
                        <div class="sisa-hari">
                            <span>Durasi</span>
                            <div class="days-left">3 hari lagi</div>
                        </div>
                    </div>

                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar w-75"></div>
                    </div>

                    <div class="progress-info">
                        <div class="progress-start">
                            <span>Terkumpul</span>
                            <div class="amount">Rp. 2.500.000</div>
                        </div>

                        <div class="progress-end">
                            <span>Dana dibutuhkan</span>
                            <div class="jumlah">Rp. 3.000.000</div>
                        </div>
                    </div>

                    <div class="share-buttons">
                        <div>
                            <p>Bagikan:</p>
                        </div>

                        <div class="icon-container">
                            <a href="#" id="share-instagram" title="Share on Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" id="share-whatsapp" title="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
                            <a href="#" id="share-facebook" title="Share on Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" id="copy-link" title="Copy Link"><i class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                    <p id="share-instructions" style="display: none;">URL copied!</p>
                </div>
                <a class="button-selengkapnya" href="/donate" role="button">DONASI</a>
            </div>
        </div>
    </div>
</section>

<div class="filter">
    <ul class="detail-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
        <li data-filter="detail" class="filter-active">Detail</li>
        <li data-filter="donatur">Donatur</li>
    </ul> 
</div>

<section class="detail" id="detail-section">
        <!-- Content for Detail section -->
    <div class="container">
        <h3>Peduli Palestina</h3>
            <p>Kira-kira mereka ngapain ya??
                <br>Jadi, berdasarkan Hadis Riwayat Bukhari dan Muslim dari Abu Hurairah, Rasulullah pernah bersabda bahwa: 
                <br>“Setiap awal pagi saat matahari terbit, Allah menurunkan dua malaikat ke bumi. Lalu salah satu berkata: “Ya Allah, berilah karunia kepada orang yang menginfakkan hartanya. Ganti kepada orang yang membelanjakan hartanya karena Allah. Malaikat yang satu berkata: “Ya Allah binasakanlah orang-orang yang bakhil/kikir”.
                <br>Ternyata itu sahabat. Para malaikat-Nya sengaja turun ke bumi untuk turut mendoakan hamba favoritnya Allah yang memulai aktivitas pagi dengan “bersedekah”. Dan turunnya ga tanggung-tanggung loh: “tiap awal pagi”.
                <br>Jadi, mari maksimalkan setiap pagi kita dengan salah satu amalan baik yakni “sedekah subuh”. Malaikat nungguin kita nih! Yuk sahabat, kita sambut kedatangan mereka dan karunia pagi dariNya setiap waktu subuh. Infak yang sahbaat berikan insya Allah akan dipergunakan untuk keperluan dakwah dan kegiatan sosial. </p>
    </div>
</section>

<section class="donatur" id="donatur-section" style="display: none;">
        <!-- Content for Donatur section -->
    <div class="container">
        <div class="para-donatur">
            <p>comingsoon</p>
        </div>
    </div>
</section>


</main>

@endsection

<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Current URL for sharing
    const currentUrl = window.location.href;
    
    // Share buttons and instructions
    const instagramShareButton = document.getElementById('share-instagram');
    const whatsappShareButton = document.getElementById('share-whatsapp');
    const facebookShareButton = document.getElementById('share-facebook');
    const copyLinkButton = document.getElementById('copy-link');
    const shareInstructions = document.getElementById('share-instructions');
    
    // Event listeners for share buttons
    instagramShareButton.addEventListener('click', function(e) {
        e.preventDefault();
        navigator.clipboard.writeText(currentUrl).then(function() {
            shareInstructions.style.display = 'block';
            setTimeout(function() {
                shareInstructions.style.display = 'none';
            }, 5000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    });

    whatsappShareButton.addEventListener('click', function(e) {
        e.preventDefault();
        const textToShare = encodeURIComponent('Check out this blog: ' + currentUrl);
        const whatsappUrl = `https://api.whatsapp.com/send?text=${textToShare}`;
        window.open(whatsappUrl, '_blank');
    });

    facebookShareButton.addEventListener('click', function(e) {
        e.preventDefault();
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
        window.open(facebookUrl, '_blank');
    });

    copyLinkButton.addEventListener('click', function(e) {
        e.preventDefault();
        navigator.clipboard.writeText(currentUrl).then(function() {
            shareInstructions.style.display = 'block';
            setTimeout(function() {
                shareInstructions.style.display = 'none';
            }, 5000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    });

    // Filter functionality
    const filters = document.querySelectorAll('.detail-filters li');
    const detailSection = document.getElementById('detail-section');
    const donaturSection = document.getElementById('donatur-section');

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filters.forEach(f => f.classList.remove('filter-active'));
            // Add active class to the clicked filter
            this.classList.add('filter-active');

            // Hide all sections
            detailSection.style.display = 'none';
            donaturSection.style.display = 'none';

            // Show the selected section
            const filterValue = this.getAttribute('data-filter');
            if (filterValue === 'detail') {
                detailSection.style.display = 'block';
            } else if (filterValue === 'donatur') {
                donaturSection.style.display = 'block';
            }
        });
    });
});

</script>
