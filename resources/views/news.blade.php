
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>jobes@jobes.com</title>
    <meta charset="utf-8">
    <meta name="viewport" content="{{ csrf_token() }}">
    <link href="{{ asset('/img/logo/1600574490.png') }}" rel="icon">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('jobes/css/animate.css') }}">

    <link rel="stylesheet" href=" {{ asset('jobes/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jobes/css/owl.theme.default.min.css ') }}">
    <link rel="stylesheet" href=" {{ asset('jobes/css/magnific-popup.css') }}">

    <link rel="stylesheet" href=" {{ asset('jobes/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href=" {{ asset('jobes/css/jquery.timepicker.css') }}">

    <link rel="stylesheet" href=" {{ asset('jobes/css/flaticon.css') }}">
    <link rel="stylesheet" href=" {{ asset('jobes/css/style.css') }}">
  </head>
  <body>
		<div class="wrap">
	    <div class="container">

            @php($company=\App\Company::all())
             @foreach ( $company as $company )
				<div class="row justify-content-between">

					<div class="col-md-3 d-flex align-items-center">


                        <a class="navbar-brand" ><span> <img width="100" height="100" src="{{ asset('img/logo') . '/' . $company->companylogo }}" alt="Jobes Packaage & Delivery Company" class="brand-image img-circle elevation-3"</span></a>

					</div>
					<div class="col-md-7">


						<div class="row">
							<div class="col">
								<div class="top-wrap d-flex">
									<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-location-arrow"></span></div>
									<div class="text"><span>Address</span><span>{{ $company->companyaddress }}</span></div>
								</div>
							</div>
							<div class="col">
								<div class="top-wrap d-flex">
									<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-location-arrow"></span></div>
									<div class="text"><span>Call us</span><span>{{ $company->companyphone }}</span></div>
								</div>
							</div>
							<div class="col-md-3 d-flex justify-content-end align-items-center">
								<div class="social-media">
					    		<p class="mb-0 d-flex">
					    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
					    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
					    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
					    			<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
					    		</p>
				        </div>
							</div>
                        </div>

					</div>
                </div>
                @endforeach
			</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">

	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>


	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav mr-auto">
	        	<li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
	        	<li class="nav-item"><a href="{{ route('about.index') }}" class="nav-link">About</a></li>
	        	<li class="nav-item"><a href="{{ route('services.index') }}" class="nav-link">Services</a></li>
	        	<li class="nav-item"><a href="{{ route('news.index') }}" class="nav-link">News</a></li>
                <li class="nav-item"><a href="{{ route('contactus.index') }}" class="nav-link">Contact us</a></li>
            </ul>
            @if (Route::has('login'))
            <div class="float-left">
                <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Home</a></li>
                @else
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Sign In</a></li>
              @if (Route::has('register'))
              <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Sign UP</a></li>
              @endif
              @endauth
            </ul>
            </div>
             @endif
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    <div class="hero-wrap">
	    <div class="home-slider owl-carousel">
	      <div class="slider-item" style="background-image:url(img/logo/picha1.jpg);">
	      	<div class="overlay"></div>
	        <div class="container">
	          <div class="row no-gutters slider-text align-items-center justify-content-start">
		          <div class="col-md-6 ftco-animate">
		          	<div class="text w-100">
		          		<h2>We do it for you</h2>
			            <h1 class="mb-4">We transport your packages safely with reliable price</h1>
			            <p><a href="{{ route('login') }}" class="btn btn-primary">order the service</a></p>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>

	      <div class="slider-item" style="background-image:url(img/logo/photo.jpg);">
	      	<div class="overlay"></div>
	        <div class="container">
	          <div class="row no-gutters slider-text align-items-center justify-content-start">
		          <div class="col-md-6 ftco-animate">
		          	<div class="text w-100">
		          		<h2>We deliver packages safe</h2>
			            <h1 class="mb-4">We assure safely transportation and fast delivery of your packages</h1>
			            <p><a href="{{ route('login') }}" class="btn btn-primary">Order the service</a></p>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>
	    </div>
	  </div>

		<section class="intro">
			<div class="container intro-wrap">
				<div class="row no-gutters">
					<div class="col-md-12 col-lg-9 bg-intro d-sm-flex align-items-center align-items-stretch">
						<div class="intro-box d-flex align-items-center">
							<div class="icon d-flex align-items-center justify-content-center">
								<i class="flaticon-repair"></i>
							</div>
							<h2 class="mb-0">Are you ready? <span>Let's serve you!</span></h2>
						</div>
						<a href="{{ route('login') }}" class="bg-primary btn-custom d-flex align-items-center"><span>Order a Service Here</span></a>
					</div>
				</div>
			</div>
		</section>


        <section class="ftco-section">
      <div class="container">
        <div class="row">
            @php($news=\App\Blog::all())
             @foreach ( $news as $news )
          <div class="col-md-4 services ftco-animate">
            <div class="blog-entry align-self-stretch">

              <div class="text mt-3 ">
              	<div class="posted mb-3 d-flex">
              		<div class="desc pl-3">

              			<span>{{ 'Posted at:   ' }} {{ $news->created_at }}</span>
              		</div>
              	</div>
                <h3 class="heading"><a href="#">{{ $news->title }}</a></h3>
                <p>{{ $news->description }}</p>
              </div>

            </div>
          </div>
          @endforeach





        </div>
        <div class="row mt-5">

        </div>
      </div>
    </section>







        <footer class="footer ftco-section">
      <div class="container">
        @php($footer=\App\Company::all())
         @foreach ( $footer as $footer )
        <div class="row mb-5">
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
              <h2 class="logo"><a href="#">{{ $footer->companyname }}<span></span></a></h2>
              @php($ftt=\App\Aboutus::all())
             @foreach ( $ftt as $ftt )
              <p>{{ $ftt->description }}</p>
              @endforeach
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-4">
                <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Services</h2>
              @php($srv=\App\Service::all())
                @foreach ( $srv as $srv )
              <ul class="list-unstyled">
                <li><a href="#" class="py-1 d-block"><span class="fa fa-check mr-3"></span>{{ $srv->service_name }}</a></li>
              </ul>
              @endforeach
            </div>
          </div>
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Contact information</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon fa fa-map-marker"></span><span class="text">{{ $footer->companyaddress }}</span></li>
	                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">{{ $footer->companyphone }}</span></a></li>
	                <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">{{ $footer->companygst }}</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md-6 col-lg">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Business Hours</h2>
              <div class="opening-hours">
              	<h4>Opening Days:</h4>
              	<p class="pl-3">
              		<span>Monday – Friday : 9am to 20 pm</span>
              		<span>Saturday : 9am to 17 pm</span>
              	</p>
              	<h4>Vacations:</h4>
              	<p class="pl-3">
              		<span>All Sunday Days</span>
              		<span>All Official Holidays</span>
              	</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is customized with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="goddymj@gmail.com" target="_blank">GoBRIGHT</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
      @endforeach
    </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{ asset('jobes/js/jquery.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/popper.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/bootstrap.min.js') }}" ></script>
  <script src="{{ asset('jobes/js/jquery.easing.1.3.js ') }}"></script>
  <script src=" {{ asset('jobes/js/jquery.waypoints.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/jquery.stellar.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('jobes/js/bootstrap-datepicker.js ') }}"></script>
  <script src="{{ asset('jobes/js/jquery.timepicker.min.js ') }}"></script>
  <script src=" {{ asset('jobes/js/owl.carousel.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/jquery.magnific-popup.min.js') }}"></script>
  <script src=" {{ asset('jobes/js/scrollax.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{ asset('jobes/js/google-map.js ') }}"></script>
  <script src=" {{ asset('jobes/js/main.js') }}"></script>

  </body>
</html>

