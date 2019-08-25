<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach ($post->photos as $photo)
          <li data-target="#myCarousel" 
              data-slide-to="{{$loop->index}}" 
              class="{{$loop->first ? 'active':''}}"></li>
        @endforeach
    </ol>
      <div class="carousel-inner">
          @foreach ($post->photos as $photo)
            <div class="item {{$loop->first ? 'active':''}}">
            <img src="{{url($photo->url)}}">
            </div>
          @endforeach
      </div> 
    </a>
  </div>