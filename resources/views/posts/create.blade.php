<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Post</h2>

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                    class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter title">
            </div>

            <div class="mb-4" x-data="{ content: @js(old('description', '')) }">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" x-model="content" rows="4"
                    class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter description"></textarea>
                
                <div class="flex justify-end mt-1">
                    <span class="text-sm font-medium" :class="content.length > 500 ? 'text-red-600' : 'text-gray-500'">
                        <span x-text="content.length"></span> / 500
                    </span>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back</a>
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow transition duration-300">Save</button>
            </div>
        </form>
    </div>

</body>

</html>