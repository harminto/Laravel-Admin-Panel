@extends('landing.frontend')

@section('konten')
<section class="artikel-detail" id="artikel-detail" style="margin-top: 8rem">
    <h3 class="heading">{{ $competitionTypes->title }}</h3>
    <div class="box-container">
        <div class="box">
            @if($competitionTypes->flyer)
            <div class="image">
                <img src="{{ asset('competition-flyers/'. $competitionTypes->flyer) }}" alt="">
            </div>
            @endif
            <div class="content">
                <p>{!! $competitionTypes->description !!}</p>
            </div>
            
        </div>
    </div>
</section>

{{-- @if ($competitionTypes->type_form == '1')
    @include('landing.page.formulir1')
@endif --}}

@switch($competitionTypes->type_form)
    @case('1')
        @include('landing.page.formulir1')
        @break

    @case('2')
        @include('landing.page.formulir2')
        @break

    @case('3')
        @include('landing.page.formulir3')
        @break

    @case('4')
        @include('landing.page.formulir4')
        @break

    @default
        @include('landing.page.defaultForm')
@endswitch

@endsection