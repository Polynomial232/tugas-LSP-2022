<?php
    session_start();
    include "koneksi.php";

    if(!$_SESSION["id_login"]){
        header ("location: login.php");
    }

    if(isset($_POST['krs'])){
        $ID = $_POST['id'];
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $name = uniqid();
        $folder = "KRS/".$name.'.'.$file_extension;
        move_uploaded_file($tempname,$folder);
        $QUERY = mysqli_query($KONEKSI, "UPDATE `laporan` SET `krs_pelajar`='$folder' WHERE `id_laporan`='$ID'");
    }
    
    $ID_PELAJAR = $_GET["id_pelajar"];
    $ID_JADWAL = $_GET["id_jadwal"];

    $Q_LAPORAN = mysqli_query($KONEKSI, "SELECT * FROM laporan WHERE id_pelajar = '$ID_PELAJAR' AND id_jadwal='$ID_JADWAL'");
    if(mysqli_num_rows($Q_LAPORAN) < 1){
        $QUERY=mysqli_query($KONEKSI, "INSERT INTO `laporan`(`id_laporan`, `id_jadwal`, `id_pelajar`, `krs_pelajar`, `status`) VALUES (NULL,'$ID_JADWAL','$ID_PELAJAR','0','0')") or die(mysqli_error($KONEKSI));
        if(!$QUERY) {
            echo "<script> alert('Pendaftaran gagal.');</script>";
        }
    }

    $D_LAPORAN = mysqli_fetch_assoc($Q_LAPORAN);
    $Q_PELAJAR = mysqli_query($KONEKSI, "SELECT * FROM pelajar WHERE id_pelajar = '$ID_PELAJAR'");
    $D_PELAJAR = mysqli_fetch_assoc($Q_PELAJAR);
    $Q_KURSUS=mysqli_query($KONEKSI, "SELECT * FROM `jadwal` JOIN course ON jadwal.id_kursus=course.id_kursus");
    $D_KURSUS=mysqli_fetch_assoc($Q_KURSUS);
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
                    <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="course.php">Course</a>

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
                        <div class="col-md-4">
                            <div class="card shadow-sm text-start">
                                <div class="card-body">
                                    <?php
                                        if($D_LAPORAN['status'] == 0){
                                            echo '
                                            <span class="form-control alert alert-danger">Belum diverifikasi</span>
                                            ';
                                        }else{
                                            echo '
                                            <span class="form-control alert alert-success">Pendaftaran Sudah Diterima</span>
                                            ';
                                        }
                                    ?>
                                    <h2 class="card-text">Jenis Kursus : <?= $D_KURSUS["nm_kursus"];?></h2>
                                    <p class="card-text">Nama : <?= $D_PELAJAR["nm_pelajar"];?></p>
                                    <p class="card-text">NIM : <?= $D_PELAJAR["nim_pelajar"];?></p>
                                    <p class="card-text">Kelas : <?= $D_PELAJAR["kls_pelajar"];?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group"></div>
                                        <div style="text-align: right">
                                            <small class="text-muted">Lama Kursus : <?= $D_KURSUS["lama_kursus"];?>
                                                Hari</small>
                                            <br>
                                            <small class="text-muted">Jadwal Kursus :
                                                <?= $D_KURSUS["waktu_kursus"];?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow-sm text-start">
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <h3 class="card-text">Upload KRS</h3>
                                        <?php
                                            if($D_LAPORAN['krs_pelajar'] == '0'){
                                                echo '
                                                    <span class="form-control alert alert-danger">Upload KRS untuk Verifikasi</span>
                                                ';
                                            }else{
                                                echo '
                                                    <span class="form-control alert alert-success">KRS sudah diupload, Tunggu Admin Verifikasi</span>
                                                    <a href="'.$D_LAPORAN['krs_pelajar'].'" target="_blank">Lihat KRS</a>
                                                ';
                                            }
                                        ?>
                                        <input type="text" name="id" id="" value="<?= $D_LAPORAN['id_laporan']; ?>" hidden>
                                        <input type="file" name="uploadfile" id="" class="form-control my-2">
                                        <input type="submit" name="krs" value="Upload KRS" class="form-control btn btn-success">
                                    </form>
                                </div>
                            </div>
                        </div>
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