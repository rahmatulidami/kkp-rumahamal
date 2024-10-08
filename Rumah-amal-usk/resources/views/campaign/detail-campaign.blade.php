@extends('layouts.layout')

@section('title', 'Detail-Campaign | Rumah Amal USK')

@section('content')

<main class="main">

<!-- Page Title -->
<div class="page-title">
    <div class="heading">
        <div class="container">
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
                            <div class="days-left">{{ $campaign['acf']['lama_campaign'] ?? 'N/A' }} hari</div>
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
        <li data-filter="detail" class="filter-active"><a href="?section=detail">Detail</a></li>
        <li data-filter="donatur"><a href="?section=donatur">Donatur</a></li>
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
<section class="donatur" id="donatur-section" style="display: block;">
    <div class="container">
        <div class="donor-list">
            @if($donors->count() > 0)
                @foreach($donors as $donor)
                    <div class="para-donatur">
                        <div class="top-info">
                            <p class="donation-date"><strong>Tanggal Donasi: </strong>{{ $donor->created_at->format('d-m-Y') }}</p>
                            <p class="donation-category"><strong>Kategori: </strong>{{ $donor->category ?? 'N/A' }}</p>
                        </div>
                        <div class="icon-and-details">
                            <i class="bi bi-person-square"></i>
                            <div class="details">
                                <p class="donor-name">{{ $donor->name ?? 'Anonymous' }}</p>
                                <p class="donation-amount"><strong>Rp. {{ number_format($donor->amount ?? 0, 0, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No donors found.</p>
            @endif
        </div>
    </div>
</section>


<!-- Other Campaigns Section -->
<section id="other-campaigns" class="other-campaigns section">
    <div class="container">
        <h3>Campaign Lainnya</h3>
        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            @foreach ($otherCampaigns as $otherCampaign)
            <div class="col-lg-4 col-md-6 campaign-unggulan-item isotope-item">
              <div class="campaign-unggulan-content h-100">
                <a href="{{ route('campaign.show', ['slug' => $otherCampaign['slug']]) }}" aria-label="Detail campaign"><img src="{{ $otherCampaign['image'] }}" alt=""></a>
                <div class="campaign-unggulan-info">
                  <h4><a href="{{ route('campaign.show', ['slug' => $otherCampaign['slug']]) }}" aria-label="Detail campaign">{{ $otherCampaign['title']['rendered'] }}</a></h4>
                  <div class="progress-container">
                    <div class="Durasi">
                      <div class="sisa-hari">
                        <span>Durasi</span>
                        <div class="days-left">{{ $otherCampaign['acf']['lama_campaign'] ?? 'N/A' }} hari</div>
                      </div>
                    </div>

                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $otherCampaign['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="--progress-percentage: {{ $otherCampaign['percentage'] }}%;">
                      <div class="progress-bar" style="width: var(--progress-percentage);"></div>
                    </div>

                    <div class="progress-info">
                      <div class="progress-start">
                        <span>Terkumpul</span>
                        <div class="amount">Rp. {{ number_format($otherCampaign['terkumpul'], 0, ',', '.') }}</div>
                      </div>

                      <div class="progress-end">
                        <span>Dana dibutuhkan</span>
                        <div class="jumlah">Rp. {{ number_format($otherCampaign['dibutuhkan'], 0, ',', '.') }}</div>
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
    const urlParams = new URLSearchParams(window.location.search);
    const sectionParam = urlParams.get('section');

    const instagramShareButton = document.getElementById('share-instagram');
    const whatsappShareButton = document.getElementById('share-whatsapp');
    const facebookShareButton = document.getElementById('share-facebook');
    const copyLinkButton = document.getElementById('copy-link');
    const shareInstructions = document.getElementById('share-instructions');
    const detailSection = document.getElementById('detail-section');
    const donaturSection = document.getElementById('donatur-section');
    const detailFilterButton = document.querySelector('li[data-filter="detail"]');
    const donaturFilterButton = document.querySelector('li[data-filter="donatur"]');

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

    // Determine the initial state based on the URL parameter
    if (sectionParam === 'donatur') {
        detailSection.style.display = 'none';
        donaturSection.style.display = 'block';
        donaturFilterButton.classList.add('filter-active');
        donaturFilterButton.classList.remove('filter-inactive');
        detailFilterButton.classList.add('filter-inactive');
        detailFilterButton.classList.remove('filter-active');
    } else {
        detailSection.style.display = 'block';
        donaturSection.style.display = 'none';
        detailFilterButton.classList.add('filter-active');
        detailFilterButton.classList.remove('filter-inactive');
        donaturFilterButton.classList.add('filter-inactive');
        donaturFilterButton.classList.remove('filter-active');
    }

    // Filter functionality
    detailFilterButton.addEventListener('click', function(event) {
        event.preventDefault();
        detailSection.style.display = 'block';
        donaturSection.style.display = 'none';
        detailFilterButton.classList.add('filter-active');
        detailFilterButton.classList.remove('filter-inactive');
        donaturFilterButton.classList.add('filter-inactive');
        donaturFilterButton.classList.remove('filter-active');
        window.history.replaceState({}, '', '?section=detail');
    });

    donaturFilterButton.addEventListener('click', function(event) {
        event.preventDefault();
        detailSection.style.display = 'none';
        donaturSection.style.display = 'block';
        donaturFilterButton.classList.add('filter-active');
        donaturFilterButton.classList.remove('filter-inactive');
        detailFilterButton.classList.add('filter-inactive');
        detailFilterButton.classList.remove('filter-active');
        window.history.replaceState({}, '', '?section=donatur');
    });
});
</script>
