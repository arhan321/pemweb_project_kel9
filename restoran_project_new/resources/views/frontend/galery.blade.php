@extends('index')
@section( 'section')

<!-- ======= Gallery Section ======= -->
@foreach ($galery as $g)
<section id="gallery" class="gallery">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>{!! $g->title_1 !!}</h2>
        <p>{!! $g->title_2 !!}</p>
      </div>
    </div>
    @endforeach
   
    <div class="container-fluid" data-aos="fade-up" data-aos-delay="100" style="margin-bottom: 10%, padding:10%;">
      <div class="row g-0">
        @foreach ($galery as $g)
        <div class="col-lg-3 col-md-4">
          <div class="gallery-item">
            <a href="{{ $g->getFirstMediaUrl('image', 'priview') }}" class="gallery-lightbox" data-gall="gallery-item">
              <img src="{{ $g->getFirstMediaUrl('image', 'priview') }}" alt="{{ $g->title }}" class="img-fluid"/>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- End Gallery Section -->


@endsection
