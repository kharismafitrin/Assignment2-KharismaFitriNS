<?php
function connectDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "latihan_sql";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    return $conn;
}

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "latihan_sql";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// // Hapus data berdasarkan ID
// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];
//     $sql = "DELETE FROM data_diri WHERE id = $id";

//     if ($conn->query($sql) === TRUE) {
//         echo "Data berhasil dihapus <br>";
//         // Redirect atau tampilkan pesan sukses
//         // header("Location: form.php"); // Redirect ke halaman form.php atau halaman lain
//         exit();
//     } else {
//         echo "Error: " . $conn->error . "<br>SQL: " . $sql;
//     }
// }

// if (isset($_GET['id'])) {
//     $cekId = $_GET['id'];
//     $sql = "SELECT * FROM data_diri WHERE id = $cekId";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $nama = $row['nama'];
//         $role = $row['role'];
//         $availability = $row['availability'];
//         $usia = $row['usia'];
//         $lokasi = $row['lokasi'];
//         $experience = $row['experience'];
//         $email = $row['email'];
//     } else {
//         echo "Data tidak ditemukan.";
//     }
// }

// // Kode untuk menangani insert atau update jika diperlukan
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $nama = $_POST['nama'];
//     $role = $_POST['role'];
//     $availability = $_POST['availability'];
//     $usia = $_POST['usia'];
//     $lokasi = $_POST['lokasi'];
//     $experience = $_POST['experience'];
//     $email = $_POST['email'];

//     $sql = "INSERT INTO data_diri (nama, role, availability, usia, lokasi, experience, email)
//             VALUES ('$nama', '$role', '$availability', '$usia', '$lokasi', '$experience', '$email')";

//     if ($conn->query($sql) === TRUE) {
//         echo "Data berhasil ditambahkan <br>";
//     } else {
//         echo "Error: " . $conn->error . "<br>SQL: " . $sql;
//     }
// }

// $conn->close();
?>
