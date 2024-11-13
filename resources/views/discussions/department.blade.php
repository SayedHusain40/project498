@extends('new_layouts.app')

@section('styles')
    <style>
        .btn.active {
            background-color: #007bff;
            color: white;
        }

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

        .question {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .question-section {
            border: 1px solid #e9ebee;
            border-radius: 1rem;
            padding: 1.5rem;
            background-color: #ffffff;
        }

        .question-header {
            border-bottom: 1px solid #e9ebee;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
        }

        .question-avatar {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .question-author {
            font-size: 1rem;
            font-weight: 600;
        }

        .question-time {
            font-size: 0.875rem;
            color: #90949c;
        }

        .question-body {
            margin: 0.75rem 0;
            font-size: 1rem;
        }

        .question-actions a {
            font-size: 0.875rem;
            color: #4267b2;
            text-decoration: none;
            margin-right: 1rem;
            []
        }

        .question-actions i {
            margin-right: 0.5rem;
        }

        .reply {
            border-left: 1px solid #8080806b;
            padding-left: 1rem;
            margin-top: 1rem;
        }

        .reply-list {
            margin-top: 1rem;
            padding-left: 2rem;
            display: none;
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

        .question-input {
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
            <h2>{{ $department->name }} Discussions</h2>
        </div>
        <div class="mt-4 question-section">
            <h3>Questions ( {{ $questions->count() }} )</h3>
            <div class="question-body">
                <div class="d-flex mb-3">
                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"
                        class="question-avatar">
                    <div class="w-100">
                        <textarea id="question-input" class="form-control question-input" placeholder="Write a question..." rows="3"></textarea>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="text-danger" id="error-message"></div>
                            @if (auth()->check())
                                <button type="button" onclick="postQuestion()" id="post-question-btn"
                                    class="btn btn-primary">Post Your Question</button>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#loginSignupModal">Post Your Question</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div id="question-list" class="question-list">
                    @foreach ($questions as $question)
                        <div class="question" data-question-id="{{ $question->id }}">
                            <div class="d-flex">
                                <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"
                                    class="question-avatar">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="question-author">{{ $question->user->name }}</div>
                                            <div class="question-time">{{ $question->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="question-actions">
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $question->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">...</button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $question->id }}">
                                                    @if (Auth::check() && Auth::user()->id === $question->user_id)
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="editQuestion({{ $question->id }})">Edit</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="confirmDeleteQuestion({{ $question->id }})">Delete</button>
                                                        </li>
                                                    @endif
                                                    @if (auth()->check())
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#reportModal"
                                                            onclick="setReportData('question', {{ $question->id }})">Report</button>
                                                    @else
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#loginSignupModal"
                                                            onclick="setReportData('question', {{ $question->id }})">Report</button>
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="question-body">{{ $question->content }}</div>
                                    <div class="question-actions d-flex align-items-center mt-2">
                                        @if (auth()->check())
                                            <button href="#"
                                                class="btn btn-light me-2 btn-like {{ $question->likesDislikes()->where('user_id', auth()->user()->id)->where('type', 'like')->exists()? 'text-success': '' }}"
                                                onclick="toggleLike({{ $question->id }})">
                                                <i class="fa fa-thumbs-up"></i> <span
                                                    class="like-count">{{ $question->likes }}</span>
                                            </button>
                                            <button href="#"
                                                class="btn btn-light me-2 btn-dislike {{ $question->likesDislikes()->where('user_id', auth()->user()->id)->where('type', 'dislike')->exists()? 'text-danger': '' }}"
                                                onclick="toggleDislike({{ $question->id }})">
                                                <i class="fa fa-thumbs-down"></i> <span
                                                    class="dislike-count">{{ $question->dislikes }}</span>
                                            </button>
                                        @else
                                            <button class="btn btn-light me-2" data-bs-toggle="modal"
                                                data-bs-target="#loginSignupModal">
                                                <i class="fa fa-thumbs-up"></i> <span
                                                    class="like-count">{{ $question->likes }}</span>
                                            </button>
                                            <button class="btn btn-light me-2" data-bs-toggle="modal"
                                                data-bs-target="#loginSignupModal">
                                                <i class="fa fa-thumbs-down"></i> <span
                                                    class="dislike-count">{{ $question->dislikes }}</span>
                                            </button>
                                        @endif
                                        @if (auth()->check())
                                            <button class="btn btn-light"
                                                onclick="toggleReplyForm({{ $question->id }})">Reply<i
                                                    class="fa-solid fa-reply ms-2"></i></button>
                                        @else
                                            <button class="btn btn-light" data-bs-toggle="modal"
                                                data-bs-target="#loginSignupModal">Reply<i
                                                    class="fa-solid fa-reply ms-2"></i></button>
                                        @endif

                                    </div>
                                    <div class="reply-toggle" onclick="toggleReplyList({{ $question->id }})">View
                                        {{ $question->replyCount() }} Replies</div>
                                    <div class="reply-list" id="reply-list-{{ $question->id }}">
                                        @foreach ($question->replies as $reply)
                                            <div class="question reply" data-question-id="{{ $reply->id }}">
                                                <div class="d-flex">
                                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                        alt="avatar" class="question-avatar">
                                                    <div class="w-100">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div class="question-author">{{ $reply->user->name }}</div>
                                                                <div class="question-time">
                                                                    {{ $reply->created_at->diffForHumans() }}</div>
                                                            </div>
                                                            <div class="question-actions">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-light dropdown-toggle"
                                                                        type="button"
                                                                        id="dropdownMenuButtonReply{{ $reply->id }}"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">...</button>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="dropdownMenuButtonReply{{ $reply->id }}">
                                                                        @if (Auth::check() && Auth::user()->id === $reply->user_id)
                                                                            <li>
                                                                                <button class="dropdown-item"
                                                                                    onclick="editReply({{ $question->id }}, {{ $reply->id }})">Edit</button>
                                                                            </li>
                                                                            <li>
                                                                                <button class="dropdown-item"
                                                                                    onclick="confirmDeleteReply({{ $reply->id }})">Delete</button>
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            @if (auth()->check())
                                                                                <button class="dropdown-item"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#reportModal"
                                                                                    onclick="setReportData('reply', {{ $reply->id }})">Report</button>
                                                                            @else
                                                                                <button class="dropdown-item"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#loginSignupModal">Report</button>
                                                                            @endif

                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-body">{{ $reply->content }}</div>
                                                        <div class="question-actions d-flex align-items-center mt-2">
                                                            @if (auth()->check())
                                                                <button
                                                                    class="btn btn-light me-2 btn-like {{ $reply->likesDislikes()->where('user_id', auth()->user()->id)->where('type', 'like')->exists()? 'text-success': '' }}"
                                                                    onclick="toggleReplyLike({{ $reply->id }})">
                                                                    <i class="fa fa-thumbs-up"></i> <span
                                                                        class="like-count">{{ $reply->likes }}</span>
                                                                </button>
                                                                <!-- Dislike Button -->
                                                                <button
                                                                    class="btn btn-light me-2 btn-dislike {{ $reply->likesDislikes()->where('user_id', auth()->user()->id)->where('type', 'dislike')->exists()? 'text-danger': '' }}"
                                                                    onclick="toggleReplyDislike({{ $reply->id }})">
                                                                    <i class="fa fa-thumbs-down"></i> <span
                                                                        class="dislike-count">{{ $reply->dislikes }}</span>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-light me-2" data-bs-toggle="modal"
                                                                    data-bs-target="#loginSignupModal"><i
                                                                        class="fa fa-thumbs-up"></i> <span
                                                                        class="like-count">{{ $reply->likes }}</span></button>
                                                                <button class="btn btn-light me-2" data-bs-toggle="modal"
                                                                    data-bs-target="#loginSignupModal"><i
                                                                        class="fa fa-thumbs-down"></i> <span
                                                                        class="dislike-count">{{ $reply->dislikes }}</span></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="reply-form" id="reply-form-{{ $question->id }}" style="display: none;">
                                        <div class="d-flex">
                                            <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                alt="avatar" class="question-avatar">
                                            <div class="w-100">
                                                <textarea class="form-control question-input" placeholder="Write a reply..." rows="2"></textarea>
                                                @if (auth()->check())
                                                    <button type="button" class="btn btn-primary mt-2"
                                                        onclick="postReply({{ $question->id }})">Post Reply</button>
                                                @else
                                                    <button type="button" class="btn btn-primary mt-2"
                                                        data-bs-toggle="modal" data-bs-target="#loginSignupModal">Post
                                                        Reply</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <!-- Delete Question Confirmation Modal -->
    <div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-labelledby="deleteQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-triangle-exclamation modal-icon"></i>
                    </div>
                    <h5 class="modal-title" id="deleteQuestionModalLabel">Delete Question</h5>
                    <p>Are you sure you want to delete this question?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger ms-2" id="confirmDeleteQuestionButton">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Reply Confirmation Modal -->
    <div class="modal fade" id="deleteReplyModal" tabindex="-1" aria-labelledby="deleteReplyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-triangle-exclamation modal-icon"></i>
                    </div>
                    <h5 class="modal-title" id="deleteReplyModalLabel">Delete Reply</h5>
                    <p>Are you sure you want to delete this reply?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger ms-2" id="confirmDeleteReplyButton">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fa-solid fa-flag modal-icon"></i>
                    </div>
                    <h5 class="modal-title" id="reportModalLabel">Report Content</h5>
                    <p>Please enter your reason for reporting this content:</p>
                    <textarea id="reportReason" class="form-control mt-3" placeholder="Enter your reason here..." rows="3"></textarea>
                    <div id="reportError" class="text-danger mt-2" style="display: none;"></div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="submitReportButton">Submit Report</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login/Signup Modal -->
    <div class="modal fade" id="loginSignupModal" tabindex="-1" aria-labelledby="loginSignupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginSignupModalLabel">Login or Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>You need to be logged in to perform this action.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleReplyList(questionId) {
            const replyList = document.getElementById(`reply-list-${questionId}`);
            replyList.style.display = replyList.style.display === 'none' || replyList.style.display === '' ? 'block' :
                'none';
        }

        function postQuestion() {
            const content = document.getElementById('question-input').value.trim();
            const departmentId = {{ $department->id }};

            // Clear previous error message
            const errorMessageElem = document.getElementById('error-message');
            errorMessageElem.textContent = '';

            if (!content) {
                errorMessageElem.textContent = 'Question content cannot be empty.';
                return; // exit
            }

            fetch('/departments/questions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        content: content,
                        department_id: departmentId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('question-input').value = '';

                        const newQuestionElement = document.createElement('div');
                        newQuestionElement.innerHTML = `
                            <div class="question" data-question-id="${data.question.id}">
                                <div class="d-flex">
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="question-avatar">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="question-author">${data.question.user.name}</div>
                                                <div class="question-time">Just Now</div>
                                            </div>
                                            <div class="question-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton${data.question.id}" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data.question.id}">
                                                        <li><button class="dropdown-item" href="#" onclick="editQuestion(${data.question.id}, '${data.question.content}')">Edit</button></li>
                                                        <li><button class="dropdown-item" onclick="confirmDeleteQuestion(${data.question.id})">Delete</button></li>
                                                        <li><button class="dropdown-item" href="#" onclick="openReportModal('question', ${data.question.id})">Report</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question-body">${data.question.content}</div>
                                        <div class="question-actions d-flex align-items-center mt-2">
                                            <button class="btn btn-light me-2 btn-like ${data.question.likedByUser ? 'text-success' : ''}" 
                                                    onclick="toggleLike(${data.question.id})">
                                                <i class="fa fa-thumbs-up"></i> <span class="like-count">0</span>
                                            </button>
                                            <button class="btn btn-light me-2 btn-dislike ${data.question.dislikedByUser ? 'text-danger' : ''}" 
                                                    onclick="toggleDislike(${data.question.id})">
                                                <i class="fa fa-thumbs-down"></i> <span class="dislike-count">0</span>
                                            </button>
                                            <button class="btn btn-light" onclick="toggleReplyForm(${data.question.id})">Reply</button>
                                        </div>
                                        <div class="reply-toggle" onclick="toggleReplyList(${data.question.id})">View Replies</div>
                                        <div class="reply-list" id="reply-list-${data.question.id}" style="display: none;"></div>
                                        <div class="reply-form" id="reply-form-${data.question.id}" style="display: none;">
                                            <div class="d-flex">
                                                <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="question-avatar">
                                                <div class="w-100">
                                                    <textarea class="form-control question-input" placeholder="Write a reply..." rows="2"></textarea>
                                                    <button type="button" class="btn btn-primary mt-2" onclick="postReply(${data.question.id})">Post Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        document.getElementById('question-list').prepend(newQuestionElement);
                    }
                })
                .catch(error => {
                    console.error('Error posting question:', error);
                    errorMessageElem.textContent = error.message;
                });
        }

        function toggleReplyForm(questionId) {
            const replyForm = document.getElementById(`reply-form-${questionId}`);
            replyForm.style.display = replyForm.style.display === 'none' || replyForm.style.display === '' ? 'block' :
                'none';
        }

        function postReply(questionId) {
            const replyInput = document.querySelector(`#reply-form-${questionId} textarea`);
            const content = replyInput.value.trim();

            const existingErrorMessageElem = document.querySelector(`#reply-form-${questionId} .reply-error-message`);
            if (existingErrorMessageElem) {
                existingErrorMessageElem.remove();
            }

            if (!content) {
                const replyErrorMessageElem = document.createElement(
                    'div');
                replyErrorMessageElem.classList.add('text-danger', 'reply-error-message');
                replyErrorMessageElem.textContent = 'Reply content cannot be empty.';

                replyInput.parentNode.insertBefore(replyErrorMessageElem, replyInput.nextSibling);
                return;
            }

            fetch(`/departments/questions/${questionId}/replies`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        content: content,
                        question_id: questionId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        replyInput.value = '';

                        if (existingErrorMessageElem) {
                            existingErrorMessageElem.remove();
                        }

                        const newReplyElement = document.createElement('div');
                        newReplyElement.innerHTML = `
                            <div class="question reply" data-question-id="${data.reply.id}">
                                <div class="d-flex">
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="question-avatar">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="question-author">${data.reply.user.name}</div>
                                                <div class="question-time">Just Now</div>
                                            </div>
                                            <div class="question-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButtonReply${data.reply.id}" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonReply${data.reply.id}">
                                                        <li><button class="dropdown-item" href="#" onclick="editReply(${questionId}, ${data.reply.id}, '${data.reply.content}')">Edit</button></li>
                                                        <li><button class="dropdown-item" onclick="confirmDeleteReply(${data.reply.id})">Delete</button></li>
                                                        <li><button class="dropdown-item" href="#" onclick="openReportModal('reply', ${data.reply.id})">Report</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question-body">${data.reply.content}</div>
                                        <div class="question-actions d-flex align-items-center mt-2">
                                            <button class="btn btn-light me-2 btn-like ${data.reply.likedByUser ? 'text-success' : ''}" 
                                                    onclick="toggleReplyLike(${data.reply.id})">
                                                <i class="fa fa-thumbs-up"></i> <span class="like-count">0</span>
                                            </button>
                                            <button class="btn btn-light me-2 btn-dislike ${data.reply.dislikedByUser ? 'text-danger' : ''}" 
                                                    onclick="toggleReplyDislike(${data.reply.id})">
                                                <i class="fa fa-thumbs-down"></i> <span class="dislike-count">0</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;


                        const replyList = document.querySelector(`#reply-list-${questionId}`);
                        replyList.appendChild(newReplyElement);

                        if (replyList.style.display === 'none') {
                            replyList.style.display = 'block';
                        }

                        document.getElementById(`reply-form-${questionId}`).style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error posting reply:', error);
                    const replyErrorMessageElem = document.createElement('div');
                    replyErrorMessageElem.classList.add('text-danger', 'reply-error-message');
                    replyErrorMessageElem.textContent = error.message;
                    replyInput.parentNode.insertBefore(replyErrorMessageElem, replyInput
                        .nextSibling);
                });
        }

        function editQuestion(questionId) {
            const questionElement = document.querySelector(`[data-question-id="${questionId}"] .question-body`);
            const originalContent = questionElement.textContent.trim();

            questionElement.innerHTML = `
                <textarea class="form-control question-edit-input" rows="3">${originalContent}</textarea>
                <div class="text-danger mt-1" id="error-message-${questionId}"></div>
                <div class="d-flex mt-2">
                    <button type="button" class="btn btn-primary me-2" onclick="saveQuestionEdit(${questionId})">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="cancelEditQuestion(${questionId}, '${originalContent}')">Cancel</button>
                </div>
            `;
        }

        function saveQuestionEdit(questionId) {
            const editInput = document.querySelector(`[data-question-id="${questionId}"] .question-edit-input`);
            const errorMessageElem = document.getElementById(`error-message-${questionId}`);
            const content = editInput.value.trim();

            if (!content) {
                errorMessageElem.textContent = 'Question content cannot be empty.';
                return;
            }

            // Clear error message
            errorMessageElem.textContent = '';

            fetch(`/departments/questions/${questionId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        content
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const questionElement = document.querySelector(
                            `[data-question-id="${questionId}"] .question-body`);
                        questionElement.innerHTML = content;
                    }
                })
                .catch(error => console.error('Error updating question:', error));
        }

        function cancelEditQuestion(questionId, originalContent) {
            const questionElement = document.querySelector(`[data-question-id="${questionId}"] .question-body`);
            questionElement.innerHTML = originalContent;
        }

        function editReply(questionId, replyId) {
            const replyElement = document.querySelector(`[data-question-id="${replyId}"] .question-body`);
            const originalContent = replyElement.textContent.trim();

            replyElement.innerHTML = `
                <textarea class="form-control reply-edit-input" rows="2">${originalContent}</textarea>
                <div class="text-danger mt-1" id="reply-error-message-${replyId}"></div>
                    <div class="d-flex mt-2">
                        <button type="button" class="btn btn-primary me-2" onclick="saveReplyEdit(${questionId}, ${replyId})">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEditReply(${replyId}, '${originalContent}')">Cancel</button>
                    </div>
                `;
        }

        function saveReplyEdit(questionId, replyId) {
            const editInput = document.querySelector(`[data-question-id="${replyId}"] .reply-edit-input`);
            const errorMessageElem = document.getElementById(`reply-error-message-${replyId}`);
            const content = editInput.value.trim();

            if (!content) {
                errorMessageElem.textContent = 'Reply content cannot be empty.';
                return;
            }

            errorMessageElem.textContent = '';

            fetch(`/departments/questions/${questionId}/replies/${replyId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        content
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const replyElement = document.querySelector(`[data-question-id="${replyId}"] .question-body`);
                        replyElement.innerHTML = content;
                    }
                })
                .catch(error => console.error('Error updating reply:', error));
        }

        function cancelEditReply(replyId, originalContent) {
            const replyElement = document.querySelector(`[data-question-id="${replyId}"] .question-body`);
            replyElement.innerHTML = originalContent;
        }
    </script>

    <script>
        function toggleLike(questionId) {
            fetch(`/questions/${questionId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`[data-question-id="${questionId}"] .btn-like`);
                    const dislikeButton = document.querySelector(`[data-question-id="${questionId}"] .btn-dislike`);
                    const likeCount = document.querySelector(`[data-question-id="${questionId}"] .like-count`);
                    const dislikeCount = document.querySelector(`[data-question-id="${questionId}"] .dislike-count`);

                    likeCount.textContent = data.likes;
                    dislikeCount.textContent = data.dislikes;

                    // Toggle the green color for like
                    if (likeButton.classList.contains('text-success')) {
                        likeButton.classList.remove('text-success'); // Remove green if already active
                    } else {
                        likeButton.classList.add('text-success'); // Add green if not active
                    }

                    // If dislike button is active, remove red
                    if (dislikeButton.classList.contains('text-danger')) {
                        dislikeButton.classList.remove('text-danger');
                    }
                });
        }

        function toggleDislike(questionId) {
            fetch(`/questions/${questionId}/dislike`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`[data-question-id="${questionId}"] .btn-like`);
                    const dislikeButton = document.querySelector(`[data-question-id="${questionId}"] .btn-dislike`);
                    const likeCount = document.querySelector(`[data-question-id="${questionId}"] .like-count`);
                    const dislikeCount = document.querySelector(`[data-question-id="${questionId}"] .dislike-count`);

                    likeCount.textContent = data.likes;
                    dislikeCount.textContent = data.dislikes;

                    // Toggle the red color for dislike
                    if (dislikeButton.classList.contains('text-danger')) {
                        dislikeButton.classList.remove('text-danger'); // Remove red if already active
                    } else {
                        dislikeButton.classList.add('text-danger'); // Add red if not active
                    }

                    // If like button is active, remove green
                    if (likeButton.classList.contains('text-success')) {
                        likeButton.classList.remove('text-success');
                    }
                });
        }


        function toggleReplyLike(replyId) {
            fetch(`/replies/${replyId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`[data-question-id="${replyId}"] .btn-like`);
                    const dislikeButton = document.querySelector(`[data-question-id="${replyId}"] .btn-dislike`);
                    const likeCount = document.querySelector(`[data-question-id="${replyId}"] .like-count`);
                    const dislikeCount = document.querySelector(`[data-question-id="${replyId}"] .dislike-count`);

                    likeCount.textContent = data.likes;
                    dislikeCount.textContent = data.dislikes;

                    // Toggle the green color for like
                    if (likeButton.classList.contains('text-success')) {
                        likeButton.classList.remove('text-success'); // Remove green if already active
                    } else {
                        likeButton.classList.add('text-success'); // Add green if not active
                    }

                    // If dislike button is active, remove red
                    if (dislikeButton.classList.contains('text-danger')) {
                        dislikeButton.classList.remove('text-danger');
                    }
                });
        }

        function toggleReplyDislike(replyId) {
            fetch(`/replies/${replyId}/dislike`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`[data-question-id="${replyId}"] .btn-like`);
                    const dislikeButton = document.querySelector(`[data-question-id="${replyId}"] .btn-dislike`);
                    const likeCount = document.querySelector(`[data-question-id="${replyId}"] .like-count`);
                    const dislikeCount = document.querySelector(`[data-question-id="${replyId}"] .dislike-count`);

                    likeCount.textContent = data.likes;
                    dislikeCount.textContent = data.dislikes;

                    // Toggle the red color for dislike
                    if (dislikeButton.classList.contains('text-danger')) {
                        dislikeButton.classList.remove('text-danger'); // Remove red if already active
                    } else {
                        dislikeButton.classList.add('text-danger'); // Add red if not active
                    }

                    // If like button is active, remove green
                    if (likeButton.classList.contains('text-success')) {
                        likeButton.classList.remove('text-success');
                    }
                });
        }
    </script>

    <script>
        let questionIdToDelete = null;
        let replyIdToDelete = null;

        function confirmDeleteQuestion(questionId) {
            questionIdToDelete = questionId;
            const deleteQuestionModal = new bootstrap.Modal(document.getElementById('deleteQuestionModal'));
            deleteQuestionModal.show(); // Show the modal
        }

        function confirmDeleteReply(replyId) {
            replyIdToDelete = replyId;
            const deleteReplyModal = new bootstrap.Modal(document.getElementById('deleteReplyModal'));
            deleteReplyModal.show(); // Show the modal
        }

        document.getElementById('confirmDeleteQuestionButton').addEventListener('click', function() {
            fetch(`/questions/${questionIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-question-id="${questionIdToDelete}"]`)
                            .remove(); // Remove the question 
                    }
                    const deleteQuestionModal = bootstrap.Modal.getInstance(document.getElementById(
                        'deleteQuestionModal'));
                    deleteQuestionModal.hide(); // Hide the modal
                });
        });

        document.getElementById('confirmDeleteReplyButton').addEventListener('click', function() {
            fetch(`/replies/${replyIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-question-id="${replyIdToDelete}"]`)
                            .remove(); // Remove the reply 
                    }
                    const deleteReplyModal = bootstrap.Modal.getInstance(document.getElementById(
                        'deleteReplyModal'));
                    deleteReplyModal.hide(); // Hide the modal
                });
        });
    </script>
    <script>
        let reportType;
        let reportId;

        function openReportModal(type, id) {
            reportType = type;
            reportId = id;
            // Clear any previous error messages
            document.getElementById('reportError').style.display = 'none';
            document.getElementById('reportError').textContent = '';

            const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
            reportModal.show();
        }

        document.getElementById('submitReportButton').addEventListener('click', function() {
            const reason = document.getElementById('reportReason').value;
            const reportError = document.getElementById('reportError');

            reportError.style.display = 'none';
            reportError.textContent = '';

            if (reason.trim() === '') {
                reportError.style.display = 'block';
                reportError.textContent = 'Please enter a reason for reporting.';
                return;
            }

            fetch('/report', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        type: reportType,
                        id: reportId,
                        reason: reason
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const reportModal = bootstrap.Modal.getInstance(document.getElementById('reportModal'));
                        reportModal.hide();
                    } else {
                        reportError.style.display = 'block';
                        reportError.textContent = 'Failed to submit report.';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
