<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MTSS AL-MUNAWAROH</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('main/assets/img/logo-mts.png') }}" rel="icon">
  <link href="{{ asset('main/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('main/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('main/assets/css/main.css') }}" rel="stylesheet"> 

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">LMS ISLAH</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          {{-- <li><a href="#features">Features</a></li> --}}
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="#contact">Contact</a></li>
          <a href="{{ route('login') }}" class="btn btn-primary text-light rounded-pill py-2 px-4 ms-3">Login</a>
          <a href="{{ route('register') }}" class="btn btn-light text-dark rounded-pill py-2 px-4 ms-3">Daftar</a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <img src="assets/img/hero-bg-2.jpg" alt="" class="hero-bg">

      <div class="container">
        <div class="row gy-4 justify-content-between">
          <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ asset('main/assets/img/student.png') }}" class="img-fluid animated" alt="Hero Image">

          </div>

          <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
            <h1>MTSS <span><br>AL-MUNAWAROH</span></h1>
            <p>"Mewujudkan generasi rabbani, berjiwa qur'ani yang berbekal iman dan taqwa (IMTAQ) serta ilmu pengetahuan dan teknologi (IPTEK)" </p>
            <div class="d-flex">
              <a href="{{ route('register') }}" class="btn-get-started">Daftar Sekarang</a>
            </div>
          </div>

        </div>
      </div>

      <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
          <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
        </defs>
        <g class="wave1">
          <use xlink:href="#wave-path" x="50" y="3"></use>
        </g>
        <g class="wave2">
          <use xlink:href="#wave-path" x="50" y="0"></use>
        </g>
        <g class="wave3">
          <use xlink:href="#wave-path" x="50" y="9"></use>
        </g>
      </svg>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
  
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-xl-center gy-5">
  
          <div class="col-xl-5 content">
            <h3>About Us</h3>
            <h2>MTSS AL-MUNAWAROH</h2>
            <p>Sistem ini dirancang untuk membantu pengelolaan sekolah, mulai dari administrasi, akademik, hingga laporan antara guru, siswa, dan orang tua. Dengan teknologi terkini, kami berkomitmen untuk meningkatkan mutu pendidikan.</p>
            <a href="{{ route('login') }}" class="read-more"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
          </div>
  
          <div class="col-xl-7">
            <div class="row gy-4 icon-boxes">
  
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box">
                  <i class="bi bi-display"></i>
                  <h3>Sistem Terintegrasi</h3>
                  <p>Menyediakan sistem untuk proses PPDB, media pembelajaran, dan perpustakaan berbasis online dalam satu tempat.</p>
                </div>
              </div> <!-- End Icon Box -->
  
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-people"></i>
                  <h3>Interaksi Guru & Siswa</h3>
                  <p>Memudahkan komunikasi antara guru, siswa, dan orang tua melalui sistem ini.</p>
                </div>
              </div> <!-- End Icon Box -->
  
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-clipboard-check"></i>
                  <h3>Monitoring & Evaluasi</h3>
                  <p>Orang tua dan guru dapat memantau perkembangan akademik siswa secara real-time dengan sistem pelaporan yang transparan.</p>
                </div>
              </div> <!-- End Icon Box -->
  
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-cloud-upload"></i>
                  <h3>Akses Fleksibel</h3>
                  <p>Sistem berbasis online memungkinkan akses kapan saja dan di mana saja, mendukung pembelajaran yang lebih dinamis.</p>
                </div>
              </div> <!-- End Icon Box -->
  
            </div>
          </div>
  
        </div>
      </div>
  
    </section><!-- /About Section -->


   <!-- Features Section -->
    {{-- <section id="features" class="features section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="features-item">
              <i class="bi bi-display" style="color: #ffbb2c;"></i>
              <h3><a href="" class="stretched-link">E-Learning Interaktif</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="features-item">
              <i class="bi bi-clipboard-data" style="color: #5578ff;"></i>
              <h3><a href="" class="stretched-link">Manajemen Absensi</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="features-item">
              <i class="bi bi-chat-dots" style="color: #e80368;"></i>
              <h3><a href="" class="stretched-link">Laporan Akademik</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="features-item">
              <i class="bi bi-calendar-check" style="color: #e361ff;"></i>
              <h3><a href="" class="stretched-link">Media Pembelajaran</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="features-item">
              <i class="bi bi-file-earmark-text" style="color: #47aeff;"></i>
              <h3><a href="" class="stretched-link">Tugas</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="features-item">
              <i class="bi bi-bell" style="color: #ffa76e;"></i>
              <h3><a href="" class="stretched-link">Notifikasi</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="features-item">
              <i class="bi bi-people" style="color: #11dbcf;"></i>
              <h3><a href="" class="stretched-link">Kolaborasi Guru & Siswa</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="features-item">
              <i class="bi bi-camera-video" style="color: #4233ff;"></i>
              <h3><a href="" class="stretched-link">Perpustakaan Digital</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
            <div class="features-item">
              <i class="bi bi-shield-lock" style="color: #b2904f;"></i>
              <h3><a href="" class="stretched-link">Keamanan Data</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
            <div class="features-item">
              <i class="bi bi-cloud-upload" style="color: #b20969;"></i>
              <h3><a href="" class="stretched-link">Penyimpanan Buku Digital</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1100">
            <div class="features-item">
              <i class="bi bi-bar-chart" style="color: #ff5828;"></i>
              <h3><a href="" class="stretched-link">Analisis Perkembangan</a></h3>
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1200">
            <div class="features-item">
              <i class="bi bi-phone" style="color: #29cc61;"></i>
              <h3><a href="" class="stretched-link">Akses Terjangkau</a></h3>
            </div>
          </div><!-- End Feature Item -->

        </div>

      </div>

    </section><!-- /Features Section --> --}}


    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-emoji-smile"></i>
            <div class="stats-item">
                <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\User::count() }}" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total Pengguna</p>
            </div>
        </div>
        

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-journal-richtext"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
              <p>Projects</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-headset"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
              <p>Hours Of Support</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-people"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
              <p>Hard Workers</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Details Section -->
    <section id="details" class="details section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Details</h2>
        <div><span>Check Our Details</span> <span class="description-title"></span></div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ asset('main/assets/img/gambar-1.jpg') }}" class="img-fluid" alt="E-Learning Interaktif">
          </div>
          <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            <h3>E-Learning Interaktif</h3>
            <p class="fst-italic">
              MTSS AL-MUNAWAROH menyediakan sistem pembelajaran interaktif dengan materi yang bisa diakses kapan saja dan di mana saja.
            </p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Materi pembelajaran dan tugas.</span></li>
              <li><i class="bi bi-check"></i> <span>Akses mudah melalui perangkat komputer dan mobile.</span></li>
              <li><i class="bi bi-check"></i> <span>Materi ajar yang diperbarui secara berkala.</span></li>
            </ul>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ asset('main/assets/img/gambar-3.jpg') }}" class="img-fluid" alt="Manajemen Nilai & Absensi">
          </div>
          <div class="col-md-7 order-2 order-md-1" data-aos="fade-up" data-aos-delay="200">
            <h3>Manajemen Absensi</h3>
            <p class="fst-italic">
              Guru dapat mengelola absensi siswa dengan mudah melalui sistem.
            </p>
            <p>
              Absensi kehadiran siswa dapat langsung diinput ke dalam sistem dan dapat diakses oleh orang tua serta siswa sendiri.
            </p>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out">
            <img src="{{ asset('main/assets/img/gambar-2.jpg') }}" class="img-fluid" alt="Forum Diskusi & Komunikasi">
          </div>
          <div class="col-md-7" data-aos="fade-up">
            <h3>Perpustakaan Digital</h3>
            <p>Sistem ini menyediakan bacaan buku digital yang memungkinkan siswa untuk membaca buku secara digital.</p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Akses mudah ke dunia literasi!</span></li>
              <li><i class="bi bi-check"></i> <span>Tempat terbaik untuk menjelajahi ilmu pengetahuan tanpa batas!</span></li>
              <li><i class="bi bi-check"></i> <span>Jelajahi dunia pengetahuan dengan koleksi buku digital.</span></li>
            </ul>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out">
            <img src="{{ asset('main/assets/img/gambar-4.jpg') }}" class="img-fluid" alt="Keamanan & Privasi">
          </div>
          <div class="col-md-7 order-2 order-md-1" data-aos="fade-up">
            <h3>Keamanan & Privasi</h3>
            <p class="fst-italic">
              Data pengguna tetap aman serta kontrol akses yang ketat.
            </p>
            <p>
              Sistem ini dirancang dengan teknologi keamanan terbaru untuk memastikan data akademik dan informasi pribadi siswa tetap terjaga.
            </p>
          </div>
        </div><!-- Features Item -->

      </div>

    </section><!-- /Details Section -->


    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <div><span>Check Our</span> <span class="description-title">Gallery</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-1.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-1.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-2.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-2.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-3.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-3.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-4.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-4.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-5.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-5.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-6.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-6.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-7.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-7.jpg') }}"alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-8.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="{{ asset('main/assets/img/gallery/gallery-8.jpg') }}" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

        </div>

      </div>

    </section><!-- /Gallery Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section dark-background">

      <img src="{{ asset('main/assets/img/testimonials-bg.jpg') }}" class="testimonials-bg" alt="">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <div><span>Check Our</span> <span class="description-title">Team</span></div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="pic"><img src="{{ asset('main/assets/img/team/team-1.jpg') }}" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Hendra Permana., S.Pd.I</h4>
                <span>Kepala Madrasah</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <div class="pic"><img src="{{ asset('main/assets/img/team/team-2.jpg') }}" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Enong Rina., S.Pd.I</h4>
                <span>Wakil Kepala Madrasah Kurikulum</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <div class="pic"><img src="{{ asset('main/assets/img/team/team-3.jpg') }}" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Cecep Roslan., S.I.Pust</h4>
                <span>TU/Operator</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Buku Section -->
    <section id="buku" class="buku section py-5 bg-light">
      <div class="container" data-aos="fade-up">
          <!-- Section Title -->
          <div class="text-center mb-5">
              <h2 class="fw-bold">Daftar Buku</h2>
              <p class="text-muted">Temukan <span class="fw-semibold text-primary">Buku Favorit Anda</span></p>
          </div>
          <!-- End Section Title -->

          <div class="row gy-4">
              @php
                  $buku = \App\Models\Buku::all(); // Ambil data buku langsung dari model
              @endphp

              @foreach ($buku as $item)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                      <div class="card h-100 shadow-sm border-0">
                          <div class="card-img-top-wrapper text-center p-3">
                              <img src="{{ asset('storage/' . $item->cover_buku) }}" class="card-img-top img-fluid" style="max-height: 200px; width: auto;" alt="{{ $item->judul }}">
                          </div>
                          <div class="card-body d-flex flex-column">
                              <h5 class="card-title text-primary">{{ $item->judul }}</h5>
                              <h6 class="text-muted">{{ $item->penulis }}</h6>
                              <p class="card-text flex-grow-1">{{ Str::limit($item->deskripsi, 100) }}</p>
                              @if(Auth::check())
                                  <a href="#" class="btn btn-outline-primary mt-auto">Lihat Detail</a>
                              @else
                                  <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto">Baca</a>
                              @endif
                          </div>
                      </div>
                  </div><!-- End Book Item -->
              @endforeach
          </div>
      </div>
    </section><!-- /Buku Section -->


    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <div class="container-fluid">

        <div class="row gy-4">

          <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

            <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
              <h3><span>FAQ </span><strong></strong></h3>
              <p>
                Berikut adalah beberapa pertanyaan yang sering diajukan terkait dengan penggunaan LMS MTSS AL-Munawaroh.
              </p>
            </div>

            <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

              <div class="faq-item faq-active">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Bagaimana cara mendaftar dan mengakses LMS?</h3>
                <div class="faq-content">
                  <p>Untuk mendaftar, siswa dan guru akan mendapatkan akun dari pihak sekolah. Setelah login menggunakan akun yang diberikan, pengguna dapat langsung mengakses materi pembelajaran dan fitur lainnya.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apa saja fitur utama yang tersedia dalam LMS ini?</h3>
                <div class="faq-content">
                  <p>LMS ini menyediakan fitur seperti Media pembelajaran, pengelolaan materi dan tugas, laporan absensi, serta perpustakaan untuk media bacaan secara digital.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apakah LMS ini bisa diakses melalui perangkat mobile?</h3>
                <div class="faq-content">
                  <p>Ya, LMS MTSS AL-MUNAWAROH dapat diakses melalui komputer, laptop, tablet, maupun smartphone, sehingga siswa dan guru dapat belajar dengan fleksibel dari mana saja.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div>

          <div class="col-lg-5 order-1 order-lg-2">
            <img src="{{ asset('main/assets/img/faq.jpg') }}" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
          </div>
        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <div><span>Check Our</span> <span class="description-title">Contact</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Alamat</h3>
                <p>Kp. Cikupa RT:03 RW:06 Desa Sukamanah Kec Rongga Kab Bandung Barat</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Telepon</h3>
                <p>+62 0123 1112 322</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>info@example.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">MTSS<br>Al-Munawaroh</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Kp. Cikupa RT:03 RW:06 Desa Sukamanah</p>
            <p>Kec. Rongga Kab. Bandung Barat</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62 0123 1112 322</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">MTS Al-Munawaroh</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
    <script src="{{ asset('main/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('main/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('main/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('main/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('main/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('main/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  
    <!-- Main JS File -->
    <script src="{{ asset('main/assets/js/main.js') }}"></script>

</body>

</html>