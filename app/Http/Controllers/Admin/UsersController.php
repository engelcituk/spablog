<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Events\UserWasCreated;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::permitidos()->get(); 
        /* $users = User::all();  */

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        
        $user = new User;// creo una instancia vacia de user porque esta variable es usada en dos archivos parciales create y edit
        
        $this->authorize('create', $user);
        
        $roles = Role::with('permissions')->get();
        $permissions = Permission::pluck('name','id');

        return view('admin.users.create', compact('user','roles','permissions'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $this->authorize('create', new User);

        //validamos el usuario
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);
        //generamos una contraseña
        $data["password"] = str_random(8);
        //creamos al usuaio
        $user= User::create($data);
        //asignamos los roles
        $user->assignRole($request->roles);
        //asignamos los permisos
        $user->givePermissionTo($request->permissions);
        //enviamos el email
        UserWasCreated::dispatch($user, $data["password"]);//evento 
        //regresamos al usuario
        return redirect()->route('admin.users.index')->withFlash('El usuario ha sido creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user){

        $this->authorize('update', $user);

        /* $roles = Role::pluck('name','id'); */
        $roles = Role::with('permissions')->get();
        
        $permissions = Permission::pluck('name','id');

        return view('admin.users.edit', compact('user','roles','permissions'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated()); //actualizo
       
        return redirect()->route('admin.users.edit',$user)->withFlash('El usuario ha sido actualizado');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
 
        return redirect()->route('admin.users.index')->withFlash('El usuario ha sido eliminado');
    }
}
