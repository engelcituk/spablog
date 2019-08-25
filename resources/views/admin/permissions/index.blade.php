@extends('admin.layout')

@section('header')
<h1>
        Permisos
        <small>Listado</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route ('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Permisos</li>
      </ol>
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Listado de permisos</h3>
            {{-- <a href="{{route('admin.permissions.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Crear un rol</a> --}}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="permissionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identificador</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->id}}</td>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->display_name}}</td>
                            <td>
                                @can('update', $permission)
                                    <a href="{{route('admin.permissions.edit', $permission)}}" class="btn btn-info"><i class="fa fa-pencil"></i></a> 
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
        $('#permissionsTable').DataTable({
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

