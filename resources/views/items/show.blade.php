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
                                        <img src="{{ $photoUrl }}" class="d-block w-100" alt="{{ $item->title }}" style="max-height: 500px; object-fit: contain; background-color: #f8f9fa;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($item->getAllPhotoUrls()) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#itemPhotos" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">{{ __('Previous') }}</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#itemPhotos" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">{{ __('Next') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card mb-4">
                        <img src="{{ $item->getFirstPhotoUrlOrPlaceholder() }}" class="card-img-top" alt="{{ $item->title }}" style="max-height: 400px; object-fit: contain; background-color: #f8f9fa;">
                    </div>
                @endif

                <!-- Item Details -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $item->title }}</h5>
                        <span class="badge {{ $item->status === App\Enums\ItemStatus::Available ? 'bg-success' : 'bg-warning' }}">
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
                                <p class="text-muted">{{ $item->category }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>{{ __('City') }}</h6>
                                <p class="text-muted">{{ $item->city }}</p>
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
                                            <span class="badge" style="background-color: {{ $tag->color }}; color: #fff;">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Comments') }} ({{ $item->comments->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <!-- Comment Form -->
                        <form action="{{ route('items.comments.store', $item) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea
                                    class="form-control @error('content') is-invalid @enderror"
                                    name="content"
                                    rows="3"
                                    placeholder="{{ __('Add a comment...') }}"
                                    required
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Post Comment') }}
                            </button>
                        </form>

                        <!-- Comments List -->
                        @forelse($item->comments()->with('user')->latest()->get() as $comment)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>{{ $comment->user->name }}</strong>
                                        <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    @can('delete', $comment)
                                        <form action="{{ route('items.comments.destroy', [$item, $comment]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-muted text-center">{{ __('No comments yet. Be the first to comment!') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Voting Card -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h6 class="mb-3">{{ __('Vote for this item') }}</h6>
                        @php
                            $userVote = $item->votes->where('user_id', auth()->id())->first();
                            $upvotes = $item->votes->where('vote', 1)->count();
                            $downvotes = $item->votes->where('vote', -1)->count();
                        @endphp

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <!-- Upvote -->
                            <form action="{{ $userVote ? route('items.vote.remove', $item) : route('items.vote', $item) }}" method="POST">
                                @csrf
                                @if($userVote)
                                    @method('DELETE')
                                @else
                                    <input type="hidden" name="vote" value="1">
                                @endif
                                <button type="submit" class="btn {{ $userVote && $userVote->vote === 1 ? 'btn-success' : 'btn-outline-success' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
                                    </svg>
                                    {{ $upvotes }}
                                </button>
                            </form>

                            <!-- Downvote -->
                            <form action="{{ $userVote ? route('items.vote.remove', $item) : route('items.vote', $item) }}" method="POST">
                                @csrf
                                @if($userVote)
                                    @method('DELETE')
                                @else
                                    <input type="hidden" name="vote" value="-1">
                                @endif
                                <button type="submit" class="btn {{ $userVote && $userVote->vote === -1 ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/>
                                    </svg>
                                    {{ $downvotes }}
                                </button>
                            </form>
                        </div>
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
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('{{ __('Are you sure you want to delete this item?') }}')">
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
