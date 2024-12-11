<?php
use Illuminate\Support\Facades\Route;

Route::get('/signin', function () {
    return 'Signin Page';
});

Route::post('/signin', function () {
    return 'Process Signin';
});

Route::get('/signup', function () {
    return 'Signup Page';
});

Route::post('/signup', function () {
    return 'Process Signup';
});

Route::get('/', function () {
    return 'Home Page';
});

// Route::get('/blog', function () {
//     return 'Blog List';
// });

Route::get('/blog/{blogId}', function ($blogId) {
    $title = request()->query('title', 'Untitled');
    $content = request()->query('content', 'No content provided.');

    return "Blog ID: $blogId, Title: $title, Content: $content";
})->where('blogId', '[0-9]+');

Route::get('/blog/{slug}', function ($slug) {
    return "Blog Detail: $slug";
})->where('slug', '[a-zA-Z0-9\-]+');


Route::get('/category/{slug}', function ($slug) {
    return "Category: $slug";
});

Route::get('/author/{username}', function ($username) {
    return "Author: $username";
});

Route::get('/privacy-policy', function () {
    return 'Privacy Policy Page';
});
