@extends('layouts.layout')

@section('title', 'Detail-Campaign | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Section -->
  <section id="campaign-detail" class="campaign-detail section">
    <div class="container">
        <div class="left">
            <img src="assets/img/campaign/palestine.png" alt="">
        </div>
        <div class="right">
            <div class="campaign-detail-info">
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
                        
                </div>
                <a class="button-selengkapnya" href="/donate" role="button">DONASI</a>
            </div>
        </div>
    </div>
  </section> <!-- End Section -->

  <div>
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
Jadi, berdasarkan Hadis Riwayat Bukhari dan Muslim dari Abu Hurairah, Rasulullah pernah bersabda bahwa: 

“Setiap awal pagi saat matahari terbit, Allah menurunkan dua malaikat ke bumi. Lalu salah satu berkata: “Ya Allah, berilah karunia kepada orang yang menginfakkan hartanya. Ganti kepada orang yang membelanjakan hartanya karena Allah. Malaikat yang satu berkata: “Ya Allah binasakanlah orang-orang yang bakhil/kikir”.

Ternyata itu sahabat. Para malaikat-Nya sengaja turun ke bumi untuk turut mendoakan hamba favoritnya Allah yang memulai aktivitas pagi dengan “bersedekah”. Dan turunnya ga tanggung-tanggung loh: “tiap awal pagi”.

Jadi, mari maksimalkan setiap pagi kita dengan salah satu amalan baik yakni “sedekah subuh”. Malaikat nungguin kita nih! Yuk sahabat, kita sambut kedatangan mereka dan karunia pagi dariNya setiap waktu subuh. Infak yang sahbaat berikan insya Allah akan dipergunakan untuk keperluan dakwah dan kegiatan sosial. </p>
        </div>
    </section>

    <section class="donatur" id="donatur-section" style="display: none;">
        <!-- Content for Donatur section -->
        <div class="container">
            <div>
                <p>comingsoon</p>
            </div>
        </div>
    </section>


</main>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
