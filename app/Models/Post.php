<?php
namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class Post
{
  public $title;
  public $excerpt;
  public $date;
  public $body;
  public $slug;

  public function __construct($title, $excerpt, $date, $body, $slug)
  {
    $this->title = $title;
    $this->excerpt = $excerpt;
    $this->date = $date;
    $this->body = $body;
    $this->slug = $slug;
  }


  public static function all()
  {

    // Adicionando cache salvo para sempre
    return cache()->rememberForever('posts.all', function(){
      return collect(File::files(resource_path("posts")))
        ->map(function($file){
          return $document = YamlFrontMatter::parseFile($file);
        })
        ->map(function($document) {
          return new Post(
            $document->title,
            $document->excerpt,
            $document->date,
            $document->body(),
            $document->slug,
          );
        })
        ->sortByDesc("date");

    });

  }

  public static function find($slug)
  {

    //se slug não existe
    // if(! file_exists($path = resource_path("posts/{$slug}.html"))){
    //   throw new ModelNotFoundException();
    // }

    // Mesma operação usando cache por 1 hora
    // return  cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));


    // Usando YamlFrontMatter
    return static::all()->firstWhere('slug', $slug);

  }

  public static function findOrFail($slug)
  {

    //se slug não existe
    // if(! file_exists($path = resource_path("posts/{$slug}.html"))){
    //   throw new ModelNotFoundException();
    // }

    // Mesma operação usando cache por 1 hora
    // return  cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));


    // Usando YamlFrontMatter
    $post = static::all()->firstWhere('slug', $slug);

    if (!posts){
      throw new ModelNotFoundException();
    }

    return $post;

  }

}
