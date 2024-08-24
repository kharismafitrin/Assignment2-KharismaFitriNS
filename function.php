<?php
require_once 'connection.php';

connectDatabase();
session_start();


function getPostData($field)
{
    return isset($_POST[$field]) ? $_POST[$field] : null;
}

function saveData($conn, $nama, $role, $availability, $usia, $lokasi, $experience, $email)
{
    $sql = $conn->prepare("INSERT INTO data_diri (nama, role, availability, usia, lokasi, experience, email)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssisis", $nama, $role, $availability, $usia, $lokasi, $experience, $email);

    if ($sql->execute()) {
        // Ambil ID terakhir yang dimasukkan
        $lastId = $conn->insert_id;
        $sql->close();
        return $lastId; // Kembalikan ID untuk digunakan dalam redireksi
    } else {
        echo "Error: " . $sql->error . "<br>";
        return false;
    }
}

function validateData($nama, $role, $availability, $usia, $lokasi, $experience, $email)
{
    // echo "test jalan lah";

    $errors = [];
    if (empty($nama) || strlen($nama) < 7) {
        $errors[] = "Nama tidak boleh kosong dan kurang dari 7 karakter.";
    }

    if (empty($role) || strlen($role) < 2) {
        $errors[] = "Role tidak boleh kosong dan kurang dari 2 karakter.";
    }

    if (empty($availability)) {
        $errors[] = "Availability tidak boleh kosong";
    }

    if (!is_int($usia) || $usia < 1) {
        $errors[] = "Usia harus berupa angka dan tidak boleh kurang dari 1.";
    }

    if (empty($lokasi) || strlen($lokasi) < 4) {
        $errors[] = "Lokasi tidak boleh kosong dan kurang dari 4 karakter.";
    }

    if (!is_int($experience) || $experience < 1) {
        $errors[] = "Pengalaman harus berupa angka dan tidak boleh kurang dari 1.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    // var_dump($errors);

    return $errors;
}

function insertData()
{
    $conn = connectDatabase();
    $nama = getPostData('nama');
    $role = getPostData('role');
    $availability = getPostData('availability');
    $usia = (int) getPostData('usia');
    $lokasi = getPostData('lokasi');
    $experience = (int) getPostData('experience');
    $email = getPostData('email');

    $errors = validateData($nama, $role, $availability, $usia, $lokasi, $experience, $email);
    if (!$errors) {
        $lastId = saveData($conn, $nama, $role, $availability, $usia, $lokasi, $experience, $email);

        if ($lastId) {
            $_SESSION['success'] = "Berhasil Menambahkan data";

            header("Location: form.php?id=" . $lastId);
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: form.php");
        exit();
        // header("Location: form.php");
        // echo"error bro";
        // var_dump($errors);
        // exit();
    }

}

function getDataById($id)
{
    $conn = connectDatabase();

    $sql = "SELECT * FROM data_diri WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        echo "Data tidak ditemukan.";
        return null;
    }
}

function deleteById($id)
{
    $conn = connectDatabase();
    $sql = $conn->prepare("DELETE FROM data_diri WHERE id = ?");
    $sql->bind_param("i", $id);
    var_dump($sql);

    if ($sql->execute()) {
        $_SESSION['success'] = " Berhasil Menghapus Data";
        header("Location: form.php");
        exit();
    } else {
        // echo "weehh gagal";
        $_SESSION['error'] = " Gagal Menghapus Data";
        header("Location: form.php");
        exit();
    }
}

function updateDataById($id, $nama, $role, $availability, $usia, $lokasi, $experience, $email)
{
    $conn = connectDatabase();

    $sql = $conn->prepare("UPDATE data_diri SET nama = ?, role = ?, availability = ?, usia = ?, lokasi = ?, experience = ?, email = ? WHERE id = ?");
    $sql->bind_param("sssisisi", $nama, $role, $availability, $usia, $lokasi, $experience, $email, $id);

    if ($sql->execute()) {
        return true;
    } else {
        echo "Error: " . $sql->error . "<br>";
        return false;
    }
}

function updateData($id)
{
    // echo "udah sampe sini bro";
    $nama = getPostData('nama');
    $role = getPostData('role');
    $availability = getPostData('availability');
    $usia = (int) getPostData('usia');
    $lokasi = getPostData('lokasi');
    $experience = (int) getPostData('experience');
    $email = getPostData('email');

    $errors = validateData($nama, $role, $availability, $usia, $lokasi, $experience, $email);
    if (!$errors) {
        if (updateDataById($id, $nama, $role, $availability, $usia, $lokasi, $experience, $email)) {
            $_SESSION['success'] = "Berhasil Mengupdate data";
            header("Location: form.php?id=" . $id);
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: form.php?id=" . $id);
        exit();
    }
}


?>