@extends('layouts.layout')

@section('title', 'Campaign | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-8">
            <h1>KAMPANYE</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Beranda</a></li>
          <li class="current">Kampanye</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- campaign Section -->
  <section id="campaign-unggulan" class="campaign-unggulan section">
    <div class="container">
      
      <div class="search-container" data-aos="fade-up" data-aos-delay="100">
        <input type="text" id="search-input" class="form-control" placeholder="Cari kampanye berdasarkan judul...">
      </div>
      
      <div class="row gy-4" id="campaign-container" data-aos="fade-up" data-aos-delay="200">

        @foreach ($processedCampaigns as $campaign)
          <div class="col-lg-4 col-md-6 campaign-unggulan-item" data-title="{{ strtolower($campaign['title']['rendered']) }}">
            <div class="campaign-unggulan-content h-100">
              <a href="{{ route('campaign.show', ['slug' => $campaign['slug']]) }}"><img src="{{ $campaign['image'] }}" alt=""></a>
              <div class="campaign-unggulan-info">
                <h3>
                  <a href="{{ route('campaign.show', ['slug' => $campaign['slug']]) }}">{{ $campaign['title']['rendered'] }}</a>
                </h3>
                <div class="progress-container">
                  <div class="Durasi">
                    <div class="sisa-hari">
                      <span>Durasi</span>
                      <div class="days-left">{{ $campaign['acf']['lama_campaign'] ?? 'N/A' }} hari</div>
                    </div>
                  </div>
                  <div class="progress" role="progressbar" aria-valuenow="{{ $campaign['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="--progress-percentage: {{ $campaign['percentage'] }}%;">
                    <div class="progress-bar" style="width: var(--progress-percentage);"></div>
                  </div>
                  <div class="progress-info">
                    <div class="progress-start">
                      <span>Terkumpul</span>
                      <div class="amount">Rp. {{ number_format($campaign['terkumpul'], 0, ',', '.') }}</div>
                    </div>
                    <div class="progress-end">
                      <span>Dana dibutuhkan</span>
                      <div class="jumlah">Rp. {{ number_format($campaign['dibutuhkan'], 0, ',', '.') }}</div>
                    </div>
                  </div>
                </div>
                <a class="btn-btn-primary" href="/donate" role="button">DONASI</a>
              </div>
            </div>
          </div><!-- End campaign-unggulan Item -->
        @endforeach

      </div><!-- End Campaign Container -->

    </div>
  </section>

  <script>
    document.getElementById('search-input').addEventListener('keyup', function() {
      let filter = this.value.toLowerCase();
      let items = document.querySelectorAll('.campaign-unggulan-item');

      items.forEach(item => {
        let title = item.getAttribute('data-title');
        if (title.includes(filter)) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  </script>

</main>

@endsection
