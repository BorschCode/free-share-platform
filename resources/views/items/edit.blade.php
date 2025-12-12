<x-layouts.bootstrap>
    <x-slot:title>{{ __('Edit Item') }}</x-slot:title>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Edit Item') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $item->title) }}"
                                    required
                                    maxlength="255"
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    required
                                >{{ old('description', $item->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('category') is-invalid @enderror"
                                    id="category"
                                    name="category"
                                    value="{{ old('category', $item->category) }}"
                                    required
                                    maxlength="100"
                                >
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-3">
                                <label for="city" class="form-label">{{ __('City') }} <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('city') is-invalid @enderror"
                                    id="city"
                                    name="city"
                                    value="{{ old('city', $item->city) }}"
                                    required
                                    maxlength="100"
                                >
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Weight -->
                            <div class="mb-3">
                                <label for="weight" class="form-label">{{ __('Weight (kg)') }}</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control @error('weight') is-invalid @enderror"
                                    id="weight"
                                    name="weight"
                                    value="{{ old('weight', $item->weight) }}"
                                >
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dimensions -->
                            <div class="mb-3">
                                <label for="dimensions" class="form-label">{{ __('Dimensions') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('dimensions') is-invalid @enderror"
                                    id="dimensions"
                                    name="dimensions"
                                    value="{{ old('dimensions', $item->dimensions) }}"
                                    maxlength="255"
                                    placeholder="{{ __('e.g., 50x30x20 cm') }}"
                                >
                                @error('dimensions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Photos -->
                            @if($item->hasPhotos())
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Current Photos') }}</label>
                                    <div class="row g-2">
                                        @foreach($item->getAllPhotoUrls() as $photoUrl)
                                            <div class="col-md-3">
                                                <img src="{{ $photoUrl }}" class="img-thumbnail" alt="{{ $item->title }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- New Photos -->
                            <div class="mb-3">
                                <label for="photos" class="form-label">{{ __('Upload New Photos') }}</label>
                                <input
                                    type="file"
                                    class="form-control @error('photos.*') is-invalid @enderror"
                                    id="photos"
                                    name="photos[]"
                                    multiple
                                    accept="image/*"
                                >
                                <div class="form-text">
                                    {{ __('Upload new photos to replace existing ones (max 2MB each)') }}
                                </div>
                                @error('photos.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="{{ App\Enums\ItemStatus::Available->value }}" {{ old('status', $item->status->value) == App\Enums\ItemStatus::Available->value ? 'selected' : '' }}>
                                        {{ __('Available') }}
                                    </option>
                                    <option value="{{ App\Enums\ItemStatus::Gifted->value }}" {{ old('status', $item->status->value) == App\Enums\ItemStatus::Gifted->value ? 'selected' : '' }}>
                                        {{ __('Gifted') }}
                                    </option>
                                    <option value="{{ App\Enums\ItemStatus::Pending->value }}" {{ old('status', $item->status->value) == App\Enums\ItemStatus::Pending->value ? 'selected' : '' }}>
                                        {{ __('Pending') }}
                                    </option>
                                    <option value="{{ App\Enums\ItemStatus::Claimed->value }}" {{ old('status', $item->status->value) == App\Enums\ItemStatus::Claimed->value ? 'selected' : '' }}>
                                        {{ __('Claimed') }}
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Item') }}
                                </button>
                                <a href="{{ route('items.show', $item) }}" class="btn btn-outline-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.bootstrap>
