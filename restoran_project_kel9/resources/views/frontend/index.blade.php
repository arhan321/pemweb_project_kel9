@extends('layouts.frontend')

@section('content')

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div
      class="container position-relative text-center text-lg-start"
      data-aos="zoom-in"
      data-aos-delay="100"
    >
      <div class="row">
        <div class="col-lg-8">
          <h1>Welcome to <span>Restaurantly</span></h1>
          <h2>Delivering great food for more than 18 years!</h2>

          <div class="btns">
            <a href="https://wa.me/6282113862854" class="btn-menu animated fadeInUp scrollto">Ask me</a>
            <a id="tomboll"
              href="{{ route('layouts.reservasi') }}"
              class="btn-book animated fadeInUp scrollto"
              >Book a Table</a>
          </div>
        </div>
        <div
          class="col-lg-4 d-flex align-items-center justify-content-center position-relative"
          data-aos="zoom-in"
          data-aos-delay="200"
        >
          <a
            href="https://www.youtube.com/watch?v=GlrxcuEDyF8"
            class="glightbox play-btn"
          ></a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero -->

  <!-- ======= Why Us Section ======= -->
  <section id="why-us" class="why-us">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Why Us</h2>
        <p>Why Choose Our Restaurant</p>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <div class="box" data-aos="zoom-in" data-aos-delay="100">
            <span>01</span>
            <h4>Kombinasi Cita Rasa Klasik dan Kontemporer:</h4>
            <p>
              Han`s Restoran memadukan cita rasa klasik Belanda dengan
              teknik memasak kontemporer, memberikan sentuhan modern pada
              hidangan tradisional. Ini menciptakan pengalaman kuliner yang
              menarik dan berbeda.
            </p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in" data-aos-delay="200">
            <span>02</span>
            <h4>Kualitas Bahan dan Keahlian Kuliner</h4>
            <p>
              Setiap hidangan di Han`s Restoran disusun dengan bahan
              berkualitas tinggi dan dipilih secara cermat, mempersembahkan
              rasa otentik dari warisan kuliner Belanda. Kombinasi ini
              dengan keahlian kuliner yang tinggi menciptakan hidangan yang
              luar biasa.
            </p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in" data-aos-delay="300">
            <span>03</span>
            <h4>Pelayanan Berkualitas</h4>
            <p>
              Han`s Restoran bangga memberikan pelayanan terbaik kepada
              setiap tamu. Staf mereka yang ramah dan berpengetahuan siap
              membantu Anda dalam memilih hidangan terbaik dan menjawab
              setiap pertanyaan tentang menu.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Why Us Section -->

</main>
<!-- End #main -->
@endsection