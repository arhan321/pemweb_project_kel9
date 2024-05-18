    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div
          class="container d-flex justify-content-center justify-content-md-between"
        >
          <div class="contact-info d-flex align-items-center">
            <i class="bi bi-phone d-flex align-items-center"
              ><span>+1 5589 55488 55</span></i
            >
            <i class="bi bi-clock d-flex align-items-center ms-4"
              ><span> Mon-Sat: 11AM - 23PM</span></i
            >
          </div>
  
          <div class="languages d-none d-md-flex align-items-center">
            <ul>
              <li>En</li>
              <li><a href="#">De</a></li>
            </ul>
          </div>
        </div>
      </div>
  
      <!-- ======= Header ======= -->
      <header id="header" class="fixed-top d-flex align-items-cente">
        <div
          class="container-fluid container-xl d-flex align-items-center justify-content-lg-between"
        >
          <h1 class="logo me-auto me-lg-0">
            <img src="assets/img/logo.png" alt="" />
            <a href="{{ route('frontend.home') }}">Han`s Bar And Restaurant</a>
          </h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
  
          <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
              <li><a class="nav-link scrollto active" href="{{ route('frontend.home') }}">Home</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.about') }}">About</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.menu') }}">Menu</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.signature') }}">Signature</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.testimonial') }}">Testimonials</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.galery') }}">Gallery</a></li>
              <li><a class="nav-link scrollto" href="{{ route('frontend.chefs') }}">Chefs</a></li>
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
              <li><a class="nav-link scrollto" href="https://wa.me/6282113862854">Contact Us</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
          <!-- .navbar -->
          <a
            id="tombol"
            href="reservasi.html"
            class="book-a-table-btn scrollto d-none d-lg-flex"
            >Reservation</a
          >
        </div>
      </header>
      <!-- End Header -->
  