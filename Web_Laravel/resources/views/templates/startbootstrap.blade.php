<!DOCTYPE html>
<html lang="id">
    <head>
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="E-Diagnostics pada Mata Kuliah Algoritma dan Pemrograman" />
        <meta name="author" content="Jahrulnr" />

        <title>Sistem E-Diagnostics</title>

        <!-- CSS -->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/custom.css" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
        <link href="/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet"> 
        <link href="/vendor/fontawesome/css/brands.min.css" rel="stylesheet"> 
        <link href="/vendor/fontawesome/css/regular.min.css" rel="stylesheet"> 
        <link href="/vendor/fontawesome/css/solid.min.css" rel="stylesheet"> 

        <!-- Script -->
        <script type="text/javascript">console.warn = () => {};</script>
        <script src="/vendor/jQuery/jquery-3.6.0.min.js"></script>
        <!-- <script src="/vendor/fontawesome/js/all.min.js"></script> -->
        <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/vendor/js-cookie/js.cookie.min.js"></script>
        <script src="/js/scripts.js"></script>
        <script src="/js/custom.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                // darkTime(true);
            });
        </script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="./">Sistem E-Diagnostics</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            </ul>
            <div class="mode-panel d-none d-md-flex">
                <div class="form-check form-switch">
                    <input class="form-check-input form-sm" type="checkbox" id="dark-mode">
                    <label class="form-check-label"><small>Dark Mode</small></label>
                </div>
            </div>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="/">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            @if(session('is_mahasiswa'))
                            <a class="nav-link" href="/mahasiswa/profil">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Profil
                            </a>
                            <a class="nav-link" href="/about">
                                <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                                Panduan
                            </a>
                            @elseif(session('is_dosen'))
                            <a class="nav-link" href="/dosen/profil">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Profil
                            </a>
                            <a class="nav-link" href="/about">
                                <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                                Panduan
                            </a>
                            @endif

                            <div class="sb-sidenav-menu-heading">Menu</div>
                            @if(session('is_admin'))
                                @yield('admin')
                            @elseif(session('is_dosen'))
                                @yield('dosen')
                            @else
                                @yield('mahasiswa')
                            @endif
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#m_keluar">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Keluar
                            </a>


                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    
                    <!-- Content -->
                    @yield('content')

                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-center small">
                            <div class="text-muted">Copyright &copy; {{ $_SERVER['HTTP_HOST'] }} 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Logout Modal -->
        <div class="modal fade" id="m_keluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><span class="fas fa-info-circle fa-sm"></span> Keluar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Yakin ingin keluar dari aplikasi?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <a href="/keluar" class="btn btn-primary">Keluar</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading -->
        <div class="w-100 h-100" id="load_page">
            <div class="loader">
                <ul>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                    <li><div></div></li>
                </ul>
                <h4>Loading ...</h4>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    var idleMax = 25; // Logout after 25 minutes of IDLE
    var idleTime = 0;

    var idleInterval = setInterval("timerIncrement()", 60000);  // 1 minute interval    
    $( "body" ).mousemove(function( event ) {
        idleTime = 0; // reset to zero
    });

    // count minutes
    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime > idleMax) { 
            window.location="/keluar#expired";
        }
    }       
</script>
