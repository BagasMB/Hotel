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
    $fasilitas_hotel = $_POST['fasilitas_hotel'];
    $fasilitas_umum = $_POST['fasilitas_umum'];
    $fasilitas_terdekat = $_POST['fasilitas_terdekat'];

    $query_sql = "INSERT INTO `faslitas_hotel`(`fasilitas_hotel`, `fasilitas_umum`, `fasilitas_terdekat`) VALUES ('$fasilitas_hotel', '$fasilitas_umum', '$fasilitas_terdekat')";

    if (mysqli_query($conn, $query_sql)) {
        header("Location: fasilitashotel.php");
    } else {
        echo "Faild : " . mysqli_error($conn);
    }
}


if (isset($_POST['update'])) {
    global $conn;
    $id = $_POST['id'];
    $fasilitas_hotel = $_POST['fasilitas_hotel'];
    $fasilitas_umum = $_POST['fasilitas_umum'];
    $fasilitas_terdekat = $_POST['fasilitas_terdekat'];

    $update = "UPDATE `faslitas_hotel` SET `fasilitas_hotel`='$fasilitas_hotel',`fasilitas_umum`='$fasilitas_umum',`fasilitas_terdekat`='$fasilitas_terdekat' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: fasilitashotel.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    <li class="nav-item">
                        <a class="nav-link active link-success" href="#" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa-sharp fa-solid fa-plus me-1"></i><strong>Tambah</strong></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link link-danger" href="administrator.php">Back</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-top:8rem; margin-left:4rem;">
            Tambah Data
        </button> -->
        <!-- table-borderless -->

        <table id="table" class="table text-center shadow p-3 mb-5 bg-body rounded" style="margin-top: 10rem;">
            <thead class="table font-monospace fst-italic">
                <tr>
                    <!-- <th scope="col">No</th> -->
                    <th scope="col">Fasilitas Hotel</th>
                    <th scope="col">Fasilitas Umum</th>
                    <th scope="col">Fasilitas Terdekat</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                include("../cont.php");
                $query = "SELECT * FROM faslitas_hotel";
                $no = 1;
                $ambildata = mysqli_query($conn, $query);
                while ($tampil = mysqli_fetch_array($ambildata)) {
                ?>
                    <tr>
                        <!-- <td><?= $no++ ?></td> -->
                        <td class="fst-italic"><?= $tampil['fasilitas_hotel'] ?></td>
                        <td class="fst-italic"><?= $tampil['fasilitas_umum'] ?></td>
                        <td class="fst-italic"><?= $tampil['fasilitas_terdekat'] ?></td>
                        <td>
                            <a href="" class="btn link-dark" data-bs-toggle="modal" data-bs-target="#staticBackdropupadate<?= $tampil['id']; ?>"><i class="fa-sharp fa-solid fa-eye me-1"></i>Show</a>
                        </td>
                    </tr>

                    <!-- Modal Update -->
                    <div class="modal fade" id="staticBackdropupadate<?= $tampil['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">From Mengedit Data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?= $tampil['id'] ?>">
                                    <div class="modal-body">
                                        <!-- <img class="mt-2" src="img/reddords.png" alt="" width="160px" height="100px"> -->
                                        <p class="mt-1">Mengedit No Kamar</p>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="fasilitas_hotel" value="<?= $tampil['fasilitas_hotel'] ?>" autocomplete="off">
                                            <label for="floatingInput">Fasilitas Hotel</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="fasilitas_umum" value="<?= $tampil['fasilitas_umum'] ?>" autocomplete="off">
                                            <label for="floatingPassword">Fasilitas Umum</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="fasilitas_terdekat" value="<?= $tampil['fasilitas_terdekat'] ?>" autocomplete="off">
                                            <label for="floatingPassword">Fasilitas Terdekat</label>
                                        </div>
                                        <hr class="my-4">
                                        <small class="mt-5 mb-3 text-muted">&copy; copyright 2023</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-sharp fa-solid fa-xmark me-1"></i>Close</button>
                                        <button class="btn btn-primary" type="submit" name="update"><i class="fa-sharp fa-solid fa-upload me-1"></i>Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                <?php
                }
                ?>
            </tbody>
        </table>
    </div>




    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">From Data Tambah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="fasilitashotel.php" method="post">
                    <div class="modal-body">
                        <p class="mt-1 mb-3 ">Menambahkan No Kamar</p>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fasilitas_hotel" placeholder="Fasilitas Hotel" autocomplete="off">
                            <label for="floatingInput">Fasilitas Hotel</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fasilitas_umum" placeholder="Fasilitas Umum" autocomplete="off">
                            <label for="floatingInput">Fasilitas Umum</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fasilitas_terdekat" placeholder="Fasilitas Terdekat" autocomplete="off">
                            <label for="floatingInput">Fasilitas Terdekat</label>
                        </div>
                        <hr class="my-4">
                        <small class="mt-5 mb-3 text-muted">&copy; copyright 2023</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" name="save">Save</button>
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