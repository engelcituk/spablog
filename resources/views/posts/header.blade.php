<header class="container-flex space-between">
    <div class="date">
        <span class="c-gray-1">{{$post->published_at->format('M d')}}   
        </span>
    </div>
    <div class="post-category">
    <span class="category text-capitalize">
    <span><a href="{{route('categories.show', $post->category)}}">{{$post->category->name}}</a></span>
    </div>
</header> 