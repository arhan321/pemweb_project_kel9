@extends('index')

@section('section')

@foreach ($About as $a)
  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2"data-aos="zoom-in"data-aos-delay="100">
            <div class="about-img">
              <img src="{{ $a->getFirstMediaUrl('image', 'priview') }}" alt="{{ $a->title }}" />
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>{!! $a->title !!}</h3>
            <p class="fst-italic">
            {!! $a->description !!}
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- End About Section -->
    @endforeach
   
     <!-- ======= Why Us Section ======= -->
     @foreach ($whyus as $ab)
     <section id="why-us" class="why-us">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>{!! $ab->title_1 !!}</h2>
            <p>{!! $ab->title_2 !!}</p>
          </div>
          @endforeach
          <div class="row">
            @foreach ($whyus as $abo)
            <div class="col-lg-4 col-md-4">
              <div class="box" data-aos="zoom-in" data-aos-delay="100">
                <span>{!! $abo->nomor !!}</span>
                <h4>{!! $abo->description_box_1 !!}</h4>
                <p>
                  {!! $abo->description_box_2 !!}
                </p>
              </div>
            </div>
            @endforeach
          </div>
          
        </div>
      </section>
      <!-- End Why Us Section -->

    @endsection