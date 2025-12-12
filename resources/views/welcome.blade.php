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
            width: 72px;          /* Larger badge */
            height: 72px;         /* Larger badge */
            background: linear-gradient(145deg, #1f2430, #171b23);
            border: 1px solid #2f3644;
            border-radius: 1.25rem;
            font-size: 36px;      /* Larger emoji */
            box-shadow: 0 8px 20px rgba(0,0,0,0.35);
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


    <!-- Features Section -->
    <section class="mt-12">
        <h2 class="text-4xl font-bold text-center text-gray-100 mb-10 tracking-tight">
            ✨ Key Features
        </h2>

        <!-- Grid for Feature Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Feature 1: Authentication -->
            <div class="feature-card p-8">
                <div class="text-4xl feature-icon mb-4">🔐</div>
                <!-- Updated feature title color to match the new scheme (e.g., orange-400) -->
                <h3 class="text-2xl font-bold text-orange-400 mb-3 border-b border-gray-700 pb-2">Authentication</h3>
                <p class="text-gray-400">Secure access and control over content.</p>
                <ul class="mt-4 space-y-2 text-gray-300 ml-4 list-disc list-inside">
                    <li>Only registered users can access the main application.</li>
                    <li>Guests are guided to log in or register immediately.</li>
                </ul>
            </div>

            <!-- Feature 2: Item Listings -->
            <div class="feature-card p-8">
                <div class="text-4xl feature-icon mb-4">📦</div>
                <h3 class="text-2xl font-bold text-orange-400 mb-3 border-b border-gray-700 pb-2">Item Listings & Management</h3>

                <p class="text-gray-400 font-semibold mt-4">Each item includes:</p>
                <ul class="mt-2 space-y-1 text-gray-300 ml-4 list-disc list-inside">
                    <li>Title, description, category, and city.</li>
                    <li>Optional: Weight & dimensions.</li>
                    <li>One or more photos.</li>
                    <li>Status: <span class="text-green-500 font-bold">available</span> or <span class="text-red-500 font-bold">gifted</span>.</li>
                </ul>

                <p class="text-gray-400 font-semibold mt-4">Users can:</p>
                <ul class="mt-2 space-y-1 text-gray-300 ml-4 list-disc list-inside">
                    <li>Create new listings easily.</li>
                    <li>Edit their own posts.</li>
                    <li>Mark items as *gifted* upon exchange.</li>
                </ul>
            </div>

            <!-- Feature 3: Browsing & Filtering -->
            <div class="feature-card p-8">
                <div class="text-4xl feature-icon mb-4">🔍</div>
                <h3 class="text-2xl font-bold text-orange-400 mb-3 border-b border-gray-700 pb-2">Browsing & Filtering</h3>
                <p class="text-gray-400">Find exactly what you need, fast.</p>
                <ul class="mt-4 space-y-2 text-gray-300 ml-4 list-disc list-inside">
                    <li>Paginated item list with thumbnails.</li>
                    <li>Filter by category, city, or status.</li>
                    <li>Full-text search (title / description).</li>
                    <li>Sorting options: newest / most upvoted.</li>
                </ul>
            </div>

            <!-- Feature 4: Item Details & Community -->
            <div class="feature-card p-8">
                <div class="text-4xl feature-icon mb-4">📝</div>
                <h3 class="text-2xl font-bold text-orange-400 mb-3 border-b border-gray-700 pb-2">Item Details & Interaction</h3>
                <p class="text-gray-400">A dedicated space for every item.</p>
                <ul class="mt-4 space-y-2 text-gray-300 ml-4 list-disc list-inside">
                    <li>Full description and photo gallery.</li>
                    <li>Owner information and contact.</li>
                    <li>Integrated comments section.</li>
                    <li>Voting controls to highlight great items.</li>
                    <li>Clear “Gifted” status badge when claimed.</li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Call to Action (Optional, but good for design) -->
    <div class="text-center mt-16 p-8 bg-gray-900 rounded-xl shadow-inner">
        <!-- Updated CTA button color from green to orange -->
        <a href="{{route('register')}}" class="inline-block px-8 py-3 text-lg font-semibold rounded-lg bg-orange-600 text-white shadow-lg hover:bg-orange-700 transition duration-200">
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
