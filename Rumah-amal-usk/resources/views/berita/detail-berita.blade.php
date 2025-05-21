@extends('layouts.layout')

@section('title', 'Detail Berita | Rumah Amal USK')

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

        <div class="comment-section">
          <h2>Comments (<span id="comment-count">0</span>)</h2>
          <form class="comment-form" id="mainForm" onsubmit="return handleComment(event)">
              @csrf
              <input type="hidden" id="post_id" value="{{ $berita['id'] }}">
              <div id="authorInputArea">
                  <input type="text" id="author" name="author" placeholder="Nama (optional)">
              </div>
              <textarea id="content" name="content" placeholder="Tulis komentar Anda..." required></textarea>
              <button type="submit">Kirim Komentar</button>
          </form>
            <!-- Container untuk komentar -->
            <div class="comments" id="commentsContainer">
                <ul id="comments-list"></ul>
            </div>

            <!-- Form untuk komentar baru -->
        </div>
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
                    <h4><a href="{{ route('berita.show', $recent['slug']) }}">{{ $recent['title']['rendered'] }}</a></h4>
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

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/id.js"></script>
<script>
    dayjs.extend(dayjs_plugin_relativeTime);
    dayjs.locale('id'); // Gunakan bahasa Indonesia
</script>

<script>
    window.IS_ADMIN = {{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }};
    window.ADMIN_NAME = "{{ auth()->check() && auth()->user()->is_admin ? (auth()->user()->name ?? 'Admin') : '' }}";

    document.addEventListener('DOMContentLoaded', function () {
    if (window.IS_ADMIN) {
        // Hilangkan input nama, ganti dengan label fixed
        document.getElementById('authorInputArea').innerHTML = `
            <div class="admin-label">Sebagai <span class="admin-name">Admin</span></div>
        `;
    }
});
</script>

<script>
  const postId = {{ $berita['id'] }};
  const commentsContainer = document.getElementById('commentsContainer');

  // =========== FLATTEN AND RENDER COMMENTS (TWO LEVELS) ===========

  // Flatten all replies under a single comment (no matter how deep)
  function flattenReplies(children) {
      let result = [];
      children.forEach(child => {
          result.push(child);
          if (child.children && child.children.length > 0) {
              result = result.concat(flattenReplies(child.children));
          }
      });
      return result;
  }

  // Render all comments: only two levels (main + all replies flat under main)
  function renderCommentsTwoLevel(comments, container) {
      container.innerHTML = '';

      // Urutkan komentar utama dari yang terbaru
      comments.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

      comments.forEach(comment => {

          const commentEl = makeCommentElement(comment, false);
          container.appendChild(commentEl);

          // Flatten & urutkan replies dari yang terbaru
          const replies = comment.children ? flattenReplies(comment.children) : [];
          replies.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

          // Render max 2 reply, sisanya hidden
          const repliesToShow = replies.slice(0, 2);
          const repliesHidden = replies.slice(2);

          repliesToShow.forEach(reply => {
              const replyEl = makeCommentElement(reply, true);
              container.appendChild(replyEl);
          });

          if (repliesHidden.length > 0) {
              // Wrap hidden replies in a div
              const hiddenRepliesDiv = document.createElement('div');
              hiddenRepliesDiv.style.display = "none";
              repliesHidden.forEach(reply => {
                  const replyEl = makeCommentElement(reply, true);
                  hiddenRepliesDiv.appendChild(replyEl);
              });
              container.appendChild(hiddenRepliesDiv);

              // Toggle button
              const moreBtn = document.createElement('button');
              moreBtn.className = 'reply-btn more-replies-btn';
              moreBtn.textContent = `Tampilkan ${repliesHidden.length} balasan lainnya`;
              let expanded = false;
              moreBtn.onclick = function () {
                  expanded = !expanded;
                  if (expanded) {
                      hiddenRepliesDiv.style.display = "";
                      moreBtn.textContent = "Sembunyikan balasan";
                  } else {
                      hiddenRepliesDiv.style.display = "none";
                      moreBtn.textContent = `Tampilkan ${repliesHidden.length} balasan lainnya`;
                  }
              };
              container.appendChild(moreBtn);
          }
      });
  }

  function deleteComment(commentId) {
      if (!confirm('Yakin ingin menghapus komentar ini?')) return;
      fetch(`/comments/${commentId}`, {
          method: 'DELETE',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              // Refresh komentar setelah hapus
              fetchAndRenderComments();
          } else {
              alert(data.message || 'Gagal menghapus komentar');
          }
      });
  }

  // Create a comment DOM element
  function makeCommentElement(comment, isReply) {
      const commentEl = document.createElement('div');
    let isAdminComment = comment.is_admin; // bukan cuma cek author
  commentEl.className = 'comment' + (isReply ? ' comment-reply' : '') + (isAdminComment ? ' comment-admin' : '');

      commentEl.setAttribute('data-id', comment.id);

      // Preview hanya jika reply ke reply
      let previewHTML = '';
      if (isReply && comment.parent && comment.parent.parent_id !== null) {
          previewHTML = `
              <div class="reply-preview">
                  Membalas ${comment.parent.author}: "${truncate(comment.parent.content, 30)}"
              </div>
          `;
      }

      // Tombol delete hanya jika admin
      let deleteBtnHTML = '';
      if (window.IS_ADMIN) {
          deleteBtnHTML = `
              <button class="delete-btn" onclick="deleteComment(${comment.id})">Hapus</button>
          `;
      }

      commentEl.innerHTML = `
          ${previewHTML}
          <div class="author">
              <span class="${isAdminComment ? 'admin-name' : ''}">${comment.author}</span>
              <span class="timestamp">${dayjs(comment.created_at).fromNow()}</span>
              ${deleteBtnHTML}
          </div>
          <div class="content">${comment.content}</div>
          <button class="reply-btn" onclick="showReplyForm(${comment.id})">Balas</button>
          <div class="replies"></div>
      `;
      return commentEl;
  }
  // Truncate helper
  function truncate(text, maxLength) {
      return text && text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
  }

  // Show reply form below the comment
  function showReplyForm(parentId) {
      const parentComment = document.querySelector(`.comment[data-id="${parentId}"]`);
      const repliesContainer = parentComment?.querySelector('.replies');

      if (!parentComment || !repliesContainer) {
          console.error(`Parent comment with ID ${parentId} not found.`);
          return;
      }

      // Remove any existing reply form
      document.querySelectorAll('.reply-form').forEach(form => form.remove());

      // Create reply form
      const form = document.createElement('form');
      form.className = 'comment-form reply-form';
      form.innerHTML = window.IS_ADMIN
          ? `
              <div class="admin-label">Sebagai <span class="admin-name">Admin</span></div>
              <textarea class="reply-content" required placeholder="Balasan Anda"></textarea>
              <button type="submit">Kirim Balasan</button>
          `
          : `
              <input type="text" class="reply-author" placeholder="Nama (optional)">
              <textarea class="reply-content" required placeholder="Balasan Anda"></textarea>
              <button type="submit">Kirim Balasan</button>
          `;
      form.onsubmit = (e) => handleReply(e, parentId);
      repliesContainer.appendChild(form);
  }

  // Handle main comment submit
  async function handleComment(e) {
      e.preventDefault();

      const author = window.IS_ADMIN ? (window.ADMIN_NAME || 'Admin') : (document.getElementById('author').value || 'Anonim');

      const content = document.getElementById('content').value;

      const response = await fetch('/comments', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ post_id: postId, author, content, parent_id: null })
      });

      const data = await response.json();
      if (data.success) {
          // Refetch all comments so the order stays correct
          await fetchAndRenderComments();
          document.getElementById('mainForm').reset();
      }
  }

  // Handle reply submit
  async function handleReply(e, parentId) {
      e.preventDefault();

      const form = e.target;
      const author = window.IS_ADMIN
      ? (window.ADMIN_NAME || 'Admin')
      : (form.querySelector('.reply-author')?.value || 'Anonim');

      const content = form.querySelector('.reply-content').value;

      const response = await fetch('/comments', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ post_id: postId, author, content, parent_id: parentId })
      });

      const data = await response.json();
      if (data.success) {
          form.remove();
          // Refetch all comments so the order and structure stays correct
          await fetchAndRenderComments();
      }
  }

  // Fetch and render comments on page
  async function fetchAndRenderComments() {
      const commentsContainer = document.getElementById('commentsContainer');
      const response = await fetch(`/comments/${postId}`);
      const comments = await response.json();
      renderCommentsTwoLevel(comments.comments, commentsContainer);

      document.getElementById('comment-count').textContent = comments.count;
  }

  // INIT: Fetch on page load
  document.addEventListener('DOMContentLoaded', function () {
      fetchAndRenderComments();
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
