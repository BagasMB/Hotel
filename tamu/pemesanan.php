<?php
session_start();

// var_dump($_SESSION['user_id']);

if ($_SESSION['user_type'] != 'tamu') {
    header('location: ../index.php');
}

include '../cont.php';

if (isset($_POST['pesan'])) {
    $no_kamar   = $_GET['pesan'];
    $checkin    = $_POST['tanggal_checkin'];
    $checkout   = $_POST['tanggal_checkout'];

    $query  =   "SELECT harga FROM kamar 
                    JOIN tipe_kamar
                    ON
                    kamar.tipe_kamar_id = tipe_kamar.tipe_kamar_id
                    WHERE kamar.no_kamar = $no_kamar";

    $eksekusi   = mysqli_query($conn, $query);
    $data       = mysqli_fetch_array($eksekusi);

 
    $insert = "INSERT INTO pemesanan 
                                    (no_kamar, user_id, tanggal_checkin, tanggal_checkout, harga, status) 
                                    VALUES ('$no_kamar', '$_SESSION[user_id]', '$checkin', '$checkout',
                                    DATEDIFF(DATE('$checkout'), DATE('$checkin'))*$data[harga], 'Proses')";
    $sek    = mysqli_query($conn, $insert);

    if ($sek) {
        header("Location: ../tamu/tamu.php?msg=Pesanan Anda Berhasil Terkirim<meta http-equiv=refresh content=3;URL='tamu.php'>");
        // echo "<script>alert('Pesanan Anda Berhasil Terkirim')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan | Kamar</title>

    <link href="../img/smk.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Font Jam -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,600;1,600&display=swap" rel="stylesheet">

    <style>
        body {
            padding-bottom: 100rem;
        }

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

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar fixed-top">
        <div class="container">
            <a href="tamu.php">
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
                    <!-- <li class="nav-item">
                        <a class="nav-link link-danger" href="../logout.php"><strong>Sign Out <i class="fa-solid fa-arrow-right-from-bracket"></i></strong></a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center">
        <div class="card text-center mb-3" style="width: 23rem; margin-top: 9rem;">
            <div class="card-header">
                Pesan Kamar
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="text" class="form-control mb-3 text-center" name="no_kamar" value="No Kamar : <?= $_GET['pesan'] ?>">
                    <input type="date" class="form-control mb-3" name="tanggal_checkin">
                    <input type="date" class="form-control mb-3" name="tanggal_checkout">
                    <button type="submit" name="pesan" class="btn btn-primary">Pesan</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    include '../dist/footers.php';
    ?>

</body>

<!-- <script>
    setInterval(() => {
        const waktu = new Date()
        const jam = waktu.getHours()
        const menit = waktu.getMinutes()
        const detik = waktu.getSeconds()
        document.getElementById('jam').innerHTML = jam + ":" + menit + ":" + detik;
    }, 1000)
</script> -->

<script src="../dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</html>