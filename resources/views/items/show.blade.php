<x-layouts.bootstrap>
    <x-slot:title>{{ $item->title }}</x-slot:title>

    <div class="container py-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Item Images -->
                @if($item->hasPhotos())
                    <div class="card mb-4">
                        <div id="itemPhotos" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($item->getAllPhotoUrls() as $index => $photoUrl)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $photoUrl }}" class="d-block w-100" alt="{{ $item->title }}"
                                             style="max-height: 500px; object-fit: contain; background-color: #f8f9fa;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($item->getAllPhotoUrls()) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#itemPhotos"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">{{ __('Previous') }}</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#itemPhotos"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">{{ __('Next') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card mb-4">
                        <img src="{{ $item->getFirstPhotoUrlOrPlaceholder() }}" class="card-img-top"
                             alt="{{ $item->title }}"
                             style="max-height: 400px; object-fit: contain; background-color: #f8f9fa;">
                    </div>
                @endif

                <!-- Item Details -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $item->title }}</h5>
                        <span class="badge {{ $item->status->badgeClass() }}">
                            {{ $item->status->label() }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">{{ __('Description') }}</h6>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ $item->description }}</p>

                        <hr>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6>{{ __('Category') }}</h6>
                                <p class="text-muted">{{ $item->category?->name ?? __('Uncategorized') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>{{ __('City') }}</h6>
                                <p class="text-muted">
                                    @if($item->city)
                                        {{ $item->city->name }} ({{ $item->city->postal_code }})
                                    @else
                                        {{ __('No city specified') }}
                                    @endif
                                </p>
                            </div>
                            @if($item->weight)
                                <div class="col-md-6">
                                    <h6>{{ __('Weight') }}</h6>
                                    <p class="text-muted">{{ $item->weight }} kg</p>
                                </div>
                            @endif
                            @if($item->dimensions)
                                <div class="col-md-6">
                                    <h6>{{ __('Dimensions') }}</h6>
                                    <p class="text-muted">{{ $item->dimensions }}</p>
                                </div>
                            @endif
                            @if($item->tags->isNotEmpty())
                                <div class="col-12">
                                    <h6>{{ __('Tags') }}</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($item->tags as $tag)
                                            <span class="badge"
                                                  style="background-color: {{ $tag->color }}; color: #fff;">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Comments Section (Livewire) -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Comments') }}</h5>
                    </div>
                    <div class="card-body">
                        @livewire('items.item-comments', ['item' => $item], key('item-comments-'.$item->id))
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Voting Card (Livewire) -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @livewire('items.item-votes', ['item' => $item], key('item-votes-'.$item->id))
                    </div>
                </div>

                <!-- User Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">{{ __('Posted By') }}</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>{{ $item->user->name }}</strong></p>
                        <p class="text-muted small mb-0">
                            {{ __('Posted') }} {{ $item->created_at->diffForHumans() }}
                        </p>
                        @if($item->created_at != $item->updated_at)
                            <p class="text-muted small mb-0">
                                {{ __('Updated') }} {{ $item->updated_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @can('update', $item)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">{{ __('Actions') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-primary">
                                    {{ __('Edit Item') }}
                                </a>
                                @can('delete', $item)
                                    <form action="{{ route('items.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this item?') }}')">
                                            {{ __('Delete Item') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- Back Button -->
                <div class="mt-3">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary w-100">
                        {{ __('Back to Items') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.bootstrap>
