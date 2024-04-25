<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Restaurantly Bootstrap Template - Index</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

  @include('layouts.inc.link')
  </head>

  <body>
     @include('layouts.inc.navbar')

     @yield('content')

  
    @include('layouts.inc.footer')

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    @include('layouts.inc.script')
  </body>
</html>
