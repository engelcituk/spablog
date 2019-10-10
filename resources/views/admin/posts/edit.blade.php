@extends('admin.layout')

@section('header')
<h1>
        POSTS
        <small>Crear una publicación</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route ('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{route ('admin.posts.index')}}"><i class="fa fa-bars"></i> Post</a></li>
        <li class="active">Crear</li>
      </ol>
@stop  

@section('content')
<div class="row">
    @if($post->photos->count())
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                @foreach ($post->photos as $photo)
                    <form method="POST" action="{{route('admin.photos.destroy', $photo)}}">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                        <div class="col-md-2">
                                <button class="btn btn-danger btn-xs" style="position:absolute;"><i class="fa fa-remove"></i></button>
                                <img  class="img-responsive" src="{{url($photo->url)}}" alt="">
                        </div>
                    </form> 
                @endforeach
            </div>
        </div>
    </div> 
    @endif
    
<form method="POST" action="{{route('admin.posts.update', $post)}}">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="">Título de la publicación</label>
                    <input type="text" name="title"
                     class="form-control " value="{{ old('title', $post->title) }}"
                     placeholder="Ingresa aquí el título de la publicación" required>
                    {!! $errors->first('title','<span class="help-block">:message</span>')!!}
                </div>
                <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                    <label for="">Contenido de la publicación</label>
                    <textarea class="form-control" id="editor" name="body" rows="10" placeholder="Ingrese el contenido completo de la publicación" required> {{ old('body', $post->body) }}</textarea>
                    {!! $errors->first('body','<span class="help-block">:message</span>')!!}
                </div>
                <div class="form-group {{ $errors->has('iframe') ? 'has-error' : '' }}">
                    <label for="">Contenido embebido (iframe)</label>
                    <textarea class="form-control" id="editor" name="iframe" rows="2" placeholder="Ingrese contenido embebido de audio o video"> {{ old('iframe', $post->iframe) }}</textarea>
                    {!! $errors->first('iframe','<span class="help-block">:message</span>')!!}
                </div>
            </div>  
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                <label>Fecha de publicación:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="published_at" class="form-control pull-right" value="{{ old('published_at', $post->published_at ? $post->published_at->format('m/d/Y') : null) }}" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                <label for="">categorías</label>
                <select class="form-control select2" name="category_id" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"
                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : ''}}
                            >{{$category->name}}</option>
                    @endforeach
                </select>
                {!! $errors->first('category_id','<span class="help-block">:message</span>')!!}
              </div>
              <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                  <label for="">Etiquetas</label>
                <select name="tags[]" class="form-control select2"
                        multiple="multiple"
                        data-placeholder="Selecciona una o más etiquetas"
                        style="width: 100%;" required>
                        @foreach($tags as $tag)
                            <option 
                            {{ collect(old('tags', $post->tags->pluck('id')))->contains($tag->id) ? 'selected':'' }} value="{{$tag->id}}"
                                >{{$tag->name}}</option>
                        @endforeach
                </select>
                {!! $errors->first('tags','<span class="help-block">:message</span>')!!}
              </div>
                <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                    <label for="">Extracto de la publicación</label>
                    <textarea class="form-control" name="excerpt" placeholder="Ingrese un extracto de la publicación" required> {{ old('excerpt', $post->excerpt) }}</textarea>
                    {!! $errors->first('excerpt','<span class="help-block">:message</span>')!!}
                </div>
                <div class="form-group">
                    <div class="dropzone">

                    </div>
                </div>
                <div class="form-group">
                    <button  type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Guardar publicación</button>
                </div>
            </div>
            
        </div>
    </div>
</form>
</div>
@stop

@push('styles')
<link rel="stylesheet" href={{asset('adminlte/bower_components/dropzone/dropzone.css')}}>
    <!-- bootstrap datepicker -->
<link rel="stylesheet" href={{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}>
     <!-- Select2 -->
<link rel="stylesheet" href={{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}>
@endpush
@push('scripts')
<script src={{asset('adminlte/bower_components/dropzone/dropzone.min.js')}}></script> 
<!-- bootstrap datepicker -->
<script src={{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}></script> 
<!-- CK Editor -->
<script src={{asset('adminlte/bower_components/ckeditor/ckeditor.js')}}></script> 
<!-- Select2 -->
<script src={{asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}></script>


<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    $('.select2').select2({
        tags:true
    });
    CKEDITOR.replace('editor');
    //CKEDITOR.config.height = 315;
   
    var miDropzone = new Dropzone(".dropzone", { 
        url: "/admin/posts/{{$post->url}}/photos",
        dictDefaultMessage: "Arrastra aqui las fotos para subirlas",
        acceptedFiles:'image/*',
        maxFilesize: 2,
        paramName:'photo',
        headers: {
            "X-CSRF-TOKEN":"{{csrf_token()}}"
        }
        });
        miDropzone.on('error', function(file, respuesta) {
            var mensaje= respuesta.photo[0];
            $('.dz-error-message:last > span').text(mensaje);
        });

    Dropzone.autoDiscover= false;
</script>
@endpush


