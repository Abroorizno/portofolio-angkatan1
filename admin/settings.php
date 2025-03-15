<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
session_regenerate_id();
include '../db/conn.php';


if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

$id = 1;
$sqlSettings = mysqli_query($conn, "SELECT * FROM settings WHERE id = $id");
$data = mysqli_fetch_assoc($sqlSettings);

// Cek apakah folder assets/uploads ada
$uploadDir = "../assets/uploads/";
if (!is_dir($uploadDir)) {
    die("Folder uploads tidak ditemukan. Pastikan 'assets/uploads' sudah ada.");
}

if (isset($_POST['simpan'])) {
    $nama_web = $_POST['nama_web'];
    $url_web = $_POST['alamat_web'];
    $email = $_POST['email'];
    $telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $logo = $_FILES['icon'];

    if (mysqli_num_rows($sqlSettings) > 0) {
        $fillQupdate = '';
        if ($logo['error'] == 0) {
            $fileName = uniqid() . "_" . basename($logo['name']);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($logo['tmp_name'], $filePath)) {
                $rowLogo = $data['logo'];
                if ($rowLogo && file_exists($uploadDir . $rowLogo)) {
                    unlink($uploadDir . $rowLogo);
                } else {
                    echo '<script>alert("LOGO GAGAL DI UPLOAD")</script>';
                }
            }
        }
        $fillQupdate = "logo='$fileName'";
        $sqlUpdate = mysqli_query($conn, "UPDATE settings SET website_name = '$nama_web', website_link = '$url_web', email = '$email', no_telp = '$telp', alamat = '$alamat', $fillQupdate WHERE id = 1");
        // if ($sqlUpdate) {
        //     echo "<input>alert('Data Berhasil Diupdate'); window.location.href = 'settings.php'";
        // } else {
        //     echo "<script>alert('Data Gagal Diupdate'); window.location.href = 'settings.php'";
        // }
        header("Location: settings.php?ubah=berhasil");
    } else {
        if ($logo['error'] == 0) {
            $fileName = uniqid() . "_" . basename($logo["name"]);
            $filePath = $uploadDir . $fileName;

            move_uploaded_file($logo['tmp_name'], $filePath);
            $sqlInsert = mysqli_query($conn, "INSERT INTO settings (website_name, website_link, email, no_telp, alamat, logo) VALUES ('$nama_web', '$url_web', '$email', '$telp', '$alamat', '$fileName')");
            header("Location: settings.php?tambah=berhasil");
        }
        // if ($sqlInsert) {
        //     echo "<script>alert('Data Berhasil Ditambahkan'); window.location.href = 'settings.php'";
        // } else {
        //     echo "<script>alert('Data Gagal Ditambahkan'); window.location.href = 'settings.php'";
        // }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($data['logo']) {
        unlink($uploadDir . $data['logo']);
        $sql = mysqli_query($conn, "DELETE FROM settings WHERE id = '$id'");
        $alt = mysqli_query($conn, "ALTER TABLE settings AUTO_INCREMENT id = 1");

        if ($sql & $alt) {
            echo "<script>alert('Website deleted successfully')</script>";
            header("Location: settings.php");
        }
    } else {
        echo "<script>alert('Error deleting website')</script>";
    }
} else {
    header("Localhost: settings.php");
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
                            <h5 class="card-title">General Settings</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="site_name" class="form-label">Site Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_web" placeholder="E.g Googles" value="<?php echo (isset($_GET['tambah']) && $_GET['tambah'] == 'berhasil') || isset($_GET['sidebar']) && $_GET['sidebar'] ? $data['website_name'] : (isset($_GET['ubah']) && $_GET['ubah'] == 'berhasil' ? $data['website_name'] : '');  ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="site_url" class="form-label">Site URL :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="alamat_web" placeholder="www.example.com" value="<?php echo (isset($_GET['tambah']) && $_GET['tambah'] == 'berhasil') || isset($_GET['sidebar']) && $_GET['sidebar'] ? $data['website_name'] : (isset($_GET['ubah']) && $_GET['ubah'] == 'berhasil' ? $data['website_link'] : '');  ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="email" class="form-label">Email :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email" placeholder="example@site.com" value="<?php echo (isset($_GET['tambah']) && $_GET['tambah'] == 'berhasil') || isset($_GET['sidebar']) && $_GET['sidebar'] ? $data['email'] : (isset($_GET['ubah']) && $_GET['ubah'] == 'berhasil' ? $data['email'] : '');  ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="phone" class="form-label">Phone :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="no_telp" placeholder="+62" value="<?php echo (isset($_GET['tambah']) && $_GET['tambah'] == 'berhasil') || isset($_GET['sidebar']) && $_GET['sidebar'] ? $data['no_telp'] : (isset($_GET['ubah']) && $_GET['ubah'] == 'berhasil' ? $data['no_telp'] : '');  ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="address" class="form-label">Address :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea name="alamat" id="alamat" cols="30" class="form-control" rows="5"><?php echo (isset($_GET['tambah']) && $_GET['tambah'] == 'berhasil') || isset($_GET['sidebar']) && $_GET['sidebar'] ? $data['alamat'] : (isset($_GET['ubah']) && $_GET['ubah'] == 'berhasil' ? $data['alamat'] : '');  ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Icon :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="file" name="icon" class="form-control">
                                        <img src="../assets/uploads/<?= $data['logo']; ?>" width="150" class="mt-4" alt="Logo">
                                    </div>
                                </div>
                                <div class="row mt-5 text-end">
                                    <div class="col-12">
                                        <?php
                                        if (isset($_GET['tambah']) || isset($_GET['ubah'])) {
                                            echo '<button type="submit" class="btn btn-secondary" name="simpan" value="edit">EDIT</button>';
                                        } else {
                                            echo '<button type="submit" class="btn btn-secondary" name="simpan" value="tambah">SAVE</button>';
                                        }
                                        ?>

                                        <?php
                                        if (isset($_GET['tambah']) || isset($_GET['ubah'])) {
                                        ?>
                                            <a href="settings.php?id=<?php echo $data['id'] ?>" class="btn btn-light" onclick="return confirm('Are You Sure Want to Delete This Data?')">DELETE</a>
                                        <?php
                                        } else {
                                            echo '<button type="reset" class="btn btn-light">RESET</button>';
                                        }
                                        ?>
                                        <!-- <button type="reset" class="btn btn-light" onclick="return confirm('Are You Sure Want to Delete This Website?')">RESET</button> -->
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script>
        $(document).ready(function() {
            // Ketika form disubmit
            $("#settingsForm").submit(function(e) {
                e.preventDefault(); // Mencegah form reload (default behavior)

                var formData = $(this).serialize(); // Mengambil data form

                // Kirim data dengan AJAX
                $.ajax({
                    type: "POST",
                    url: "settings.php", // File PHP yang akan menangani request
                    data: formData, // Data yang dikirim
                    success: function(response) {
                        // Menampilkan response dari PHP (misalnya pesan sukses)
                        $("#responseMessage").html(response);
                        // Kamu bisa juga melakukan tindakan lain, seperti mereset form
                        $("#settingsForm")[0].reset();
                    },
                    error: function() {
                        // Jika ada error saat pengiriman
                        alert("Ada kesalahan dalam pengiriman data.");
                    }
                });
            });
        });
    </script> -->

</body>

</html>