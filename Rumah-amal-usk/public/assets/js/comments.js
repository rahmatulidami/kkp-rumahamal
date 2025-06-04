window.initComments = function(postId, isAdmin, adminName) {
    window.postId = postId;
    window.IS_ADMIN = isAdmin;
    window.ADMIN_NAME = adminName;


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
            <span class="${isAdminComment ? 'admin-name' : ''}">
            ${comment.author}
            ${isAdminComment ? '<i class="bi bi-patch-check-fill verified-badge" style="color:#1da1f2;vertical-align:middle;margin-left:3px;" title="Admin Terverifikasi"></i>' : ''}
            </span>
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

    window.handleComment = handleComment;
    window.handleReply = handleReply;
    window.showReplyForm = showReplyForm;
    window.deleteComment = deleteComment;

    document.addEventListener('DOMContentLoaded', function () {
        if (window.IS_ADMIN) {
            document.getElementById('authorInputArea').innerHTML = `
                <div class="admin-label">Sebagai <span class="admin-name">Admin</span></div>
            `;
        }
        fetchAndRenderComments();
    });

};