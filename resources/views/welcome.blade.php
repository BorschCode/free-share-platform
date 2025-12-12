<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freecycle Listings Platform</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d0f14;
            color: #e5e7eb;
        }

        .header-bg {
            background: radial-gradient(circle at top, #1a1d24, #0d0f14);
        }

        .emoji-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px; /* Larger badge */
            height: 72px; /* Larger badge */
            background: linear-gradient(145deg, #1f2430, #171b23);
            border: 1px solid #2f3644;
            border-radius: 1.25rem;
            font-size: 36px; /* Larger emoji */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
        }
    </style>
</head>

<body class="min-h-screen p-6 md:p-12">

<div class="max-w-6xl mx-auto">

    <header class="header-bg text-center mb-16 p-12 rounded-2xl shadow-xl border border-gray-800">

        <div class="flex justify-center mb-5">
            <span class="emoji-badge">🎁</span>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-gray-100">
            Freecycle Listings Platform
        </h1>

        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
            A simple web application where registered users can give away items for free.
            Others can browse, vote, and comment — creating a lightweight,
            community-driven exchange platform for unused items.
        </p>

    </header>

    <!-- Latest Available Items -->
    <section class="mt-12">
        <h2 class="text-4xl font-bold text-center text-gray-100 mb-10 tracking-tight">
            📦 Latest Available Items
        </h2>

        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div
                        class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <img
                            src="{{ $item->getFirstPhotoUrlOrPlaceholder() }}"
                            alt="{{ $item->title }}"
                            class="w-full h-48 object-cover"
                        >

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-100 mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-400 text-sm mb-4">
                                {{ Str::limit($item->description, 100) }}
                            </p>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded-full">{{ $item->category }}</span>
                                <span
                                    class="px-3 py-1 bg-gray-700 text-gray-300 text-xs rounded-full">{{ $item->city }}</span>
                                <span
                                    class="px-3 py-1 bg-green-600 text-white text-xs rounded-full">{{ $item->status->label() }}</span>
                            </div>

                            <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                                <span>By {{ $item->user->name }}</span>
                                <div class="flex gap-3">
                                    <span>👍 {{ $item->votes->where('vote', 1)->count() }}</span>
                                    <span>💬 {{ $item->comments->count() }}</span>
                                </div>
                            </div>

                            <a
                                href="{{ route('items.show', $item) }}"
                                class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-200"
                            >
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @auth
                <div class="text-center mt-8">
                    <a
                        href="{{ route('items.index') }}"
                        class="inline-block px-6 py-3 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 transition duration-200"
                    >
                        View All Items →
                    </a>
                </div>
            @endauth
        @else
            <div class="text-center p-12 bg-gray-900 rounded-xl border border-gray-800">
                <p class="text-gray-400 text-lg">No items available at the moment. Check back soon!</p>
            </div>
        @endif
    </section>

    <!-- Call to Action (Optional, but good for design) -->
    <div class="text-center mt-16 p-8 bg-gray-900 rounded-xl shadow-inner">
        <!-- Updated CTA button color from green to orange -->
        <a href="{{route('register')}}"
           class="inline-block px-8 py-3 text-lg font-semibold rounded-lg bg-orange-600 text-white shadow-lg hover:bg-orange-700 transition duration-200">
            Get Started Now
        </a>
        <p class="mt-3 text-sm text-gray-500">Join the community and start sharing.</p>
    </div>

    <footer class="text-center mt-16 pt-6 text-gray-600 border-t border-gray-800">
        <!-- UPDATED: Dynamic year using Blade syntax -->
        &copy; {{ date('Y') }} Freecycle Listings Platform. Built with Community.
    </footer>

</div>

</body>
</html>
