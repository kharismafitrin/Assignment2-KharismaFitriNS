<?php
include("connection.php");
include("function.php");
session_start();

$form = false;
$row = null;
if (isset($_GET['id'])) {
    $row = getDataById($_GET['id']);
} else {
    $form = true;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit'])) {
        $form = true;
        // echo 'ini berhasil ke klik bro';
        // echo $_POST['id'];
    } else if (isset($_POST['update'])) {
        // echo 'ini berhasil ke klik update bro';
        updateData($_POST['id']);
    } else if (isset($_POST['submit'])) {
        insertData();
    } else if (isset($_POST['delete'])) {
        deleteById($_POST['id']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Assignment 2</title>
    <style>
        @media (min-width: 992px) {
            .border-lg-start {
                border-left: 1px solid #dee2e6 !important;
            }
        }

        body {
            font-family: "Poppins";
        }
    </style>

</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white mb-2 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kharisma</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inventory</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    ?>
    <section id="data_diri" class="container my-4 mx-auto shadow bg-white p-4">
        <div class="row">
            <div class="col-lg-7 col-md-12 row mx-auto">
                <div class="col-md-4 col-12 text-center my-auto">
                    <img class="rounded-circle img-fluid" src="https://picsum.photos/600" alt="">
                </div>
                <div class="col-md-8 col-12 my-auto py-4">
                    <?php if (isset($row['nama']) && isset($row['role'])) { ?>
                        <p id="dataNama" class="fw-bold fs-5"><?php echo ($row['nama']); ?></p>
                        <p id="dataRole"><?php echo ($row['role']); ?></p>
                        <form action="" method="post" class="">
                            <input type="hidden" name="id" value="<?php echo ($id); ?>">
                            <div class="row">
                                <div class="col-sm-6 col-12 d-grid gap-2">
                                    <input type="submit" name="edit" value="edit" class="btn btn-primary">
                                </div>
                                <div class="col-sm-6 col-12 d-grid gap-2">
                                    <input type="submit" name="delete" value="delete" class="btn btn-outline-danger">
                                </div>
                        </form>
                    </div>
                <?php } else { ?>
                    <p id="dataNama" class="fw-bold fs-5">Nama Anda</p>
                    <p id="dataRole">Role Anda</p>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 my-4 border-lg-start">
            <table class="table table-borderless">
                <tr>
                    <td class="fw-bold">Availability</td>
                    <td id="dataAvailability">
                        <?php echo isset($row['availability']) ? ($row['availability']) : 'Availability anda'; ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Usia</td>
                    <td id="dataAge"><?php echo isset($row['usia']) ? ($row['usia']) : 'umur anda'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Lokasi</td>
                    <td id="dataLokasi"><?php echo isset($row['lokasi']) ? ($row['lokasi']) : 'Lokasi anda'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Pengalaman</td>
                    <td id="dataPengalaman">
                        <?php echo isset($row['experience']) ? ($row['experience']) : 'Tahun pengalaman anda'; ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Email</td>
                    <td id="dataEmail" class="text-break">
                        <?php echo isset($row['email']) ? ($row['email']) : 'email anda'; ?>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </section>
    <section id="form-data" class="container my-4 mx-auto p-4 shadow bg-white">
        <?php
        if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Tidak dapat menambah data!</strong> 
                        <p class="border-top border-danger mt-2">Terdapat kesalahan input pada form di bawah!<p>';
            foreach ($_SESSION['errors'] as $error) {
                echo '<ul><li>' . $error . '</li></ul>';
            }
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            unset($_SESSION['errors']);
        }
        if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo '<strong>Success!</strong>' . $_SESSION["success"];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['success']);
        } else if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '<strong>Error!</strong>' . $_SESSION["error"];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form id="tambah_data" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">
            <label class="form-label mt-4" for="nama">Nama</label>
            <input class="form-control" type="text" name="nama" id="nama" value="<?php echo $row['nama'] ?? ''; ?>"
                <?php echo $form ? '' : 'disabled'; ?>>
            <label class="form-label mt-4" for="role">Role</label>
            <input class="form-control" type="text" name="role" id="role" value="<?php echo $row['role'] ?? ''; ?>"
                <?php echo $form ? '' : 'disabled'; ?>>
            <label class="form-label mt-4" for="availability">Availability</label>
            <select class="form-select" name="availability" id="availabilitySelect" aria-label="Default select example"
                <?php echo $form ? '' : 'disabled'; ?>>
                <option value="Full Time" <?php echo (isset($row['availability']) && $row['availability'] == 'Full Time') ? 'selected' : ''; ?>>Full time</option>
                <option value="Part Time" <?php echo (isset($row['availability']) && $row['availability'] == 'Part Time') ? 'selected' : ''; ?>>Part time</option>
                <option value="Internship" <?php echo (isset($row['availability']) && $row['availability'] == 'Internship') ? 'selected' : ''; ?>>Internship</option>
            </select>
            <label class="form-label mt-4" for="usia">Usia</label>
            <input class="form-control" type="number" name="usia" id="usia" value="<?php echo $row['usia'] ?? ''; ?>"
                <?php echo $form ? '' : 'disabled'; ?>>
            <label class="form-label mt-4" for="lokasi">Lokasi</label>
            <input class="form-control" type="text" name="lokasi" id="lokasi"
                value="<?php echo $row['lokasi'] ?? ''; ?>" <?php echo $form ? '' : 'disabled'; ?>>
            <label class="form-label mt-4" for="experience">Years Experience</label>
            <input class="form-control" type="number" name="experience" id="experience"
                value="<?php echo $row['experience'] ?? ''; ?>" <?php echo $form ? '' : 'disabled'; ?>>
            <label class="form-label mt-4" for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email" value="<?php echo $row['email'] ?? ''; ?>"
                <?php echo $form ? '' : 'disabled'; ?>>
            <div class="d-grid gap-2 my-4">
                <?php if ($edit) { ?>
                    <input class="btn btn-success" type="submit" name="update" value="Update">
                <?php } else { ?>
                    <input class="btn btn-success" type="submit" name="submit" value="Submit">
                <?php } ?>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>