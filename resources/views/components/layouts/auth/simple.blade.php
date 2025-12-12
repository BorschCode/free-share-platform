<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="bg-light">
    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <h3 class="text-primary mb-0">{{ config('app.name', 'Laravel') }}</h3>
                    </a>
                </div>

                <div class="card shadow">
                    <div class="card-body p-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
