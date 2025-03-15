<?php
session_start();
session_regenerate_id();
require_once '../db/conn.php';
// include("./session/login.php");

if (!isset($_SESSION["email"])) {
    header("location: session/login.php");
    exit();
}

$sql = mysqli_query($conn, "SELECT * FROM profiles");
$result = $sql->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "DELETE FROM profiles WHERE id = '$id'");

    if ($sql) {
        echo "<script>alert('Profile deleted successfully')</script>";
        header("Location: profile.php");
    } else {
        echo "<script>alert('Error deleting profile')</script>";
    }
} else {
    header("Localhost: profile.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['idSts'];

    $update_sts0 = mysqli_query($conn, "UPDATE profiles SET status = '0'");
    $update_sts1 = mysqli_query($conn, "UPDATE profiles SET status = '1' WHERE id = $id");

    if ($update_sts1) {
        echo "<script>alert('Profile di Tampilkan!')</script>";
        header("Location: profile.php");
    } else {
        echo "<script>alert('Profile Gagal di Tampilkan')</script>";
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
            <h1>Profiles Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Profiles</li>
                    <!-- <li class="breadcrumb-item active">Blank</li> -->
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title">Profiles</h5>
                                <a href="../app/add_edit_profiles.php" class="icon-link">ADD PROFILES</a>
                            </div>
                            <table class="table">
                                <thead>
                                    <th scope="col">No.</th>
                                    <th scope="col">Photos</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Positions</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </thead>
                                <?php
                                $no = 1;
                                foreach ($result as $row):
                                ?>
                                    <tr>
                                        <td><?php echo $no++ . '.'; ?></td>
                                        <td><img src="../assets//uploads/<?= $row['photo'] ?> " alt="" width="150"></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['jabatan']; ?></td>
                                        <td><?= $row['deskripsi']; ?></td>
                                        <td>
                                            <a href="../app/add_edit_profiles.php?id=<?= base64_encode($row['id']) ?>" class="btn btn-light">EDIT</a>
                                            <a href="profile.php?id=<?= $row['id'] ?>" class="btn btn-dark" onclick="return confirm('Are you sure?')">DELETE</a>
                                            <br>
                                            <hr>
                                            <form action="?idSts=<?= $row['id'] ?>" method="post">
                                                <input type="radio" onchange="this.form.submit()" name="status" id="status" class="form-check-input" value="1" <?php echo isset($row['status']) && $row['status'] == 1 ? 'checked' : ''; ?>> SHOW
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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