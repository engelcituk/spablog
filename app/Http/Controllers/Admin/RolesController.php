<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveRolesRequest;
use Spatie\Permission\Models\Permission;




class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', new Role);

        return view('admin.roles.index',[
            'roles'=>Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', $role = new Role);

        return view('admin.roles.create',[
            'role'=> $role,
            'permissions'=> Permission::pluck('name','id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveRolesRequest $request)
    {
        //valido los datos
       /*  $data = $request->validate([
            'name' => 'required|unique:roles',
            'display_name' => 'required'
        ],
        [
            'name.required'=>'El campo identificador es obligatorio',
            'name.unique'=>'Este identificador ya ha sido registrado',
            'display_name.required'=>'El campo nombre es obligatorio'
        ]
    ); */

        $this->authorize('create', new Role);

        $role = Role::create($request->validated()); //creo el rol
        
        //en versiones anteriores spatie daba problemas si no validamos si permisos viene vacio
        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.roles.index')->withFlash('El rol fue creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        return view('admin.roles.edit',[
            'role'=> $role,
            'permissions'=> Permission::pluck('name','id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveRolesRequest $request, Role $role)
    {
        //valido los datos
        /* 'name' => 'required|unique:roles,name,'.$role->id, */
        /* $data = $request->validate(['display_name' => 'required'],
            [
                'display_name.required'=>'El campo nombre es obligatorio'
            ]
    ); */
        $this->authorize('update', $role);

        $role->update($request->validated()); //guardo el rol
        
        $role->permissions()->detach();//quito todos los permisos que tiene

        //en versiones anteriores spatie daba problemas si no validamos si permisos viene vacio
        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.roles.edit', $role)->withFlash('El rol fue actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role){

        $this->authorize('delete', $role);

        $role->delete();

        return redirect()->route('admin.roles.index')->withFlash('El rol ha sido borrado exitosamente');
    }
}
