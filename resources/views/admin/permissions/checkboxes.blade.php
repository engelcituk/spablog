@foreach ($permissions as $id => $name)
<div class="checkbox">
    <label for="">
        <input type="checkbox" name="permissions[]" value="{{$name}}" 
        {{ $model->permissions->contains($id) || collect(old('permissions'))->contains($name) ? 'checked' : ''}}>
        {{$name}}
    </label>
</div>
@endforeach