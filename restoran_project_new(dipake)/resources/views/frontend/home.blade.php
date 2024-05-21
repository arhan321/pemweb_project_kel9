@extends('index')
@section('section')

<!-- ======= Hero Section ======= -->
@foreach ($Home as $H)
<section id="hero" class="d-flex align-items-center">
    <div class="background-image">
        <img src="{{ $H->getFirstMediaUrl('image', 'priview') }}" alt="{{ $H->tittle }}" />
    </div>
    <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
        <div class="row">
            <div class="col-lg-8">
                <h1>{{ $H->title }}</h1>
                <!-- <h2>Delivering great food for more than 18 years!</h2> -->
                <!-- <div class="btns">
                    <a href="https://wa.me/6282113862854" class="btn-menu animated fadeInUp scrollto">Ask me</a>
                    <a href="reservasi.html" class="btn-book animated fadeInUp scrollto">Book a Table</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
@endforeach
<!-- End Hero -->

@endsection
