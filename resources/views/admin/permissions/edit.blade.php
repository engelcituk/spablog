@extends('admin.layout')
@section('content')
<div class="row">
        <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Actualizar permiso</h3>
                    </div>
                    <div class="box-body">

                        @include('partials.error-messages')

                        <form method="POST" action="{{route('admin.permissions.update', $permission)}}">
                            {{method_field('PUT')}}{{csrf_field()}}
                            
                            <div class="form-group">
                                <label for="name">Identificador:</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name',$permission->name) }}" disabled>
                            </div>

                            <div class="form-group">
                                    <label for="display_name">Nombre:</label>
                                    <input type="text" name="display_name" class="form-control" value="{{old('display_name',$permission->display_name)}}">
                                </div>

                            <button class="btn btn-primary btn-block">Actualizar permiso</button>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection
