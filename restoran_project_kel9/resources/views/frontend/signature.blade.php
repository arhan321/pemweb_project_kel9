@extends('index')

@section('section')
      <!-- ======= Specials Section ======= -->
      <section id="signature" class="signature">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>{{ trans('panel.frontend.signature.signature_1') }}</h2>
            <p>{{ trans('panel.frontend.signature.signature_2') }}</p>
          </div>

          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-3">
              <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                  <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Menu Utama</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Appetizer</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Drink</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-9 mt-4 mt-lg-0">
              <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>Sate Maranggi</h3>
                      <p class="fst-italic">
                        Nikmati kelezatan Sate Maranggi, hidangan khas dari
                        Purwakarta, Jawa Barat, yang terkenal dengan cita rasa
                        yang khas dan menggugah selera. Kami mempersembahkan
                        potongan daging sapi muda yang empuk dan berlemak,
                        dipanggang di atas bara arang dengan bumbu rempah yang
                        kaya.
                      </p>
                      <p>
                        Daging sapi Maranggi kami direndam dalam campuran bumbu
                        tradisional yang terdiri dari bawang putih, bawang
                        merah, kunyit, jahe, dan rempah pilihan lainnya untuk
                        memberikan cita rasa yang autentik dan lezat. Disajikan
                        dengan sambal kecap yang khas dan lalapan segar, setiap
                        gigitan Sate Maranggi ini akan membawa Anda merasakan
                        sensasi yang memikat. Sate Maranggi adalah pilihan yang
                        sempurna untuk dinikmati sebagai hidangan pembuka atau
                        sebagai bagian dari santapan utama Anda. Segera nikmati
                        kelezatan Sate Maranggi ini hanya di restoran kami.
                      </p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="frontend/assets/img/menu/cordonblue.png" alt="" class="img-fluid"/>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="tab-2">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>chiken Satay</h3>
                      <p class="fst-italic">
                        Nikmati cita rasa autentik Asia Tenggara dengan Chicken
                        Satay kami yang lezat. Potongan daging ayam muda yang
                        empuk dan beraroma, disajikan dalam tusukan sate yang
                        lezat, dipanggang sempurna di atas bara arang dengan
                        cita rasa yang khas. Daging ayam kami direndam dalam
                        campuran bumbu rempah-rempah tradisional, menciptakan
                        kombinasi rasa yang menawan dan aroma yang menggugah
                        selera. Dipanggang hingga keemasan dengan cermat, setiap
                        gigitan Chicken Satay ini menghadirkan kesempurnaan rasa
                        dan tekstur yang memikat.
                      </p>
                      <p>
                        Disajikan dengan sambal kacang pedas yang kaya rasa dan
                        lalapan segar, setiap hidangan Chicken Satay adalah
                        perpaduan yang sempurna antara cita rasa yang otentik
                        dan pengalaman makan yang memuaskan. Chicken Satay
                        adalah pilihan yang tepat untuk dinikmati sebagai
                        hidangan pembuka yang menggugah selera atau sebagai
                        hidangan utama yang memuaskan. Segera nikmati kelezatan
                        Chicken Satay ini di restoran kami.
                      </p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="frontend/assets/img/menu/calamari.png"alt=""class="img-fluid"/>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="tab-3">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>Bacardi Black</h3>
                      <p class="fst-italic">
                        Bacardi bukanlah sekadar minuman beralkohol; itu adalah perpaduan sempurna antara tradisi, keahlian, dan kreativitas yang memancarkan kebebasan dan semangat petualangan. Setiap tetesnya menceritakan cerita tentang kebebasan, keunggulan, dan keindahan hidup yang menggelora.Ketika Anda meneguk Bacardi, Anda tidak hanya merasakan kelezatan rasa yang khas, tetapi Anda juga merasakan keanggunan dan keistimewaan, sebagai penjelajah yang menemukan keindahan di balik setiap pengalaman. Dengan Bacardi di tangan, setiap momen menjadi pesta, setiap pertemuan menjadi kisah, dan setiap langkah menjadi petualangan yang tak terlupakan.
                      </p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="frontend/assets/img/menu/b.png"alt=""class="img-fluid"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Specials Section -->




@endsection