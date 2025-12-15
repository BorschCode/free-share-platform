<div>
    <!-- Comment Form -->
    @auth
        <div class="mb-4">
            <textarea wire:model.defer="content" class="form-control" rows="3" placeholder="Add a comment..."></textarea>
            @error('content') <div class="text-danger">{{ $message }}</div> @enderror
            <button wire:click="addComment" class="btn btn-primary btn-sm mt-2">Post Comment</button>
        </div>
    @endauth

    <!-- Comments List -->
    @forelse($comments as $comment)
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <strong>{{ $comment->user->name }}</strong>
                    <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                @can('delete', $comment)
                    <button wire:click="deleteComment({{ $comment->id }})"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                @endcan
            </div>
            <p class="mb-0">{{ $comment->content }}</p>
        </div>
    @empty
        <p class="text-muted text-center">No comments yet. Be the first to comment!</p>
    @endforelse
</div>
