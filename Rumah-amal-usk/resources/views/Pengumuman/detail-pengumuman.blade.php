@extends('layouts.layout')

@section('title', 'Detail Pengumuman | Rumah Amal USK')

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
            @include('components.comments', ['postId' => $pengumuman['id']])
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
                    {{ $pengumuman['id'] }},
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
                    <h4><a href="{{ route('pengumuman.show', $recent['slug']) }}">{{ $recent['title']['rendered'] }}</a></h4>
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

<style>
 .admin-label {
    font-weight: bold;
    color: #fff;
    background: #1e88e5;
    display: inline-block;
    padding: 0.3rem 1rem;
    border-radius: 6px;
    margin-bottom: 0.5rem;
  }
  .admin-name {
      color: #fff;
      font-weight: bold;
  }
  .comment-admin {
      background: #e3f2fd !important;
      border-left: 4px solid #1e88e5 !important;
  }
  .comment-admin .author .admin-name {
      color: #1565c0;
      font-weight: bold;
      font-family: 'Montserrat', sans-serif;
  }

      .delete-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 0.3rem 1rem;
      border-radius: 5px;
      margin-left: 1rem;
      cursor: pointer;
  }
  .delete-btn:hover {
      background: #b71c1c;
  }

          * {
              box-sizing: border-box;
              margin: 0;
              padding: 0;
          }

          /* body {
              font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
              max-width: 800px;
              margin: 2rem auto;
              padding: 0 1rem;
              background-color: #f5f5f5;
          } */

          .comment-section {
              background: white;
              padding: 2rem;
              border-radius: 10px;
              box-shadow: 0 2px 15px rgba(0,0,0,0.1);
          }

          .comment {
              margin: 1rem 0;
              padding: 1rem;
              background: #fff;
              border-radius: 8px;
              border: 1px solid #eee;
              animation: fadeIn 0.3s ease-in;
              transition: transform 0.2s;
          }

          .comment:hover {
              transform: translateX(5px);
          }

          .comment-reply {
              margin-left: 2rem;
              border-left: 3px solid #007bff;
              /* padding-left: 1rem; */
              animation: slideIn 0.3s ease-out;
          }

          .author {
              font-weight: 600;
              color: #333;
              margin-bottom: 0.5rem;
          }

          .timestamp {
              font-size: 0.8rem;
              color: #666;
              margin-left: 1rem;
          }

          .content {
              color: #444;
              line-height: 1.5;
          }

          .reply-preview {
              font-size: 0.9rem;
              color: #666;
              padding: 0.5rem;
              background: #f8f9fa;
              border-radius: 5px;
              margin: 0.5rem 0;
              border-left: 2px solid #007bff;
          }

          .reply-btn {
              background: none;
              border: none;
              color: #007bff;
              cursor: pointer;
              padding: 0.5rem 1rem;
              margin-top: 0.5rem;
              border-radius: 5px;
              transition: background 0.2s;
          }

          .reply-btn:hover {
              background: #e3f2fd;
          }

          .comment-form {
              margin-top: 2rem;
              padding: 1rem;
              background: #fff;
              border-radius: 8px;
              box-shadow: 0 2px 10px rgba(0,0,0,0.05);
          }

          input, textarea {
              width: 100%;
              padding: 0.8rem;
              margin: 0.5rem 0;
              border: 1px solid #ddd;
              border-radius: 5px;
              font-family: inherit;
          }

          button[type="submit"] {
              background: #007bff;
              color: white;
              border: none;
              padding: 0.8rem 1.5rem;
              border-radius: 5px;
              cursor: pointer;
              transition: background 0.2s;
          }

          button[type="submit"]:hover {
              background: #0056b3;
          }

          @keyframes fadeIn {
              from { opacity: 0; }
              to { opacity: 1; }
          }

          @keyframes slideIn {
              from { transform: translateX(-20px); opacity: 0; }
              to { transform: translateX(0); opacity: 1; }
          }
    </style>


@endsection
