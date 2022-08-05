<?php
  session_start();
  include "koneksi.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.101.0">
  <title>Course</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/album/">

  <link href="./dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>

  <link href="style.css" rel="stylesheet">

</head>

<body class="d-flex h-100 text-center bg-anime">
  <div class="d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto px-5">
      <div class="text-white">
        <h3 class="float-md-start mb-0">Yuk Belajar!</h3>
        <nav class="nav nav-masthead justify-content-center float-md-end">
          <a class="nav-link fw-bold py-1 px-0" href="index.php">Beranda</a>
          <a class="nav-link fw-bold py-1 px-0" href="course.php">Course</a>

          <?php
              if (isset ($_SESSION["role"])=="pelajar") {
                echo '
                <a class="nav-link fw-bold py-1 px-0" href="logout.php">Log Out</a>
                ';
              }
              else {
                echo '
                <a class="nav-link fw-bold py-1 px-0" href="login.php">Login</a>
                ';
              }
            ?>

        </nav>
      </div>
    </header>

    <main>

      <div class="album py-5">
        <div class="container">

          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
              $QUERY = mysqli_query($KONEKSI, "SELECT * FROM `jadwal` JOIN course ON jadwal.id_kursus=course.id_kursus");
              while ($DATA=mysqli_fetch_assoc($QUERY)) {
                if(!isset($_SESSION["id_login"])){
                  $ID_PELAJAR='nol';
                }else{
                  $ID_PELAJAR = $_SESSION["id_login"];
                }
                $ID_JADWAL = $DATA['id_jadwal'];
                $Q_JADWAL = mysqli_query($KONEKSI, "SELECT * FROM `laporan` WHERE `id_pelajar`='$ID_PELAJAR' AND `id_jadwal`='$ID_JADWAL'");
                  echo '
                    <div class="col">
                    <div class="card shadow-sm">  
                    <div class="card-body">
                    <h2 class="card-text">'.$DATA['nm_kursus'].'</h2>
                      <p class="card-text">'.$DATA['ket_kursus'].'</p>
                          <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">';
                          if(mysqli_num_rows($Q_JADWAL) < 1){
                            echo '
                              <a href="daftar-config.php?id_pelajar='.$ID_PELAJAR.'&id_jadwal='.$ID_JADWAL.'" class="btn btn-sm btn-outline-secondary">Daftar</a>
                            ';
                          }else{
                            echo '
                              <a href="daftar-config.php?id_pelajar='.$ID_PELAJAR.'&id_jadwal='.$ID_JADWAL.'" class="btn btn-sm btn-success">Lihat Kartu</a>
                            ';
                          }
                            echo
                            '</div>
                            <div style="text-align: right">
                              <small class="text-muted">'.$DATA['lama_kursus'].' Hari</small>
                              <br>
                              <small class="text-muted">Tanggal Mulai: '.$DATA['waktu_kursus'].'</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  ';
                }
            ?>
          </div>
        </div>
      </div>

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-end mb-1 py-2">
          <a href="#">Kembali ke atas</a>
        </p>
      </div>
    </footer>


    <script src="./dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>