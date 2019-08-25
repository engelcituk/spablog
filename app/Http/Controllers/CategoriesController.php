<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller{

    public function show(Category $category){
       
        //$posts= $category->posts;

        return view('pages.home', [
            'title'=>"Publicaciones de la categoría {$category->name}",
            'posts'=> $category->posts()->with(['category','tags', 'owner','photos'])->paginate()
        ]);
    }
}
