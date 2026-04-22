<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6" x-data="{ search: '' }">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                📄 Post Management
            </h1>

            <div class="flex gap-3">
                <a href="{{ route('posts.trash') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-xl shadow transition">
                    🗑 Trash
                </a>

                <a href="{{ route('posts.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow-lg transition">
                    ➕ Create
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6 shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
        <form method="GET" class="mb-6">
            <div class="flex items-center bg-white shadow rounded-xl overflow-hidden">
                <input type="text" name="search" placeholder="🔍 Search posts..." value="{{ request('search') }}"
                    class="w-full p-3 outline-none">

                <button class="bg-blue-600 text-white px-6 h-full hover:bg-blue-700 transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Table Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-left">

                <!-- Head -->
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>
                    @forelse($posts as $post)
                        <tr class="border-b hover:bg-gray-50 transition duration-200">

                            <td class="p-4 font-semibold text-gray-800">
                                {{ $post->id }}
                            </td>

                            <!-- Title -->
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $post->title }}
                            </td>

                            <!-- Description -->
                            <td class="p-4 text-gray-600">
                                {{ Str::limit($post->description, 50) }}
                            </td>

                            <!-- Status -->
                            <td class="p-4">
                                <a href="{{ route('posts.toggle', $post->id) }}"
                                    class="px-4 py-1 rounded-full text-sm font-semibold text-white shadow
                                       {{ $post->status ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                                    {{ $post->status ? 'Active' : 'Inactive' }}
                                </a>
                            </td>

                            <!-- Actions -->
                            <td class="p-4">
                                <div class="flex justify-center gap-4">

                                    <a href="{{ route('posts.show', $post->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        👁 View
                                    </a>

                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="text-yellow-600 hover:text-yellow-800 font-medium">
                                        ✏ Edit
                                    </a>

                                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}"
                                        onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:text-red-800 font-medium">
                                            🗑 Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-6 text-gray-500">
                                🚫 No posts found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $posts->links() }}
        </div>

    </div>

</body>

</html>