@extends('layout')
@section('meta-title',$post->title)
@section('meta-description',$post->excerpt)
@section('content')
    <article class="post container">
      
      @include($post->viewType())

    <div class="content-post">
      @include('posts.header')
      <h1>{{$post->title}}</h1>
        <div class="divider"></div>
        <div class="image-w-text">
          {!!$post->body!!}
        </div>

        <footer class="container-flex space-between">
          <div class="buttons-social-media-share">
            
          </div>
          @include('posts.tags')
      </footer>
      <div class="comments">
      <div class="divider"></div>
        <div id="disqus_thread"></div>
        @include('partials.discus-script')                  
      </div><!-- .comments -->
    </div>
  </article>
@endsection

@push('styles')
   <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}"> 
@endpush

@push('scripts')
<script id="dsq-count-scr" src="//zendero.disqus.com/count.js" async></script>
<script src={{asset('/js/jquery.min.js')}}></script>
<script src={{asset('/js/bootstrap.min.js')}}></script>
@endpush


