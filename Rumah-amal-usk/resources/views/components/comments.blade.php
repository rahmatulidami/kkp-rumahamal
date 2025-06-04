<div class="comment-section">
    <h2>Comments (<span id="comment-count">0</span>)</h2>
    <form class="comment-form" id="mainForm" onsubmit="return handleComment(event)">
        @csrf
        <input type="hidden" id="post_id" value="{{ $postId }}">
        <div id="authorInputArea">
            <input type="text" id="author" name="author" placeholder="Nama (optional)">
        </div>
        <textarea id="content" name="content" placeholder="Tulis komentar Anda..." required></textarea>
        <button type="submit">Kirim Komentar</button>
    </form>
    <div class="comments" id="commentsContainer">
        <ul id="comments-list"></ul>
    </div>
</div>

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
      background:rgb(255, 255, 255) !important;
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