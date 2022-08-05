<?php
  session_start();
  include "koneksi.php";

  if (isset($_POST["Login"])) {
    $USERNAME=$_POST["Username"];
    $PASSWORD=$_POST["Password"];

    $QUERY=mysqli_query($KONEKSI, "SELECT * FROM `pelajar` WHERE nim_pelajar='$USERNAME' AND nim_pelajar='$PASSWORD'") or die(mysqli_error($KONEKSI));
    if (mysqli_num_rows($QUERY)>0) {
      $DATA=mysqli_fetch_assoc($QUERY);
      $_SESSION["id_login"]=$DATA["id_pelajar"];
      
      if($DATA["role"]=="admin") {
        echo "Halo Kamu ADMIN";
        $_SESSION["role"]="admin";
        header("location: dashboard.php");
      }
      else
      {
        echo "Halo Kamu Pelajar";
        $_SESSION["role"]="pelajar";
        header("location: index.php");
      }
    }
    else {
      echo "<script> alert('Gagal login.');</script>";
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">  

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
  <body class="text-center bg-anime">  
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
                <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="login.php">Login</a>
                ';
              }
            ?>

            </nav>
        </div>
      </header>

<main class="form-signin w-100 m-auto">
  <form method="post">
    <div class="text-white">
      <h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>
      <p>Masukkan NIM dan password anda</p>
    </div>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingUsername" placeholder="Username" name="Username">
      <label for="floatingUsername">NIM</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="mb-3">
    </div>
    <input class="w-100 btn btn-lg btn-primary" type="submit" value="Login" name="Login">
  </form>
</main>
  </body>
</html>
