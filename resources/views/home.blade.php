<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> {{ config('app.name') }}</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/assets/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('front/assets/images/favicons/site.webmanifest') }}" />
    <meta name="description" content="Jetly HTML 5 Template " />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">

    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('front/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/nouislider/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/nouislider/nouislider.pips.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/jetly-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/tiny-slider/tiny-slider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/reey-font/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/owl-carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/bxslider/jquery.bxslider.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/vegas/vegas.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/timepicker/timePicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/vendors/nice-select/nice-select.css') }}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/jetly.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/jetly-responsive.css') }}" />
</head>

<body class="custom-cursor">


    <div class="page-wrapper">
        <header class="main-header-three">
            <div class="main-header-three__top">
                <div class="main-header-three__top-inner">
                    <div class="main-header-three__top-left">
                        <ul class="list-unstyled main-header-three__contact-list">
                            <li>
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text">
                                    <p>Kavumu Airport International</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="text">
                                    <p><a href="mailto:needhelp@kavumu.com">needhelp@kavumu.com</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="main-header-three__top-right">
                        <div class="main-header-three__social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main-menu main-menu-three">
                <div class="main-menu-three__wrapper">
                    <div class="main-menu-three__wrapper-inner">
                        <div class="main-menu-three__left">
                            <div class="main-menu-three__logo">
                                <a href="index.html"><img src="assets/images/resources/logo-2.png" alt=""></a>
                            </div>
                        </div>
                        <div class="main-menu-three__main-menu-box">
                            <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                            <ul class="main-menu__list one-page-scroll-menu">
                                <li class="scrollToLink">
                                    <a href="#home">Home </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="stricky-header stricked-menu main-menu main-menu-three">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <!--Main Slider Start-->
        <section class="main-slider-three clearfix" id="home">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{
        "slidesPerView": 1,
        "allowTouchMove": false,
        "loop": false,
        "effect": "fade",
        "pagination": {
            "el": "#main-slider-pagination",
            "type": "bullets",
            "clickable": true
        },
        "navigation": {
            "nextEl": "#main-slider__swiper-button-next",
            "prevEl": "#main-slider__swiper-button-prev"
        }}'>
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="image-layer-three"
                            style="background-image: url('{{ asset('front/assets/images/backgrounds/airport-mis-bg.png') }}');"></div>
                        <div class="main-slider-three__img">
                            <img src="{{ asset('front/assets/images/resources/mis-dashboard-preview.png') }}"
                                alt="MIS Dashboard Preview" class="float-bob-y">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="main-slider-three__content">
                                        <p class="main-slider-three__sub-title">Kavumu Airport MIS</p>
                                        <h2 class="main-slider-three__title">Manage Flights, Passengers & Staff <br> All in One Place</h2>

                                        @if (Route::has('login'))
                                        <div class="main-slider-three__btn-box">
                                            @auth
                                            <a href="{{ url('/dashboard') }}" class="thm-btn main-slider__btn">
                                                Go to Dashboard
                                            </a>
                                            @else
                                            <a href="{{ route('login') }}" class="thm-btn main-slider__btn">
                                                Log in
                                            </a>
                                            @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="thm-btn main-slider__btn-two">
                                                Register
                                            </a>
                                            @endif
                                            @endauth
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Slide -->

                </div>
            </div>
        </section>
        <!--Main Slider End-->


    </div><!-- /.page-wrapper -->

    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assets/images/resources/logo-1.png" width="143"
                        alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:needhelp@kavumu.com">needhelp@kavumu.com</a>
                </li>
                <li>
                    <i class="fa fa-phone-alt"></i>
                    <a href="tel:+25088006780">+250 788 006 780</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-facebook-square"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->

        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="icon-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="icon-right-arrow"></i></a>


    <script src="{{ asset('front/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/odometer/odometer.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/tiny-slider/tiny-slider.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/isotope/isotope.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/countdown/countdown.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/bxslider/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/vegas/vegas.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/timepicker/timePicker.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/circleType/jquery.circleType.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/circleType/jquery.lettering.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendors/nice-select/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('front/assets/js/jetly.js') }}"></script>
</body>

</html>