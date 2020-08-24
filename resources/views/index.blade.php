<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>拟物校园</title>
    <link rel="stylesheet" href="{{ URL::asset('index/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/piloz-icons.css') }}">
    
    <link rel="stylesheet" href="{{ URL::asset('index/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('index/css/responsive.css') }}">
</head>

<body>
    <div class="preloader">
        <img src="{{ URL::asset('index/images/logo.png') }}" height="100" class="preloader__image" alt="">
    </div><!-- /.preloader -->
    <div class="page-wrapper">
        <header class="site-header-one stricky site-header-one__fixed-top">
            <div class="container-fluid">
                <div class="site-header-one__logo">
                    <a href="">
                        <img src="{{ URL::asset('index/images/logo.png') }}" width="129" alt="">
                    </a>
                    <span class="side-menu__toggler"><i class="fa fa-bars"></i></span><!-- /.side-menu__toggler -->
                </div><!-- /.site-header-one__logo -->
                <div class="main-nav__main-navigation">
                    <ul class="main-nav__navigation-box one-page-scroll-menu">
                        <li class="scrollToLink"><a href="">首页</a></li>
                        <li class="scrollToLink"><a href="{{ route('h5.index') }}">前台</a></li>
                        <li class="scrollToLink"><a href="{{ route('admin.index') }}">后台</a></li>
                    </ul><!-- /.main-nav__navigation-box -->
                </div><!-- /.main-nav__main-navigation -->
            </div><!-- /.container-fluid -->
        </header><!-- /.site-header-one -->
        <section class="banner-one" id="home">
            <img src="{{ URL::asset('index/images/banner/banner-shape-1-1.png') }}" alt="Banner-Shape-1" class="banner-shape-1">
            <img src="{{ URL::asset('index/images/banner/banner-shape-1-2.png') }}" alt="Banner-Shape-2" class="banner-shape-2">
            <div class="banner-one__bg" style="background-image: url({{ URL::asset('index/images/banner/banner-bg-1.png') }});"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="banner-one__content">
                            <h3>拟物校园</h3>
                            <p>拟物校园是一款开源的高校教务爬虫系统，可查询学生个人信息，成绩，课表等。已支持正方教务，青果教务。</p>
                            <a href="https://github.com/nivin-studio/nivinEdu" class="thm-btn"><span>Github</span></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="banner-img wow fadeInUp" data-wow-duration="1500ms">
                            <img src="{{ URL::asset('index/images/shapes/banner-1-1.png') }}" class="banner-image__curvs" alt="">
                            <div class="banner-bg" style="background-image: url({{ URL::asset('index/images/banner/banner-shape-1-4.png') }})"></div>
                            <img src="{{ URL::asset('index/images/banner/banner-img-1.png') }}" alt="Banner-img">
                            <div class="banner-icon-1">
                                <i class="piloz-lamp"></i>
                            </div>
                            <div class="banner-icon-2">
                                <i class="piloz-shield"></i>
                            </div>
                            <div class="banner-icon-3">
                                <i class="piloz-human-resources"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="features" class="service-one">
            <div class="container">
                <div class="block-title text-center">
                    <h3>功能</h3>
                </div>
                <div class="row">
                    <div class=" col-xl-3 col-lg-3 col-md-6 wow fadeInLeft" data-wow-duration="1500ms">
                        <div class="service-one__single">
                            <div class="service-icon">
                                <div class="icon-box">
                                    <i class="piloz-user"></i>
                                </div>
                            </div>
                            <div class="text">
                                <h3>个人信息</h3>
                                <p>可以获取学生班级，专业，学院等个人信息。</p>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xl-3 col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="100ms">
                        <div class="service-one__single">
                            <div class="service-icon icon-bg-2">
                                <div class="icon-box icon-box-bg-2">
                                    <i class="piloz-linked"></i>
                                </div>
                            </div>
                            <div class="text">
                                <h3>成绩</h3>
                                <p>可以获取学生成绩，绩点，学分等信息</p>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xl-3 col-lg-3 col-md-6 wow fadeInDown" data-wow-duration="1500ms" data-wow-delay="200ms">
                        <div class="service-one__single">
                            <div class="service-icon icon-bg-3">
                                <div class="icon-box icon-box-bg-3">
                                    <i class="piloz-writing"></i>
                                </div>
                            </div>
                            <div class="text">
                                <h3>课表</h3>
                                <p>可以获取学生课表，时间，地点等信息</p>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xl-3 col-lg-3 col-md-6 wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="300ms">
                        <div class="service-one__single">
                            <div class="service-icon icon-bg-4">
                                <div class="icon-box icon-box-bg-4">
                                    <i class="piloz-gear"></i>
                                </div>
                            </div>
                            <div class="text">
                                <h3>后台</h3>
                                <p>后台可配置学校信息，操作学生信息，学生成绩，学生课表等</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cta-two">
            <img src="{{ URL::asset('index/images/shapes/cta-2-shape-1.png') }}" class="cta-two__bg-shape-1" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="cta-two__content">
                            <div class="block-title cus-pb">
                                <h3>后台管理</h3>
                            </div>
                            <div class="cta-two__text">
                                <p>后台采用开源的Dcat Admin搭建而成，使用很少的代码快速构建一个功能完善的高颜值后台系统，内置丰富的后台常用组件，开箱即用，让开发者告别冗杂的HTML代码。</p>
                            </div>
                            <ul class="list-unstyled cta-two__list">
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    管理学生信息
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    管理学生成绩
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    管理学生课表
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="cta-two__moc wow fadeInLeft" data-wow-duration="1500ms">
                            <img src="{{ URL::asset('index/images/resources/cta-2-moc-1.png') }}" class="cta-one__moc-img" alt="">
                        </div>
                    </div><!-- /.col-xl-6 -->
                </div>
            </div>
        </section>
        <section class="brand-one">
            <div class="container">
                <div class="block-title text-center">
                    <h3>支持院校</h3>
                </div>
                <div class="brand-one__carousel owl-carousel thm__owl-carousel owl-theme" data-options='{"loop": true, "autoplay": true, "autoplayHoverPause": true, "autoplayTimeout": 5000, "items": 5, "dots": false, "nav": false, "margin": 100, "smartSpeed": 700, "responsive": { "0": {"items": 2, "margin": 30}, "480": {"items": 3, "margin": 30}, "991": {"items": 4, "margin": 50}, "1199": {"items": 5, "margin": 100}}}'>
                    @foreach ($schools as $school)
                        <div class="item">
                            <img src="{{ $school->icon }}" alt="">
                        </div>
                    @endforeach
                </div><!-- /.brand-one__carousel owl-carousel thm__owl-carousel owl-theme -->
            </div><!-- /.container -->
        </section><!-- /.brand-one -->
        <footer class="site-footer">
            <div class="site-footer-bg" style="background-image: url({{ URL::asset('index/images/resources/footer-bg-shape-1.png') }})">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="footer-upper text-center">
                            <div class="footer-logo">
                                <img src="{{ URL::asset('index/images/resources/footer-logo.png') }}" alt="Footer Logo">
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="">首页</a></li>
                                    <li><a href="{{ route('h5.index') }}">前台</a></li>
                                    <li><a href="{{ route('admin.index') }}">后台</a></li>
                                    <li><a href="https://github.com/nivin-studio/nivinEdu">Github</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-footer__bottom">
                <div class="container text-center">
                    <p>Copyright &copy; 2020. 拟物工作室 All rights reserved.</p>
                </div><!-- /.container -->
            </div>
        </footer>
    </div><!-- /.page-wrapper -->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <div class="side-menu__block">
        <div class="side-menu__block-overlay custom-cursor__overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div>
        <div class="side-menu__block-inner ">
            <div class="side-menu__top justify-content-end">
                <a href="#" class="side-menu__toggler side-menu__close-btn">
                    <img src="{{ URL::asset('index/images/shapes/close-1-1.png') }}" alt="">
                </a>
            </div>
            <nav class="mobile-nav__container">
                <!-- content is loading via js -->
            </nav>
        </div>
    </div>
    <script src="{{ URL::asset('index/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/isotope.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/TweenMax.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/wow.js') }}"></script>
    <script src="{{ URL::asset('index/js/jquery.easing.min.js') }}"></script>
    <script src="{{ URL::asset('index/js/theme.js') }}"></script>
</body>

</html>