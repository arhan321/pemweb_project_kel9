@extends('index')
@section('section')

<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>{{ trans('panel.frontend.testimonials.testimonials_1') }}</h2>
        <p>{{ trans('panel.frontend.testimonials.testimonials_2') }}</p>
      </div>

      <div
        class="testimonials-slider swiper-container"
        data-aos="fade-up"
        data-aos-delay="100"
      >   
      @php
      $testimonial = \App\Models\Testimonial::find(1); 
      @endphp
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                {!! $testimonial->find(1)->pesan !!}
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img src="{{ $testimonial->getFirstMediaUrl('image', 'priview') }}" class="testimonial-img" alt="{{ $testimonial->title }}" />
              <h3>{{ $testimonial->find(1)->nama }}</h3>
            </div>
          </div>
          <!-- End testimonial item -->

          @php
          $testimonial = \App\Models\Testimonial::find(2); 
          @endphp
          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                {!! $testimonial->find(2)->pesan !!}
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img src="{{ $testimonial->getFirstMediaUrl('image', 'priview') }}" class="testimonial-img" alt="{{ $testimonial->title }}" />
              <h3>{{ $testimonial->find(2)->nama }}</h3>
            </div>
          </div>
          <!-- End testimonial item -->

          @php
          $testimonial = \App\Models\Testimonial::find(3); 
          @endphp
          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                {!! $testimonial->find(3)->pesan !!}
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img src="{{ $testimonial->getFirstMediaUrl('image', 'priview') }}" class="testimonial-img" alt="{{ $testimonial->title }}" />
              <h3>{{ $testimonial->find(3)->nama }}</h3>
            </div>
          </div>
          <!-- End testimonial item -->

          <!-- End testimonial item -->
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
  <!-- End Testimonials Section -->

  <!-- ======= Book A Table Section ======= -->
  <div class="form-container mx-auto p-4 bg-light rounded shadow-sm" style="max-width: 600px; margin-top: 50px;">
    <h2 class="mb-4 text-center">Form</h2>
    
    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="formData" action="{{ route('frontend.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label" style="font-weight: bold; color: #555;">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" style="border-radius: 5px;" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label" style="font-weight: bold; color: #555;">Email</label>
            <input type="email" class="form-control" id="email" name="email" style="border-radius: 5px;" required>
        </div>
        <div class="mb-3">
            <label for="nomor_telfon" class="form-label" style="font-weight: bold; color: #555;">Nomor Telepon</label>
            <input type="text" class="form-control" id="nomor_telfon" name="nomor_telfon" style="border-radius: 5px;" required>
        </div>
        <div class="mb-3">
            <label for="pesan" class="form-label" style="font-weight: bold; color: #555;">Pesan</label>
            <textarea class="form-control" id="pesan" name="pesan" rows="4" style="border-radius: 5px;" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; border-radius: 5px; padding: 10px 20px; font-size: 16px; transition: background-color 0.3s;">Submit</button>
    </form>
</div>
  <!-- End Book A Table Section -->
@endsection
{{-- @section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formData');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Kirim form data menggunakan AJAX
            const formData = new FormData(form);
            fetch(form.getAttribute('action'), {
                method: 'POST',
                body: formData,
                // Tambahkan ini untuk memastikan respons yang diterima adalah JSON
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan sweet alert jika data berhasil disimpan
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    form.reset();
                } else {
                    // Tampilkan sweet alert jika terjadi error
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>
@endsection --}}