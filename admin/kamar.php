<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
// if (!isset($_SESSION['user_type'])) {
//     header('location:index.php');
//     // exit;
// } echo "tamu";

if ($_SESSION['user_type'] != 'administrator') {
    header('location:../index.php');
}

include "../cont.php";

if (isset($_POST['save'])) {
    $no_kamar        = $_POST['no_kamar'];
    $tipe_kamar_id   = $_POST['tipe_kamar_id'];
    $foto            = upload_file();

    if (!$foto) {
        return false;
    }


    $add = "INSERT INTO `kamar`(`no_kamar`,`tipe_kamar_id`,`foto`) VALUES ('$no_kamar','$tipe_kamar_id','$foto')";

    if (mysqli_query($conn, $add)) {
        header("Location: kamar.php?msg=Data Anda Telah DiTambahakan<meta http-equiv=refresh content=3;URL='kamar.php'>");
    } else {
        echo "Gagal Menambah Data Karena : " . mysqli_error($conn);
    }
}

// fungsi mengupload file
function upload_file()
{
    $namaFile   = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['name'];
    $error      = $_FILES['foto']['error'];
    $tmpName    = $_FILES['foto']['tmp_name'];

    // check file yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile      = explode('.', $namaFile);
    $extensifile      = strtolower(end($extensifile));

    // check format/extensi file
    if (!in_array($extensifile, $extensifileValid)) {

        echo "<script>
             alert('Format File Tidak Valid');
             document.location.href = 'kamar.php';
            </script>";
        die();
    }

    // check ukuran file
    if ($ukuranFile < 2048000) {
        // pesan gagal
        echo "<script>
             alert('Ukuran File Max 2 MB');
             document.location.href = 'kamar.php';
            </script>";
        var_dump($ukuranFile);
        die();
    }

    // ganerate nama file baru
    $namaFileBaru   = uniqid();
    $namaFileBaru  .= '.';
    $namaFileBaru  .= $extensifile;

    // pindahakan ke folder local
    move_uploaded_file($tmpName, '../foto/' . $namaFileBaru);
    return $namaFileBaru;
}


if (isset($_POST['update'])) {
    $id_kamar       = $_POST['id_kamar'];
    $no_kamar       = $_POST['no_kamar'];
    $tipe_kamar_id  = $_POST['tipe_kamar_id'];

    $sql = "UPDATE `kamar` SET `no_kamar`='$no_kamar',`tipe_kamar_id`='$tipe_kamar_id' WHERE no_kamar=$id_kamar";

    if (mysqli_query($conn, $sql)) {
        header("Location: kamar.php?msg=Data Anda Telah DiUpdate<meta http-equiv=refresh content=3;URL='kamar.php'>");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaLaman | Admin</title>

    <link href="../img/smk.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

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


</head>

<body class="">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar fixed-top">
        <div class="container">
            <a href="administrator.php">
                <img class="" src="../img/reddords.png" alt="" width="120px" height="64px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="administrator.php"><i class="fa-solid fa-house me-1"></i><strong>Home</strong></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                        </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link link-danger" href="administrator.php">Back</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 8rem;">
        <?php
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-success alert-dismissible fade show text-center" style="margin-left: 27rem; margin-right: 27rem;" role="alert">
            ' . $msg . '
            </div>';
        }
        ?>

        <div class="card">
            <div class="card-header">
                Kamar
            </div>
            <div class="card-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fa-sharp fa-solid fa-plus me-1"></i>Tambah Data
                </button>

                <table id="example" class="table table-striped text-center table-bordered shadow p-3 mb-5 bg-body rounded" style="width:100%; margin-top:1rem;">
                    <thead class="table">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Kamar</th>
                            <th scope="col">Tipe Id Kamar</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../cont.php");
                        $query = "SELECT * FROM kamar ORDER BY no_kamar ASC";
                        $no = 1;
                        $ambildata = mysqli_query($conn, $query);
                        while ($tampil = mysqli_fetch_array($ambildata)) {
                        ?>
                            <tr>
                                <!-- height='50%' -->
                                <td><?= $no++ ?></td>
                                <td><?= $tampil['no_kamar']; ?></td>
                                <td><?= $tampil['tipe_kamar_id']; ?></td>
                                <!-- <td><?= "foto/" . $tampil['foto']; ?></td> -->
                                <td>
                                    <a href=<?php echo "'../foto/$tampil[foto]' width='100%'"; ?>">
                                        <img src="../foto/<?= $tampil['foto']; ?>" width="200px">
                                    </a>
                                </td>
                                <td>
                                    <a href="kamar.php?update=<?= $tampil['no_kamar']; ?>" class="btn btn-sm link-dark" data-bs-toggle="modal" data-bs-target="#staticBackdropupadate<?= $tampil['no_kamar']; ?>"><i class="fa-sharp fa-solid fa-eye me-1"></i>Show</a>
                                </td>
                            </tr>

                            <!-- Modal Update -->
                            <div class="modal fade" id="staticBackdropupadate<?= $tampil['no_kamar']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">From Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <p class="mt-1">Mengedit No Kamar</p>
                                                <input type="hidden" value="<?= $tampil['no_kamar'] ?>" name="id_kamar">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="no_kamar" value="<?= $tampil['no_kamar'] ?>" autocomplete="off">
                                                    <label for="floatingInput">Nomor Kamar</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" name="tipe_kamar_id" value="<?= $tampil['tipe_kamar_id'] ?>" autocomplete="off" required>
                                                    <label for="floatingInput">Tipe Kamar</label>
                                                </div>
                                                <div class="mt-3 d-flex justify-content-center border" style="padding-top: 2rem; padding-bottom: 2rem;">
                                                    <img src="../foto/<?= $tampil['foto']; ?>" width="90%" alt="">
                                                </div>
                                                <hr class="my-4">
                                                <small class="mt-5 mb-3 text-muted">&copy; copyright 2023</small>
                                            </div>
                                            <div class="modal-footer">
                                                <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-sharp fa-solid fa-xmark me-1"></i>Close</button> -->
                                                <button class="btn btn-danger" type="submit" name="delete" onclick="return confirm('yakin mau menghapus ?')"><i class="fa-sharp fa-solid fa-trash me-1"></i>Delete</button>
                                                <button class="btn btn-primary" type="submit" name="update"><i class="fa-sharp fa-solid fa-upload me-1"></i>Update</button>
                                            </div>
                                        </form>
                                        <?php
                                        if (isset($_POST['delete'])) {
                                            $delete = $_POST['delete'];
                                            $no_kamar = $_POST['no_kamar'];
                                            $dele =  "DELETE FROM kamar WHERE `kamar`.`no_kamar` = $no_kamar";

                                            if (mysqli_query($conn, $dele)) {
                                                echo "<script>
                                                        alert('Data Berhasil terhapus');
                                                        window.location = 'kamar.php';
                                                    </script>";
                                            } else {
                                                echo "Failed: " . mysqli_error($conn);
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">From Menambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="kamar.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p class="mt-1 mb-3 ">Menambahkan No Kamar</p>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_kamar" placeholder="No kamar" autocomplete="off" required>
                            <label for="floatingInput">No Kamar</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" name="tipe_kamar_id" placeholder="Tipe Kamar" autocomplete="off" required>
                            <label for="floatingInput">Tipe Kamar</label>
                        </div>
                        <div class="mt-3">
                            <label for="formFile" class="form-label">Select Image File to Upload:</label>
                            <input type="file" id="foto" class="form-control" name="foto">
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

    <?php
    include '../dist/footers.php';
    ?>
</body>


<script src="../dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>


</html>