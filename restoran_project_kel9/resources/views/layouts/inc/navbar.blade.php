    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div
          class="container d-flex justify-content-center justify-content-md-between"
        >
        @foreach ($footer as $f)
          <div class="contact-info d-flex align-items-center">
            <i class="bi bi-phone d-flex align-items-center"
              ><span>{!! $f->phone !!}</span></i
            >
            <i class="bi bi-clock d-flex align-items-center ms-4"
              ><span> {!! $f->opening_day !!} {{ $f->opening_hours }} AM - {{ $f->closing_hours }} PM</span>
            </i>
            
          </div>
          @endforeach
        </div>
      </div>
  
      <!-- ======= Header ======= -->
      <header id="header" class="fixed-top d-flex align-items-cente">
        @foreach ($footer as $fo)
        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">
        
          <h1 class="logo me-auto me-lg-0">
            <img src="assets/img/logo.png" alt="" />
            <a href="{{ route('frontend.home') }}">{!! $fo->logo_restoran !!}</a>
          </h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
  
          <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
              <li><a class="nav-link scrollto" href="{{ route('frontend.home') }}">{{ trans('panel.frontend.usefullinks.Home') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.about') }}">{{ trans('panel.frontend.usefullinks.Abouts') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.menu') }}">{{ trans('panel.frontend.usefullinks.Menu') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.signature') }}">{{ trans('panel.frontend.usefullinks.Signature') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.testimonial') }}">{{ trans('panel.frontend.usefullinks.Testimonials') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.galery') }}">{{ trans('panel.frontend.usefullinks.Galery') }}</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.chefs') }}">{{ trans('panel.frontend.usefullinks.Chefs') }}</a></li>
              <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="#">Drop Down 1</a></li>
                <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">Deep Drop Down 1</a></li>
                    <li><a href="#">Deep Drop Down 2</a></li>
                    <li><a href="#">Deep Drop Down 3</a></li>
                    <li><a href="#">Deep Drop Down 4</a></li>
                    <li><a href="#">Deep Drop Down 5</a></li>
                  </ul>
                </li>
                <li><a href="#">Drop Down 2</a></li>
                <li><a href="#">Drop Down 3</a></li>
                <li><a href="#">Drop Down 4</a></li>
              </ul>
            </li> -->
              <li><a class="nav-link scrollto" href="https://wa.me/6282113862854">{{ trans('panel.frontend.usefullinks.Contact') }}</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
          <!-- .navbar -->
          <a
            id="tombol"
            href="reservasi.html"
            class="book-a-table-btn scrollto d-none d-lg-flex"
            >{{ trans('panel.frontend.usefullinks.reservation') }}</a
          >
        </div>
        @endforeach
      </header>
      <!-- End Header -->
  