@extends('new_layouts.app')
@section('styles')
    <style>
        .modal-icon {
            font-size: 3rem;
            color: #dc3545;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.25rem;
            margin-top: 1rem;
        }

        .modal-body p {
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .custom-table {
            border-collapse: collapse;
            border-radius: 1rem;
            border-style: hidden;
            box-shadow: 0 0 0 1px #e6ebef;
            overflow: hidden;
            text-align: left;
            width: 100%;
        }

        .badge-file-extension {
            background-color: #f25961;
            color: white;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
        }

        .bookmark-active svg {
            fill: #FF9800;
        }

        .description-text {
            font-size: 1.1rem;
            color: #555;
            margin-top: 0.5rem;
        }

        .comment {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .comment-section {
            border: 1px solid #e9ebee;
            border-radius: 1rem;
            padding: 1.5rem;
            background-color: #ffffff;
            /* box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1); */
        }

        .comment-header {
            border-bottom: 1px solid #e9ebee;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
        }

        .comment-avatar {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .comment-author {
            font-size: 1rem;
            font-weight: 600;
        }

        .comment-time {
            font-size: 0.875rem;
            color: #90949c;
        }

        .comment-body {
            margin: 0.75rem 0;
            font-size: 1rem;
        }

        .comment-actions a {
            font-size: 0.875rem;
            color: #4267b2;
            text-decoration: none;
            margin-right: 1rem;
        }

        .comment-actions i {
            margin-right: 0.5rem;
        }

        .reply-list {
            margin-top: 1rem;
            padding-left: 2rem;
        }

        .reply-list .comment {
            border-left: 1px dotted #d3d6db;
            padding-left: 1rem;
            margin-top: 1rem;
        }

        .reply-toggle {
            cursor: pointer;
            font-size: 0.875rem;
            color: #4267b2;
            text-decoration: none;
            margin-top: 1rem;
            display: block;
        }

        .reply-form {
            display: none;
            position: relative;
            z-index: 10;
        }

        .comment-input {
            border-radius: 0.5rem;
        }

        .like-button.active i {
            color: #4caf50;
        }

        .dislike-button.active i {
            color: #dc3545;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            right: 0;
            left: auto;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="mt-4">
            <h2>{{ $department->name }} Chat</h2>
        </div>
        <div class="mt-4 comment-section">
            <h3>Comments ( {{ $comments->count() }} )</h3>
            <div class="comment-header d-flex justify-content-between align-items-center">
            </div>
            <div class="comment-body">
                <div class="d-flex mb-3">
                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"
                        class="comment-avatar">
                    <div class="w-100">
                        <form id="comment-form" action="{{ route('comments.store', $department) }}" method="POST">
                            @csrf
                            <div class="d-flex flex-column">
                                <textarea name="content" class="form-control comment-input" placeholder="Write a comment..." rows="3"></textarea>
                                <div class="d-flex justify-content-between mt-2">
                                    <div id="comment-form-error" class="text-danger"></div>
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="comment-list" class="comment-list">
                    @foreach ($comments as $comment)
                        <div class="comment" data-comment-id="{{ $comment->id }}">
                            <div class="d-flex">
                                <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"
                                    class="comment-avatar">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="comment-author">
                                                {{ $comment->user_id === auth()->id() ? 'You' : $comment->user->name }}
                                            </div>
                                            <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $comment->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                                @if ($comment->user_id === auth()->id())
                                                    <li><a class="dropdown-item" href="#" data-action="edit"
                                                            data-comment-id="{{ $comment->id }}">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"
                                                            data-action="delete"
                                                            data-comment-id="{{ $comment->id }}">Delete</a></li>
                                                @endif
                                                <li>
                                                    <a href="#" class="dropdown-item report-comment"
                                                        data-comment-id="{{ $comment->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#reportModal">Report</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="comment-body">{{ $comment->content }}</div>
                                    <div class="comment-actions">
                                        <a href="#"
                                            class="like-button {{ $comment->likes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                                            data-action="like" data-comment-id="{{ $comment->id }}">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                            <span class="like-dislike-count">{{ $comment->likes }}</span>
                                        </a>
                                        <a href="#"
                                            class="dislike-button {{ $comment->dislikes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                                            data-action="dislike" data-comment-id="{{ $comment->id }}">
                                            <i class="fa-solid fa-thumbs-down"></i>
                                            <span class="like-dislike-count">{{ $comment->dislikes }}</span>
                                        </a>
                                        <a href="#" class="reply-link" data-comment-id="{{ $comment->id }}"
                                            data-author="{{ $comment->user->name }}">
                                            <i class="fa-solid fa-reply"></i> Reply
                                        </a>
                                    </div>
                                    <div class="reply-toggle" onclick="toggleReplies(this)">View replies</div>

                                    <form class="reply-form" action="{{ route('replies.store', $comment) }}"
                                        method="POST">
                                        @csrf
                                        <div class="d-flex flex-column">
                                            <textarea name="content" class="form-control comment-input" placeholder="Write a reply..." rows="2"></textarea>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div id="comment-form-error" class="text-danger" style="display: none;">
                                                    Error: Reply cannot be empty
                                                </div>
                                                <button type="submit" class="btn btn-primary ms-auto">Post Reply</button>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="reply-list" style="display: none;">
                                        @foreach ($comment->replies as $reply)
                                            <div class="comment reply" data-comment-id="{{ $reply->id }}">
                                                <div class="d-flex">
                                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                        alt="avatar" class="comment-avatar">
                                                    <div class="w-100">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div class="comment-author">
                                                                    {{ $reply->user_id === auth()->id() ? 'You' : $reply->user->name }}
                                                                </div>
                                                                <div class="comment-time">
                                                                    {{ $reply->created_at->diffForHumans() }}</div>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-link dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenuButton{{ $reply->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton{{ $reply->id }}">
                                                                    @if ($reply->user_id === auth()->id())
                                                                        <li><a class="dropdown-item" href="#"
                                                                                data-action="edit"
                                                                                data-comment-id="{{ $reply->id }}">Edit</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item text-danger"
                                                                                href="#" data-action="delete"
                                                                                data-comment-id="{{ $reply->id }}">Delete</a>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a href="#"
                                                                            class="dropdown-item report-comment"
                                                                            data-comment-id="{{ $reply->id }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#reportModal">Report</a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                        <div class="comment-body">
                                                            {{-- @if ($reply->parent)
                                                                <a href="#"
                                                                    class="reply-mention">{{ '@' . $reply->parent->user->name }}</a>
                                                            @endif --}}
                                                            <span class="reply-content">{{ $reply->content }}</span>
                                                        </div>
                                                        <div class="comment-actions">
                                                            <a href="#"
                                                                class="like-button {{ $reply->likes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                                                                data-action="like" data-comment-id="{{ $reply->id }}">
                                                                <i class="fa-solid fa-thumbs-up"></i>
                                                                <span
                                                                    class="like-dislike-count">{{ $reply->likes }}</span>
                                                            </a>
                                                            <a href="#"
                                                                class="dislike-button {{ $reply->dislikes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                                                                data-action="dislike"
                                                                data-comment-id="{{ $reply->id }}">
                                                                <i class="fa-solid fa-thumbs-down"></i>
                                                                <span
                                                                    class="like-dislike-count">{{ $reply->dislikes }}</span>
                                                            </a>
                                                            {{-- <a href="#" class="reply-link"
                                                                data-comment-id="{{ $reply->id }}"
                                                                data-author="{{ $reply->user->name }}">
                                                                <i class="fa-solid fa-reply"></i> Reply
                                                            </a> --}}
                                                        </div>
                                                        <form class="reply-form"
                                                            action="{{ route('replies.store', $reply) }}" method="POST">
                                                            @csrf
                                                            <div class="d-flex flex-column">
                                                                <textarea name="content" class="form-control comment-input" placeholder="Write a reply..." rows="2"></textarea>
                                                                <div class="d-flex justify-content-between mt-2">
                                                                    <div id="comment-form-error" class="text-danger"
                                                                        style="display: none;">
                                                                        Error: Reply cannot be empty
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary ms-auto">Post Reply</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @include('materials.comment', ['replies' => $reply->replies]) --}}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-triangle-exclamation modal-icon"></i>
                    </div>
                    <h5 class="modal-title" id="deleteModalLabel">Delete Comment</h5>
                    <p>Are you sure you want to delete this comment?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger ms-2" id="confirmDelete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to report this comment?</p>
                    <textarea id="reportReason" class="form-control" rows="4"
                        placeholder="Please provide a reason for reporting..."></textarea>
                    <input type="hidden" id="report_id" name="report_id">
                    <input type="hidden" id="report_type" name="report_type" value="comment">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmReport">Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('report-comment')) {
                    const commentId = event.target.getAttribute('data-comment-id');
                    document.getElementById('report_id').value = commentId;
                    document.getElementById('report_type').value = 'comment';
                }
            });

            const confirmReportButton = document.getElementById('confirmReport');
            if (confirmReportButton) {
                confirmReportButton.addEventListener('click', function() {
                    const reportForm = new FormData();
                    reportForm.append('report_id', document.getElementById('report_id').value);
                    reportForm.append('report_type', document.getElementById('report_type').value);
                    reportForm.append('reason', document.getElementById('reportReason').value);

                    fetch('{{ route('user_report.submit') }}', {
                            method: 'POST',
                            body: reportForm,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'reportModal'));
                                modal.hide();
                            } else {
                                console.error('Error:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Something went wrong:', error);
                        });
                });
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentList = document.getElementById('comment-list');

        // Handle edit button click
        commentList.addEventListener('click', function(event) {
            const button = event.target.closest('a[data-action="edit"]');
            if (button) {
                event.preventDefault();
                const commentId = button.getAttribute('data-comment-id');
                const commentElement = document.querySelector(`.comment[data-comment-id="${commentId}"]`);
                const commentBodyElement = commentElement.querySelector('.comment-body');

                // Extract mention and content
                const mentionElement = commentBodyElement.querySelector('.reply-mention');
                const mention = mentionElement ? mentionElement.innerText.trim() : '';
                const contentElement = mentionElement ? mentionElement.nextElementSibling : commentBodyElement;
                const content = contentElement.innerText.trim();

                // Store original content for cancel action
                commentBodyElement.dataset.originalContent = commentBodyElement.innerHTML;

                const editForm = `
                <form class="edit-comment-form" data-comment-id="${commentId}">
                    ${mention ? `<span class="reply-mention">${mention}</span>` : ''}
                    <textarea class="form-control">${content}</textarea>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div id="edit-form-error" class="text-danger" style="display: none;"></div>
                        <div class="ms-auto">
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <button type="button" class="btn btn-secondary cancel-edit">Cancel</button>
                        </div>
                    </div>
                </form>
            `;

                commentBodyElement.innerHTML = editForm;
                attachEditFormListeners(commentId);
            }
        });

        function attachEditFormListeners(commentId) {
            const editForm = document.querySelector(`.edit-comment-form[data-comment-id="${commentId}"]`);

            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const textarea = this.querySelector('textarea');
                const content = textarea.value.trim();
                const mention = this.querySelector('.reply-mention') ? this.querySelector('.reply-mention').innerText.trim() : '';

                // Check if textarea is empty
                if (content === '') {
                    const errorElement = this.querySelector('#edit-form-error');
                    errorElement.innerText = 'Error: Comment cannot be empty';
                    errorElement.style.display = 'block';
                    return;
                } else {
                    this.querySelector('#edit-form-error').style.display = 'none'; // Hide error if valid
                }

                fetch(`/comments/${commentId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const commentBodyElement = document.querySelector(`.comment[data-comment-id="${commentId}"] .comment-body`);
                            const mentionElement = mention ? `<a href="#" class="reply-mention">${mention}</a>` : '';
                            commentBodyElement.innerHTML = `${mentionElement} <span class="reply-content">${data.content}</span>`;
                        } else {
                            alert('Error updating comment.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            editForm.querySelector('.cancel-edit').addEventListener('click', function() {
                const originalContent = document.querySelector(`.comment[data-comment-id="${commentId}"] .comment-body`).dataset.originalContent;
                document.querySelector(`.comment[data-comment-id="${commentId}"] .comment-body`).innerHTML = originalContent;
            });
        }
    });
</script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // for delete 
            let commentIdToDelete = null;

            document.getElementById('comment-list').addEventListener('click', function(event) {
                const button = event.target.closest('a[data-action="delete"]');
                if (button) {
                    event.preventDefault();
                    commentIdToDelete = button.getAttribute('data-comment-id');

                    // Show the delete confirmation modal
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                }
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (commentIdToDelete) {
                    fetch(`/comments/${commentIdToDelete}`, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentElement = document.querySelector(
                                    `.comment[data-comment-id="${commentIdToDelete}"]`);
                                if (commentElement) {
                                    commentElement.remove();
                                }
                            } else {
                                alert(
                                    'Error: This comment was deleted because its parent comment was removed'
                                );
                            }
                        })
                        .catch(error => {
                            // console.error('Error:', error);
                            // alert('Something went wrong');
                        });

                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    deleteModal.hide();
                }
            });

            // for like and dislike
            document.getElementById('comment-list').addEventListener('click', function(event) {
                const button = event.target.closest('a');
                if (button && (button.classList.contains('like-button') || button.classList.contains(
                        'dislike-button'))) {
                    event.preventDefault();

                    const commentId = button.getAttribute('data-comment-id');
                    const action = button.getAttribute('data-action');

                    fetch(`/comments/${commentId}/${action}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                _method: 'POST'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentElement = document.querySelector(
                                    `.comment[data-comment-id="${commentId}"]`);
                                const likeCount = commentElement.querySelector(
                                    '.like-button .like-dislike-count');
                                const dislikeCount = commentElement.querySelector(
                                    '.dislike-button .like-dislike-count');

                                likeCount.textContent = data.comment.likes;
                                dislikeCount.textContent = data.comment.dislikes;

                                if (action === 'like') {
                                    button.classList.toggle('active');
                                    commentElement.querySelector('.dislike-button').classList.remove(
                                        'active');
                                } else {
                                    button.classList.toggle('active');
                                    commentElement.querySelector('.like-button').classList.remove(
                                        'active');
                                }
                            } else {
                                alert(data.message || 'Error updating like/dislike');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Something went wrong');
                        });
                }
            });

            // For submission of the main comment form
            document.getElementById('comment-form')?.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                const errorDiv = document.getElementById('comment-form-error');
                errorDiv.textContent = ''; // Clear previous errors

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const commentList = document.getElementById('comment-list');
                            if (commentList) {
                                const newCommentHtml = `
                            <div class="comment" data-comment-id="${data.comment.id}">
                                <div class="d-flex">
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="comment-avatar">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="comment-author">You</div>
                                                <div class="comment-time">${data.comment.created_at}</div>
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-link dropdown-toggle" type="button"
                                                    id="dropdownMenuButton${data.comment.id}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data.comment.id}">
                                                    <li><a class="dropdown-item" href="#" data-action="edit" data-comment-id="${data.comment.id}">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#" data-action="delete" data-comment-id="${data.comment.id}">Delete</a></li>
                                                    <li>
                                                        <a href="#" class="dropdown-item report-comment"
                                                        data-comment-id="${data.comment.id}" data-bs-toggle="modal"
                                                        data-bs-target="#reportModal">Report</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="comment-body">${data.comment.content}</div>
                                        <div class="comment-actions">
                                            <a href="#" class="like-button" data-action="like" data-comment-id="${data.comment.id}">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <span class="like-dislike-count">0</span>
                                            </a>
                                            <a href="#" class="dislike-button" data-action="dislike" data-comment-id="${data.comment.id}">
                                                <i class="fa-solid fa-thumbs-down"></i>
                                                <span class="like-dislike-count">0</span>
                                            </a>
                                            <a href="#" class="reply-link" data-comment-id="${data.comment.id}" data-author="${data.comment.user_name}">
                                                <i class="fa-solid fa-reply"></i> Reply
                                            </a>
                                        </div>
                                        <div class="reply-toggle" onclick="toggleReplies(this)">View replies</div>
                                        <form class="reply-form" action="{{ route('replies.store', ':commentId') }}" method="POST" style="display: none;">
                                            @csrf
                                            <div class="d-flex flex-column">
                                                <textarea name="content" class="form-control comment-input" placeholder="Write a reply..." rows="2"></textarea>
                                                <div class="d-flex justify-content-between  mt-2">
                                                    <div id="comment-form-error" class="text-danger" style="display: none;">
                                                        Error: Reply cannot be empty
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ms-auto">Post Reply</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="reply-list" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        `.replace(':commentId', data.comment.id);

                                commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
                                this.reset();
                                initializeDropdowns();
                            }
                        } else {
                            // Display error messages
                            errorDiv.textContent = data.error || 'Your comment is empty';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorDiv.textContent = 'Something went wrong';
                    });
            });

            // For submission of reply forms
            document.getElementById('comment-list')?.addEventListener('submit', function(event) {
                if (event.target.closest('.reply-form')) {
                    event.preventDefault();
                    const form = event.target;
                    const formData = new FormData(form);
                    const parentId = form.closest('.comment').dataset.commentId;
                    const errorDiv = form.querySelector('#comment-form-error');

                    errorDiv.style.display = 'none';
                    errorDiv.textContent = '';

                    fetch(form.action.replace(':commentId', parentId), {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const replyList = form.closest('.reply-list') || form.closest(
                                    '.comment').querySelector('.reply-list');
                                if (replyList) {
                                    const newReplyHtml = `
                                <div class="comment reply" data-comment-id="${data.reply.id}">
                                    <div class="d-flex">
                                        <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="comment-avatar">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="comment-author">You</div>
                                                    <div class="comment-time">${data.reply.created_at}</div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton${data.reply.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data.reply.id}">
                                                        <li><a class="dropdown-item" href="#" data-action="edit" data-comment-id="${data.reply.id}">Edit</a></li>
                                                        <li><a class="dropdown-item text-danger" href="#" data-action="delete" data-comment-id="${data.reply.id}">Delete</a></li>
                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item report-comment"
                                                                data-comment-id="${data.reply.id}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reportModal">Report</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="comment-body">
                                                <span class="reply-content">${data.reply.content}</span>
                                            </div>
                                            <div class="comment-actions">
                                                <a href="#" class="like-button" data-action="like" data-comment-id="${data.reply.id}">
                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                    <span class="like-dislike-count">0</span>
                                                </a>
                                                <a href="#" class="dislike-button" data-action="dislike" data-comment-id="${data.reply.id}">
                                                    <i class="fa-solid fa-thumbs-down"></i>
                                                    <span class="like-dislike-count">0</span>
                                                </a>
                                            </div>
                                            <form class="reply-form" action="{{ route('replies.store', ':commentId') }}" method="POST" style="display: none;">
                                                @csrf
                                                    <div class="d-flex flex-column">
                                                        <textarea name="content" class="form-control comment-input" placeholder="Write a reply..." rows="2"></textarea>
                                                        <div class="d-flex justify-content-between  mt-2">
                                                            <div id="comment-form-error" class="text-danger" style="display: none;">
                                                                Error: Reply cannot be empty
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-auto">Post Reply</button>
                                                        </div>
                                                    </div>
                                            </form>
                                            <div class="reply-list" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                `.replace(':commentId', data.reply.id);

                                    replyList.insertAdjacentHTML('beforeend', newReplyHtml);
                                    form.reset();
                                    form.style.display =
                                        'none'; // Hide the reply form after successful submission

                                    const replyToggle = form.closest('.comment').querySelector(
                                        '.reply-toggle');
                                    if (replyToggle) {
                                        const replyList = replyToggle.nextElementSibling
                                            .nextElementSibling;
                                        replyList.style.display = 'block';
                                        replyToggle.textContent = 'Hide replies';
                                    }

                                    initializeDropdowns();
                                }
                            } else {
                                // Display error message
                                errorDiv.textContent = data.message || 'Error posting reply';
                                errorDiv.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Display error message
                            errorDiv.textContent = 'Something went wrong';
                            errorDiv.style.display = 'block';
                        });
                }
            });

            // For reply link click to show reply form
            document.getElementById('comment-list')?.addEventListener('click', function(event) {
                if (event.target.closest('.reply-link')) {
                    event.preventDefault();
                    const replyForm = event.target.closest('.comment').querySelector('.reply-form');
                    if (replyForm) {
                        replyForm.style.display = replyForm.style.display === 'block' ? 'none' : 'block';
                    }
                }
            });
        });

        function initializeDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown-toggle:not(.initialized)');
            dropdowns.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
                dropdown.classList.add('initialized');
            });
        }

        function toggleReplies(element) {
            const replyList = element.nextElementSibling.nextElementSibling;
            const isVisible = replyList.style.display === 'block';
            replyList.style.display = isVisible ? 'none' : 'block';
            element.textContent = isVisible ? 'View replies' : 'Hide replies';
        }
    </script>


@endsection
