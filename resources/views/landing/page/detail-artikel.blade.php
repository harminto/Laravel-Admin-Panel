@extends('landing.frontend')

@section('konten')
<section class="artikel-detail" id="artikel-detail" style="margin-top: 8rem">
    <h3 class="heading">{{ $artikelDetail->post_title }}</h3>
    <div class="box-container">
        <div class="box">
            @if($artikelDetail->images->count() > 0)
            <div class="image">
                <img src="{{ asset('posts_images/'. $artikelDetail->images->first()->image_path) }}" alt="">
            </div>
            @endif
            <div class="meta-info">
                <p class="category">
                    @foreach ($artikelDetail->categories as $category)
                        {{ $category->name }}
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
                <span>oleh: {{ $artikelDetail->user->name }}</span>
                <span><i class="fa fa-calendar" aria-hidden="true"></i> {{ $artikelDetail->post_date ? date('d M Y', strtotime($artikelDetail->post_date)) : '00 00 0000' }}</span>
            </div>
            <div class="content">
                <p>{!! $artikelDetail->post_content !!}</p>
            </div>
        </div>
    </div>
</section>
@endsection