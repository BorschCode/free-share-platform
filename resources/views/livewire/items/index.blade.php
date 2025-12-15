<div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Filter Items') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                placeholder="{{ __('Search by title or description...') }}"
                                wire:model.live.debounce.300ms="search"
                            >
                        </div>

                        <div class="col-md-6">
                            <label for="sort" class="form-label">{{ __('Sort By') }}</label>
                            <select class="form-select" id="sort" wire:model.live="sort">
                                <option value="newest">{{ __('Newest First') }}</option>
                                <option value="upvotes">{{ __('Most Upvoted') }}</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <select class="form-select" id="category" wire:model.live="category">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categoryOptions as $cat) // <-- Corrected
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="form-label">{{ __('City') }}</label>
                            <select class="form-select" id="city" wire:model.live="city">
                                <option value="">{{ __('All Cities') }}</option>
                                @foreach($cityOptions as $cityOption) // <-- Corrected
                                <option value="{{ $cityOption->id }}">{{ $cityOption->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select class="form-select" id="status" wire:model.live="status">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="{{ App\Enums\ItemStatus::Available->value }}">{{ __('Available') }}</option>
                                <option value="{{ App\Enums\ItemStatus::Gifted->value }}">{{ __('Gifted') }}</option>
                            </select>
                        </div>

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
                            {{ Str::limit($item->description, 100) }}
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @if($item->category)
                                <span class="badge bg-info">{{ $item->category->name }}</span>
                            @endif
                            @if($item->city)
                                <span class="badge bg-secondary">{{ $item->city->name }}</span>
                            @endif
                            <span class="badge {{ $item->status === App\Enums\ItemStatus::Available ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->status->label() }}
                            </span>
                        </div>

                        @if(isset($item->tags) && $item->tags->isNotEmpty())
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                @foreach($item->tags as $tag)
                                    <span class="badge" style="background-color: {{ $tag->color ?? '#6c757d' }}; color: #fff;">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                {{ __('By') }} {{ $item->user->name }}
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
                        <a href="{{ route('items.show', $item) }}" class="btn btn-primary btn-sm w-100">
                            {{ __('View Details') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    {{ __('No items found. Try adjusting your filters or') }}
                    <a href="{{ route('items.create') }}">{{ __('create a new item') }}</a>.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>
</div>
