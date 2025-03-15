<?php
session_start();
session_regenerate_id();
include '../db/conn.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

if (isset($_POST['kirim'])) {
    $id = $_POST['id'];
    $tahun_awal = $_POST['year_in'];
    $tahun_akhir = $_POST['year_out'];
    $skill = $_POST['skill'];
    $instansi = $_POST['instansi'];
    $desc = $_POST['deskripsi'];

    $sqlInsert = mysqli_query($conn, "INSERT INTO resume (tahun_masuk, tahun_keluar, skills, instansi, deskripsi) VALUES ('$tahun_awal', '$tahun_akhir', '$skill', '$instansi', '$desc')");

    if ($sqlInsert) {
        echo "<scrip>alert('Data Berhasil Ditambahkan');</script>";
        header("refresh:1; url=../admin/resume.php");
    } else {
        echo "<script>alert('Data Gagal Ditambahkan');</script>";
    }
}

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);

    $sqlGet = mysqli_query($conn, "SELECT * FROM resume WHERE id = '$id'");
    $result = mysqli_fetch_assoc($sqlGet);

    if (!$result) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['update'])) {
    $id = base64_decode($_GET['id']);
    $tahun_awal = $_POST['year_in'];
    $tahun_akhir = $_POST['year_out'];
    $skill = $_POST['skill'];
    $instansi = $_POST['instansi'];
    $desc = $_POST['deskripsi'];

    $sqlUpdate = mysqli_query($conn, "UPDATE resume SET tahun_masuk = '$tahun_awal', tahun_keluar = '$tahun_akhir', skills = '$skill', instansi = '$instansi', deskripsi = '$desc' WHERE id = '$id'");

    if ($sqlUpdate) {
        echo "<script>alert('Data Berhasil Diupdate');</script>";
        header("refresh:1; url=../admin/resume.php");
    } else {
        echo "<script>alert('Data Gagal Diupdate');</script>";
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
            <h1>Resume Pages</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">General Settings</li>
                    <li class="breadcrumb-item active">Resume Add</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <h5 class="card-title"><?php echo isset($id) ? 'Resume Edit' : 'Resume Add' ?></h5>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="tahun">Year :</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" name="year_in" id="year_in" class="form-control" placeholder="IN" min="1800" max="2089" step="1" value="<?php echo isset($id) ? $result['tahun_masuk'] : "" ?>" required>
                                        <br>
                                        <input type="number" name="year_out" id="year_out" class="form-control" min="1800" max="2089" value="<?php echo isset($id) ? $result['tahun_keluar'] : date('Y') ?>" required>
                                    </div>
                                </div>
                                <div class=" row mb-3">
                                    <div class="col-sm-3">
                                        <label for="major">Skills :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="skill" id="skill" class="form-control" value="<?php echo isset($id) ? $result['skills'] : '' ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="major">Company :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="instansi" id="instansi" class="form-control" value="<?php echo isset($id) ? $result['instansi'] : '' ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-sm-3">
                                        <label for="major">Description :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control"><?php echo isset($id) ? $result['deskripsi'] : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <?php if (isset($id)) { ?>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-light" name="update">UPDATE</button>
                                            <button type="reset" class="btn btn-dark">RESET</button>
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-light" name="kirim">SAVE</button>
                                            <button type="reset" class="btn btn-dark">RESET</button>
                                        </div>
                                    <?php } ?>
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