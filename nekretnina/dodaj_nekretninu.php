<?php
include "../db.php";
include "../functions.php";

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
    <title></title>
</head>

<body>
    <div class="container">
        <?php
        include "./nav.html";
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == "add_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Nekretnina uspješno dodata!</h4> </div>";
            if ($_GET['msg'] == "add_err")
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Nekretnina neuspješno dodata!</h4> </div>";
        }
        ?>

        <div class="row mt-1">
            <div class="col-3"></div>
            <div class="col-6">
                <form action="./dodaj_nekretninu_db.php" method="POST" class="form-control" enctype="multipart/form-data">
                    <h3 class="text-center">DODAVANJE NEKRETNINE</h3>
                    <div class="text-center">
                        <label for="grad">GRAD</label>
                        <select name="grad" id="grad" class="form-control mt-1" required>
                            <option value="0">Izaberite grad</option>
                            <?php
                            selectOptions($arr_grad);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="tip_o">TIP OGLASA</label>
                        <select name="tip_o" id="tip_o" class="form-control mt-1" required>
                            <option value="0">Izaberite tip oglasa</option>
                            <?php
                            selectOptions($arr_tip_oglasa);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="tip_n">TIP NEKRETNINE</label>
                        <select name="tip_n" id="tip_n" class="form-control mt-1" required>
                            <option value="0">Izaberite tip nekretnine</option>
                            <?php
                            selectOptions($arr_tip_nekretnine);
                            ?>
                        </select>
                    </div>
                    <div class="text-center my-2">
                        <label for="povrsina">POVRŠINA</label>
                        <input type="number" name="povrsina" id="povrsina" class="form-control mt-1" placeholder="Unesite povrsinu" required>
                    </div>
                    <div class="text-center my-2">
                        <label for="cijena">CIJENA</label>
                        <input type="number" name="cijena" id="cijena" class="form-control mt-1" placeholder="Unesite cijenu" required>
                    </div>
                    <div class="text-center my-2">
                        <label for="god_izgradnje">GODINA IZGRADNJE</label>
                        <input type="date" name="god_izgradnje" id="god_izgradnje" class="form-control mt-1">
                    </div>
                    <div class="text-center my-2">
                        <label for="opis">OPIS</label>
                        <textarea name="opis" id="opis" class="form-control mt-1" placeholder="Opis"></textarea>
                    </div>
                    <div class="text-center my-2">
                        <label for="foto">FOTOGRAFIJA/E</label>
                        <input type="file" name="fotografija[]" id="foto" class="form-control mt-1" multiple required>
                    </div>
                    <div class="text-center mt-1">
                        <input type="submit" class="btn btn-success" value="DODAJ">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>