# PHP_Laravel12_With_Alpine.JS_Crud

##  Introduction

This project demonstrates a **complete CRUD (Create, Read, Update, Delete) application** built using **Laravel 12** and **Alpine.js installed via NPM**.

Alpine.js is bundled using **Laravel Vite**, making it suitable for modern Laravel projects and company‑level code standards.

---

##  Project Overview

PHP_Laravel12_With_Alpine.JS_Crud is a lightweight, reactive CRUD application built with Laravel 12 for backend management and Alpine.js for frontend interactivity. The project demonstrates how to combine Laravel’s powerful server-side capabilities with Alpine.js’ lightweight reactivity to create dynamic web pages without heavy frontend frameworks.


### Key Features:

Create Posts: Add new posts with title and description.

Read Posts: View all posts in a dynamic list and individual post details.

Update Posts: Edit existing posts with real-time feedback.

Delete Posts: Remove posts with confirmation dialogs using Alpine.js.

Reactive UI: Leverages Alpine.js to handle interactive behaviors such as confirmation prompts, form toggles, and dynamic updates.

---

## 🛠️ Tech Stack

* Laravel 12
* PHP 8.2+
* MySQL
* Blade Templates
* Alpine.js (NPM + Vite)
* Tailwind CSS

---

##  Project Name

```
PHP_Laravel12_With_Alpine.JS_Crud
```

---

##  Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_With_Alpine.JS_Crud "12.*"
cd PHP_Laravel12_With_Alpine.JS_Crud
```

---

##  Step 2: Database Configuration

Edit `.env` file:

```env
DB_DATABASE=laravel12_alpine_crud
DB_USERNAME=root
DB_PASSWORD=
```

Create database using below command:

```bash
php artisan migrate
```

---

##  Step 3: Install Frontend Dependencies

Install Node dependencies:

```bash
npm install
```

Install Alpine.js:

```bash
npm install alpinejs
```

---

##  Step 4: Configure Alpine.js with Vite

Edit `resources/js/app.js`

```js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
```

Run Vite:

```bash
npm run dev
```

---

##  Step 5: Create Model & Migration

```bash
php artisan make:model Post -m
```

### Migration

`database/migrations/xxxx_create_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

Run migration:

```bash
php artisan migrate
```

---

##  Step 6: Model

`app/Models/Post.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];
}
```

---

##  Step 7: Controller (Full CRUD)

```bash
php artisan make:controller PostController
```

`app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }
}
```

---

##  Step 8: Routes

`routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Posts CRUD routes

// Display all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Show create form
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// Store new post
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// Show single post
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Show edit form
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

// Update post
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

// Delete post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/', function () {
    return view('welcome');
});
```

---

##  Step 9: Blade Views (Index, Create, Edit, Show)

### `resources/views/posts/index.blade.php`

```html
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
```

---

### `create.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Post</h2>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" id="title" name="title" class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter title">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" name="description" class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter description"></textarea>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back</a>
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow transition duration-300">Save</button>
        </div>
    </form>
</div>

</body>
</html>
```

---

### `edit.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Post</h2>

    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ $post->title }}" class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter title">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" name="description" class="border rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter description">{{ $post->description }}</textarea>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Back</a>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition duration-300">Update</button>
        </div>
    </form>
</div>

</body>
</html>
```

---

### `show.blade.php`

```html
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
```

---

## Step 10: Run Development Server

You need to start two terminals for Laravel + Vite (Alpine.js) because they are separate:

### Terminal 1 – Laravel Server:

```bash
php artisan serve
```

Runs your Laravel backend

Default URL: 

```
http://127.0.0.1:8000
```

### Terminal 2 – Vite (Alpine.js + Tailwind CSS) Frontend Assets:

```bash
npm run dev
```

Compiles your Alpine.js and Tailwind CSS

Hot-reloads changes automatically

Make sure this terminal stays open while developing


---


##  Step 11: Access the Application in Browser

After this, open your browser and go to:

http://127.0.0.1:8000/posts


You should see your Post List

Create/Edit/View/Delete should all work

Alpine.js + Tailwind styles should load properly

---

##  Project Structure

```
PHP_Laravel12_With_Alpine.JS_Crud/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │       └── PostController.php
│   │   
│   ├── Models/
│   │   └── Post.php
│
├── database/
│   ├── migrations/
│   │   └── 2026_01_28_000000_create_posts_table.php
│   └── seeders/
│
├── resources/  
│   ├── js/
│   │   └── app.js      // import alpine 
│   └── views/
│       └── posts/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
│
├── routes/
│   └── web.php
│
├── composer.json
├── package.json
├── vite.config.js
└── .env
```

---

## Output

**Create Post**

<img width="1808" height="1085" alt="Screenshot 2026-01-28 121527" src="https://github.com/user-attachments/assets/e0cef907-ba95-4229-a496-e474f7572e25" />

<img width="1815" height="1086" alt="Screenshot 2026-01-28 121544" src="https://github.com/user-attachments/assets/6fd700af-a206-475a-aa97-080ae13deb11" />

**Index Page**

<img width="1828" height="1090" alt="image" src="https://github.com/user-attachments/assets/cc532d71-c0ef-438d-a5c6-b4fd55d54ec6" />

**Edit Post**

<img width="1810" height="1085" alt="Screenshot 2026-01-28 121739" src="https://github.com/user-attachments/assets/09b2c321-392a-4feb-8649-5003dfdb6164" />

<img width="1812" height="1088" alt="Screenshot 2026-01-28 121751" src="https://github.com/user-attachments/assets/fd29ac33-8ac0-467c-8a43-397df56b8fac" />

**Show Post**

<img width="1813" height="1090" alt="Screenshot 2026-01-28 121806" src="https://github.com/user-attachments/assets/b519d810-3d78-455b-8239-07194480599d" />

**Delete Post**

<img width="1919" height="1030" alt="Screenshot 2026-01-28 124915" src="https://github.com/user-attachments/assets/9c1ad251-a356-4510-bb48-a713603087d9" />

---

Your PHP_Laravel12_With_Alpine.JS_Crud Project is now ready!


