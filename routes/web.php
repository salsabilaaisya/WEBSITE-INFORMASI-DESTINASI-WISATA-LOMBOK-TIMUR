<?php

use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\About;

use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Livewire\Admin\Destination\Index as DestinationIndex;
use App\Livewire\Admin\Gallery\Index as GalleryIndex;
use App\Livewire\Admin\Article\Index as ArticleIndex;
use App\Livewire\Admin\Message\Index as MessageIndex;
use App\Livewire\Admin\About\Index as AboutIndex;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {


    $featuredDestinations = Destination::with('category')
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('featuredDestinations'));

})->name('home');

     Route::get('/about', AboutIndex::class)
            ->name('about');

/*
|--------------------------------------------------------------------------
| Contact Form
|--------------------------------------------------------------------------
*/

Route::post('/contact', function () {

    request()->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    ContactMessage::create([
        'name' => request('name'),
        'email' => request('email'),
        'message' => request('message'),
    ]);

    return redirect('/')
        ->with('success', 'Pesan berhasil dikirim.');

})->name('contact.store');


/*
|--------------------------------------------------------------------------
| Destinations
|--------------------------------------------------------------------------
*/

Route::get('/destinations', function () {

    $destinations = Destination::with('category')

        ->when(request('search'), function ($query) {

            $query->where(function ($q) {

                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('location', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');

            });

        })

        ->when(request('category'), function ($query) {

            $query->where('category_id', request('category'));

        })

        ->latest()

        ->paginate(6)

        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    return view(
        'frontend.destinations.index',
        compact('destinations', 'categories')
    );

})->name('frontend.destinations');


Route::get('/destinations/{destination}', function (Destination $destination) {

    $destination->load([
        'category',
        'galleries',
    ]);

    $related = Destination::with('category')
        ->where('id','!=',$destination->id)
        ->latest()
        ->take(3)
        ->get();

    return view(
        'frontend.destinations.show',
        compact('destination', 'related')
    );

})->name('frontend.destinations.show');


/*
|--------------------------------------------------------------------------
| Gallery
|--------------------------------------------------------------------------
*/

Route::get('/gallery', function () {

    $galleries = Gallery::with('destination')
        ->latest()
        ->get();

    return view(
        'frontend.gallery.index',
        compact('galleries')
    );

})->name('frontend.gallery');


/*
|--------------------------------------------------------------------------
| Articles
|--------------------------------------------------------------------------
*/

Route::get('/articles', function () {

    $articles = Article::query()

        ->when(request('search'), function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('content', 'like', '%' . request('search') . '%');
            });
        })

        ->latest()
        ->paginate(6)
        ->withQueryString();

    return view(
        'frontend.articles.index',
        compact('articles')
    );

})->name('frontend.articles');


Route::get('/articles/{article}', function (Article $article) {

    $related = Article::where('id', '!=', $article->id)
        ->latest()
        ->take(3)
        ->get();

    return view(
        'frontend.articles.show',
        compact('article', 'related')
    );

})->name('frontend.articles.show');

Route::get('/about', function () {

    $about = About::first();

    return view('frontend.about.index', [
        'about' => $about,
        'destinationCount' => Destination::count(),
        'galleryCount' => Gallery::count(),
        'articleCount' => Article::count(),
        'categoryCount' => Category::count(),
    ]);

})->name('about');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/dashboard', 'dashboard')
            ->name('dashboard');

        Route::get('/categories', CategoryIndex::class)
            ->name('categories');

        Route::get('/destinations', DestinationIndex::class)
            ->name('destinations');

        Route::get('/gallery', GalleryIndex::class)
            ->name('gallery');

        Route::get('/articles', ArticleIndex::class)
            ->name('articles');

        Route::get('/messages', MessageIndex::class)
            ->name('messages');

        Route::get('/about', AboutIndex::class)
            ->name('about');

    });
