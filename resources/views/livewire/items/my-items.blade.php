<div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>{{ __('My Items') }}</h2>
                <a href="{{ route('items.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    {{ __('Create New Item') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Filter Items') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                placeholder="{{ __('Search by title or description...') }}"
                                wire:model.live.debounce.300ms="search"
                            >
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select class="form-select" id="status" wire:model.live="status">
                                <option value="">{{ __('All Statuses') }}</option>
                                @foreach($statuses as $statusOption)
                                    <option value="{{ $statusOption->value }}">{{ $statusOption->label() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="col-md-4">
                            <label for="sort" class="form-label">{{ __('Sort By') }}</label>
                            <select class="form-select" id="sort" wire:model.live="sort">
                                <option value="newest">{{ __('Newest First') }}</option>
                                <option value="oldest">{{ __('Oldest First') }}</option>
                                <option value="upvotes">{{ __('Most Upvoted') }}</option>
                            </select>
                        </div>

                        <!-- Reset Filters -->
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-secondary" wire:click="resetFilters">
                                {{ __('Reset Filters') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Grid -->
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-6 col-lg-4" wire:key="item-{{ $item->id }}">
                <div class="card h-100">
                    <img
                        src="{{ $item->getFirstPhotoUrlOrPlaceholder() }}"
                        class="card-img-top"
                        alt="{{ $item->title }}"
                        style="height: 200px; object-fit: cover;"
                    >

                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($item->description, 80) }}
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-info">{{ $item->category }}</span>
                            <span class="badge bg-secondary">{{ $item->city }}</span>
                        </div>

                        <!-- Status Management -->
                        <div class="mb-3">
                            <label class="form-label small">{{ __('Status') }}</label>
                            <select
                                class="form-select form-select-sm"
                                wire:change="updateStatus({{ $item->id }}, $event.target.value)"
                            >
                                @foreach($statuses as $statusOption)
                                    <option
                                        value="{{ $statusOption->value }}"
                                        {{ $item->status === $statusOption ? 'selected' : '' }}
                                    >
                                        {{ $statusOption->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">
                                {{ $item->created_at->diffForHumans() }}
                            </small>
                            <div>
                                <span class="badge bg-light text-dark me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
                                    </svg>
                                    {{ $item->votes->where('vote', 1)->count() }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                    </svg>
                                    {{ $item->comments->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-primary">
                                {{ __('View Details') }}
                            </a>
                            <div class="btn-group" role="group">
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-secondary">
                                    {{ __('Edit') }}
                                </a>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    wire:click="deleteItem({{ $item->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this item?') }}"
                                >
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    {{ __('You have not created any items yet.') }}
                    <a href="{{ route('items.create') }}">{{ __('Create your first item') }}</a>.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif
</div>

@script
<script>
    $wire.on('success', (event) => {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '11';
        toast.innerHTML = `
            <div class="toast show align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${event.message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });

    $wire.on('error', (event) => {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '11';
        toast.innerHTML = `
            <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${event.message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });
</script>
@endscript
