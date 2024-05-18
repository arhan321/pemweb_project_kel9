@extends('index')
@section('section')

<!-- ======= Hero Section ======= -->
@foreach ($Home as $H)
<section id="hero" class="d-flex align-items-center">
    <img src="assets/img/imagebg.png" alt="Background Image" class="bg-img">
    <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8">
          <h1></h1>
          <!-- <h2>Delivering great food for more than 18 years!</h2> -->
          <!-- <div class="btns">
            <a href="https://wa.me/6282113862854" class="btn-menu animated fadeInUp scrollto">Ask me</a>
            <a href="reservasi.html" class="btn-book animated fadeInUp scrollto">Book a Table</a>
          </div> -->
        </div>
        @endforeach
        <!-- <div class="col-lg-4 d-flex align-items-center justify-content-center position-relative" data-aos="zoom-in" data-aos-delay="200">
          <a href="https://www.youtube.com/watch?v=GlrxcuEDyF8" class="glightbox play-btn"></a>
        </div> -->
      </div>
    </div>
  </section>
  <!-- End Hero -->

@endsection
