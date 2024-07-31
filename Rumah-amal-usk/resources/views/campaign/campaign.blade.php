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
            <h1>CAMPAIGN</h1>
          </div>
        </div>
      </div>
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="current">Campaign</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <!-- campaign Section -->
  <section id="campaign-unggulan" class="campaign-unggulan section">
    <div class="container">

      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <div class="program-filters" data-aos="fade-up" data-aos-delay="100">
          <select id="filter-select" class="isotope-filters">
            <option value="*" class="filter-active">ALL</option>
            <option value=".filter-pendidikan">PENDIDIKAN</option>
            <option value=".filter-pemberdayaan">PEMBERDAYAAN</option>
            <option value=".filter-sosial">SOSIAL & KEMANUSIAAN</option>
            <option value=".filter-syiar">SYIAR & QURBAN</option>
            <option value=".filter-kemitraan">KEMITRAAN</option>
            <option value=".filter-fasilitator">FASILITATOR & RELAWAN</option>
          </select>
        </div>

        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

          @foreach ($processedCampaigns as $campaign)
            <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item filter-{{ $campaign['category'] }}">
              <div class="campaign-unggulan-content h-100">
                <a href="{{ $campaign['link'] }}"><img src="{{ $campaign['image'] }}" alt=""></a>
                <div class="campaign-unggulan-info">
                  <h4><a href="{{ $campaign['link'] }}" title="More Details">{{ $campaign['title']['rendered'] }}</a></h4>
                  <div class="progress-container">
                    <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">{{ $campaign['acf']['lama_campaign'] ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $campaign['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="--progress-percentage: {{ $campaign['percentage'] }}%;">
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

        </div><!-- End Portfolio Container -->

      </div>

    </div>

  </section>

</main>

@endsection
