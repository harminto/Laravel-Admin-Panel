@extends('landing.frontend')

@section('konten')

<section class="timeline" id="timeline" style="margin-top: 8rem">
    <h3 class="heading">Saintek Expo <span>Timeline</span></h3>
    <div class="timeline-slider">
        @foreach ($timelines as $timeline)
        <div class="box">
            <div class="image-wrapper">
                <img src="{{ asset('timeline_images/' . $timeline->gambar) }}" alt="{{ $timeline->judul_timeline }}">
            </div>
            <div class="konten-wrapper">
                <h3>{{ $timeline->judul_timeline }}</h3>
                @php
                    // Pisahkan tanggal, bulan, dan tahun untuk tanggal mulai dan selesai
                    $startDay = date('j', strtotime($timeline->tanggal_mulai));
                    $startMonth = date('n', strtotime($timeline->tanggal_mulai));
                    $startYear = date('Y', strtotime($timeline->tanggal_mulai));

                    $endDay = date('j', strtotime($timeline->tanggal_selesai));
                    $endMonth = date('n', strtotime($timeline->tanggal_selesai));
                    $endYear = date('Y', strtotime($timeline->tanggal_selesai));

                    // Logika untuk menampilkan tanggal dengan aturan yang telah disebutkan
                    if ($timeline->tanggal_mulai == $timeline->tanggal_selesai) {
                        $formattedDate = date('j F Y', strtotime($timeline->tanggal_mulai));
                    } elseif ($startMonth == $endMonth) {
                        $formattedDate = $startDay . ' - ' . $endDay . ' ' . date('F Y', strtotime($timeline->tanggal_mulai));
                    } else {
                        $formattedDate = date('j F Y', strtotime($timeline->tanggal_mulai)) . ' - ' . date('j F Y', strtotime($timeline->tanggal_selesai));
                    }
                @endphp
                <div class="date"><i class="fas fa-calendar-alt"></i> &nbsp;{{ $formattedDate }}</div>
                <p>{{ $timeline->kepesertaan }}</p><br />
                <p>{{ $timeline->deskripsi }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection