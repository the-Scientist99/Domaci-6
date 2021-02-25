<?php
include "./db.php";
include "./functions.php";

$show_q = "SELECT n.id, n.povrsina, n.cijena, (SELECT fotografija FROM foto_nekretnine fn WHERE fn.nekretnina_id = n.id LIMIT 1) AS fotografija, 
                g.naziv AS grad, tn.naziv AS tip_n, tog.naziv AS tip_o
                        FROM nekretnina n 
                        LEFT JOIN grad g ON g.id = n.grad_id
                        LEFT JOIN tip_nekretnine tn ON tn.id = n.tip_nekretnine_id
                        LEFT JOIN tip_oglasa tog ON tog.id = n.tip_oglasa_id";

$arr_grad = vratiti("grad");
$arr_tip_nekretnine = vratiti("tip_nekretnine");
$arr_tip_oglasa = vratiti("tip_oglasa");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $where_arr = [];
    $arr_names = ["grad", "tip_n", "tip_o", "min_povrsina", "max_povrsina", "min_cijena", "max_cijena"];
    $where_arr = validacijaPOST($where_arr, $arr_names);
    $show_q = $show_q . implode("AND", $where_arr);
}
$stmt = $pdo->prepare($show_q);
$stmt->execute();
$rezultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css" />
    <title>Prodaja Nekretnina</title>
</head>

<body>
    <div class="container">
        <?php
        include "./nav.html";
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == "e_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Nekretnina uspješno izmijenjena!</h4> </div>";
            if ($_GET['msg'] == "e_err")
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Nekretnina neuspješno izmijenjena!</h4> </div>";
            if ($_GET['msg'] == "del_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Nekretnina uspješno izbrisana!</h4> </div>";
            if ($_GET['msg'] == "del_err")
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Nekretnina neuspješno izbrisana!</h4> </div>";
        }
        ?>

        <form class="form border-top border-bottom mb-5 pt-2 pb-2" action="./index.php" method="POST">
            <div class="row text-center mb-2">
                <div class="col-2">GRAD</div>
                <div class="col-2">VRSTA NEKRETNINE</div>
                <div class="col-2">TIP NEKRETNINE</div>
                <div class="col-2">POVRŠINA</div>
                <div class="col-2">CIJENA</div>
                <div class="col-2"> <button class="btn btn-pretraga w-75">
                        <i class="fas fa-search"></i> TRAŽI</button>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <select name="grad" class="form-control">
                        <option>- izaberi grad -</option>
                        <?php
                        selectOptionsPOST($arr_grad, "grad");
                        ?>
                    </select>
                </div>
                <div class="col-2">
                    <select name="tip_n" class="form-control">
                        <option>- tip nekretnine -</option>
                        <?php
                        selectOptionsPOST($arr_tip_nekretnine, "tip_n");
                        ?>
                    </select>
                </div>
                <div class="col-2">
                    <select name=" tip_o" class="form-control">
                        <option>- tip oglasa -</option>
                        <?php
                        selectOptionsPOST($arr_tip_oglasa, "tip_o");
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <?php isset($_POST['min_povrsina']) ? $p = $_POST['min_povrsina'] : $p = "" ?>
                    <input type="text" class="form-control text-center" name="min_povrsina" placeholder="- od -" value="<?= $p ?>">
                </div>
                <div class="col-1">
                    <?php isset($_POST['max_povrsina']) ? $p = $_POST['max_povrsina'] : $p = "" ?>
                    <input type="text" class="form-control text-center" name="max_povrsina" placeholder="- do -" value="<?= $p ?>">
                </div>
                <div class="col-1">
                    <?php isset($_POST['min_cijena']) ? $c = $_POST['min_cijena'] : $c = "" ?>
                    <input type="text" class="form-control text-center" name="min_cijena" placeholder="- od -" value="<?= $c ?>">
                </div>
                <div class="col-1">
                    <?php isset($_POST['max_cijena']) ? $c = $_POST['max_cijena'] : $c = "" ?>
                    <input type="text" class="form-control text-center" name="max_cijena" placeholder="- do -" value="<?= $c ?>">
                </div>
                <div class="col-2 text-center">
                    <a href="./index.php" class="btn btn-danger w-75"><i class="fas fa-times mr-2"></i> PONIŠTI</a>
                </div>
            </div>
        </form>

        <table class="table">
            <?php
            if (count($rezultat) != 0) {
                for ($i = 0; $i < count($rezultat); $i++) {
                    $red = $rezultat[$i];
                    $fotografija = $red['fotografija'];
            ?>
                    <tr class="row">
                        <td class="col-5 text-center">
                            <img src="<?= $fotografija ?>" alt="foto-nekretnine" height="200px" width="350px">
                        </td>
                        <td class="col-7 d-flex flex-column">
                            <h2 class="mt-2"> <?= ucfirst($red['tip_o']) ?> - <?= ucfirst($red['tip_n']) ?> </h2>
                            <i class="fas fa-map-marker-alt"> <span class="ml-1"> <?= $red['grad'] ?> </span> </i>
                            <span class="cijena my-3"> <?= number_format($red['cijena']); ?> &euro; </span>
                            <span class="povrsina"> <b>Površina:</b> <?= $red['povrsina'] ?> m <sup>2</sup> </span>
                            <div class="mt-2">
                                <a href="./details.php?id=<?= $red['id'] ?>" class="btn btn-opcije btn-detalji w-50"> <i class="fas fa-info-circle">
                                    </i> Detalji</a>
                                <a href="./nekretnina/edit.php?id=<?= $red['id'] ?>" class="btn btn-opcije btn-izmijeni"> <i class="far fa-edit"></i> Izmijeni</a>
                                <div class="d-none" id="id"><?= $red['id'] ?></div>
                                <a href="./delete.php?id=<?= $red['id'] ?>" class="btn btn-opcije btn-izbrisi" id="btn-del"> <i class="fas fa-times-circle"></i> Izbriši </a>
                            </div>
                    </tr>
            <?php
                }
                echo "</table>";
                echo "<h6 class='text-center alert alert-light'>Broj pronađenih nekretnina: " . count($rezultat) . "</h6>";
            } else {
                echo "<h1 class='text-center alert alert-danger'>No Results Found!</h1>";
                echo "<h6 class='text-center alert alert-light'>Broj pronađenih nekretnina: 0</h6>";
            }
            ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>