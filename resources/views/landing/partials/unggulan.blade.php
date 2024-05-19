<section class="price" id="price">
    <h1 class="heading">Saintek Expo <span>Unggulan</span></h1>
    <div class="box-container">
        @foreach ($competitionTypes as $competitionType)
        <div class="box">
            <h3 class="title">{{ $competitionType->title }}</h3>
            <h3 class="amount">
                @if($competitionType->biaya == 0)
                    -
                @else
                    Rp. {{ number_format($competitionType->biaya, 0, ',', '.') }},-
                @endif
            </h3>
            <ul>
                @foreach($competitionType->facilities as $facility)
                    <li><i class="fas fa-check"></i>{{ $facility->fasilitas }}</li>
                @endforeach
            </ul>
            <a href="{{ route('unggulans', ['slug' => $competitionType->slug]) }}" class="btn">Info Detail</a>
        </div>
        @endforeach

    </div>
</section>