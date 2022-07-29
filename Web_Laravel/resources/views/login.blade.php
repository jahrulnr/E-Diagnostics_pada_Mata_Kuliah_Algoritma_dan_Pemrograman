<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="E-Diagnostics pada Mata Kuliah Algoritma dan Pemrograman" />
        <meta name="author" content="Jahrulnr" />

        <!-- Refresh token laravel every 25 minutes -->
        <meta http-equiv="refresh" content="1500">

        <title>Login | E-Diagnostics</title>
        
        <!-- style -->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/custom.css" rel="stylesheet" />

        <!-- Core -->
        <link href="/vendor/fontawesome/css/all.min.css" rel="stylesheet">
        <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="/vendor/jQuery/jquery-3.6.0.min.js"></script>

        <!-- Toastr -->
        <script src="/vendor/toastr/toastr.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/vendor/toastr/toastr.min.css">
    </head>
    <body class="bg-success">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-dark text-white">
                                        <div class="d-flex justify-content-center my-4">
                                            <div class="col-auto">
                                                <img src="/assets/img/uir.png" id="logo">
                                            </div>
                                            <div class="ms-1 col-auto">
                                                <h3 class="text-center font-weight-light">
                                                    <i>E-Diagnostics</i>
                                                </h3>
                                                <h5 class="text-center font-weight-light">
                                                    Algoritma dan Pemrograman
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- AutoLogout -->
                                        <div class="card card-body bg-danger d-none text-white mb-3" id="expired">
                                            Sistem keluar secara otomatis karena tidak ada aktivitas selama 25 menit.
                                        </div>

                                        <!-- Reset Pass -->
                                        <div class="card card-body bg-info d-none text-white mb-3" id="konfirmasi_reset">
                                            Silakan cek email yang terpaut pada akun anda.
                                        </div>

                                        <!-- AutoLogout -->
                                        <div class="card card-body bg-success d-none text-white mb-3" id="reset_sukses">
                                            Password berhasil diubah. Silakan login.
                                        </div>

                                        <div class="d-flex justify-content-end mb-1">
                                            <a href="/about">Panduan Aplikasi</a>
                                        </div>

                                        <!-- Admin/Dosen Login -->
                                        <form method="POST" action="/login" id="inputEmail">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" type="email" placeholder="nama@contoh.com" name="email" required />
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="form-floating flex-grow-1">
                                                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" required />
                                                    <label for="password">Password</label>
                                                </div>
                                                <a href="#" class="input-group-text cp_type">
                                                    <span class="fas fa-eye-slash"></span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small reset_form" href="#">Lupa Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>

                                        <!-- Mahasiswa Login -->
                                        <form method="POST" action="/mahasiswa/login" id="inputNPM" style="display: none;">
                                            @csrf
                                            <div class="card mb-3 bg-primary text-white">
                                                <div class="row g-0">
                                                    <div class="col-2">
                                                        <img src="/assets/img/app-icon.png" class="h-100 w-100 rounded-start" />
                                                    </div>
                                                    <div class="col-10 my-auto">
                                                        <div class="card-body p-2">
                                                            <a class="card-text text-white" href="/files/E-Diagnostics.apk">
                                                                Download aplikasi untuk akses lebih mudah!
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="npm" type="text" placeholder="173500000" name="npm" required />
                                                <label for="npm">NPM</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="form-floating flex-grow-1">
                                                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" required />
                                                    <label for="password">Password</label>
                                                </div>
                                                <a href="#" class="input-group-text cp_type">
                                                    <span class="fas fa-eye-slash"></span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small reset_form" href="#">Lupa Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>

                                        <!-- Reset Pass -->
                                        <form method="POST" action="/reset" id="reset_form" style="display: none;">
                                            @csrf
                                            <div class="form-floating">
                                                <input class="form-control" type="text" placeholder="nama@contoh.com" name="user" required />
                                                <label for="email">Email/NPM</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center bg-dark text-white py-3 btnLogin">
                                        <div class="small" id="login_switch">
                                            <span>Bukan Admin?</span>
                                            <a href="#">
                                                Login sebagai Mahasiswa
                                            </a>
                                        </div>
                                        <div class="small" id="login_fReset" style="display:none">
                                            <span>Login?</span>
                                            <a href="#">
                                                Kembali ke halaman Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                if(window.location.hash == '#login_gagal')
                    toastr.error('User/Password tidak ditemukan');
                if(window.location.hash == '#expired')
                    $('#expired').removeClass('d-none');
                if(window.location.hash == '#reset_confirm')
                    $('#konfirmasi_reset').removeClass('d-none');
                if(window.location.hash == '#reset_success')
                    $('#reset_sukses').removeClass('d-none');
                if(window.location.hash == '#account_not_found')
                    toastr.error('Email/NPM tidak ditemukan');
                if(window.location.hash == '#reset'){
                    var $this = $('#login_switch');
                    $('#reset_form, #login_fReset').show();
                    $('#inputEmail, #inputNPM, #login_switch').hide();

                    $this.find('span').html($this.find('span').html().replace('Admin?', 'Mahasiwa?'));
                    $this.find('a').html($this.find('a').html().replace('Mahasiswa', 'Admin'));
                    
                }

                $('.cp_type').click(function(){
                    var $pass = $('input[name="password"]');
                    if($pass.attr('type') == 'password'){
                        $pass.attr('type', 'text');
                        $('#cp_type .fas').removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                    else{
                        $pass.attr('type', 'password');
                        $('#cp_type .fas').removeClass('fa-eye').addClass('fa-eye-slash');
                    }
                });

                $('#login_switch a, #login_fReset a').click(function(){
                    var $this = $('#login_switch');

                    if($('#reset_form').css('display') != 'none' || $('#inputNPM').css('display') != 'none'){
                        $('#inputEmail').show();
                        $('#inputNPM, #reset_form, #login_fReset').hide();
                        $this.find('span').html($this.find('span').html().replace('Mahasiwa?', 'Admin?'));
                        $this.find('a').html($this.find('a').html().replace('Admin', 'Mahasiswa'));
                    }
                    else if($('#inputEmail').css('display') != 'none'){
                        $('#inputNPM').show();
                        $('#inputEmail, #reset_form, #login_fReset').hide();
                        $this.find('span').html($this.find('span').html().replace('Admin?', 'Mahasiwa?'));
                        $this.find('a').html($this.find('a').html().replace('Mahasiswa', 'Admin'));
                    }

                    if($('#login_fReset a').css('display') != 'none')
                        $('#login_switch').show();

                });

                $('.reset_form').click(function(){
                    var $this = $('#login_switch');
                    $('#reset_form, #login_fReset').show();
                    $('#inputEmail, #inputNPM, #login_switch').hide();

                    $this.find('span').html($this.find('span').html().replace('Admin?', 'Mahasiwa?'));
                    $this.find('a').html($this.find('a').html().replace('Mahasiswa', 'Admin'));
                    
                });
            });
        </script>
    </body>
</html>
