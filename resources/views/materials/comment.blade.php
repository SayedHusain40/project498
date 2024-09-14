@foreach ($replies as $reply)
    <div class="comment reply" data-comment-id="{{ $reply->id }}">
        <div class="d-flex">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" class="comment-avatar">
            <div class="w-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="comment-author">
                            {{ $reply->user_id === auth()->id() ? 'You' : $reply->user->name }}
                        </div>
                        <div class="comment-time">{{ $reply->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $reply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $reply->id }}">
                            @if ($reply->user_id === auth()->id())
                                <li><a class="dropdown-item" href="#" data-action="edit"
                                        data-comment-id="{{ $reply->id }}">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#" data-action="delete"
                                        data-comment-id="{{ $reply->id }}">Delete</a></li>
                            @endif
                            <li>
                                <a href="#" class="dropdown-item report-comment"
                                    data-comment-id="{{ $reply->id }}" data-bs-toggle="modal"
                                    data-bs-target="#reportModal">Report</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="comment-body">
                    @if ($reply->parent)
                        <a href="#" class="reply-mention">{{ '@' . $reply->parent->user->name }}</a>
                    @endif
                    <span class="reply-content">{{ $reply->content }}</span>
                </div>
                <div class="comment-actions">
                    <a href="#"
                        class="like-button {{ $reply->likes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                        data-action="like" data-comment-id="{{ $reply->id }}">
                        <i class="fa-solid fa-thumbs-up"></i>
                        <span class="like-dislike-count">{{ $reply->likes }}</span>
                    </a>
                    <a href="#"
                        class="dislike-button {{ $reply->dislikes()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                        data-action="dislike" data-comment-id="{{ $reply->id }}">
                        <i class="fa-solid fa-thumbs-down"></i>
                        <span class="like-dislike-count">{{ $reply->dislikes }}</span>
                    </a>
                    <a href="#" class="reply-link" data-comment-id="{{ $reply->id }}"
                        data-author="{{ $reply->user->name }}">
                        <i class="fa-solid fa-reply"></i> Reply
                    </a>
                </div>
                <form class="reply-form" action="{{ route('replies.store', $reply) }}" method="POST">
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
                <div id="edit-comment-template" style="display: none;">
                    <div class="edit-comment-form">
                        <textarea class="form-control edit-comment-input" rows="3"></textarea>
                        <div class="text-end mt-2">
                            <button type="button" class="btn btn-primary save-edit-button">Save</button>
                            <button type="button" class="btn btn-secondary cancel-edit-button">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('materials.comment', ['replies' => $reply->replies])
@endforeach
