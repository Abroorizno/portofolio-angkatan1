<?php
require_once '../db/conn.php';

if (isset($_POST['daftar'])) {
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    $nama = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$nama', '$email', '$password')");
    // $sql = $conn->prepared("INSERT INTO users (username, email, password) VALUES ('$nama', '$email', '$password')");
    // $sql->bind_param("sss", $nama, $email, $hashedPassword);

    if ($sql) {
        echo "<script>alert('SIGN IN BERHASIL'); window.location='login.php';</script>";
        // header("Location: login.php");
    } else {
        echo "<script>alert('SIGN IN GAGAL!')</script>";
    }
}
?>

<style>
    .container {
        padding-top: 90px;
        margin: 50px;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header fw-bold d-flex justify-content-between">
                        FORM SIGN IN
                        <a href="login.php" class="btn btn-light">LOGIN</a>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" onsubmit="return validasi();">
                            <div class="mt-3">
                                <label for="">Username :</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="mt-3">
                                <label for="">Email :</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="mt-3">
                                <label for="">Password :</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <span id="passwordError" class="text-danger" style="display: none;">
                                    Password harus terdiri dari 8 karakter!
                                    <p>
                                    <ul>
                                        <li>Harus terdiri dari 8 karakter</li>
                                        <li>Harus terdiri dari huruf besar dan kecil</li>
                                        <li>Harus terdiri dari angka</li>
                                        <li>Harus terdiri dari karakter spesial</li>
                                    </ul>
                                    </p>
                                </span>
                            </div>
                            <div class="mt-5 text-end">
                                <button type="submit" name="daftar" id="daftar" class="btn btn-secondary">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous">
    </script>

    <script>
        function validasi() {
            let password = document.getElementById('password').value;
            let passwordError = document.getElementById('passwordError');
            let isValid = true;

            let passReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&#])[A-Za-z\d@$!%?&#]{8,}$/;

            if (passReg.test(password)) {
                passwordError.style.display = "none";
            } else {
                passwordError.style.display = "block";
                isValid = false;
            }
            return isValid;
        }
    </script>

</body>

</html>