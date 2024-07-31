@extends('layouts.layout')

@section('title', 'Detail Pengumuman | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
    </div>
    <nav class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li><a href="/pengumuman">Pengumuman</a></li>
          <li class="current">{{ $pengumuman['title']['rendered'] }}</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Page Title -->

  <div class="container">
    <div class="row">

      <div class="col-lg-8">

        <!-- Blog Details Section -->
        <section id="blog-details" class="blog-details section">
          <div class="container">

            <article class="article">

              <h3 class="title">{{ $pengumuman['title']['rendered'] }}</h3>

              <div class="content" style="max-width: 100%; height: auto;">
                  {!! $filteredContent !!}
              </div>

              <div class="meta-bottom">
                <i class="bi bi-folder"></i>
                <ul class="cats">
                  @foreach($pengumuman['categories'] as $category)
                    <li><a href="#">{{ $category }}</a></li>
                  @endforeach
                </ul>

                <i class="bi bi-tags"></i>
                <ul class="tags">
                  @foreach($tags as $tag)
                    <li><a href="#">{{ $tag['name'] }}</a></li>
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
                    <a href="#" id="copy-link" title="Copy Link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                  <p id="share-instructions" style="display: none;">URL copied!</p>
                </div>

              </div><!-- End meta bottom -->

            </article>

          </div>
        </section><!-- /Blog Details Section -->

      </div>

      <div class="col-lg-4 sidebar">
        <div class="widgets-container">

          <!-- Search Widget -->
          <div class="search-widget widget-item">
            <h3 class="widget-title">Search</h3>
            <form action="">
              <input type="text">
              <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
          </div><!--/Search Widget -->

          <div class="recent-posts-widget widget-item">
              <h3 class="widget-title">Recent Posts</h3>

              @foreach($recent_posts as $recent)
                <div class="post-item">
                  <img src="{{ $recent['image_url'] ?? asset('assets/img/default.jpeg') }}" alt="{{ $recent['title']['rendered'] }}" class="img-fluid recent-post-img">
                  <div>
                    <h4><a href="{{ route('pengumuman.show', $recent['id']) }}">{{ $recent['title']['rendered'] }}</a></h4>
                    <time datetime="{{ $recent['date'] }}">{{ \Carbon\Carbon::parse($recent['date'])->format('M d, Y') }}</time>
                  </div>
                </div><!-- End post item -->
              @endforeach

          </div><!--/Recent Posts Widget -->


          <!-- Tags Widget -->
          <div class="tags-widget widget-item">
            <h3 class="widget-title">Tags</h3>
            <ul class="tags">
              @foreach($tags as $tag)
                <li><a href="#">{{ $tag['name'] }}</a></li>
              @endforeach
            </ul>
          </div><!--/Tags Widget -->

        </div><!--/widgets-container -->
      </div><!--/sidebar -->

    </div><!--/row -->
  </div><!--/container -->
</main><!--/main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  const copyLinkButton = document.getElementById('copy-link');
  const shareInstructions = document.getElementById('share-instructions');

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

  copyLinkButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default anchor click behavior
    const url = window.location.href;
    navigator.clipboard.writeText(url)
      .then(() => {
        shareInstructions.style.display = 'inline';
        setTimeout(() => {
          shareInstructions.style.display = 'none';
        }, 2000);
      })
      .catch(err => {
        console.error('Could not copy text: ', err);
      });
  });
});
</script>



@endsection
