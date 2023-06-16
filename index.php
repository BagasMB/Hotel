<?php

session_start();

include 'cont.php';

if (isset($_POST['save'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $save = "INSERT INTO `user`(`username`,`password`) VALUES ('$username','$password')";

  if (mysqli_query($conn, $save)) {
    header("Location: index.php");
  } else {
    echo "Gagal Menambah Data Karena : " . mysqli_error($conn);
  }
}


if (isset($_POST['submit'])) {
  // koneksi
  include 'cont.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  // mencocokan data
  $query_get_data = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
  $exec = mysqli_query($conn, $query_get_data);
  $get_data = mysqli_fetch_assoc($exec);
  // $get_data = mysqli_fetch_array($exec);

  // melempar akun
  $user_type = $get_data['user_type'];

  $_SESSION['user_type'] = $user_type;
  $_SESSION['user_id'] = $get_data['user_id'];


  switch ($user_type) {
    case 'tamu':
      header("location:tamu/tamu.php");
      break;
    case 'resepsionis':
      header("location:resepsionis/resepsionis.php");
      break;
    case 'administrator':
      header("location:admin/administrator.php?msg=Selamat Datang $username Dihalaman Admin<meta http-equiv=refresh content=3;URL='administrator.php'>");
      break;

    default;
      header('location:index.php');
      break;
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
  <meta name="generator" content="Hugo 0.104.2">
  <title>Login | Dulu</title>

  <link href="img/smk.png" rel="icon">

  <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/"> -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../sign-in/dist/css/signin.css" rel="stylesheet">


</head>

<body>

  <div class="container col-xl-10 col-xxl-8 px-4 py-5 text-center">
    <div class="row align-items-center g-lg-5 py-5">
      <!-- <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Vertically centered hero sign-up form</h1>
        <p class="col-lg-10 fs-4">Below is an example form built entirey with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
      </div> -->
      <div class="col-md-10 mx-auto col-lg-6">
        <form action="" method="post" class="p-4 p-md-5 border rounded-3 bg-light">
          <img class="mb-2" src="img/reddords.png" alt="" width="170px" height="104px">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required>
            <label for="floatingInput">Username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
          </div>
          <!-- <div class="checkbox mb-3"> -->
          <!-- <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div> -->
          <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Login</button>
          <hr class="my-4">
          <small class="text-muted">By clicking Login, you agree to the terms of use.</small></br>
          <small class="text-muted">Don't Have An Account?</small>
          <small class="link-danger fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">Account List</small>
          <p class="mt-5 mb-3 text-muted">&copy; copyright 2023</p>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <img class="fs-5" id="exampleModalLabel" src="img/reddords.png" alt="" width="120px" height="64px">
          <button type="button" class="btn-close" style="margin-right: 1rem;" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="index.php" method="post">
          <div class="modal-body">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required>
              <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
              <label for="floatingInput">Password</label>
            </div>
            <hr class="my-4">
            <small class="mt-5 mb-3 text-muted">&copy; copyright 2023</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-sharp fa-solid fa-xmark me-1"></i>Close</button>
            <button class="btn btn-primary" type="submit" name="save"><i class="fa-sharp fa-solid fa-download me-1"></i>Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</html>