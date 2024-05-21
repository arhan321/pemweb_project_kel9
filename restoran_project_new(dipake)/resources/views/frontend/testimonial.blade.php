@extends('index')
@section('section')

<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>{{ trans('panel.testimonials_1') }}</h2>
        <p>{{ trans('panel.testimonials_2') }}</p>
      </div>

      <div
        class="testimonials-slider swiper-container"
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Saya sangat terkesan dengan pengalaman makan saya di Han`s
                Resto. Dari suasana yang hangat hingga hidangan yang lezat,
                semuanya luar biasa. Pelayanan yang ramah dan profesional
                membuat saya merasa benar-benar istimewa."
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img
                src="frontend/assets/img/testimonials/anya.png"
                class="testimonial-img"
                alt=""
              />
              <h3>Anya Geraldine</h3>
              <h4>Selebgram</h4>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Han`s restaurant adalah tempat yang sempurna untuk makan
                malam romantis. Makanan yang lezat dan presentasi yang
                menakjubkan membuat kami terpesona. Kami pasti akan kembali
                lag
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img
                src="frontend/assets/img/testimonials/rigen.png"
                class="testimonial-img"
                alt=""
              />
              <h3>Rigen</h3>
              <h4>Komedian</h4>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Han`s restaurant telah menjadi tempat favorit saya untuk
                bersantap. Hidangan mereka selalu segar dan penuh rasa, dan
                suasana restoran sangat mengundang. Ini adalah tempat yang
                sempurna untuk menikmati waktu bersama keluarga dan
                teman-teman
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img
                src="frontend/assets/img/testimonials/anastasya.png"
                class="testimonial-img"
                alt=""
              />
              <h3>Anastasya</h3>
              <h4>Influencer</h4>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Saya telah mencoba banyak restoran di sekitar, tetapi Han`s
                Resto benar-benar menonjol. Hidangan mereka adalah kombinasi
                sempurna antara rasa dan kreativitas. Saya sangat
                merekomendasikan untuk dicoba
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img
                src="frontend/assets/img/testimonials/pesulap1.png"
                class="testimonial-img"
                alt=""
              />
              <h3>Pesulap Merah</h3>
              <h4>Tukang Sulap</h4>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Menu yang disajikan sangat proper sekali dengan harga yang
                juga proper
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
              <img
                src="frontend/assets/img/testimonials/gibran.png"
                class="testimonial-img"
                alt=""
              />
              <h3>Gibran Rakabuming</h3>
              <h4>Wakil Presiden 2024-2029</h4>
            </div>
          </div>
          <!-- End testimonial item -->
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
  <!-- End Testimonials Section -->

  <!-- ======= Book A Table Section ======= -->

  <section id="book-a-table" class="book-a-table">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Suggestion Table</h2>
        <p></p>
      </div>

      <form
        action="forms/book-a-table.php"
        method="post"
        role="form"
        class="php-email-form"
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <div class="row">
          <div class="col-lg-4 col-md-6 form-group">
            <input
              type="text"
              name="name"
              class="form-control"
              id="name"
              placeholder="Your Name"
              data-rule="minlen:4"
              data-msg="Please enter at least 4 chars"
            />
            <div class="validate"></div>
          </div>
          <div class="col-lg-4 col-md-6 form-group mt-3 mt-md-0">
            <input
              type="email"
              class="form-control"
              name="email"
              id="email"
              placeholder="Your Email"
              data-rule="email"
              data-msg="Please enter a valid email"
            />
            <div class="validate"></div>
          </div>
          <div class="col-lg-4 col-md-6 form-group mt-3 mt-md-0">
            <input type="text"  class="form-control" name="phone" id="phone"  placeholder="Your Phone" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
            <div class="validate"></div>
          </div> 
           <div class="col-lg-4 col-md-6 form-group mt-3">
            <input
              type="text"
              name="date"
              class="form-control"
              id="date"
              placeholder="Date"
              data-rule="minlen:4"
              data-msg="Please enter at least 4 chars"
            />
            <div class="validate"></div>
          </div>
          <div class="col-lg-4 col-md-6 form-group mt-3">
            <input
              type="text"
              class="form-control"
              name="time"
              id="time"
              placeholder="Time"
              data-rule="minlen:4"
              data-msg="Please enter at least 4 chars"
            />
            <div class="validate"></div>
          </div>
          <div class="col-lg-4 col-md-6 form-group mt-3">
            <input
              type="number"
              class="form-control"
              name="people"
              id="people"
              placeholder="# of people"
              data-rule="minlen:1"
              data-msg="Please enter at least 1 chars"
            />
            <div class="validate"></div>
          </div>
        </div> 
        <div class="form-group mt-3">
          <textarea
            class="form-control"
            name="message"
            rows="5"
            placeholder="Message"
          ></textarea>
          <div class="validate"></div>
        </div>
        <div class="mb-3">
          <div class="loading">Loading</div>
          <div class="error-message"></div>
          <div class="sent-message">
            Your booking request was sent. We will call back or send an
            Email to confirm your reservation. Thank you!
          </div>
        </div>
        <div class="text-center">
          <button type="submit">Send</button>
        </div>
      </form>
    </div>
  </section>
  <!-- End Book A Table Section -->

@endsection