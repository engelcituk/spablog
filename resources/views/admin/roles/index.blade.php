@extends('admin.layout')

@section('header')
<h1>
        Roles
        <small>Listado</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route ('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
      </ol>
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Listado de rol</h3>

            @can('create', $roles->first())
                <a href="{{route('admin.roles.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Crear un rol</a>
            @endcan
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="rolesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identificador</th>
                        <th>Nombre</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->display_name}}</td>
                            <td>{{$role->permissions->pluck('display_name')->implode(', ')}}</td>
                            <td>
                                {{-- <a href="{{route('admin.roles.show', $role)}}" class="btn btn-default"><i class="fa fa-eye"></i></a> --}}
                                @can('update', $role)
                                    <a href="{{route('admin.roles.edit', $role)}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>  
                                @endcan
                                
                                @can('delete', $role)
                                    @if ($role->id !==1)
                                    <form method="POST" action="{{route('admin.roles.destroy', $role)}}" style="display:inline">
                                            {{ csrf_field() }}{{ method_field('DELETE') }}
                                        <button class="btn btn-danger" onclick="return confirm('Estás seguro de querer eliminar a este rol')"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>                       
@stop

@push('styles')
 <!-- DataTables -->
 <link rel="stylesheet" href={{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}>
@endpush

@push('scripts')
<!-- DataTables -->
<script src={{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}></script>
<script src={{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}></script>
<script>
    $(function() {
        $('#rolesTable').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });
    })
</script>

@endpush

