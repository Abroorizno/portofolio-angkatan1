<?php
session_start();
session_regenerate_id();
require_once '../db/conn.php';

// if (isset($id)) {
//     // Pastikan $data dan $result berisi data yang benar
//     echo '<pre>';
//     print_r($data);
//     // print_r($result);
//     echo '</pre>';
// }

if (!isset($_SESSION["email"])) {
    header("location: session/login.php");
    exit();
}

if (isset($_POST['kirim'])) {
    // Pastikan koneksi database ada
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    $photo = $_FILES['photo'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah ada kesalahan dalam upload file
    if ($photo["error"] != 0) {
        die("Error saat upload file: " . $photo["error"]);
    }

    // Cek apakah folder assets/uploads ada
    $uploadDir = "../assets/uploads/";
    if (!is_dir($uploadDir)) {
        die("Folder uploads tidak ditemukan. Pastikan 'assets/uploads' sudah ada.");
    }

    $fillName = uniqid() . "_" . basename($photo["name"]);
    $fillPath = $uploadDir . $fillName;

    // Coba pindahkan file ke folder tujuan
    if (move_uploaded_file($photo['tmp_name'], $fillPath)) {
        echo "File berhasil diunggah ke: " . $fillPath . "<br>";

        // Simpan ke database
        $sql = mysqli_query($conn, "INSERT INTO profiles (photo, nama, jabatan, deskripsi) VALUES ('$fillName', '$nama','$jabatan','$deskripsi')");

        if ($sql) {
            echo "Data berhasil dimasukkan ke database.";
            header("Location: ../admin/profile.php");
            exit();
        } else {
            die("Gagal menyimpan ke database: " . mysqli_error($conn));
        }
    } else {
        die("Gagal memindahkan file ke folder uploads.");
    }
}

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);

    // Ambil data berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM profiles WHERE id='$id'");
    $data = mysqli_fetch_assoc($result);

    // Jika data tidak ditemukan
    if (!$data) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['update'])) {
    $id = base64_decode($_GET['id']);
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $deskripsi = $_POST['deskripsi'];
    $old_photo = $_POST['old_photo'];

    // Cek apakah ada file yang diunggah
    if ($_FILES['photo']['name'] != '') {
        $photo = $_FILES['photo'];
        $photoName = uniqid() . "_" . basename($photo["name"]);
        $photoPath = "../assets/uploads/" . $photoName;

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            // Hapus foto lama jika ada dan bukan gambar default
            if (!empty($old_photo) && file_exists("../assets/uploads/" . $old_photo)) {
                unlink("../assets/uploads/" . $old_photo);
            }
        }
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $photoName = $old_photo;
    }

    $sql = mysqli_query($conn, "UPDATE profiles SET photo='$photoName', nama='$nama', jabatan='$jabatan', deskripsi='$deskripsi' WHERE id='$id'");

    if ($sql) {
        echo "<script>alert('DATA BERHASIL DI UBAH')</script>";
        header("Location: ../admin/profile.php");
    } else {
        echo "<script>alert('DATA GAGAL DI UBAH')</script>" . mysqli_error($conn);
        header("Location: add_edit-profiles.php");
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
                    <!-- <li class="breadcrumb-item">General Settings</li> -->
                    <li class="breadcrumb-item active">Profiles</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <h5 class="card-title"><?php echo isset($id) ? 'Profiles Edit' : 'Profiles Add' ?></h5>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_photo" value="<?= $data['photo']; ?>">

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="tahun">Photos :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="mb-4">
                                            <?php echo isset($id) ? '<img src="../assets/uploads/' . $data['photo'] . '" width="150" alt="Foto Profil">' : ''; ?>
                                        </div>
                                        <input type="file" name="photo" id="photo" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="major">Full Name :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo isset($id) ? $data['nama'] : '' ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="major">Positions :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo isset($id) ? $data['jabatan'] : '' ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-sm-3">
                                        <label for="major">Description :</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control"><?php echo isset($id) ? $data['deskripsi'] : '' ?></textarea>
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