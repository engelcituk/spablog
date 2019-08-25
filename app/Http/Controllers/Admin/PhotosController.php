<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Photo;

class PhotosController extends Controller
{
    
    public function store(Post $post){

        $this->validate(request(),[
            'photo'=>'required|image|max:2048'
        ]);

        //$photo = request()->file('photo')->store('posts','public');
        //$photoUrl= Storage::url($photo);

        /*$photo= new Photo;
        $photo->url=request()->file('photo')->store('posts','public');
        $photo->post_id=$post->id;
        $photo->save();*/
        $post->photos()->create([
            'url'=>request()->file('photo')->store('posts','public'),
        ]);
        
    }
    public function destroy(Photo $photo){
        $photo->delete();

        //$photoPath= str_replace('storage','public',$photo->url);

        return back()->with('flash', 'Foto eliminada');
    }
}
