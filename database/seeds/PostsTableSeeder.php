<?php

use Illuminate\Database\Seeder;
use App\Post;
use Carbon\Carbon;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Storage;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('posts');
        Post::truncate();
        Category::truncate();
        Tag::truncate();

        $category = new Category;
        $category->name ="Categoría 1";
        $category->save();

        $category = new Category;
        $category->name ="Categoría 2";
        $category->save();

        $post = new Post;
        $post->title="Mi Primer post";
        $post->url=str_slug("Mi Primer post");
        $post->excerpt="Extracto de mi primer post";
        $post->body="<p> Este es el cuerpo de mi primer post </p>";
        $post->published_at=Carbon::now()->subDays(5);
        $post->category_id=1;
        $post->user_id=1;
        $post->save();
        $post->tags()->attach(Tag::create(['name'=>'Etiqueta 1']));

        $post = new Post;
        $post->title="Mi segundo post";
        $post->url=str_slug("Mi segundo post");
        $post->excerpt="Extracto de mi segundo post";
        $post->body="<p> Este es el cuerpo de mi segundo post </p>";
        $post->published_at=Carbon::now()->subDays(4);
        $post->category_id=1;
        $post->user_id=1;
        $post->save();
        $post->tags()->attach(Tag::create(['name'=>'Etiqueta 2']));

        $post = new Post;
        $post->title="Mi tercer post";
        $post->url=str_slug("Mi tercer post");
        $post->excerpt="Extracto de mi tercer post";
        $post->body="<p> Este es el cuerpo de mi tercer post </p>";
        $post->published_at=Carbon::now()->subDays(3);
        $post->category_id=1;
        $post->user_id=1;
        $post->save();
        $post->tags()->attach(Tag::create(['name'=>'Etiqueta 3']));

        $post = new Post;
        $post->title="Mi cuarto post";
        $post->url=str_slug("Mi cuarto post");
        $post->excerpt="Extracto de mi cuarto post";
        $post->body="<p> Este es el cuerpo de mi cuarto post </p>";
        $post->published_at=Carbon::now()->subDays(2);
        $post->category_id=2;
        $post->user_id=2;
        $post->save();
        $post->tags()->attach(Tag::create(['name'=>'Etiqueta 4']));

        $post = new Post;
        $post->title="Mi quinto post";
        $post->url=str_slug("Mi quinto post");
        $post->excerpt="Extracto de mi quinto post";
        $post->body="<p> Este es el cuerpo de mi quinto post </p>";
        $post->published_at=Carbon::now()->subDays(1);
        $post->category_id=2;
        $post->user_id=2;
        $post->save();
        $post->tags()->attach(Tag::create(['name'=>'Etiqueta 5']));
    }
}


