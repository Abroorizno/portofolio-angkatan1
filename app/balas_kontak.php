<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
session_regenerate_id();
include '../db/conn.php';
require '../vendor/autoload.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}

$id = $_GET['id'];
$sql = mysqli_query($conn, "SELECT * FROM contact WHERE id = '$id'");
$result = mysqli_fetch_assoc($sql);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['kirim'])) {
    $id = $_GET['id'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email
    $subjek = htmlspecialchars($_POST['subject']); // Sanitize subject
    $pesan = htmlspecialchars($_POST['pesan_balasan']); // Sanitize message

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true); // Buat objek PHPMailer
    $mail->SMTPDebug = 2; // Aktifkan debug

    try {
        // Setel pengaturan server SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abroorprod@gmail.com';
        $mail->Password   = 'zolp pinb dubd xwet';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Setel pengaturan pengirim dan penerima
        $mail->setFrom('abroorprod@gmail.com', 'Abroor Rizky');
        $mail->addAddress($email);

        // Setel subjek dan isi email
        $mail->isHTML(true);
        $mail->Subject = $subjek;
        $mail->Body    = $pesan;
        $mail->AltBody = strip_tags($pesan);

        // Kirim email
        if ($mail->send()) {
            // Jika email berhasil dikirim, hapus data dari database
            $sqlDel = mysqli_query($conn, "DELETE FROM contact WHERE id = '$id'");
            echo "<script>alert('PESAN TERKIRIM!'); window.location.href='../admin/kontak.php';</script>";
        } else {
            echo "<script>alert('GAGAL KIRIM PESAN!'); window.location.href='balas_kontak.php';</script>";
        }
    } catch (Exception $e) {
        // Menangani error jika pengiriman email gagal
        echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
        echo "<br>Error Tambahan: " . $e->getMessage();
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
                    <li class="breadcrumb-item active">Reply Message</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Message</h5>
                            <div class="row mt-3"></div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="service_name">Nama Pengirim :</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="nama_pengirim" class="form-control" value="<?= $result['nama_kontak']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="email">Email Pengirim :</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" name="email_pengirim" class="form-control" value="<?= $result['email_kontak']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="message" class="col-sm-2 col-form-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="message" rows="3" disabled><?= $result['pesan_kontak']; ?></textarea>
                                </div>
                            </div>

                            <!-- FORM BALASAN -->
                            <hr>
                            <form action="" method="post" enctype="multipart/form-data">
                                <h5 class="card-title">Reply Message</h5>
                                <div class="row mt-3">
                                    <div class="col-sm-2">
                                        <label for="email_pengirim">Email Penerima :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" value="<?= $result['email_kontak']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-2">
                                        <label for="subject">Subject :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <!-- <input type="text" name="subject" class="form-control"> -->
                                        <select name="subject" id="subject" class="form-select" aria-label="Default select example">
                                            <option selected>- SUBJECT BALASAN -</option>
                                            <option value="complain-acception">COMPLAIN ACCEPTION</option>
                                            <optgroup label="ACCEPTION">
                                                <option value="collaboration-acception">COLLABORATION ACCEPTION</option>
                                                <option value="contribution-acception">CONTRIBUTION ACCEPTION</option>
                                            </optgroup>
                                            <optgroup label="REJECTION">
                                                <option value="collaboration-rejected">COLLABORATION REJECTED</option>
                                                <option value="contribution-rejected">CONTRIBUTION REJECTED</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-2">
                                        <label for="pesan_balasan">Pesan Balasan :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea name="pesan_balasan" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="col text-end">
                                        <button type="submit" name="kirim" class="btn btn-secondary">SEND</button>
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

</body>

</html>