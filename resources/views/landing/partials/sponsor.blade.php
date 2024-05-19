<section class="review" id="review">
    <h1 class="heading">Sponsor<span>ship</span></h1>
    <div class="review-slider swiper-container swiper">
        <div class="swiper-wrapper">
            @foreach ($sponsorships as $sponsorship)
            <div class="swiper-slide box">
                <i class="fa-sharp fa-solid fa-medal"></i>
                <div class="user">
                    <img src="{{ $sponsorship->logo_perusahaan ? asset('sponsorship_logo/' . $sponsorship->logo_perusahaan) : asset('assets/landing/images/logo-usaha.png') }}" alt="Logo Perusahaan">
                    <div class="user-info">
                        <h3>{{ $sponsorship->nama_perusahaan }}</h3>
                        <span>{{ $sponsorship->jenis_perusahaan }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>