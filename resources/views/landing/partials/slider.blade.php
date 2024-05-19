<section class="home" id="home">
    <div class="swiper-container home-slider swiper">
        <div class="swiper-wrapper">
            @foreach ($agendas as $agenda)
                <div class="swiper-slide"><img src="{{ asset('hero_carousel/' . $agenda->background_image) }}" alt="{{ $agenda->title }}"></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>