<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['id']) ? $id = $_GET['id'] : exit("Error!");

$q = "SELECT * FROM nekretnina WHERE id = $id";
$res = mysqli_query($dbconn, $q);
$nekretnina = mysqli_fetch_assoc($res);

$arr_grad = vratiti("grad");
$arr_tip_nekretnine = vratiti("tip_nekretnine");
$arr_tip_oglasa = vratiti("tip_oglasa");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style.css">
    <title>Izmijeni nekretninu</title>
</head>

<body>
    <div class="container">
        <?php
        include "./nav.html";
        ?>
        <div class="row mt-1">
            <div class="col-3"></div>
            <div class="col-6">
                <form action="./edit_db.php" method="POST" class="form-control">
                    <h3 class="text-center">IZMJENA NEKRETNINE</h3>
                    <input type="hidden" class="d-none" name="id" value="<?= $id ?>">
                    <div class="text-center">
                        <label for="grad">GRAD</label>
                        <select name="grad" id="grad" class="form-control mt-1">
                            <option value="0">Izaberite grad</option>
                            <?php
                            selectOptionsEdit($arr_grad, "grad_id", $nekretnina);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="tip_o">TIP OGLASA</label>
                        <select name="tip_o" id="tip_o" class="form-control mt-1">
                            <option value="0">Izaberite tip oglasa</option>
                            <?php
                            selectOptionsEdit($arr_tip_oglasa, "tip_oglasa_id", $nekretnina);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="tip_n">TIP NEKRETNINE</label>
                        <select name="tip_n" id="tip_n" class="form-control mt-1">
                            <option value="0">Izaberite tip nekretnine</option>
                            <?php
                            selectOptionsEdit($arr_tip_nekretnine, "tip_nekretnine_id", $nekretnina);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="povrsina">POVRŠINA</label>
                        <input type="number" name="povrsina" id="povrsina" class="form-control mt-1" value="<?= $nekretnina['povrsina'] ?>">
                    </div>
                    <div class="text-center my-2">
                        <label for="cijena">CIJENA</label>
                        <input type="number" name="cijena" id="cijena" class="form-control mt-1" value="<?= $nekretnina['cijena'] ?>">
                    </div>
                    <div class="text-center my-2">
                        <label for="god_izgradnje">GODINA IZGRADNJE</label>
                        <input type="date" name="god_izgradnje" id="god_izgradnje" class="form-control mt-1" value="<?= $nekretnina['god_izgradnje'] ?>">
                    </div>
                    <div class="my-2 text-center">
                        <?php
                        $e = "";
                        $c = "";
                        $d = "";
                        if ($nekretnina['status'] == "dostupno") {
                            $c = "checked";
                        } else {
                            $e = "checked";
                            $d = "disabled";
                        }
                        ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="dostupno" <?php echo $c . " " . $d ?>>
                            <label class="form-check-label" for="inlineRadio1">Dostupno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="prodato" <?= $e ?>>
                            <label class="form-check-label" for="inlineRadio2">Prodato</label>
                        </div>
                    </div>
                    <div class="text-center my-2" id="dat_p">
                        <label for="dat_prodaje">DATUM PRODAJE</label>
                        <input type="date" name="dat_prodaje" id="dat_prodaje" class="form-control mt-1" value="<?= $nekretnina['dat_prodaje'] ?>">
                    </div>
                    <div class="text-center my-2">
                        <label for="opis">OPIS</label>
                        <textarea name="opis" id="opis" class="form-control mt-1"><?= $nekretnina['opis'] ?></textarea>
                    </div>
                    <div class="text-center mt-1">
                        <input type="submit" class="btn btn-success" value="IZMIJENI">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="./app.js" type="text/javascript"></script>
</body>

</html>