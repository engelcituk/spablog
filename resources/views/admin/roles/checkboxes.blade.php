@foreach ($roles as $role)
    <div class="checkbox">
        <label for="">
            <input type="checkbox" name="roles[]" value="{{$role->name}}" {{$user->roles->contains($role->id) ? 'checked' : ''}}>
            {{$role->name}}
            <br>
            <small class="text-muted">{{$role->permissions->pluck('name')->implode(', ')}}</small>
        </label>
    </div>                          
@endforeach