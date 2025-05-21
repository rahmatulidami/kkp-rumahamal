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