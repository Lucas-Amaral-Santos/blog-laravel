<?php

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {




    return view('posts', [
        'posts' => Post::all()
    ]);
});


Route::get('posts/{post}', function ($slug) {

    //  Find a post by its slug and pass it to a view called "post"
    $post = Post::find($slug);

    return view("post", [
        'post'=> $post
    ]);





/*    return view('post', [
//      'post' => '<h1>Hello World</h1>' // Define a variável $post
//      'post' => file_get_contents(__DIR__ . '/../resources/posts/my-first-post.html') // Função extrai conteúdo de arquivo e joga em variável posts
        'post' => $post
    ]);*/
})->where('post', '[A-z_\-]+');
