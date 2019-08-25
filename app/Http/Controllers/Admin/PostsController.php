<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Post;
use App\Category;
use App\Tag;
use App\Http\Requests\StorePostRequest;


class PostsController extends Controller
{
    protected $guarded=[];

    public function index()
    {
        $posts = Post::permitidos()->get(); //permitidos es un query scope

        return view('admin.posts.index', compact('posts'));
    }

    /*public function create()
    {
        $categories= Category::all();
        $tags= Tag::all();

        return view('admin.posts.create', compact('categories','tags'));
    }*/
    public function store(Request $request){
        
        $this->authorize('create',new Post); //autorizacion para crear un nuevo post--`policies

        $this->validate($request,['title'=>'required|min:3']);

       /*$post = Post::create([
           'title' => $request->get('title'),
           'url' => str_slug($request->get('title'))
           ]);*/

        //$post= Post::create($request->only('title'));

        $post= Post::create($request->all());

        //$post->title=$request->get('title');
         

       return redirect()->route('admin.posts.edit',$post);
    }

    public function edit(Post $post){
       
        $this->authorize('update',$post); //policies de acceso

       return view('admin.posts.edit', [
           'post'=>$post,
           'tags'=>Tag::all(),
           'categories'=>Category::all()
       ]);
    }
    
    public function update(Post $post, StorePostRequest $request){
       
       $this->authorize('update', $post);
       
       $post->update($request->all());
       $post->syncTags($request->get('tags'));

       return redirect()->route('admin.posts.edit',$post)->with('flash', 'La publicación ha sido guardada');

    }
    public function destroy(Post $post){
       
        $this->authorize('delete', $post);
        $post->delete();
 
        return redirect()->route('admin.posts.index')->with('flash', 'La publicación ha sido eliminada');
 
     }
}

