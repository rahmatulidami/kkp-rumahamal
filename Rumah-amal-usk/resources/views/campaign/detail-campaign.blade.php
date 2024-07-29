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
    <hr class="filter-divider">
</div>


<section class="detail" id="detail-section">
    <div class="container">
        <h3 class="detail-title">Peduli Palestina</h3>
        <p class="detail-description">
            Kira-kira mereka ngapain ya??
            <br><br>
            Jadi, berdasarkan Hadis Riwayat Bukhari dan Muslim dari Abu Hurairah, Rasulullah pernah bersabda bahwa:
            <br><br>
            “Setiap awal pagi saat matahari terbit, Allah menurunkan dua malaikat ke bumi. Lalu salah satu berkata: “Ya Allah, berilah karunia kepada orang yang menginfakkan hartanya. Ganti kepada orang yang membelanjakan hartanya karena Allah. Malaikat yang satu berkata: “Ya Allah binasakanlah orang-orang yang bakhil/kikir”.
            <br><br>
            Ternyata itu sahabat. Para malaikat-Nya sengaja turun ke bumi untuk turut mendoakan hamba favoritnya Allah yang memulai aktivitas pagi dengan “bersedekah”. Dan turunnya ga tanggung-tanggung loh: “tiap awal pagi”.
            <br><br>
            Jadi, mari maksimalkan setiap pagi kita dengan salah satu amalan baik yakni “sedekah subuh”. Malaikat nungguin kita nih! Yuk sahabat, kita sambut kedatangan mereka dan karunia pagi dariNya setiap waktu subuh. Infak yang sahabat berikan insya Allah akan dipergunakan untuk keperluan dakwah dan kegiatan sosial.
        </p>
    </div>
</section>

<section class="donatur" id="donatur-section" style="display: none;">
    <div class="container">
        <div class="para-donatur">
            <div class="top-info">
                <p class="donation-date"><strong>Tanggal Donasi: </strong>25 Juli 2024</p>
                <p class="donation-category"><strong>Kategori: </strong>Kemanusiaan</p>
            </div>
            <div class="icon-and-details">
                <i class="bi bi-person-square"></i>
                <div class="details">
                    <p class="donor-name">John Doe</p>
                    <p class="donation-amount"><strong>Rp. 1.000.000</strong></p>
                </div>
            </div>
        </div>

        <div class="para-donatur">
            <div class="top-info">
                <p class="donation-date"><strong>Tanggal Donasi: </strong>25 Juli 2024</p>
                <p class="donation-category"><strong>Kategori: </strong>Kemanusiaan</p>
            </div>
            <div class="icon-and-details">
                <i class="bi bi-person-square"></i>
                <div class="details">
                    <p class="donor-name">John Doe</p>
                    <p class="donation-amount"><strong>Rp. 1.000.000</strong></p>
                </div>
            </div>
        </div>

        <div class="para-donatur">
            <div class="top-info">
                <p class="donation-date"><strong>Tanggal Donasi: </strong>25 Juli 2024</p>
                <p class="donation-category"><strong>Kategori: </strong>Kemanusiaan</p>
            </div>
            <div class="icon-and-details">
                <i class="bi bi-person-square"></i>
                <div class="details">
                    <p class="donor-name">John Doe</p>
                    <p class="donation-amount"><strong>Rp. 1.000.000</strong></p>
                </div>
            </div>
        </div>
        <!-- Add more donors as needed -->
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
        const textToShare = encodeURIComponent('Check out this campaign: ' + currentUrl);
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

    // Filter functionality with localStorage to persist state
    const filters = document.querySelectorAll('.detail-filters li');
    const detailSection = document.getElementById('detail-section');
    const donaturSection = document.getElementById('donatur-section');
    const activeFilter = localStorage.getItem('activeFilter') || 'detail';

    function showSection(filter) {
        filters.forEach(f => f.classList.remove('filter-active'));
        document.querySelector(`[data-filter="${filter}"]`).classList.add('filter-active');
        detailSection.style.display = filter === 'detail' ? 'block' : 'none';
        donaturSection.style.display = filter === 'donatur' ? 'block' : 'none';
    }

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            showSection(filterValue);
            localStorage.setItem('activeFilter', filterValue);
        });
    });

    // Show the saved or default section on page load
    showSection(activeFilter);
});
</script>
