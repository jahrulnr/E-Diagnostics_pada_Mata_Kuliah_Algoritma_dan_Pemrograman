<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="E-Diagnostics pada Mata Kuliah Algoritma dan Pemrograman" />
        <meta name="author" content="Jahrulnr" />

        <!-- Refresh token laravel -->
        <meta http-equiv="refresh" content="1800">

        <title>Reset Password | E-Diagnostics</title>
        
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
                                        <form method="POST" autocomplete="off">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <div class="form-floating flex-grow-1">
                                                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                                                    <label for="password">Password Baru</label>
                                                </div>
                                                <a href="#" class="input-group-text" id="cp_type">
                                                    <span class="fas fa-eye-slash"></span>
                                                </a>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="confirm_password" type="password" placeholder="nama@contoh.com" name="password" autocomplete="new-password" required />
                                                <label for="password">Konfirmasi Password</label>
                                                <span id="invalid" class="text-danger" style="display:none">* Password tidak cocok</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end mb-0">
                                                <button type="submit" id="btnSave" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center bg-dark text-white py-3 btnLogin">
                                        <div class="small" id="login_fReset">
                                            <span>Login?</span>
                                            <a href="/">
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
                if(window.location.hash == '#not_found')
                    toastr.error('User tidak ditemukan');

                $('#cp_type').click(function(){
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

                $("#btnSave").prop('disabled', true);
                $('#confirm_password, #password').on('paste keyup keydown',function(){
                    if($('#confirm_password').val() != $('#password').val()){
                        $("#invalid").show();
                        $("#btnSave").prop('disabled', true);
                    }else{
                        $("#invalid").hide();    
                        $("#btnSave").prop('disabled', false);                    
                    }
                });

                $('#btnSave').click(function(e){
                    if($('#confirm_password').val() != $('#password').val()){
                        e.preventDefault();
                        toastr.error("Password tidak sama");
                    }
                    else if($('#password').val().length < 5){
                        e.preventDefault();
                        toastr.error("Pasword minimal 5 karakter");
                    }
                })
            });
        </script>
    </body>
</html>
