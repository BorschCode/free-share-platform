<x-layouts.bootstrap>
    <x-slot:title>{{ __('Create New Item') }}</x-slot:title>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Create New Item') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
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
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id"
                                    name="category_id"
                                    required
                                >
                                    <option value="">{{ __('Select a category') }}</option>
                                    @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->children as $child)
                                                <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-3">
                                <label for="city_id" class="form-label">{{ __('City') }} <span class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('city_id') is-invalid @enderror"
                                    id="city_id"
                                    name="city_id"
                                    required
                                >
                                    <option value="">{{ __('Select a city') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }} ({{ $city->postal_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
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
                                    value="{{ old('weight') }}"
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
                                    value="{{ old('dimensions') }}"
                                    maxlength="255"
                                    placeholder="{{ __('e.g., 50x30x20 cm') }}"
                                >
                                @error('dimensions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('Tags') }}</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="tags[]"
                                                value="{{ $tag->id }}"
                                                id="tag-{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="tag-{{ $tag->id }}">
                                                <span class="badge" style="background-color: {{ $tag->color }}; color: #fff;">
                                                    {{ $tag->name }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('tags')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photos -->
                            <div class="mb-3">
                                <label for="photos" class="form-label">{{ __('Photos') }}</label>
                                <input
                                    type="file"
                                    class="form-control @error('photos.*') is-invalid @enderror"
                                    id="photos"
                                    name="photos[]"
                                    multiple
                                    accept="image/*"
                                >
                                <div class="form-text">{{ __('You can upload multiple photos (max 2MB each)') }}</div>
                                @error('photos.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Item') }}
                                </button>
                                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
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
