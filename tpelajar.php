<?php
    session_start();
    include "koneksi.php";

    if($_SESSION["role"]!="admin") {
        header ("location: login.php");
    }

    if (isset($_POST["InputPelajar"])) {
        $NAMA_PELAJAR=$_POST["NamaPelajar"];
        $KELAS_PELAJAR=$_POST["KelasPelajar"];
        $NIM_PELAJAR=$_POST["NimPelajar"];
    
        $QUERY=mysqli_query($KONEKSI, "INSERT INTO `pelajar`(`id_pelajar`, `nm_pelajar`, `kls_pelajar`, `nim_pelajar`, `role`) VALUES (NULL,'$NAMA_PELAJAR','$KELAS_PELAJAR','$NIM_PELAJAR')") or die(mysqli_error($KONEKSI));
        if ($QUERY) {
        echo "<script> alert('Anda berhasil menambahkan pelajar.');</script>";
        }
    }

    if (isset($_POST["Edit"])) {
        $NAMA = $_POST["Pelajar"];
        $KELAS = $_POST["Kelas"];
        $NIM = $_POST["Nim"];
        $ID = $_POST["ID"];

        $QUERY=mysqli_query($KONEKSI, "UPDATE `pelajar` SET `nm_pelajar`='$NAMA',`kls_pelajar`='$KELAS',`nim_pelajar`='$NIM' WHERE id_pelajar = $ID");
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
          <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="tpelajar.php">Pelajar</a>
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
            <label for="NamaPelajar" class="mt-2">Masukkan nama pelajar: </label>
            <input type="text" id="NamaPelajar" name="NamaPelajar" class="form-control">
            <label for="KelasPelajar" class="mt-2">Masukkan kelas pelajar: </label>
            <input type="text" id="KelasPelajar" name="KelasPelajar" class="form-control">
            <label for="NimPelajar" class="mt-2">Masukkan NIM: </label>
            <input type="text" id="NimPelajar" name="NimPelajar" class="form-control">
            <input type="submit" value="Submit" name="InputPelajar" class="btn btn-success mt-2">
          </form>
        </div>
        <div class="col-8 px-5">
          <table class="table mt-3 text-white bg-dark">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>NIM</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $QUERY=mysqli_query($KONEKSI, "SELECT * FROM `pelajar`");
                    while ($DATA=mysqli_fetch_assoc($QUERY)) {
                        echo '
                              <tr>
                                <form method="post">
                                  <td>'.$DATA['id_pelajar'].'</td>
                                  <td><input type="text" name="Pelajar" value="'.$DATA['nm_pelajar'].'" class="form-control"></td>
                                  <td><input type="text" name="Kelas" value="'.$DATA['kls_pelajar'].'" class="form-control"></td>
                                  <td><input type="text" name="Nim" value="'.$DATA['nim_pelajar'].'" class="form-control"></td>
                                  <td class="d-flex">
                                      <input type="text" name="ID" value="'.$DATA["id_pelajar"].'" hidden>
                                      <input type="submit" value="Edit" name="Edit" class="btn btn-warning mx-1">
                                      <a href="course-config.php?Aksi=Hapus&id='.$DATA['id_pelajar'].'" class="btn btn-danger">Hapus</a>
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