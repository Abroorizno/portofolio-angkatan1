<?php
session_start();
session_regenerate_id();
include '../db/conn.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

$sql = mysqli_query($conn, "SELECT * FROM contact");
$result = $sql->fetch_all(MYSQLI_ASSOC);


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sqlDel = mysqli_query($conn, "DELETE FROM contact WHERE id = '$id'");

    if ($sqlDel) {
        echo "<script>alert('Messages was Dismissed!')</script>";
        header("refresh:1;url=kontak.php");
    } else {
        echo "<script>alert('Error Dismissed Messages!')</script>";
        header("Location: ../app/balas_kontak.php");
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
            <h1>Message</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">General Settings</li>
                    <li class="breadcrumb-item active">Contact</li>
                    </li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">CONTACT SERVICES</h5>
                            <table class="table">
                                <thead>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name Contact</th>
                                    <th scope="col">Email Contact</th>
                                    <th scope="col">Subject Contact</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <?php
                                $no = 1;
                                foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo $no++ . '.'; ?></td>
                                        <td><?= $row['nama_kontak']; ?></td>
                                        <td><?= $row['email_kontak'] ?></td>
                                        <td><?= $row['subjek_kontak'] ?></td>
                                        <td><?= $row['pesan_kontak'] ?></td>
                                        <td>
                                            <div class="mb-3">
                                                <a href="../app/balas_kontak.php?id=<?php echo $row['id'] ?>" class="btn btn-light">REPLY</a>
                                            </div>
                                            <div class="mb-3">
                                                <a href="kontak.php?id=<?= $row['id'] ?>" onclick="return confirm('Are You Sure want to Dismissed this Messages?')" class="btn btn-dark">DISMISS</a>
                                            </div>
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