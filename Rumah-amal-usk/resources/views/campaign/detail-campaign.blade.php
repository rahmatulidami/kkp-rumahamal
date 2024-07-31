@extends('layouts.layout')

@section('title', 'Detail-Campaign | Rumah Amal USK')

@section('content')

<main class="main">

<!-- Page Title -->
<div class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1>{{ $campaign['title']['rendered'] }}</h1>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="/">Home</a></li>
                <li><a href="/campaign">Campaign</a></li>
                <li class="current">{{ $campaign['title']['rendered'] }}</li>
            </ol>
        </div>
    </nav>
</div><!-- End Page Title -->

<!-- Campaign Detail Section -->
<section id="campaign-detail" class="campaign-detail section">
    <div class="container">
        <div class="campaign-detail-info">
            <div class="left">
                <a href="#"><img src="{{ $campaign['image'] }}" alt="{{ $campaign['title']['rendered'] }}"></a>
            </div>
            <div class="right">
                <h4><a href="#" title="More Details">{{ $campaign['title']['rendered'] }}</a></h4>
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

<!-- Detail Section -->
<section class="detail" id="detail-section">
    <div class="container">
        <h3 class="detail-title">Detail Campaign</h3>
        <p class="detail-description">
            {!! $campaign['content']['rendered'] !!}
        </p>
    </div>
</section>

<!-- Donatur Section -->
<section class="donatur" id="donatur-section" style="display: none;">
    <div class="container">
        <h3 class="donatur-title">Donatur</h3>
        <div class="donor-list">
            @if(isset($campaign['donors']) && is_array($campaign['donors']))
                @foreach($campaign['donors'] as $donor)
                    @if(is_array($donor))
                        <div class="para-donatur">
                            <div class="top-info">
                                <p class="donation-date"><strong>Tanggal Donasi: </strong>{{ $donor['date'] ?? 'N/A' }}</p>
                                <p class="donation-category"><strong>Kategori: </strong>{{ $donor['category'] ?? 'N/A' }}</p>
                            </div>
                            <div class="icon-and-details">
                                <i class="bi bi-person-square"></i>
                                <div class="details">
                                    <p class="donor-name">{{ $donor['name'] ?? 'Anonymous' }}</p>
                                    <p class="donation-amount"><strong>Rp. {{ number_format($donor['amount'] ?? 0, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Invalid donor data format.</p>
                    @endif
                @endforeach
            @else
                <p>No donors found for this campaign.</p>
            @endif
        </div>
    </div>
</section>


<!-- Related Campaigns Section -->
<section id="related-campaigns" class="related-campaigns section">
    <div class="container">
        <h3>Campaign Lainnya</h3>
        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            @foreach ($relatedCampaigns as $relatedCampaign)
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
        </div>
    </div>
</section>

</main>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;

    const instagramShareButton = document.getElementById('share-instagram');
    const whatsappShareButton = document.getElementById('share-whatsapp');
    const facebookShareButton = document.getElementById('share-facebook');
    const copyLinkButton = document.getElementById('copy-link');
    const shareInstructions = document.getElementById('share-instructions');

    instagramShareButton.addEventListener('click', function(event) {
        event.preventDefault();
        const url = `https://www.instagram.com/share?url=${encodeURIComponent(currentUrl)}`;
        window.open(url, '_blank');
    });

    whatsappShareButton.addEventListener('click', function(event) {
        event.preventDefault();
        const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(currentUrl)}`;
        window.open(url, '_blank');
    });

    facebookShareButton.addEventListener('click', function(event) {
        event.preventDefault();
        const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
        window.open(url, '_blank');
    });

    copyLinkButton.addEventListener('click', function(event) {
        event.preventDefault();
        navigator.clipboard.writeText(currentUrl).then(function() {
            shareInstructions.style.display = 'block';
            setTimeout(function() {
                shareInstructions.style.display = 'none';
            }, 2000);
        });
    });
});
</script>

