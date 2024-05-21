@extends('index')

@section('section')

  <!-- ======= Menu Section ======= -->
  <section id="menu" class="menu section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>{{ trans('panel.menu_1') }}</h2>
        <p>{{ trans('panel.menu_2') }}</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
            <ul id="menu-flters">
                <li data-filter="*" class="filter-active">All</li>
                <!-- filter berdasarkan category pada model product -->
                @foreach(\App\Models\Product::CATEGORY_SELECT as $key => $value)
                <li data-filter=".filter-{{ strtolower($key) }}">{{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>
      <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">
        @foreach ($products as $p)
        <div class="col-lg-6 menu-item filter-{{ strtolower($p->category) }}">
          <img src="{{ $p->getFirstMediaUrl('image', 'priview') }}" class="menu-img" alt="{{ $p->name }}"/>
          <div class="menu-content">
            <a href="#">{{ $p->name }}</a><span>Rp.{{$p->price}}</span>
          </div>
          <div class="menu-ingredients">
           {{$p->description}}
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>


  {{-- <section id="menu" class="menu section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Menu</h2>
        <p>Check Our Tasty Menu</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="menu-flters">
            <!-- <li data-filter="*" class="filter-active">All</li> -->
            <li data-filter=".filter-starters">Menu Utama</li>
            <li data-filter=".filter-salads">Appetizer</li>
            <li data-filter=".filter-specialty">Dessert</li>
            <li data-filter=".filter-drink">Drink</li>
          </ul>
        </div>
      </div>

      <div
        class="row menu-container"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        <div class="col-lg-6 menu-item filter-starters">
          <img
            src="assets/img/menu/chikencroucet.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Chicken Croucet</a><span>Rp 45.000</span>
          </div>
          <div class="menu-ingredients">
            Roti panggang dengan toping tomat,bawang,dan basil
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-starters">
          <img src="assets/img/menu/cordonblue.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Chicken Cordon Blue</a><span>Rp 120.000</span>
          </div>
          <div class="menu-ingredients">
            Sate 10 tusuk yang menggunakan daging sapi dengan bumbu marinade
            yang dipanggang diatas bara,memberikan aroma yang khas
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-starters">
          <img
            src="assets/img/menu/calamari.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Calamari</a><span>Rp 99.000</span>
          </div>
          <div class="menu-ingredients">
            Soto tangkar dengan kuah yang kental dan gurih dengan potongan
            daging sapi yang empuk
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-starters">
          <img
            src="assets/img/menu/tuna.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Tuna Salad</a><span>Rp 99.000</span>
          </div>
          <div class="menu-ingredients">
            Potongan iga sapi yang dipanggang sampai empuk dan berlemak
            dengan balutan bumbu yang meresap
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img
            src="assets/img/menu/cromboloni.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Cromboloni</a><span>Rp 70.000</span>
          </div>
          <div class="menu-ingredients">
            Chocolate,Strawberry,GreenTea,Vanilla cheese
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-drink">
          <img src="assets/img/menu/b.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Bacardi</a><span>Rp 500.000</span>
          </div>
          <div class="menu-ingredients">-</div>
        </div>
        <div class="col-lg-6 menu-item filter-drink">
          <img src="assets/img/menu/chivas.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Chivas Regal</a><span>Rp 1.800.000</span>
          </div>
          <div class="menu-ingredients">
            Donat yang digoreng dengan mentega dan ditaburi gula halus
          </div>
        </div>
        <div class="col-lg-6 menu-item filter-drink">
          <img src="assets/img/menu/jeiger.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Jeigermeister</a><span>Rp 850.000</span>
          </div>
          <div class="menu-ingredients">
            Donat yang digoreng dengan mentega dan ditaburi gula halus
          </div>
        </div>
        <div class="col-lg-6 menu-item filter-drink">
          <img
            src="assets/img/menu/juskngkng.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Jus Kangkung</a><span>Rp 50.000</span>
          </div>
          <div class="menu-ingredients">
            Donat yang digoreng dengan mentega dan ditaburi gula halus
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-salads">
          <img src="assets/img/menu/kentang.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">French Fries</a><span>Rp 30.000</span>
          </div>
          <div class="menu-ingredients">
            Hidangan dari potongan tortila dengan keju leleh,daging
            cincang,saus salsa.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img
            src="assets/img/menu/olliebollen.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Olliebollen Cornelis De Houtman</a
            ><span>Rp 70.000</span>
          </div>
          <div class="menu-ingredients">
            Donat yang digoreng dengan mentega dan ditaburi gula halus
          </div>
        </div>


        <div class="col-lg-6 menu-item filter-salads">
          <img src="assets/img/menu/pastry.png" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Pastry</a><span>Rp 25.000</span>
          </div>
          <div class="menu-ingredients">
            Pastry puff yang diisi dengan campuran jamur duxelles yang
            lezat, kemudian dipanggang hingga keemasan dan disajikan dengan
            saus rempah khas.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-salads">
          <img
            src="assets/img/menu/chiken-satay.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Chiken Satay</a><span>Rp 40.000</span>
          </div>
          <div class="menu-ingredients">
            Potongan daging ayam yang ditusuk dengan tusukan sate, kemudian
            dipanggang atau dibakar, dan disajikan dengan saus kacang.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img
            src="assets/img/menu/stroopwafel.png"
            class="menu-img"
            alt=""
          />
          <div class="menu-content">
            <a href="#">Stroopwafel Pieter Both</a><span>Rp 55.000</span>
          </div>
          <div class="menu-ingredients">
            Stroopwafel adalah kue tipis yang terbuat dari dua lapisan wafel
            yang dipisahkan oleh lapisan sirup karamel yang lengket
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- End Menu Section -->



@endsection