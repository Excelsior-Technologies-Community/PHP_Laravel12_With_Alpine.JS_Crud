<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post List</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen p-6" x-data>

<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Post List</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition duration-300">
            + Create Post
        </a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table container -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left min-w-max">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-gray-700 font-semibold">Title</th>
                    <th class="p-3 text-gray-700 font-semibold">Description</th>
                    <th class="p-3 text-gray-700 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3 text-gray-800 font-medium">{{ $post->title }}</td>
                        <td class="p-3 text-gray-700">{{ $post->description }}</td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition">View</a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold transition">Edit</a>
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" x-on:submit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 font-semibold transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($posts->isEmpty())
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">No posts found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
