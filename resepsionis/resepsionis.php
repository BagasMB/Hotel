<?php
session_start();

if ($_SESSION['user_type'] != 'resepsionis') {
    header('location:../index.php');
}

include '../cont.php';

if (isset($_POST['kirim'])) {
    $id_pemesanan = $_POST['id_pemesanan'];
    $status = $_POST['status'];

    $update = "UPDATE `pemesanan` SET `status` = 'Selesai' WHERE `id_pemesanan` = $id_pemesanan";

    if (mysqli_query($conn, $update)) {
        header("Location: resepsionis.php?msg=Data Anda Telah DiUpdate<meta http-equiv=refresh content=3;URL='resepsionis.php'>");
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
    <title>Resepsoinis</title>

    <link href="../img/smk.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- Icon Bootsrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar fixed-top">
        <div class="container">
            <a href="#">
                <img class="" src="../img/reddords.png" alt="" width="120px" height="64px"">
            </a>
            <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0 fw-bold">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-house me-1"></i><strong> Home</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-danger" href="../logout.php"><strong>Sign Out <i class="fa-solid fa-arrow-right-from-bracket"></i></strong></a>
                        </li>
                    </ul>
                </div>
        </div>
    </nav>

    <div class="container justify-content-center mb-3" style="margin-top: 9rem;">

        <?php
        if (isset($_GET['msgd'])) {
            $msgd = $_GET['msgd'];
            echo '<div class="alert alert-danger alert-dismissible fade show text-center order rounded-3" style="margin-left: 440px; margin-right: 440px;" role="alert">
            ' . $msgd . '
            </div>';
        }
        ?>
    </div>

    <div class="container" style="margin-top: 8rem;">
        <div class="card">
            <div class="card-header">
                Kamar
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                    echo '<div class="alert alert-info alert-dismissible fade show text-center order rounded-3" style="margin-left: 440px; margin-right: 440px;" role="alert">
            ' . $msg . '
            </div>';
                }
                ?>
                <div class="container-fluid">
                    <form method="post" action="" class="d-flex col-3">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search" autocomplete="off" aria-label="Search">
                        <button class="btn btn-outline-light border me-2" name="cari" type="submit"><i class="fa-solid fa-magnifying-glass text-muted link-dark"></i></button>
                        <a href="resepsionis.php" class="btn btn-outline-light border" type="reset"><i class="fa-solid fa-rotate-right text-muted link-dark"></i></a>
                    </form>
                </div>


                <table id="example" class="table table-striped text-center table-bordered shadow p-3 mb-5 bg-body rounded" style="width:100%; margin-top:1rem;">
                    <thead class="table">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Kamar</th>
                            <th scope="col">Nama Pemesan</th>
                            <th scope="col">Tanggal Checkin</th>
                            <th scope="col">Tanggal Checkout</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../cont.php");
                        if (isset($_POST['cari'])) {
                            global $conn;
                            $pencarian = $_POST['search'];
                            $query = "SELECT * FROM pemesanan 
                                                            JOIN user ON
                                                                 user.user_id = pemesanan.user_id WHERE username like '%$pencarian%' OR no_kamar like '%$pencarian%'";
                        } else {
                            $query = "SELECT * FROM pemesanan JOIN user ON user.user_id = pemesanan.user_id ORDER BY tanggal_checkin DESC";
                        }
                        $no = 1;
                        $ambildata = mysqli_query($conn, $query);
                        while ($tampil = mysqli_fetch_array($ambildata)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <!-- <td><?= $tampil['user_id'] ?></td> -->
                                <td class="fw-bold"><?= $tampil['no_kamar'] ?></td>
                                <td class="fw-bold"><?= $tampil['username'] ?></td>
                                <td><?= $tampil['tanggal_checkin'] ?></td>
                                <td><?= $tampil['tanggal_checkout'] ?></td>
                                <td> Rp. <?= number_format($tampil['harga'], 2); ?></td>
                                <td class="fw-bold"><?= $tampil['status'] ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_pemesanan" value="<?= $tampil['id_pemesanan'] ?>">
                                        <input type="hidden" name="status" value="<?= $tampil['status'] ?>">
                                        <button type="submit" name="delete" class="btn btn-sm link-danger" onclick="return confirm('yakin mau menghapus ?')"><i class="fa-solid fa-trash me-2"></i>Delete</button>
                                        <button type="submit" name="kirim" class="btn btn-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i>Selesai</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                if (isset($_POST['delete'])) {
                    $id_pemesanan = $_POST['id_pemesanan'];
                    $delete = $_POST['delete'];
                    $dele =  "DELETE FROM pemesanan WHERE `pemesanan`.`id_pemesanan` = $id_pemesanan";

                    if (mysqli_query($conn, $dele)) {
                        echo "<script>
                    alert('Data Berhasil terhapus');
                    window.location = 'resepsionis.php';
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
    include "../dist/footers.php";
    ?>

</body>

</html>