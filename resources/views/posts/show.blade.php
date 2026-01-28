<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Post</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Post Details</h2>

    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Title</label>
        <p class="border rounded p-3 bg-gray-50 text-gray-800">{{ $post->title }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Description</label>
        <p class="border rounded p-3 bg-gray-50 text-gray-700">{{ $post->description }}</p>
    </div>

    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back</a>
</div>

</body>
</html>
