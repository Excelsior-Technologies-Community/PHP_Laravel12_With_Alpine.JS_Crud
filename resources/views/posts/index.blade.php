<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6" x-data="{ search: '{{ request('search') }}', deleteModalOpen: false, deleteUrl: '' }">

    <div class="max-w-7xl mx-auto relative">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                📄 Post Management
            </h1>

            <div class="flex gap-3">
                <a href="{{ route('posts.trash') }}" class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-xl shadow transition">
                    🗑 Trash
                </a>

                <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow-lg transition">
                    ➕ Create
                </a>
            </div>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 10000)" 
                 x-transition.duration.500ms
                 class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6 shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-6">
            <div class="flex items-center bg-white shadow rounded-xl overflow-hidden">
                <input type="text" name="search" x-model="search" placeholder="🔍 Search posts..." class="w-full p-3 outline-none">
                <button class="bg-blue-600 text-white px-6 h-full hover:bg-blue-700 transition py-3">
                    Search
                </button>
            </div>
        </form>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden pb-16">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($posts as $post)
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $post->id }}
                            </td>

                            <td class="p-4 font-semibold text-gray-800" 
                                x-data="{ editing: false, title: '{{ $post->title }}', saving: false }"
                                @click.away="editing = false">
                                
                                <div x-show="!editing" @click="editing = true" class="cursor-pointer hover:text-blue-600 transition flex items-center gap-2">
                                    <span x-text="title"></span>
                                </div>

                                <div x-show="editing" style="display: none;" class="flex items-center gap-2">
                                    <input type="text" x-model="title" 
                                        @keydown.enter="
                                            saving = true;
                                            fetch('{{ route('posts.inline-update', $post->id) }}', {
                                                method: 'PATCH',
                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                body: JSON.stringify({ title: title })
                                            }).then(res => res.json()).then(data => {
                                                editing = false; saving = false;
                                            });
                                        " 
                                        class="border border-gray-300 rounded px-2 py-1 text-sm outline-none focus:border-blue-500 w-full" 
                                        :disabled="saving">
                                </div>
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ Str::limit($post->description, 50) }}
                            </td>

                            <td class="p-4">
                                <a href="{{ route('posts.toggle', $post->id) }}"
                                    class="px-4 py-1 rounded-full text-sm font-semibold text-white shadow
                                        {{ $post->status ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                                    {{ $post->status ? 'Active' : 'Inactive' }}
                                </a>
                            </td>

                            <td class="p-4 relative">
                                <div class="flex justify-center" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-gray-500 hover:text-gray-800 focus:outline-none p-1 rounded-md hover:bg-gray-200 transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                    
                                    <div x-show="open" x-transition style="display: none;" class="absolute right-12 top-4 mt-2 w-32 bg-white rounded-md shadow-xl z-50 border border-gray-100 overflow-hidden">
                                        <a href="{{ route('posts.show', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">👁 View</a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">✏ Edit</a>
                                        <button type="button" @click="deleteUrl = '{{ route('posts.destroy', $post->id) }}'; deleteModalOpen = true; open = false;" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">🗑 Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-500">
                                🚫 No posts found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $posts->links() }}
        </div>

        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50" @click="deleteModalOpen = false"></div>
                <div x-show="deleteModalOpen" x-transition class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="px-6 pt-6 pb-4 bg-white sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                <span class="text-xl">⚠️</span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-bold leading-6 text-gray-900">Delete Post</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this post? This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 sm:flex sm:flex-row-reverse gap-3">
                        <form :action="deleteUrl" method="POST" class="inline w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex justify-center w-full px-5 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 sm:text-sm">Yes, Delete</button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="inline-flex justify-center w-full px-5 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 sm:mt-0 sm:text-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>