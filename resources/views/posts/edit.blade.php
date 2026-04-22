<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Post</h2>

        <form method="POST" action="{{ route('posts.update', $post->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ $post->title }}"
                    class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter title">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description"
                    class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter description">{{ $post->description }}</textarea>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back</a>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition duration-300">Update</button>
            </div>
        </form>
    </div>

</body>

</html>