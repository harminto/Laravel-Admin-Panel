@extends('landing.frontend')

@section('konten')
<!-- Home section start -->
@include('landing.partials.slider')
<!-- Home section end -->

<!-- article section start -->
@include('landing.partials.artikel')
<!-- article section end -->

<!-- Timeline section start -->
@include('landing.partials.timeline')
<!-- Timeline section end -->

<!-- gallery section start -->
{{-- @include('landing.partials.galery') --}}
<!-- gallery section end -->

<!-- price section start -->
@include('landing.partials.unggulan')
<!-- price section end -->

<!-- review section start -->
@include('landing.partials.sponsor')
<!-- review section end -->
@endsection

@section('kontak')
    @include('landing.partials.kontak')
@endsection