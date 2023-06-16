<?php
session_start();


if ($_SESSION['user_type'] != 'tamu') {
    header('location: ../index.php');
}

include '../cont.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamu</title>

    <link href="../img/smk.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <scrip defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
        </script>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar fixed-top">
        <div class="container mb-4">
            <a href="#">
                <img class="" src="../img/reddords.png" alt="" width="120px" height="64px">
            </a>
            <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tamu.php"><i class="fa-solid fa-house me-1"></i><strong> Home</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-danger" href="../logout.php"><strong>Log Out <i class="fa-solid fa-arrow-right-from-bracket"></i></strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container justify-content-center" style="margin-top: 5rem;">
    <?php
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-success alert-dismissible fade show text-center order rounded-3" style="margin-left: 440px; margin-right: 440px;" role="alert">
            ' . $msg . '
            </div>';
        }
        ?>
        <?php
        // $ambildata = mysqli_query($conn, "SELECT * FROM kamar 
        //                                         JOIN tipe_kamar
        //                                         ON
        //                                         kamar.tipe_kamar_id = tipe_kamar.tipe_kamar_id
        //                                         WHERE NOT EXISTS (SELECT * FROM pemesanan WHERE pemesanan.no_kamar = kamar.no_kamar and status = 'Proses')");
        $ambildata = mysqli_query($conn, "SELECT * FROM kamar 
                                                JOIN tipe_kamar
                                                JOIN faslitas_hotel
                                                ON
                                                kamar.tipe_kamar_id = tipe_kamar.tipe_kamar_id and	faslitas_hotel.id 
                                                WHERE NOT EXISTS (SELECT * FROM pemesanan WHERE pemesanan.no_kamar = kamar.no_kamar and status = 'Proses') 
                                                and faslitas_hotel.id='1' 
                                                ORDER BY no_kamar ASC");
        // $ambildata = mysqli_query($conn, "SELECT * FROM kamar 
        //                                         JOIN faslitas_hotel
        //                                         JOIN tipe_kamar
        //                                         ON
        //                                         kamar.tipe_kamar_id = tipe_kamar.tipe_kamar_id 
        //                                         WHERE no_kamar = 703");
        while ($tampil = mysqli_fetch_array($ambildata)) {
        ?>

            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-center">
                        <div class="card mb-5" style="width: 25rem;">
                            <div class="card-header text-center fw-bold">
                                <em>Nomor Kamar : <?= $tampil['no_kamar']; ?></em>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <hr>
                                    <a href=<?php echo "'../foto/$tampil[foto]' width='100%'"; ?>">
                                        <?php echo "<img src='../foto/$tampil[foto]' width='100%' />"; ?>
                                    </a>
                                    <hr>
                                    <li class="list-group-item mb-2">Type Kamar : <?= $tampil['tipe_kamar_id']; ?></li>
                                    <li class="list-group-item mt-2 mb-2">Fasilitas Kamar : <?= $tampil['fasilitas']; ?></li>
                                    <li class="list-group-item mt-2 mb-2">Fasilitas Hotel : <?= $tampil['fasilitas_hotel']; ?></li>
                                    <!-- <li class="list-group-item mt-2 mb-2">Fasilitas Terdekat : <?= $tampil['fasilitas_terdekat']; ?></li> -->
                                    <li class="list-group-item mt-2 mb-2">Harga : Rp. <?= number_format($tampil['harga'], 2); ?></li>
                                    <div class="d-flex justify-content-center">
                                        <a href="pemesanan.php?pesan=<?= $tampil['no_kamar']; ?>" class="btn btn-primary col-3 mt-2">Pesan</a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="container" style="margin-top: 5rem;">
        <?php
        include '../dist/footers.php';
        ?>
    </div>
</body>

<script src="../dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</html>