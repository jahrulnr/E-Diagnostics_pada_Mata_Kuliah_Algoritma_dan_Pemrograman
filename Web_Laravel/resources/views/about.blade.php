<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="E-Diagnostics pada Mata Kuliah Algoritma dan Pemrograman" />
    <meta name="author" content="Jahrulnr" />

    <title>Panduan | E-Diagnostics</title>
    
    <!-- style -->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/custom.css" rel="stylesheet" />

    <!-- Core -->
    <link href="/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jQuery/jquery-3.6.0.min.js"></script>
    <script src="/js/scripts.js"></script>

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
                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h6 class="accordion-header" id="tentang-aplikasi">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tentang-aplikasi-" aria-expanded="true" aria-controls="tentang-aplikasi-">
                            Tentang Aplikasi
                          </button>
                        </h6>
                        <div id="tentang-aplikasi-" class="accordion-collapse collapse" aria-labelledby="tentang-aplikasi" data-bs-parent="#tentang-aplikasi">
                          <div class="accordion-body">
                            <p class="text-justify">
                              &nbsp;&nbsp;&nbsp;&nbsp;Aplikasi ini dirancang sebagai bahan penelitian pada skripsi yang berjudul "<b>Pengembangan Aplikasi <i>E-Diagnostics</i> Pada Mata Kuliah Algoritma Dan Pemrograman</b>". Diharapkan aplikasi ini mampu mendiagnosis mahasiswa sesuai dengan kemampuan masing-masing siswa berdasarkan tes yang telah diberikan.<br class="mb-1" />
                              &nbsp;&nbsp;&nbsp;&nbsp;Jika ada pertanyaan/mengalami bug, silakan hubungi kontak dibawah ini.
                            </p>
                            <div class="pb-2">
                              <span class="fab fa-whatsapp "></span> Whatsapp: <a href="//wa.me/6282218594993" target="_blank">082218594993</a>
                              <br/>
                              <span class="fab fa-telegram"></span> Telegram: <a href="//telegram.me/jahrulnr" target="_blank">@jahrulnr</a>
                              <br/>
                              <span class="far fa-envelope"></span> Email: <a href="mailto:jahrulnr@gmail.com" target="_blank">jahrulnr@gmail.com</a>
                              <br/>
                              <span class="fab fa-instagram"></span> Instagram: <a href="//instagram.com/jahrulnr" target="_blank">@jahrulnr</a>
                              <br/>
                              <span class="fab fa-github"></span> Github: <a href="//github.com/jahrulnr" target="_blank">github.com/jahrulnr</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h6 class="accordion-header" id="panduan">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panduan-" aria-expanded="false" aria-controls="panduan-">
                            Panduan
                          </button>
                        </h6>
                        <div id="panduan-" class="accordion-collapse collapse show" aria-labelledby="panduan" data-bs-parent="#tentang-aplikasi">
                          <div class="accordion-body">
                            <iframe src="/files/Panduan Penggunaan Aplikasi E-Diagnostics.pdf" width="100%" style="height: 100vh"></iframe>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-center bg-dark text-white py-3 btnLogin">
                    <div class="small">
                      <a href="/">
                        Kembali ke beranda
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
  </body>
</html>
<style type="text/css">
  .accordion-button:not(.collapsed) {
    background-color: #fff !important;
    color: black;
  }
</style>
