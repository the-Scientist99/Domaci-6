<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

$q = "SELECT * FROM tip_nekretnine WHERE id = '$id'";
$res = mysqli_query($dbconn, $q);
$tip_n = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style.css" />
    <title>Izmijeni Tip Nekretnine</title>
</head>

<body>

    <div class="container">
        <?php
        include "./nav.html";
        ?>
        <div class="text-center row mt-5">
            <div class="col-4"></div>
            <div class="col-4">
                <h2>Izmijeni Tip Nekretnine</h2>
                <form action="./izmijeni_tip_n_db.php" class="form d-flex flex-column" method="GET">
                    <input type="hidden" name="id" class="form-control" value="<?= $id ?>">
                    <input type="text" name="naziv" class="form-control my-2" value="<?= $tip_n['naziv'] ?>">
                    <button class="btn btn-success mt-2">Izmijeni</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>