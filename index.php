<?php
include "./db.php";
include "./functions.php";

$current_page = 1;
$per_page = 3;
$show_q = "SELECT n.id, n.povrsina, n.cijena, (SELECT fotografija FROM foto_nekretnine fn WHERE fn.nekretnina_id = n.id LIMIT 1) AS fotografija, 
                g.naziv AS grad, tn.naziv AS tip_n, tog.naziv AS tip_o, n.status
                        FROM nekretnina n 
                        LEFT JOIN grad g ON g.id = n.grad_id
                        LEFT JOIN tip_nekretnine tn ON tn.id = n.tip_nekretnine_id
                        LEFT JOIN tip_oglasa tog ON tog.id = n.tip_oglasa_id";

$arr_grad = vratiti("grad");
$arr_tip_nekretnine = vratiti("tip_nekretnine");
$arr_tip_oglasa = vratiti("tip_oglasa");
$arr_names = ["grad", "tip_n", "tip_o", "min_povrsina", "max_povrsina", "min_cijena", "max_cijena", "per_page"];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $where_arr = [];
    $where_arr = validacijaPretrage($where_arr, $arr_names);
    $show_q = $show_q . implode("AND", $where_arr);
    if (isset($_GET['page'])) $current_page = $_GET['page'];
    if (isset($_GET['per_page'])) $per_page = $_GET['per_page'];
}
$show_q .= " LIMIT $per_page OFFSET " . ($current_page - 1) * $per_page;
$stmt = $pdo->prepare($show_q);
$stmt->execute();
$rezultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
$br_rez = count($rezultat);
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

        <form class="form border-top border-bottom mb-2 pt-2 pb-2" action="./index.php" method="GET">
            <div class="row text-center mb-2">
                <div class="col-2"><b>GRAD</b></div>
                <div class="col-2"><b>VRSTA NEKRETNINE</b></div>
                <div class="col-2"><b>TIP NEKRETNINE</b></div>
                <div class="col-2"><b>POVRŠINA</b></div>
                <div class="col-2"><b>CIJENA</b></div>
                <div class="col-1"><b>BR. REZ</b></div>
                <div class="col-1">
                    <button class="btn btn-pretraga">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <select name="grad" class="form-control">
                        <option value="-1">- izaberi grad -</option>
                        <?php
                        selectOptionsGET($arr_grad, "grad");
                        ?>
                    </select>
                </div>
                <div class="col-2">
                    <select name="tip_n" class="form-control">
                        <option value="-1">- tip nekretnine -</option>
                        <?php
                        selectOptionsGET($arr_tip_nekretnine, "tip_n");
                        ?>
                    </select>
                </div>
                <div class="col-2">
                    <select name=" tip_o" class="form-control">
                        <option value="-1">- tip oglasa -</option>
                        <?php
                        selectOptionsGET($arr_tip_oglasa, "tip_o");
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <?php isset($_GET['min_povrsina']) ? $p = $_GET['min_povrsina'] : $p = "" ?>
                    <input type="number" class="form-control text-center" name="min_povrsina" placeholder="- od -" value="<?= $p ?>">
                </div>
                <div class="col-1">
                    <?php isset($_GET['max_povrsina']) ? $p = $_GET['max_povrsina'] : $p = "" ?>
                    <input type="number" class="form-control text-center" name="max_povrsina" placeholder="- do -" value="<?= $p ?>">
                </div>
                <div class="col-1">
                    <?php isset($_GET['min_cijena']) ? $c = $_GET['min_cijena'] : $c = "" ?>
                    <input type="number" class="form-control text-center" name="min_cijena" placeholder="- od -" step="0.01" value="<?= $c ?>">
                </div>
                <div class="col-1">
                    <?php isset($_GET['max_cijena']) ? $c = $_GET['max_cijena'] : $c = "" ?>
                    <input type="number" class="form-control text-center" name="max_cijena" placeholder="- do -" step="0.01" value="<?= $c ?>">
                </div>
                <div class="col-1">
                    <select name="per_page" class="form-control">
                        <?php
                        for ($i = 3; $i < 10; $i += 3) {
                            $sel = "";
                            if (isset($_GET['per_page']))
                                if ($_GET['per_page'] == $i)
                                    $sel = "selected";
                            echo "<option value='$i' $sel> $i </option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1 text-center">
                    <a href="./index.php" class="btn btn-danger w-50"><i class="fas fa-times mr-2"></i></a>
                </div>
            </div>
        </form>

        <table class="table">
            <?php
            if (count($rezultat) != 0) {
                for ($i = 0; $i < count($rezultat); $i++) {
                    $red = $rezultat[$i];
                    $fotografija = $red['fotografija'];
                    $id = $red['id'];
                    $status = "";
                    if ($red['status'] == "prodato") {
                        $status = "Prodato";
                    }
            ?>
                    <tr class="row">
                        <td class="col-4 text-center mt-2">
                            <img src="<?= $fotografija ?>" alt="foto-nekretnine" height="150px" width="250px">
                        </td>
                        <td class="col-8 d-flex flex-column">
                            <h3> <?= ucfirst($red['tip_o']) ?> - <?= ucfirst($red['tip_n']) ?></h3>
                            <i class="fas fa-map-marker-alt"> <span class="ml-1"> <?= $red['grad'] ?> </span> </i>
                            <div class="mt-2">
                                <span class="cijena"> <?= number_format($red['cijena']); ?> &euro;</span>
                                <i style="color: red; margin-left: 15px;"><?= $status ?> </i>
                            </div>

                            <span class="povrsina"> <b>Površina:</b> <?= $red['povrsina'] ?> m <sup>2</sup> </span>
                            <div class="mt-1">
                                <a href="./details.php?id=<?= $id ?>" class="btn btn-opcije btn-detalji w-50"> <i class="fas fa-info-circle">
                                    </i> Detalji</a>
                                <a href="./nekretnina/edit.php?id=<?= $id ?>" class="btn btn-opcije btn-izmijeni"> <i class="far fa-edit"></i></a>
                                <div class="d-none" id="id"><?= $red['id'] ?></div>
                                <a class="btn btn-opcije btn-izbrisi" id="btn-del" onclick="brisi(<?= $id ?>)"> <i class="fas fa-times-circle"></i></a>
                            </div>
                    </tr>
            <?php
                }
                echo "</table>";
            } else
                echo "<h3 class='text-center alert alert-danger my-5'>Nema rezultata!</h3>";

            $prev_page = $current_page - 1;
            $next_page = $current_page + 1;
            $prev_href = "href='./index.php?page=$prev_page";
            $next_href = "href='./index.php?page=$next_page";

            for ($i = 0; $i < count($arr_names); $i++) {
                $name = $arr_names[$i];
                $val = validacija($name, "GET");
                if ($val != "") {
                    $prev_href .= "&$name=$val";
                    $next_href .= "&$name=$val";
                }
            }
            $prev_href .= "'";
            $next_href .= "'";

            if ($current_page == 1)  $prev_href = " ";
            if ($br_rez < $per_page) $next_href = "";

            echo "
                    <div class=\"text-center\">
                        <a $prev_href> <i class='fas fa-chevron-left fa-2x'></i></a>
                        <a $next_href> <i class='fas fa-chevron-right fa-2x'></i></a>
                    </div>
                ";
            ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        const brisi = (id) => {
            if (confirm("Da li stvarno želite da izbrišete?"))
                location.href = "./delete.php?id=" + id;
        }
    </script>
</body>

</html>