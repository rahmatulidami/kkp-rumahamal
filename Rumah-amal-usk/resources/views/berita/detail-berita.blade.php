@extends('layouts.layout')

@section('title', 'Detail Berita | Rumah Amal USK')

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
          <li><a href="/berita">Berita</a></li>
          <li class="current">{{ $berita['title']['rendered'] }}</li>
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

              <h3 class="title">{{ $berita['title']['rendered'] }}</h3>

              <div class="post-img">
                <img src="{{ $mainImage }}" alt="{{ $berita['title']['rendered'] }}" class="img-fluid" style="width: 100%; height: auto;">
              </div>

              <!-- <div class="post-content">
                {!! $filteredContent !!}
              </div> -->

              <div class="meta-top">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $berita['author'] }}</a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime="{{ $berita['date'] }}">{{ \Carbon\Carbon::parse($berita['date'])->format('M d, Y') }}</time></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="#">{{ $comment_count }} Comments</a></li>
                </ul>
              </div><!-- End meta top -->

              <div class="content">
                {!! $berita['content']['rendered'] !!}
              </div><!-- End post content -->

              <div class="meta-bottom">
                <i class="bi bi-folder"></i>
                <ul class="cats">
                  @foreach($berita['categories'] as $category)
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

        <!-- Blog Comments Section -->
        <section id="blog-comments" class="blog-comments section">
          <div class="container">
            <h4 class="comments-count">{{ $comment_count }} Comments</h4>

            @foreach($comments as $comment)
              <div id="comment-{{ $comment['id'] }}" class="comment">
                <div class="d-flex">
                  <div class="comment-img"><img src="{{ asset('storage/' . $comment['user_image']) }}" alt=""></div>
                  <div>
                    <h5><a href="#">{{ $comment['user_name'] }}</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a></h5>
                    <time datetime="{{ $comment['created_at'] }}">{{ \Carbon\Carbon::parse($comment['created_at'])->format('M d, Y') }}</time>
                    <p>{{ $comment['content'] }}</p>
                  </div>
                </div>
              </div><!-- End comment -->
            @endforeach

          </div>
        </section><!-- /Blog Comments Section -->

        <!-- Comment Form Section -->
        <section id="comment-form" class="comment-form section">
          <div class="container">
            <form action="{{ route('comments.store') }}" method="POST">
              @csrf
              <input type="hidden" name="berita_id" value="{{ $berita['id'] }}">

              <h4>Post Comment</h4>
              <p>Your email address will not be published. Required fields are marked *</p>
              <div class="row">
                <div class="col-md-6 form-group">
                  <input name="name" type="text" class="form-control" placeholder="Your Name*" required>
                </div>
                <div class="col-md-6 form-group">
                  <input name="email" type="email" class="form-control" placeholder="Your Email*" required>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <input name="website" type="text" class="form-control" placeholder="Your Website">
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <textarea name="comment" class="form-control" placeholder="Your Comment*" required></textarea>
                </div>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary">Post Comment</button>
              </div>

            </form>
          </div>
        </section><!-- /Comment Form Section -->

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
                    <h4><a href="{{ route('berita.show', $recent['id']) }}">{{ $recent['title']['rendered'] }}</a></h4>
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
  copyLinkButton.addEventListener('click', function() {
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
