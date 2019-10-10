<template>
   <section class="posts container"> 
	<!-- @if (isset($title)) -->
		<h3>Titulo</h3>
	<!-- @endif
		@forelse($posts as $post) -->
		<article class="post no-image">

			<!-- @include($post->viewType('home')) -->

			<div class="content-post">
				<!-- @include('posts.header') -->
				<h1>titulo posts</h1>

				<div class="divider"></div>

				<p>Parafo posts</p>

				<footer class="container-flex space-between">
					<div class="read-more">
						<a href="#" class="text-uppercase c-green">Leer más</a>
					</div>
					<!-- @include('posts.tags') -->
				</footer>

			</div>

        </article>
        <!-- @empty -->
            <article class="post">
                <div class="content-post">
                    <h1>No hay publicaciones todavía</h1>
                </div>
            </article>
        <!-- @endforelse -->
</section>
</template>  