<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersRolesController extends Controller{
   
    public function update(Request $request, User $user){

        
        /* $user->roles()->detach();

        if($request->filled('roles')){

            $user->assignRole($request->roles);
        } */
 
        $user->syncRoles($request->roles); 

        return back()->withFlash("Los roles han sido actualizados");
    }

   
}
