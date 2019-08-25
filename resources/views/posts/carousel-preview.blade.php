<div class="gallery-photos masonry">
    @foreach($post->photos->take(4) as $photo)
        @if($loop->iteration ===4 )
        <div class="overlay">{{$post->photos->count()}} Fotos</div>
        @endif
        <figure class="gallery-image"><img src="{{url($photo->url)}}" class="img-responsive" alt=""></figure>
    @endforeach
</div>