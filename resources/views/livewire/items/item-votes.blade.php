<div class="text-center">
    <h6 class="mb-3">Vote for this item</h6>
    <div class="d-flex justify-content-center gap-3 mb-3">
        <button wire:click="vote(1)" class="btn {{ $userVote && $userVote->vote === 1 ? 'btn-success' : 'btn-outline-success' }}">
            ↑ {{ $upvotes }}
        </button>

        <button wire:click="vote(-1)" class="btn {{ $userVote && $userVote->vote === -1 ? 'btn-danger' : 'btn-outline-danger' }}">
            ↓ {{ $downvotes }}
        </button>
    </div>
</div>
