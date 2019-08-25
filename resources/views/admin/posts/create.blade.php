<div class="modal fade" id="myModal">
    <form method="POST" action="{{route('admin.posts.store', '#create')}}">
    {{csrf_field()}}
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agrega el título de tu nueva publicación</h4>
              </div>
              <div class="modal-body">
              <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <!--<label for="">Título de la publicación</label>-->
                    <input type="text" name="title" id="tituloPost" class="form-control " value="{{ old('title') }}" placeholder="Ingresa aquí el título de la publicación" autofocus required>
                    {!! $errors->first('title','<span class="help-block">:message</span>')!!}
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Crear publicación</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </form>
</div>

@push('scripts')
  <script>
    if(window.location.hash==='#create'){
      $("#myModal").modal("show"); 
      
    }
    $("#myModal").on("hide.bs.modal",function(){
      window.location.hash="#";
    });
  
    $("#myModal").on("shown.bs.modal",function(){
      $("#tituloPost").focus();
      window.location.hash="#create";
    });
  </script>
@endpush

