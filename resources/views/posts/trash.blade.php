<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trash Posts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                🗑 Trash Posts
            </h1>

            <a href="{{ route('posts.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                ← Back
            </a>

        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Table Box -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">

            <table class="w-full text-left">

                <!-- Head -->
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4">#</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>

                    @forelse($posts as $index => $post)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- Index -->
                            <td class="p-4 text-gray-600">
                                {{ $index + 1 }}
                            </td>

                            <!-- Title -->
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $post->title }}
                            </td>

                            <!-- Description -->
                            <td class="p-4 text-gray-500">
                                {{ \Illuminate\Support\Str::limit($post->description, 50) }}
                            </td>

                            <!-- Status -->
                            <td class="p-4">
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    Deleted
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="p-4 text-center">

                                <a href="{{ route('posts.restore', $post->id) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                                    ♻ Restore
                                </a>

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-500">
                                🚫 No deleted posts found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>