<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Category;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(Request $request)
    {
       /* esta consulta lo mandé a un scope
       $posts = Post::whereNotNull('published_at') //obtengo las publicaciones donde fecha de pub. no sean nulos
                       ->where('published_at','<=', Carbon::now()) //donde fechapub sean menores o igual a hoy
                       ->latest('published_at') //ordenados por fecha de publicacion
                       ->get(); //get obtiene los resultados*/
        $consulta = Post::with(['category','tags', 'owner','photos'])->Publicados();
        
        if ($request->has('month')){
            $mes = request('month');
            $consulta->whereRaw('month(published_at) ='.$mes)->get();
        }
        if ($request->has('year')){
            $year = request('year');
            $consulta->whereRaw('year(published_at) ='.$year)->get();
        }
        $posts = $consulta->paginate();
       
        //por si son llamados ajax retorno ajax
        if( request()->wantsJson()){
            return $posts;
        }

        return view('pages.home', compact('posts'));
    }
    public function archive()
    {
        
        $archive = Post::PostsPorAnioYmes()->get();

        return view('pages.archive',[
            'autores' => User::latest()->take(4)->get(),
            'categories'=> Category::take(7)->get(),
            'posts' => Post::latest('published_at')->take(5)->get(),
            'archive'=> $archive 

            ] 
        );
    }
    public function spa(){
        
        return view('pages.spa');
    }
}
