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

</main>

@endsection

<script>

</script>
