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
    public $slug;
    public $body;


    public function __construct($title, $excerpt, $date, $slug, $body)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }


    public static function find($slug){

        return static::all()->firstWhere('slug', $slug);
//        if (! file_exists($path = resource_path("posts/{$slug}.html"))){
//            throw new ModelNotFoundException();
//        }
//
//        return cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));
    }

    public static function  all() {
        return cache()->rememberForever('posts.all', function () {

            return collect($files = File::files(resource_path("posts")))
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function ($document) {
                    return new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->slug,
                        $document->body()
                    );
                })
                ->sortByDesc('date');

        });


//    $posts = array_map(function ($file){
//        $document = YamlFrontMatter::parseFile($file);
//        return new Post(
//            $document->title,
//            $document->excerpt,
//            $document->date,
//            $document->slug,
//            $document->body()
//        );
//    }, $files);

//    foreach ($files as $file){
//        $document = YamlFrontMatter::parseFile($file);
//        $posts[] = new Post(
//            $document->title,
//            $document->excerpt,
//            $document->date,
//            $document->slug,
//            $document->body()
//        );
//    }



//        $files = File::files(resource_path("posts"));
//        return array_map(fn($file) => $file->getContents(), $files);
    }
}








