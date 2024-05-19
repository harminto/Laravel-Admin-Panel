<section class="artikel" id="artikel">
    <h1 class="heading"><a href="{{ route('artikel') }}">Saintek Expo <span>News</span> <i class="fa-solid fa-newspaper"></i></a></h1>
    <div class="box-container">
        @foreach ($latestPosts as $post)
        <div class="box">
            @if($post->images->count() > 0)
            <div class="image">
                <img src="{{ asset('posts_images/'. $post->images->first()->image_path) }}" alt="">
            </div>
            @endif
            <div class="content">
                <h3>{{ $post->post_title }}</h3>
                <div class="meta-info">
                    <p class="category">
                        @foreach ($post->categories as $category)
                            {{ $category->name }}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </p>
                    <span>oleh: {{ $post->user->name }}</span>
                    <span><i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->post_date ? date('d M Y', strtotime($post->post_date)) : '00 00 0000' }}</span>
                </div>
                <p>{{ $post->post_excerpt }}</p>
                <a href="{{ route('detil-artikel', ['slug' => $post->slug]) }}" class="btn">Selanjutnya</a>
            </div>
        </div>
        @endforeach
    </div>
</section>