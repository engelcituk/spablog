<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{   
    protected $fillable =[

    'title','body','iframe','excerpt','published_at','category_id','user_id',

    ];
    protected $dates = ['published_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($post){
            $post->tags()->detach();
            $post->photos->each->delete();
        });
    }
    public function getRouteKeyName(){

        return 'url';
    }

    public function category(){

        return $this->belongsTo(Category::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class);
    }
    public function photos(){

        return $this->hasMany(Photo::class);
    }

    public function owner(){

        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function scopePublicados($query){

          $query->whereNotNull('published_at') //obtengo las publicaciones donde fecha de pub. no sean nulos
                ->where('published_at','<=', Carbon::now()) //donde fechapub sean menores o igual a hoy
                ->latest('published_at'); //ordenados por fecha de publicacion
                      //get ya no se ocupa porque se usaría en otro lado
    }
    public function scopePermitidos($query){ //si es admin no le damos restricciones, sino solo los posts de su autoria

        if (auth()->user()->can('view',$this)) { 
            return $query; //como admin no tiene restricciones le muestro todo el query
        }
        return $query->where('user_id',auth()->id());
    }
    public function scopePostsPorAnioYmes($query){

        $query  
                ->selectRaw('year(published_at) year')
                ->selectRaw('month(published_at) month')
                ->selectRaw('monthname(published_at) monthname')
                ->selectRaw('count(*) posts')
                ->groupBy('year','month','monthname')
                ->orderBy('year')
                ->get();
    }
    
    /*public function setTitleAttribute($title){

        $this->attributes['title']= $title;

        $url=str_slug($title);

        $urlDuplicatedCount = Post::where('url', 'LIKE',"{$url}%")->count();

        if($urlDuplicatedCount){

            $url.= "-" .uniqid();

        }

        $this->attributes['url']= str_slug($title);
    }*/

    public static function create(array $attributes=[] ){

        $attributes['user_id']=auth()->id();        

        $post = static::query()->create($attributes);

        $post->generateUrl();

        return $post;
    }
    public function generateUrl(){

        $url= str_slug($this->title);

        if($this->whereUrl($url)->exists()){

            $url  = "{$url}-{$this->id}";
        }
        $this->url = $url;

        $this->save();

    }
    public function setPublishedAtAttribute($published_at){

        $this->attributes['published_at']= $published_at ? Carbon::parse($published_at) : null;
    } 
    public function setCategoryIdAttribute($category_id){

        $this->attributes['category_id']= Category::find($category_id)
                                        ? $category_id
                                        : Category::create(['name' => $category_id])->id;
    }

    public function syncTags($tags)
    {
        $tagIds = collect($tags)->map(function($tag){

            return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
           });
           //$post->tags()->attach($request->get('tags'));
          return $this->tags()->sync($tagIds);
        
    }

    public function viewType($home=''){

        if($this->photos->count() === 1):

            return 'posts.photo';

        elseif($this->photos->count() > 1):

                return $home==='home' ? 'posts.carousel-preview' : 'posts.carousel';

        elseif($this->iframe):
            
            return 'posts.iframe';
        else:

            return 'posts.text';

        endif;
    }

    
}
