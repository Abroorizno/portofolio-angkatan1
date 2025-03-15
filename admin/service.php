<?php
session_start();
session_regenerate_id();
include '../db/conn.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

$sql = mysqli_query($conn, "SELECT * FROM services");
$result = $sql->fetch_all(MYSQLI_ASSOC);

$uploadDir = "../assets/uploads/";
if (!is_dir($uploadDir)) {
    die("Folder uploads tidak ditemukan. Pastikan 'assets/uploads' sudah ada.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sqlGet = mysqli_query($conn, "SELECT foto FROM services WHERE id = '$id'");

    // Cek apakah data ditemukan
    if (mysqli_num_rows($sqlGet) > 0) {
        $row = mysqli_fetch_assoc($sqlGet);
        $foto = $row['foto']; // Ambil nama file foto

        // Hapus file gambar jika ada
        if ($foto && file_exists($uploadDir . $foto)) {
            unlink($uploadDir . $foto); // Menghapus file gambar
        }
    }

    $sqlDel = mysqli_query($conn, "DELETE FROM services WHERE id = '$id'");

    if ($sqlDel) {
        echo "<script>alert('Profile deleted successfully')</script>";
        header("refresh:1;url=service.php");
    } else {
        echo "<script>alert('Error deleting profile')</script>";
        header("Location: service.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <?php include_once '../inc/navbar.php'; ?>
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <?php include_once '../inc/sidebar.php'; ?>
    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Blank Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Blank</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Services Settings</h5>
                                <a href="../app/add_service.php" class="icon-link">ADD SERVICES</a>
                            </div>
                            <table class="table">
                                <thead>
                                    <th scope="col">No.</th>
                                    <th scope="col">Services</th>
                                    <th scope="col">Icons</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <?php
                                $no = 1;
                                foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo $no++ . '.'; ?></td>
                                        <td><?= $row['nama_service']; ?></td>
                                        <td><img src="../assets/uploads/<?= $row['foto'] ?> " alt="icons" width="35"></td>
                                        <td>
                                            <a href="../app/edit_service.php?id=<?= base64_encode($row['id']) ?>" class="btn btn-secondary">EDIT</a>
                                            <a href="service.php?id=<?= $row['id'] ?>" class="btn btn-light" onclick="return confirm('Are you sure want to delete this data?')">DELETE</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <?php require_once '../inc/footer.php'; ?>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>