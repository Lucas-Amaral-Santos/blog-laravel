<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('posts', [
      'posts' => Post::all()
    ]);
});

Route::get('posts/{post}', function($slug){

    // Especifica caminho relacionado ao slug
    // $path = __DIR__."/../resources/posts/{$slug}.html";

    //se slug não existe
    // if(! file_exists($path)){
    //   ddd("File does not exists!");
    // }

    // Carrega conteudo do arquivo
    //$post = file_get_contents($path);

    // Mesma operação usando cache por 1 hora
    // $post = cache()->remember("posts.{$slug}", 1200, function() use ($path) {
    //   var_dump('file_get_contents');
    //   return file_get_contents($path);
    // });


    // Mesma operação anterior com cache usando arrow function
    // $post = cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));


    // Migrando o recebimento do POST para um Models

    return view('post', [
      'post' => Post::find($slug)
    ]);
})->where('post', '[A-z_\-]+');
