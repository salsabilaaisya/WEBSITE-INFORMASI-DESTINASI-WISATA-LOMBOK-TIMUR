<?php

use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Article;

use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Livewire\Admin\Destination\Index as DestinationIndex;
use App\Livewire\Admin\Gallery\Index as GalleryIndex;
use App\Livewire\Admin\Article\Index as ArticleIndex;

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

require __DIR__ . '/settings.php';

    $featuredDestinations = Destination::with('category')
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('featuredDestinations'));

})->name('home');


/*
|--------------------------------------------------------------------------
| Destinations
|--------------------------------------------------------------------------
*/

Route::get('/destinations', function () {

    $destinations = Destination::with('category')
        ->latest()
        ->get();

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

    $related = Destination::where('id', '!=', $destination->id)
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

    });
