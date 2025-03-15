<?php
session_start();
session_regenerate_id();
include '../db/conn.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

$uploadDir = "../assets/uploads/";
if (!is_dir($uploadDir)) {
    die("Folder uploads tidak ditemukan. Pastikan 'assets/uploads' sudah ada.");
}

if ($icons["error"] != 0) {
    die("Error saat upload file: " . $icons["error"]);
}

if (isset($_POST['simpan'])) {
    $serv_name = $_POST['service_name'];
    $icons = $_FILES['icons'];

    // $sql = mysqli_query($conn, "INSERT INTO services (nama_service, foto) VALUES ('$serv_name', '$icons')");

    if ($icons['error'] == 0) {
        $fileName = uniqid() . "_" . basename($icons["name"]);
        $filePath = $uploadDir . $fileName;

        move_uploaded_file($icons['tmp_name'], $filePath);
        $sql = mysqli_query($conn, "INSERT INTO services (nama_service, foto) VALUES ('$serv_name', '$fileName')");
        header("Location: ../admin/service.php");
    }

    // if ($sql) {
    //     echo "<script>alert('Data Berhasil Disimpan')</script>";
    //     header("Location: ./admin/service.php");
    // } else {
    //     echo "<script>alert('Data Gagal Disimpan')</script>";
    //     header("Location: add_service.php");
    // }
}

// if (isset($_POST['update'])) {
//     $id = $_POST['id'];
//     $serv_name = $_POST['service_name'];
//     $icons = $_FILES['icons'];

//     if ($_FILES['icons']['name'] != '') {
//         $logo = $_FILES['icons'];
//         $logoName = uniqid() . "_" . basename($logo["name"]);
//         $logoPath = "../assets/uploads/" . $logoName;

//         if (move_uploaded_file($logo['tmp_name'], $logoPath)) {
//             if (!empty($icons) && file_exists("../assets/uploads/" . $icons)) {
//                 unlink("../assets/uploads/" . $icons);
//             }
//         }
//     } else {
//         $logoName = $icons;
//     }

//     $sql = mysqli_query($conn, "UPDATE services SET nama_service = '$serv_name', foto = '$logoName' WHERE id = '$id'");

//     if ($sql) {
//         echo "<script>alert('Data Berhasil Diupdate')</script>";
//         header("refresh:1;url=../admin/service.php");
//     } else {
//         echo "<script>alert('Data Gagal Diupdate')</script>";
//         header("Location: update_service.php?id=" . base64_encode($id));
//     }
// }

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
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title">Services Settings</h5>
                                <a href="../admin/service.php" class="icon-link icon-link-hover">
                                    BACK</a>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="service_name">Service Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" name="service_name" id="service_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="service_name">Icons :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="file" name="icons" id="icons" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-5 text-end">
                                    <div class="col-sm-6">
                                        <button type="submit" name="simpan" id="simpan" class="btn btn-secondary">SAVE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <?php require_once '../../inc/footer.php'; ?>
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