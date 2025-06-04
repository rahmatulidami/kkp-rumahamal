@extends('layouts.layout')

@section('title', 'Detail Berita | Rumah Amal USK')

@section('meta')
<!-- Meta tags -->
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta name="description" content="{{ Str::limit(strip_tags($berita['content']['rendered']), 150) }}">
<meta name="keywords" content="Rumah Amal, Berita, USK, Charity, News">
<meta property="og:title" content="{{ $berita['title']['rendered'] }}" />
<meta property="og:description" content="{{ Str::limit(strip_tags($berita['content']['rendered']), 150) }}" />
<meta property="og:image" content="{{ $mainImage }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta name="twitter:card" content="summary_large_image">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
    </div>
  </div><!-- End Page Title -->

  <div class="container">
    <div class="row">

      <div class="col-lg-8">

        <!-- Blog Details Section -->
        <section id="blog-details" class="blog-details section">
          <div class="container">

            <article class="article">

              <h3 class="title">{{ $berita['title']['rendered'] }}</h3>

              <div class="content" style="max-width: 100%; height: auto;">
                  {!! $berita['content']['rendered'] !!}
              </div>

              <div class="meta-bottom">
                <i class="bi bi-folder"></i>
                <ul class="cats">
                  @foreach($berita['categories'] as $category)
                    <li><a href="#">{{ $category }}</a></li>
                  @endforeach
                </ul>

                <i class="bi bi-tags"></i>
                <ul class="tags">
                  @foreach($filteredTags as $tag)
                    <li><a href="{{ route('berita.tag', ['tag' => $tag['id']]) }}">{{ $tag['name'] }}</a></li>
                  @endforeach
                </ul>

                <div class="share-buttons">
                  <div class="share-container">
                    <p>Bagikan:</p>
                  </div>

                  <div>
                    <a href="#" id="share-instagram" title="Share on Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" id="share-whatsapp" title="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" id="share-facebook" title="Share on Facebook"><i class="bi bi-facebook"></i></a>

                    <!-- Copy link tombol dengan tooltip -->
                    <a href="#" id="copy-link" class="copy-btn" aria-label="Salin tautan ke clipboard">
                      <i class="bi bi-link-45deg"></i>
                      <span class="tooltip-text">Tautan telah disalin!</span>
                    </a>
                  </div>

                </div>

              </div><!-- End meta bottom -->

            </article>

            @include('components.comments', ['postId' => $berita['id']])
            <script src="{{ asset('assets/js/comments.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/id.js"></script>
            <script>
                dayjs.extend(dayjs_plugin_relativeTime);
                dayjs.locale('id'); // Gunakan bahasa Indonesia
            </script>
            <script>
                window.initComments(
                    {{ $berita['id'] }},
                    {{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }},
                    "{{ auth()->check() && auth()->user()->is_admin ? (auth()->user()->name ?? 'Admin') : '' }}"
                );
            </script>

          </div>
        </section><!-- /Blog Details Section -->

      </div>

      <div class="col-lg-4 sidebar">
        <div class="widgets-container">

          <!-- Search Widget -->
          <div class="search-widget widget-item">
            <h3 class="widget-title">Pencarian</h3>
            <form action="{{ route('berita') }}" method="GET">
              <input type="text" name="search" placeholder="Cari berita berdasarkan judul...." value="{{ request('search') }}">
              <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
          </div>

          <div class="recent-posts-widget widget-item">
            <h3 class="widget-title">Postingan Terkini</h3>
            @foreach($recent_posts as $recent)
              <div class="post-item">
                <img src="{{ $recent['image_url'] ?? asset('assets/img/default.jpeg') }}" alt="{{ $recent['title']['rendered'] }}" class="img-fluid recent-post-img">
                <div>
                  <h4><a href="{{ route('berita.show', $recent['slug']) }}">{{ $recent['title']['rendered'] }}</a></h4>
                  <time datetime="{{ $recent['date'] }}">{{ \Carbon\Carbon::parse($recent['date'])->translatedFormat('d F Y') }}</time>
                </div>
              </div>
            @endforeach
          </div>

          <div class="tags-widget widget-item">
            <h3 class="widget-title">Tags</h3>
            <ul class="tags">
              @foreach($filteredTags as $tag)
                <li><a href="{{ route('berita.tag', ['tag' => $tag['id']]) }}">{{ $tag['name'] }}</a></li>
              @endforeach
            </ul>
          </div>

        </div>
      </div>

    </div>
  </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const copyLinkButton = document.getElementById('copy-link');
  const tooltip = document.getElementById('tooltip-copy');

  const shareUrls = {
    'share-whatsapp': 'https://api.whatsapp.com/send?text=',
    'share-facebook': 'https://www.facebook.com/sharer/sharer.php?u='
  };

  Object.keys(shareUrls).forEach(shareId => {
    document.getElementById(shareId).addEventListener('click', function(event) {
      event.preventDefault();
      const url = window.location.href;
      const shareUrl = shareUrls[shareId] + encodeURIComponent(url);
      window.open(shareUrl, '_blank');
    });
  });

  document.getElementById('share-instagram').addEventListener('click', function(event) {
    event.preventDefault();
    window.open('https://www.instagram.com', '_blank');
  });

  document.getElementById('copy-link').addEventListener('click', function(e) {
      e.preventDefault();
      this.classList.add('show-tooltip');
      setTimeout(() => {
        this.classList.remove('show-tooltip');
      }, 2000);
    });
});
</script>

@endpush
