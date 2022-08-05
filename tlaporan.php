<?php
    session_start();
    include "koneksi.php";

    if($_SESSION["role"]!="admin") {
        header ("location: login.php");
    }

    if (isset($_POST["Edit"])) {
        $NAMA = $_POST["NamaPelatihan"];
        $WAKTU = $_POST["WaktuPelatihan"];
        $ID = $_POST["ID"];

        $QUERY=mysqli_query($KONEKSI, "UPDATE `jadwal` SET `id_kursus`='$NAMA',`waktu_kursus`='$WAKTU' WHERE id_jadwal = $ID");
    }
?>

<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.101.0">
  <title>Course</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/cover/">

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


  <!-- Custom styles for this template -->
  <link href="style.css" rel="stylesheet">
</head>

<body class="h-100 text-center bg-anime">

  <div class="d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="px-5">
      <div class="text-white">
        <h3 class="float-md-start mb-0">Yuk Belajar!</h3>
        <nav class="nav nav-masthead justify-content-center float-md-end">
          <a class="nav-link fw-bold py-1 px-0" href="dashboard.php">Beranda</a>
          <a class="nav-link fw-bold py-1 px-0" href="tcourse.php">Course</a>
          <a class="nav-link fw-bold py-1 px-0" href="tpelajar.php">Pelajar</a>
          <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="tlaporan.php">Pendaftaran</a>
          <a class="nav-link fw-bold py-1 px-0" href="tjadwal.php">Jadwal</a>

          <?php
              if (isset ($_SESSION["role"])=="admin") {
                echo '
                <a class="nav-link fw-bold py-1 px-0" href="logout.php">Log Out</a>
                ';
              }
            ?>

        </nav>
      </div>
    </header>
    <div class="container-lg mt-5 text-left text-white">
      <div class="row">
        <div class="col-12 px-5">
          <table class="table mt-3 text-white bg-dark">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Pelajar</th>
                <th>Jenis Kursus</th>
                <th>Jadwal Kursus</th>
                <th>Verifikasi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                    $QUERY = mysqli_query($KONEKSI, "SELECT * FROM `laporan` JOIN `jadwal` ON `laporan`.`id_jadwal`=`jadwal`.`id_jadwal` LEFT JOIN `course` ON `jadwal`.`id_kursus`=`course`.`id_kursus` LEFT JOIN `pelajar` ON `laporan`.`id_pelajar`=`pelajar`.`id_pelajar`");
                    while ($DATA=mysqli_fetch_assoc($QUERY)) {
                      // $ID_PELAJAR = $DATA['id_pelajar'];
                      // $Q_PELAJAR = mysqli_query($KONEKSI, "SELECT `nm_pelajar` FROM `pelajar` WHERE `id_pelajar`='$ID_PELAJAR'");
                      // $D_PELAJAR = mysqli_fetch_assoc($Q_PELAJAR);
                        echo '
                              <tr>
                                <form method="post">
                                  <td>'.$DATA['id_laporan'].'</td>
                                  <td>';
                                  if($DATA['krs_pelajar'] == '0'){
                                    echo '
                                    <span class="btn btn-danger">Belum Upload KRS</span>
                                    ';
                                  }else{
                                    echo '
                                    <a href="'.$DATA['krs_pelajar'].'" target="_blank" class="btn btn-secondary text-white">Lihat KRS</a>
                                    ';
                                  }
                                    echo $DATA['nm_pelajar'].'
                                  </td>
                                  <td>'.$DATA['nm_kursus'].'</td>
                                  <td>'.$DATA['waktu_kursus'].'</td>
                                  <td>';
                                  if($DATA['status'] == 0){
                                    echo '<a href="course-config.php?Aksi=verifikasi&id='.$DATA['id_laporan'].'" class="btn btn-danger">✓</a>';
                                  }else{
                                    echo '<a href="#" class="btn btn-success">✓</a>';
                                  }
                                  echo '</td>
                                  </form>
                               </tr>
                              ';
                           }
                      ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>