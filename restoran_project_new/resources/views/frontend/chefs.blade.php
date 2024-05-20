@extends('index')
@section('section')


<!-- ======= Chefs Section ======= -->
{{-- @foreach ($chefs as $c) --}}
<section id="chefs" class="chefs">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Chefs</h2>
        <p>Our Proffesional Chefs</p>
      </div>
   {{-- @endforeach --}}
      <div class="row">
        @foreach ($chefs as $ch)
        <div class="col-lg-4 col-md-6">
          <div class="member" data-aos="zoom-in" data-aos-delay="100">
            <img src="{{ $ch->getFirstMediaUrl('image', 'priview') }}" class="img-fluid" alt="{{ $ch->title }}" />
            <div class="member-info">
              <div class="member-info-content">
                <h4>{!! $ch->nama !!}</h4>
                <span>{!! $ch->position !!}</span>
              </div>
              {{-- <div class="social">
                @foreach ($icon as $i)
                <a href=""><i class="{!! $i->icon !!}"></i></a>
                @endforeach
              </div> --}}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- End Chefs Section -->

@endsection