<?php
    session_start();
    include "koneksi.php";

    if($_SESSION["role"]!="admin") {
        header ("location: login.php");
    }

    if (isset($_POST["InputPelatihan"])) {
        $NAMA_PELATIHAN=$_POST["Pelatihan"];
        $KETERANGAN_PELATIHAN=$_POST["Keterangan"];
        $LAMA_PELATIHAN=$_POST["Lama"];
    
        $QUERY=mysqli_query($KONEKSI, "INSERT INTO `course`(`id_kursus`, `nm_kursus`, `ket_kursus`, `lama_kursus`) VALUES (NULL,'$NAMA_PELATIHAN','$KETERANGAN_PELATIHAN','$LAMA_PELATIHAN')") or die(mysqli_error($KONEKSI));
        if ($QUERY) {
        echo "<script> alert('Anda berhasil menambahkan pelatihan.');</script>";
        }
    }

    if (isset($_POST["Edit"])) {
        $NAMA = $_POST["NamaPelatihan"];
        $KETERANGAN = $_POST["KeteranganPelatihan"];
        $LAMA = $_POST["LamaPelatihan"];
        $ID = $_POST["ID"];

        $QUERY=mysqli_query($KONEKSI, "UPDATE `course` SET `nm_kursus`='$NAMA',`ket_kursus`='$KETERANGAN',`lama_kursus`='$LAMA' WHERE id_kursus = $ID");
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
          <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="tcourse.php">Course</a>
          <a class="nav-link fw-bold py-1 px-0" href="tpelajar.php">Pelajar</a>
          <a class="nav-link fw-bold py-1 px-0" href="tlaporan.php">Pendaftaran</a>
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
        <div class="col-4">
          <form method="post" enctype="multipart/form-data">
            <label for="Pelatihan" class="mt-2">Masukkan nama pelatihan: </label>
            <input type="text" id="Pelatihan" name="Pelatihan" class="form-control">
            <label for="Keterangan" class="mt-2">Masukkan keterangan pelatihan: </label>
            <input type="text" id="Keterangan" name="Keterangan" class="form-control">
            <label for="Lama" class="mt-2">Masukkan lama waktu pelatihan: </label>
            <input type="number" id="Lama" name="Lama" class="form-control">
            <input type="submit" value="Submit" name="InputPelatihan" class="btn btn-success mt-2">
          </form>
        </div>
        <div class="col-8 px-5">
          <table class="table mt-3 text-white bg-dark">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Pelatihan</th>
                <th>Keterangan</th>
                <th>Lama Kursus</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $QUERY=mysqli_query($KONEKSI, "SELECT * FROM `course`");
                    while ($DATA=mysqli_fetch_assoc($QUERY)) {
                        echo '
                              <tr>
                                <form method="post">
                                  <td>'.$DATA['id_kursus'].'</td>
                                  <td><input type="text" name="NamaPelatihan" value="'.$DATA['nm_kursus'].'" class="form-control"></td>
                                  <td><input type="text" name="KeteranganPelatihan" value="'.$DATA['ket_kursus'].'" class="form-control"></td>
                                  <td><input type="number" name="LamaPelatihan" value="'.$DATA['lama_kursus'].'" class="form-control"></td>
                                  <td class="d-flex">
                                      <input type="text" name="ID" value="'.$DATA["id_kursus"].'" hidden>
                                      <input type="submit" value="Edit" name="Edit" class="btn btn-warning mx-1">
                                      <a href="course-config.php?Aksi=Hapus&id='.$DATA['id_kursus'].'" class="btn btn-danger">Hapus</a>
                                  </td>
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